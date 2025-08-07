@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleCadastro.css') }}">
@endsection

@section('menu')
@endsection

@section('content')

    @php
        $mudaStatus = [
            'disponivel' => 'Disponível',
            'reservado' => 'Reservado',
            'aguardando_aprovacao' => 'Aguardando aprovação'
        ];
    @endphp

    <div id="alertaAdocao">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div id="cardsAdotar" class="container">
        <h1>Pets disponíveis</h1>
        <div class="row">
            @foreach ($pets as $pet)
                @php
                    $nomeUsuario = auth('adotante')->user()->nome_completo ?? 'Usuário';
                    $cidadeUsuario = auth()->user()->cidade ?? 'sua cidade';
                    $mensagem = "Olá, meu nome é $nomeUsuario e tenho interesse no pet {$pet->nome}. Moro em $cidadeUsuario.";
                    $mensagemUrl = urlencode($mensagem);
                    $numeroOng = preg_replace('/\D/', '', $pet->ong->telefone);
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm ">
                        <img src="{{ asset('images/' . $pet->imagem_url) }}" class="card-img-top" alt="{{ $pet->nome }}">
                        <div class="card-body text-start">
                            <h6 class="fw-bold">{{ $pet->nome ?? 'Sem nome ainda' }}</h6>
                            <p class="text-muted mb-1">
                                {{ ucfirst($pet->porte) }} | {{ ucfirst($pet->genero) }} |
                                {{ $pet->idade ?? 'Idade não informada' }}
                            </p>
                            <p class="mb-3">
                                {{ $pet->descricao ?? "Conheça este pet adorável, dócil e brincalhão, perfeito para qualquer lar. Está pronto para encontrar uma nova família." }}
                            </p>
                            <div class="text-center">
                                <a href="{{ route('pet.mostrar', ['slug' => $pet->slug]) }}" class="btn btn-primary w-100"> Quero Adotar</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalOng{{ $pet->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $pet->id }}"
                    aria-hidden="true">
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
                                <a href="https://wa.me/{{ $numeroOng }}?text={{ $mensagemUrl }}" target="_blank"
                                    class="btn btn-success">
                                    Entrar em contato pelo WhatsApp
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> <!-- fechamento da .row -->
    </div> <!-- fechamento da .container -->

@endsection




<style>

</style>