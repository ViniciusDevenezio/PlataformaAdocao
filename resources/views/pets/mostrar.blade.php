@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleCadastro.css') }}">
    <style>
        #container-principal-mostrar {
            padding-top: 6rem;
        }
        .info-box, .history-box {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .info-box h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: .5rem;
        }
        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: .9rem;
            font-weight: 600;
        }
        .badge-status.disponivel { background: #d4edda; color: #155724; }
        .badge-status.reservado { background: #fff3cd; color: #856404; }
        .badge-status.adotado   { background: #f8d7da; color: #721c24; }
    </style>
@endsection

@section('content')
    <div class="container" id="container-principal-mostrar">
        <div class="row g-4">
            <!-- Coluna da imagem -->
            <div class="col-md-6">
                @php
                    $src = $pet->imagem_url
                        ? asset('storage/images/' . ltrim($pet->imagem_url, '/'))
                        : null;
                @endphp

                @if($src)
                    <img src="{{ $src }}" class="img-fluid rounded shadow" alt="{{ $pet->nome }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded shadow"
                         style="height:300px;">
                        <span class="text-muted">Sem foto</span>
                    </div>
                @endif
            </div>

            <!-- Coluna de informações -->
            <div class="col-md-6">
                <div class="info-box">
                    <h1>{{ $pet->nome ?? 'Sem nome' }} </h1>
                    <p>
                        <span class="badge-status {{ $pet->status }}">
                            {{ ucfirst($pet->status) }}
                        </span>
                    </p>
                    <p class="text-muted mb-4">
                        {{ ucfirst($pet->especie ?? '') }} | {{ ucfirst($pet->genero ?? '') }} | Porte: {{ ucfirst($pet->porte ?? '') }} |
                        {{ $pet->faixa_etaria ?? 'Idade não informada' }}
                    </p>

                    <!-- Informações em grid -->
                 <div class="row mb-3 g-3">
    <!-- Raça e Cruzado -->
    <div class="col-6">
        <strong>Raça Predominante:</strong><br>
        {{ $pet->raca ?? 'SRD' }}
    </div>
    <div class="col-6">
        <strong>É cruzado?</strong><br>
        {{ $pet->mistura ? 'Sim' : 'Não' }}
    </div>

    <!-- Raça aparente -->
    <div class="col-6">
        <strong>Raça Secundaria:</strong><br>
        {{ $pet->mistura && $pet->misturado_com ? $pet->misturado_com : '-' }}
    </div>
       <div class="col-6">
        <strong>Idade:</strong><br>
        {{ $pet->idade ?? '-' }}
    </div>

    <!-- Temperamento -->
    <div class="col-12">
        <strong>Temperamento:</strong><br>
        {{ $pet->temperamento ? implode(', ', explode(',', $pet->temperamento)) : 'Não informado' }}
    </div>

    <!-- Idade e Disponibilidade -->


    <!-- Saúde -->
    <div class="col-6">
        <strong>Vacinado:</strong><br>
        {{ $pet->vacinado ? 'Sim' : 'Não' }}
    </div>
    <div class="col-6">
        <strong>Vermifugado:</strong><br>
        {{ $pet->vermifugado ? 'Sim' : 'Não' }}
    </div>

    <!-- Localização -->
    <div class="col-12">
        <strong>Localização:</strong><br>
        {{ $pet->localizacao ?? (optional($pet->ong)->cidade ?? '-') }}
    </div>
</div>

                    <!-- Botão WhatsApp -->
                    @php
                        $nomeUsuario = auth('adotante')->user()->nome_completo ?? 'Adotante';
                        $cidadeUsuario = auth('adotante')->user()->cidade ?? 'sua cidade';
                        $mensagemUrl = urlencode("Olá, meu nome é $nomeUsuario e tenho interesse no pet {$pet->nome}. Moro em $cidadeUsuario.");
                        $numeroOng = preg_replace('/\D/', '', optional($pet->ong)->telefone ?? '');
                        if ($numeroOng && !str_starts_with($numeroOng, '55')) {
                            $numeroOng = '55' . $numeroOng;
                        }
                    @endphp

                    @if($numeroOng)
                        <a href="https://wa.me/{{ $numeroOng }}?text={{ $mensagemUrl }}"
                           target="_blank" class="btn btn-success w-100 fw-bold">Quero Adotar!</a>
                    @else
                        <button class="btn btn-secondary w-100" disabled>WhatsApp indisponível</button>
                    @endif
                </div>
            </div>
        </div>

        <!-- História -->
        <div class="history-box mt-4">
            <h5><strong>História do pet {{ $pet->nome ?? 'Sem nome' }}</strong></h5>
            <p>{{ $pet->descricao ?? 'Sem história informada.' }}</p>
        </div>
    </div>
@endsection
