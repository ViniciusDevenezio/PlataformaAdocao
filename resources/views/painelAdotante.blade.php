@extends ('layouts.main')

@section('head')
    <style>
        .bloco-com-padding {
            padding-top: 4rem;
            /* mobile */
        }

        @media (min-width: 768px) {

            /* tablet */
            .bloco-com-padding {
                padding-top: 3rem;
            }
        }

        @media (min-width: 1200px) {

            .bloco-com-padding {
                padding-top: 4rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="bloco-com-padding">
        <h2 class="fw-semibold">Meus pedidos de adoção</h2>

        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Raça</th>
                        <th>Localização</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($solicitacoes as $solicitacao)
                        @php
                            $pet = $solicitacao->pet;

                            $imagem = 'https://placehold.co/120x120?text=Pet';
                            if ($pet && $pet->imagem_url) {
                                $path = trim($pet->imagem_url);
                                if (preg_match('#^(https?:)?//#', $path) || str_starts_with($path, 'data:')) {
                                    $imagem = $path;
                                } else {
                                    $clean = ltrim($path, '/');
                                    if (!str_contains($clean, '/')) {
                                        $clean = 'images/' . $clean;
                                    }
                                    $imagem = str_starts_with($clean, 'storage/') ? asset($clean) : asset('storage/' . $clean);
                                }
                            }

                            $status = $solicitacao->status ?? 'novo';
                            $statusInfo = [
                                'novo' => ['label' => 'Aguarde a ONG entrar em contato', 'class' => 'bg-warning text-dark'],
                                'aprovado' => ['label' => 'Adotado', 'class' => 'bg-success'],
                                'recusado' => ['label' => 'Recusado', 'class' => 'bg-danger'],
                            ][$status] ?? ['label' => ucfirst($status), 'class' => 'bg-secondary'];
                        @endphp

                        <tr>
                            <td>
                                <img src="{{ $imagem }}" alt="Foto do pet" width="120" class="rounded">
                            </td>
                            <td>{{ $pet->nome ?? '—' }}</td>
                            <td>{{ $pet->raca ?? '—' }}</td>
                            <td>{{ $pet->localizacao ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Você ainda não solicitou a adoção de nenhum pet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection