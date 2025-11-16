@extends('layouts.main')

@section('head')
    <style>
        .pet-meta-highlight {
            color: #0B5ED7!important;
            font-weight: 450;
        }

        .pet-gender-femea {
            width: 18px !important;
            /* mesma largura do macho */
            height: auto !important;
            /* deixa a altura proporcional */
            transform: scale(0.75);
            /* aumenta sem distorcer */
            transform-origin: center;
        }

        .pet-card {
            height: 380px;
            /* um pouco mais alto */
            display: flex;
            flex-direction: column;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.22);
            transition: transform .2s ease, box-shadow .2s ease;
            border: none;
        }

        .pet-card .card-img-top {
            height: 12rem;
            width: 100%;
            object-fit: cover;
            object-position: center;
        }

        .pet-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1rem 1.25rem 1.75rem;
            /* mais espaço embaixo pro botão respirar */
        }

        /* Bloco com nome + meta + descrição (parte de cima) */
        .pet-info {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            gap: .35rem;
        }

        /* Linha com porte + idade (esquerda) e ícone (direita) */
        .pet-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
        }

        .pet-meta {
            font-size: .85rem;
            margin: 0;
        }

        /* Ícone de gênero (SVG do storage) */
        .pet-gender-icon {
            width: 1.1rem;
            height: 1.1rem;
            flex-shrink: 0;
        }

        .pet-gender-macho {
            /* se o SVG tiver fill="currentColor", pode usar color aqui */
            /* color: #4f8fff; */
        }

        .pet-gender-femea {
            /* color: #ff4f7b; */
        }

        /* Descrição com rolagem interna (a partir de ~3 linhas) */
        .card-desc-scroll {
            margin-top: .25rem;
            font-size: .9rem;
            line-height: 1.3;

            max-height: calc(1.3em * 3);
            /* limite visual ~3 linhas */
            min-height: calc(1.3em * 3);
            /* garante altura fixa pros cards */
            overflow-y: auto;
            /* só aparece scroll se passar disso */
            padding-right: 4px;
            /* espaço pro scroll */
        }

        /* scrollbar fininha e discreta */
        .card-desc-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .card-desc-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .card-desc-scroll::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.25);
            border-radius: 999px;
        }

        /* Botão no rodapé do card, com espaçamento */
        .card-footer-adotar {
            margin-top: .75rem;
            /* descola mais da descrição */
        }

        .card-footer-adotar .btn {
            width: 100%;
            padding: 8px 0;
            border-radius: 8px;
        }

        .pet-card h6 {
            font-weight: 600;
            margin: 0;
        }

        .pet-card p {
            margin: 0;
        }
    </style>
@endsection

@section('menu')
@endsection

@section('content')

    @php
        $mudaStatus = [
            'disponivel' => 'Disponível',
            'reservado' => 'Pet reservado',
            'aguardando_aprovacao' => 'Aguardando aprovação',
            'adotado' => 'Adotado',
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
                    $numeroOng = preg_replace('/\D/', '', $pet->ong->telefone ?? '');
                    $indisponivel = in_array($pet->status, ['reservado', 'adotado']);
                    $rotuloIndisponivel = $pet->status === 'adotado' ? 'Adotado' : 'Pet Reservado';

                    $generoLower = strtolower($pet->genero ?? '');
                @endphp

                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card pet-card">
                        <img src="{{ secure_asset('storage/images/' . $pet->imagem_url) }}" class="card-img-top"
                            alt="{{ $pet->nome }}">

                        <div class="card-body text-start">
                            <div class="pet-info">
                                <h6>{{ $pet->nome ?? 'Sem nome ainda' }}</h6>

                                {{-- porte + idade à esquerda / ícone à direita --}}
                                <div class="pet-meta-row">
                                    <p class="pet-meta pet-meta-highlight">
                                        {{ ucfirst($pet->porte) }}
                                        @if($pet->idade)
                                            | {{ $pet->idade }}
                                        @else
                                            | Idade não informada
                                        @endif
                                    </p>
                                    @if($generoLower === 'macho')
                                        <img src="{{ secure_asset('storage/images/macho.png') }}" alt="Macho"
                                            class="pet-gender-icon pet-gender-macho">
                                    @elseif($generoLower === 'femea')
                                        <img src="{{ secure_asset('storage/images/femea.png') }}" alt="Fêmea"
                                            class="pet-gender-icon pet-gender-femea">
                                    @endif
                                </div>

                                <div class="card-desc-scroll">
                                    {{ $pet->descricao ?? "Conheça este pet adorável, dócil e brincalhão, perfeito para qualquer lar. Está pronto para encontrar uma nova família." }}
                                </div>
                            </div>

                            <div class="card-footer-adotar text-center">
                                @if(!$indisponivel)
                                    <a href="{{ route('pet.mostrar', $pet) }}" class="btn btn-primary">
                                        Quero Adotar
                                    </a>
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        {{ $rotuloIndisponivel }}
                                    </button>
                                @endif
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
        </div>
    </div>

@endsection