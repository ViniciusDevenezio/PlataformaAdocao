<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class PetMatchService
{
    private const INSTRUCOES = <<<TXT
Você é um especialista em adoção responsável de animais.

Receberá:
1. As características do adotante (trabalho, tempo em casa, espaço, lazer, moradia, experiência, tolerância a cuidados, renda).
2. A lista de pets disponíveis (id, nome, espécie, raça, porte, temperamento, faixa etária, idade, descrição, vacinado, vermifugado).

Sua tarefa:
- Escolher APENAS 1 pet que seja o mais compatível com o adotante.
- Justifique em UMA frase curta.

Formato da resposta: SOMENTE em JSON
{
  "id": <id do pet>,
  "nome": "nome do pet",
  "motivo": "frase curta explicando o encaixe"
}
TXT;

    public function escolher(array $adotante, array $pets): array
    {
        $apiKey = config('services.openai.key', env('OPENAI_API_KEY'));
        if (empty($apiKey)) {
            throw new RuntimeException('Chave da IA não configurada no ambiente (OPENAI_API_KEY).');
        }

        $prompt = sprintf(
            "%s\n\nDados do adotante: %s\nPets disponíveis: %s",
            self::INSTRUCOES,
            json_encode($adotante, JSON_UNESCAPED_UNICODE),
            json_encode($pets, JSON_UNESCAPED_UNICODE)
        );

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$apiKey}",
        ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4.1-mini',
            'temperature' => 0.2,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        if (!$response->successful()) {
            Log::error('Erro HTTP ao falar com a IA', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new RuntimeException('Erro HTTP ao falar com a IA.');
        }

        $body = $response->json();
        $content = Arr::get($body, 'choices.0.message.content');

        if (empty($content)) {
            throw new RuntimeException('Resposta da IA vazia ou inválida.');
        }

        if (str_contains($content, '{')) {
            $start = strpos($content, '{');
            $end = strrpos($content, '}');
            if ($end !== false) {
                $content = substr($content, $start, $end - $start + 1);
            }
        }

        $resultado = json_decode($content, true, 512, JSON_INVALID_UTF8_SUBSTITUTE);

        if (json_last_error() !== JSON_ERROR_NONE || empty($resultado['id'])) {
            Log::error('Erro ao converter JSON retornado pela IA', [
                'json_error' => json_last_error_msg(),
                'conteudo' => $content,
            ]);
            throw new RuntimeException('IA não conseguiu sugerir um pet. Tente novamente.');
        }

        return $resultado;
    }
}
