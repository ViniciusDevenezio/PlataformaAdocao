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

        {{-- NOVO: estilo da barra de filtros horizontal --}}
        .filter-bar {
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.25rem;
            margin-top:-3rem;
            padding-bottom: 1px;
        }

        .filter-bar label {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.20rem;
        }

        .filter-bar .form-select,
        .filter-bar .form-check-input {
            font-size: 0.85rem;
        }

        .filter-bar .form-select {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .filter-bar .form-check-label {
            font-size: 0.85rem;
            font-weight: 500;
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

        // agora também montamos a lista de idades disponíveis
        $filtros = [
            'portes'   => $pets->pluck('porte')->filter()->unique()->sort()->values(),
            'generos'  => $pets->pluck('genero')->filter()->unique()->sort()->values(),
            'idades'   => $pets->pluck('idade')->filter()->unique()->sort()->values(),
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

        {{-- BARRA DE FILTROS HORIZONTAL --}}
        <div class="filter-bar">
            <div class="row g-2 align-items-end">

                <div class="col-6 col-md-3">
                    <label for="filtroPorte" class="form-label mb-0">Porte</label>
                    <select id="filtroPorte" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach($filtros['portes'] as $porte)
                            <option value="{{ strtolower($porte) }}">{{ ucfirst($porte) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3 mt-2 mt-md-0">
                    <label for="filtroGenero" class="form-label mb-0">Gênero</label>
                    <select id="filtroGenero" class="form-select form-select-sm">
                        <option value="">Todos</option>
                        @foreach($filtros['generos'] as $genero)
                            <option value="{{ strtolower($genero) }}">{{ ucfirst($genero) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- NOVO: filtro por idade --}}
                <div class="col-6 col-md-3 mt-2 mt-md-0">
                    <label for="filtroIdade" class="form-label mb-0">Idade</label>
                    <select id="filtroIdade" class="form-select form-select-sm">
                        <option value="">Todas</option>
                        @foreach($filtros['idades'] as $idade)
                            <option value="{{ $idade }}">{{ $idade }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-3 mt-2 mt-md-0 d-flex align-items-center">
                </div>
            </div>
        </div>
        {{-- FIM BARRA DE FILTRO --}}

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

                {{-- agora também tem data-idade --}}
                <div
                    class="col-md-3 col-sm-6 mb-4 pet-card-wrapper"
                    data-especie="{{ strtolower($pet->especie ?? '') }}"
                    data-porte="{{ strtolower($pet->porte ?? '') }}"
                    data-genero="{{ strtolower($pet->genero ?? '') }}"
                    data-status="{{ strtolower($pet->status ?? '') }}"
                    data-idade="{{ $pet->idade ?? '' }}"
                >
                    <div class="card pet-card">
                        <img src="{{ asset('storage/images/' . $pet->imagem_url) }}" class="card-img-top"
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
                                        <img src="{{ asset('storage/images/macho.png') }}" alt="Macho"
                                            class="pet-gender-icon pet-gender-macho">
                                    @elseif($generoLower === 'femea')
                                        <img src="{{ asset('storage/images/femea.png') }}" alt="Fêmea"
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

    {{-- script do filtro horizontal, agora com idade --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filtroPorte      = document.getElementById('filtroPorte');
            const filtroGenero     = document.getElementById('filtroGenero');
            const filtroIdade      = document.getElementById('filtroIdade');
            const filtroDisponivel = document.getElementById('filtroDisponivel');

            const cards = document.querySelectorAll('.pet-card-wrapper');

            const aplicaFiltros = () => {
                const porte   = filtroPorte.value;
                const genero  = filtroGenero.value;
                const idade   = filtroIdade.value;
                const apenasDisponiveis = filtroDisponivel.checked;

                cards.forEach((card) => {
                    const cardPorte   = card.dataset.porte;
                    const cardGenero  = card.dataset.genero;
                    const cardIdade   = card.dataset.idade;
                    const cardStatus  = card.dataset.status;

                    const coincidePorte   = !porte  || cardPorte === porte;
                    const coincideGenero  = !genero || cardGenero === genero;
                    const coincideIdade   = !idade  || cardIdade === idade;
                    const coincideStatus  = !apenasDisponiveis || cardStatus === 'disponivel';

                    const visivel = coincidePorte && coincideGenero && coincideIdade && coincideStatus;
                    card.classList.toggle('d-none', !visivel);
                });
            };

            [filtroPorte, filtroGenero, filtroIdade, filtroDisponivel].forEach((elemento) => {
                elemento.addEventListener('change', aplicaFiltros);
            });

            aplicaFiltros();
        });
    </script>
@endsection
