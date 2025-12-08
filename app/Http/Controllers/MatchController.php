<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Symfony\Component\Process\Process;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // 1. Validação
            $adotante = $request->validate([
                'trabalho' => 'required|string',
                'tempo_em_casa' => 'required|string',
                'espaco' => 'required|string',
                'lazer' => 'required|string',
                'moradia' => 'array',
                'experiencia' => 'required|string',
                'tolerancia' => 'required|string',
                'renda' => 'nullable|string',
            ]);
            $adotante['moradia'] = $adotante['moradia'] ?? ['sozinho'];

            // 2. Pets
            $pets = Pet::where('status', 'disponivel')->get();
            if ($pets->isEmpty()) {
                return view('resultado_match', [
                    'sugestao' => null,
                    'pet' => null,
                    'adotante' => $adotante,
                    'erro' => 'Nenhum pet disponível no momento.',
                ]);
            }

            $petsForAI = $pets->map(function ($pet) {
                return [
                    'id' => $pet->id,
                    'nome' => $pet->nome,
                    'especie' => $pet->especie,
                    'raca' => $pet->raca,
                    'mistura' => $pet->mistura,
                    'misturado_com' => $pet->misturado_com,
                    'temperamento' => $pet->temperamento,
                    'porte' => $pet->porte,
                    'genero' => $pet->genero,
                    'faixa_etaria' => $pet->faixa_etaria,
                    'idade' => $pet->idade,
                    'descricao' => $pet->descricao,
                    'vacinado' => $pet->vacinado,
                    'vermifugado' => $pet->vermifugado,
                ];
            })->toArray();

            $payload = json_encode([
                'adotante' => $adotante,
                'pets' => $petsForAI,
            ]);

            // 3. Caminho do Python definido via ambiente (compatível com deploy)
            $pythonPath = env('PYTHON_BIN', 'python3');
            $pythonScript = base_path('scripts/match.py');

            $apiKey = env('OPENAI_API_KEY');
            if (empty($apiKey)) {
                \Log::error('OPENAI_API_KEY não configurada no ambiente.');
                return view('resultado_match', [
                    'sugestao' => null,
                    'pet' => null,
                    'adotante' => $adotante,
                    'erro' => 'Chave da IA não configurada no ambiente (OPENAI_API_KEY).',
                ]);
            }

            // 4. Executa Python
            $process = new Process([$pythonPath, $pythonScript]);
            $process->setInput($payload);
            $process->setTimeout(30);
            $process->setEnv(array_merge(getenv(), [
                'PATH' => getenv('PATH'),
                'OPENAI_API_KEY' => $apiKey,
            ]));
            $process->run();

            if (!$process->isSuccessful()) {
                $erroProcesso = trim($process->getErrorOutput());
                if (empty($erroProcesso)) {
                    $erroProcesso = 'Processo finalizado com erro, mas sem logs. Verifique o runtime Python no Railway.';
                }

                \Log::error('Erro ao executar IA: ' . $erroProcesso);
                return view('resultado_match', [
                    'sugestao' => null,
                    'pet' => null,
                    'adotante' => $adotante,
                    'erro' => 'Erro ao executar IA: ' . $erroProcesso,
                ]);
            }

            // --- Trata saída ---
            $saidaOriginal = trim($process->getOutput());

            // remove prefixo b'...' se existir
            $saida = preg_replace('/^b[\'"](.*)[\'"]$/s', '$1', $saidaOriginal);

            // pega só o JSON entre { }
            if (preg_match('/\{.*\}/s', $saida, $matches)) {
                $saida = $matches[0];
            }

            // força UTF-8 válido
            $saida = mb_convert_encoding($saida, 'UTF-8', 'UTF-8');

            $sugestao = json_decode($saida, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);

            if (json_last_error() !== JSON_ERROR_NONE || !$sugestao || !isset($sugestao['id'])) {
                \Log::error('Erro JSON: ' . json_last_error_msg() . ' | Saída original: ' . $saidaOriginal);
                return view('resultado_match', [
                    'sugestao' => null,
                    'pet' => null,
                    'adotante' => $adotante,
                    'erro' => 'IA não conseguiu sugerir um pet. Tente novamente.',
                ]);
            }

            $pet = Pet::find($sugestao['id']);
            \Log::info('>>> Indo para resultado_match', [
                'sugestao' => $sugestao,
                'pet' => $pet?->id,
            ]);

            return view('resultado_match', compact('sugestao', 'pet', 'adotante'))
                ->with('erro', null);
        }

        return view('match');
    }
}
