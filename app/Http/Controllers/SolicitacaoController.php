<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Solicitacao;
use Illuminate\Http\Request;

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

        $paginator = Solicitacao::with([
            'pet:id,nome,imagem_url,status',
            // agora apenas os campos existentes no seu fillable
            'adotante:id,nome_completo,email,celular,cpf,nascimento,cep,endereco,numero,bairro,cidade,estado',
        ])
            ->where('ong_id', $ong->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        // helpers
        $makeImg = function (?string $path): string {
            if (empty($path))
                return 'https://placehold.co/96x96?text=Pet';
            $path = trim($path);
            if (preg_match('#^(https?:)?//#', $path) || str_starts_with($path, 'data:'))
                return $path;
            $clean = ltrim($path, '/');
            if (!str_contains($clean, '/'))
                $clean = 'images/' . $clean;
            return str_starts_with($clean, 'storage/') ? asset($clean) : asset('storage/' . $clean);
        };
        $formatFone = function (?string $fone): string {
            if (!$fone)
                return '—';
            $d = preg_replace('/\D+/', '', $fone);
            if (strlen($d) > 11 && str_starts_with($d, '55'))
                $d = substr($d, 2);
            if (strlen($d) === 11)
                return sprintf('(%s) %s-%s', substr($d, 0, 2), substr($d, 2, 5), substr($d, 7));
            if (strlen($d) === 10)
                return sprintf('(%s) %s-%s', substr($d, 0, 2), substr($d, 2, 4), substr($d, 6));
            return $fone;
        };
        $formatCpf = function (?string $cpf): ?string {
            if (!$cpf)
                return null;
            $d = preg_replace('/\D+/', '', $cpf);
            if (strlen($d) !== 11)
                return $cpf;
            return substr($d, 0, 3) . '.' . substr($d, 3, 3) . '.' . substr($d, 6, 3) . '-' . substr($d, 9, 2);
        };
        $enderecoFull = function ($ad): ?string {
            if (!$ad)
                return null;
            $l1 = trim(implode(', ', array_filter([$ad->endereco, $ad->numero])));
            $l2 = $ad->bairro ?: null;
            $l3 = ($ad->cidade && $ad->estado) ? "{$ad->cidade}/{$ad->estado}" : ($ad->cidade ?: null);
            $l4 = $ad->cep ?: null;
            $p = array_filter([$l1 ?: null, $l2, $l3, $l4]);
            return $p ? implode("\n", $p) : null; // \n -> <br> no front
        };
        $calcIdade = function (?string $iso): ?int {
            if (!$iso)
                return null;
            try {
                $d = new \DateTime($iso);
                $h = new \DateTime();
                return $d->diff($h)->y;
            } catch (\Throwable) {
                return null;
            }
        };

        $mapped = $paginator->getCollection()->map(function (Solicitacao $s) use ($makeImg, $formatFone, $formatCpf, $enderecoFull, $calcIdade) {
            $ad = $s->adotante;
            $fone = $ad->celular ?? $s->celular_cache ?? null;
            $foneDigits = $fone ? preg_replace('/\D+/', '', $fone) : null;

            return (object) [
                'id' => $s->id,
                'status' => $s->status ?? 'novo',
                'mensagem' => $s->mensagem,
                'created_at' => $s->created_at,

                // PET
                'pet_nome' => $s->pet->nome ?? '—',
                'pet_foto' => $makeImg($s->pet->imagem_url ?? null),

                // ADOTANTE
                'adotante_nome' => $ad->nome_completo ?? '—',
                'adotante_email' => $ad->email ?? null,
                'adotante_cpf_fmt' => $formatCpf($ad->cpf ?? null) ?? '—',
                'adotante_nascimento' => $ad->nascimento ?? null,
                'adotante_idade' => $calcIdade($ad->nascimento ?? null) ?? null,

                'adotante_whatsapp' => $formatFone($fone),
                'adotante_whatsapp_raw' => $foneDigits,
                'adotante_celular_fmt' => $formatFone($fone) ?? null,

                // ENDEREÇO
                'adotante_cep' => $ad->cep ?? null,
                'adotante_endereco' => $ad->endereco ?? null,
                'adotante_numero' => $ad->numero ?? null,
                'adotante_bairro' => $ad->bairro ?? null,
                'adotante_cidade' => $ad->cidade ?? null,
                'adotante_estado' => $ad->estado ?? null,
                'adotante_endereco_full' => $enderecoFull($ad) ?? '—',
            ];
        });

        $paginator->setCollection($mapped);

        return view('painel.ong.solicitacoes', [
            'solicitacoes' => $paginator,
            'ong' => $ong,
        ]);
    }

}
