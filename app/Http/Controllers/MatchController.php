<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Services\PetMatchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MatchController extends Controller
{
    public function __construct(private PetMatchService $petMatchService)
    {
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
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

            try {
                $sugestao = $this->petMatchService->escolher($adotante, $petsForAI);
            } catch (\Throwable $e) {
                Log::error('Erro ao executar IA', [
                    'erro' => $e->getMessage(),
                ]);

                return view('resultado_match', [
                    'sugestao' => null,
                    'pet' => null,
                    'adotante' => $adotante,
                    'erro' => $e->getMessage(),
                ]);
            }

            $pet = Pet::find($sugestao['id']);
            Log::info('>>> Indo para resultado_match', [
                'sugestao' => $sugestao,
                'pet' => $pet?->id,
            ]);

            return view('resultado_match', compact('sugestao', 'pet', 'adotante'))
                ->with('erro', null);
        }

        return view('match');
    }
}
