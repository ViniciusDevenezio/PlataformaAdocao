@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleCadastro.css') }}">
@endsection

@section('menu')
@endsection

@section('content')

    @php
        use Illuminate\Support\Str;

        $mudaStatus = [
            'disponivel' => 'Disponível',
            'reservado' => 'Pet reservado',
            'aguardando_aprovacao' => 'Aguardando aprovação'
        ];

        // Filtra apenas espécie "Gato" (case-insensitive)
        $gatos = $pets->filter(function ($p) {
            return isset($p->especie) && Str::lower($p->especie) === 'gato';
        });
    @endphp

    <div id="alertaAdocao">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>

    <div id="cardsAdotar" class="container">
        <h1>Gatos disponíveis</h1>

        @if($gatos->isEmpty())
            <div class="alert alert-info my-4">
                No momento não há gatos disponíveis para adoção.
            </div>
        @endif

        <div class="row">
            @foreach ($gatos as $pet)
                @php
                    $nomeUsuario   = auth('adotante')->user()->nome_completo ?? 'Usuário';
                    $cidadeUsuario = auth()->user()->cidade ?? 'sua cidade';
                    $mensagem      = "Olá, meu nome é $nomeUsuario e tenho interesse no pet {$pet->nome}. Moro em $cidadeUsuario.";
                    $mensagemUrl   = urlencode($mensagem);
                    $numeroOng     = preg_replace('/\D/', '', $pet->ong->telefone ?? '');
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/images/' . $pet->imagem_url) }}"
                             class="card-img-top"
                             style="height: 15rem; object-fit: cover; width: 100%;"
                             alt="{{ $pet->nome }}">

                        <div class="card-body text-start d-flex flex-column">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h6 class="fw-bold mb-0">{{ $pet->nome ?? 'Sem nome ainda' }}</h6>
                                    <span class="badge bg-primary-subtle text-primary border">
                                        Gato
                                    </span>
                                </div>

                                <p class="text-muted mb-1 mt-2">
                                    {{ ucfirst($pet->porte) }} | {{ ucfirst($pet->genero) }} |
                                    {{ $pet->idade ?? 'Idade não informada' }}
                                </p>

                                <p class="mb-3">
                                    {{ $pet->descricao ?? "Conheça este pet adorável, dócil e brincalhão, perfeito para qualquer lar. Está pronto para encontrar uma nova família." }}
                                </p>
                            </div>

                            <div class="text-center mt-auto">
                                @if($pet->status === 'reservado')
                                    <button class="btn btn-secondary w-100" disabled>Pet Reservado</button>
                                @else
                                    <a href="{{ route('pet.mostrar', $pet) }}" class="btn btn-primary w-100 py-2">Quero Adotar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal ONG -->
                <div class="modal fade" id="modalOng{{ $pet->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pet->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $pet->id }}">Informações da ONG</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>ONG Responsável:</strong> {{ $pet->ong->nome ?? 'Não informado' }}</p>
                                <p><strong>Telefone:</strong> {{ $pet->ong->telefone ?? 'Não informado' }}</p>
                                <p><strong>Email:</strong> {{ $pet->ong->email ?? 'Não informado' }}</p>
                                <p><strong>Endereço:</strong>
                                    {{ $pet->ong->endereco ?? '' }},
                                    {{ $pet->ong->numero ?? '' }} -
                                    {{ $pet->ong->bairro ?? '' }},
                                    {{ $pet->ong->cidade ?? '' }} -
                                    {{ $pet->ong->estado ?? '' }}<br>
                                    CEP: {{ $pet->ong->cep ?? '' }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                @if(!empty($numeroOng))
                                    <a href="https://wa.me/{{ $numeroOng }}?text={{ $mensagemUrl }}" target="_blank" class="btn btn-success">
                                        Entrar em contato pelo WhatsApp
                                    </a>
                                @endif
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> <!-- .row -->
    </div> <!-- .container -->

@endsection
