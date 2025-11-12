<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Aceitar uma solicitação:
     * - Apenas a ONG dona do pet pode aceitar
     * - Usa transação + lockForUpdate para evitar race conditions
     * - Marca a solicitação como 'aprovado'
     * - Atualiza pet.status = 'adotado' e salva adotante_id
     * - Marca outras solicitações 'novo' como 'recusado'
     */
    public function aceitar($id)
    {
        $solicitacao = Solicitacao::with('pet')->findOrFail($id);
        $pet = $solicitacao->pet;

        // verificação de ONG autenticada
        $ongLogada = auth('ong')->user();
        if (!$ongLogada || $pet->ong_id !== $ongLogada->id) {
            return redirect()->back()->with('error', 'Você não tem permissão para aceitar essa solicitação.');
        }

        // se pet já reservado/adotado, rejeita essa solicitação e aborta
        if (in_array($pet->status, ['reservado', 'adotado'])) {
            $solicitacao->update(['status' => 'recusado']);
            return redirect()->back()->with('error', 'Este pet já não está disponível (reservado ou adotado).');
        }

        // delega para o processador que faz a transação
        try {
            $this->processAcceptance($solicitacao);
            return redirect()->back()->with('success', 'Solicitação aprovada. Pet marcado como adotado.');
        } catch (\Throwable $e) {
            \Log::error('Erro ao aceitar solicitação: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao processar aceitação. Tente novamente.');
        }
    }

    /**
     * End-point para atualizar o status (patch) — usado pela sua view para recusar/atualizar.
     * Espera body JSON: { status: 'aprovado'|'recusado' }
     */
    public function atualizarStatus(Request $request, $id)
    {
        $request->validate(['status' => ['required', 'string', 'in:aprovado,recusado']]);

        $solicitacao = Solicitacao::with('pet')->findOrFail($id);
        $pet = $solicitacao->pet;

        $ongLogada = auth('ong')->user();
        if (!$ongLogada || $solicitacao->ong_id !== $ongLogada->id) {
            return response()->json(['message' => 'Não autorizado.'], 403);
        }

        $status = $request->input('status');

        // Caso: recusar -> queremos excluir a solicitação do painel e, se necessário,
        // liberar o pet (tirar 'reservado' se esse pet foi reservado por esse adotante)
        if ($status === 'recusado') {

            DB::beginTransaction();
            try {
                // Se o pet existir e estiver reservado por este adotante, libera-o
                if ($pet) {
                    // se o pet estiver reservado e apontando para esse adotante, limpa o reservation
                    if ($pet->status === 'reservado' && $pet->adotante_id == $solicitacao->adotante_id) {
                        $pet->status = 'novo'; // ou 'disponivel' conforme sua convenção
                        $pet->adotante_id = null;
                        $pet->save();
                    }
                }

                // Apaga a solicitação do painel (conforme pedido)
                $solicitacao->delete();

                DB::commit();
                return redirect()->route('ong.solicitacoes')->with('success', 'Solicitação recusada com sucesso!');
            } catch (\Throwable $e) {
                DB::rollBack();
                \Log::error('Erro ao recusar solicitação: ' . $e->getMessage());
                return response()->json(['message' => 'Erro ao recusar solicitação.'], 500);
            }
        }

        // Caso: aprovado -> delega para a lógica de aceitação (mesma que já existe)
        if ($status === 'aprovado') {
            try {
                $this->processAcceptance($solicitacao);
                return response()->json(['message' => 'Solicitação aprovada e pet marcado como adotado.']);
            } catch (\Throwable $e) {
                \Log::error('Erro ao aprovar via atualizarStatus: ' . $e->getMessage());
                return response()->json(['message' => 'Erro ao aprovar solicitação.'], 500);
            }
        }

        return response()->json(['message' => 'Status inválido.'], 400);
    }
    // atalho compatível com rotas/JS que usam "updateStatus"
    public function updateStatus(Request $request, $id)
    {
        return $this->atualizarStatus($request, $id);
    }


    /**
     * Lista as solicitações para a ong (mantive sua implementação original)
     */
    public function index()
    {
        $ong = auth('ong')->user();
        abort_unless($ong, 401, 'ONG não autenticada');

        $paginator = Solicitacao::with([
            'pet:id,nome,imagem_url,status',
            'adotante:id,nome_completo,email,celular,cpf,nascimento,cep,endereco,numero,bairro,cidade,estado',
        ])
            ->where('ong_id', $ong->id)
            ->orderByDesc('created_at')
            ->paginate(15);

        // helpers (mantidos)
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

    /**
     * Função que encapsula a lógica de aceitação dentro de transação.
     * Recebe uma instância de Solicitacao já carregada com pet.
     */
    private function processAcceptance(Solicitacao $solicitacao)
    {
        DB::beginTransaction();
        try {
            $pet = $solicitacao->pet;

            // lock para evitar concorrência
            $petLocked = Pet::where('id', $pet->id)->lockForUpdate()->first();

            if (!$petLocked) {
                throw new \Exception('Pet não encontrado.');
            }
            if (in_array($petLocked->status, ['adotado', 'reservado'])) {
                // marca a solicitação como recusada porque pet já não está disponível
                $solicitacao->update(['status' => 'recusado']);
                DB::rollBack();
                throw new \Exception('Pet já adotado/reservado.');
            }

            // aceitar a solicitação atual
            $solicitacao->update(['status' => 'aprovado']);

            // atualizar pet
            $petLocked->status = 'adotado';
            $petLocked->adotante_id = $solicitacao->adotante_id;
            $petLocked->save();

            // marcar outras solicitações 'novo' como 'recusado'
            Solicitacao::where('pet_id', $petLocked->id)
                ->where('id', '<>', $solicitacao->id)
                ->whereIn('status', ['novo'])
                ->update(['status' => 'recusado']);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
