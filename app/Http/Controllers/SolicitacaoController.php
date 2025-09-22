<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SolicitacaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => ['required', 'integer', 'exists:pets,id'],
            'mensagem' => ['nullable', 'string', 'max:2000'],
        ]);

        $adotante = auth('adotante')->user();
        $pet = Pet::with('ong')->findOrFail($request->pet_id);

        if (!$pet->ong_id) {
            return back()->with('error', 'Este pet não está vinculado a nenhuma ONG.');
        }
        if (in_array($pet->status, ['reservado', 'adotado'])) {
            return back()->with('error', 'Este pet não está disponível para solicitação.');
        }

        $solicitacao = Solicitacao::firstOrCreate(
            [
                'pet_id' => $pet->id,
                'adotante_id' => $adotante->id,
            ],
            [
                'ong_id' => $pet->ong_id,
                'celular_cache' => $adotante->celular ?? null,
                'mensagem' => $request->input('mensagem'),
                'status' => 'novo',
            ]
        );

        if (!$solicitacao->wasRecentlyCreated) {
            return back()->with('error', 'Você já solicitou a adoção deste pet.');
        }

        return back()->with('success', 'Solicitação enviada com sucesso, aguarde a ong entrar em contato!');
    }

    public function index()
    {
        $ong = auth('ong')->user();
        abort_unless($ong, 401, 'ONG não autenticada');

        $paginator = \App\Models\Solicitacao::with([
            'pet:id,nome,imagem_url,status',
            'adotante:id,nome_completo,celular',
        ])
            ->where('ong_id', $ong->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        // monta URL assumindo storage/app/public/images -> /storage/images
        $makeImg = function (?string $path): string {
            if (empty($path))
                return 'https://placehold.co/96x96?text=Pet';

            $path = trim($path);

            // Já é URL?
            if (preg_match('#^(https?:)?//#', $path) || str_starts_with($path, 'data:')) {
                return $path;
            }

            // Normaliza e garante pasta "images/"
            $clean = ltrim($path, '/');           // ex: "fofa.jpg" ou "images/fofa.jpg"
            if (!str_contains($clean, '/')) {
                // veio só o nome do arquivo -> assume "images/<arquivo>"
                $clean = 'images/' . $clean;
            }

            // Se já vier "storage/..." (raro), não duplica
            if (str_starts_with($clean, 'storage/')) {
                return asset($clean);
            }

            // Padrão para quem salva em storage/app/public/images
            return asset('storage/' . $clean);    // => /storage/images/fofa.jpg
        };

        // formata telefone BR simples
        $formatFone = function (?string $fone): string {
            if (!$fone)
                return '—';
            $digits = preg_replace('/\D+/', '', $fone);
            if (strlen($digits) > 11 && str_starts_with($digits, '55'))
                $digits = substr($digits, 2);
            if (strlen($digits) === 11)
                return sprintf('(%s) %s-%s', substr($digits, 0, 2), substr($digits, 2, 5), substr($digits, 7));
            if (strlen($digits) === 10)
                return sprintf('(%s) %s-%s', substr($digits, 0, 2), substr($digits, 2, 4), substr($digits, 6));
            return $fone;
        };

        $mapped = $paginator->getCollection()->map(function (\App\Models\Solicitacao $s) use ($makeImg, $formatFone) {
            $fone = $s->adotante->celular ?? $s->celular_cache ?? null;

            return (object) [
                'id' => $s->id,
                'status' => $s->status ?? 'novo',
                'mensagem' => $s->mensagem,
                'created_at' => $s->created_at,

                'pet_nome' => $s->pet->nome ?? '—',
                'pet_foto' => $makeImg($s->pet->imagem_url ?? null),
                'adotante_nome' => $s->adotante->nome_completo ?? '—',
                'adotante_whatsapp' => $formatFone($fone),
            ];
        });

        $paginator->setCollection($mapped);

        return view('painel.ong.solicitacoes', [
            'solicitacoes' => $paginator,
            'ong' => $ong,
        ]);
    }
}
