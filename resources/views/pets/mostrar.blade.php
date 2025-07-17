@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleCadastro.css') }}">
        <style>
        #container-principal-mostrar {
            padding-top: 6rem;
        }
        .info-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }
        .info-box h1 {
            font-size: 1.8rem;
        }
        .info-box p {
            margin-bottom: 4px;
        }
        .adopt-button {
            background-color: #8E3162;
            border: none;
            color: white;
            width: 100%;
            padding: 12px;
            font-weight: bold;
            margin-top: 15px;
        }
        .gallery-thumbnails img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 2px solid transparent;
            margin-right: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .share-icons i {
            font-size: 1.4rem;
            margin-right: 15px;
            cursor: pointer;
        }
        .history-box {
            background: #fff;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 6px;
            margin-top: 25px;
        }
    </style>
@endsection

@section('content')
<div class="container mt-4" id="container-principal-mostrar">
    <div class="row">
        <!-- Bloco da imagem e galeria -->
        <div class="col-md-6" id="coluna-esq-mostrar">
            <img src="{{ asset('images/' . $pet->imagem_url) }}" class="img-fluid rounded shadow mb-2" alt="{{ $pet->nome }}">

            {{-- Thumbnails (repetindo a imagem por enquanto) --}}
            <div class="gallery-thumbnails d-flex mt-2">
                @for ($i = 0; $i < 4; $i++)
                    <img src="{{ asset('images/' . $pet->imagem_url) }}" alt="Thumbnail">
                @endfor
            </div>
        </div>

        <!-- Bloco de informações -->
        <div class="col-md-6">
            <div class="info-box">
                <h1>Pet {{ $pet->nome ?? 'Sem nome ainda' }} para doação</h1>
                <p class="text-muted">
                    {{ ucfirst($pet->genero) }} | {{ ucfirst($pet->porte) }} | {{ $pet->faixa_etaria ?? 'Idade não informada' }}
                </p>

                <div class="row mb-2">
                    <div class="col-6"><strong>Raça:</strong> {{ $pet->raca ?? 'SRD' }}</div>
                    <div class="col-6"><strong>Localização:</strong> {{ $pet->localizacao ?? ($pet->ong->cidade ?? 'Cidade não informada') }}</div>
                    <div class="col-6"><strong>Sexo:</strong> {{ ucfirst($pet->genero) }}</div>
                    <div class="col-6"><strong>Código:</strong> {{ $pet->id }}</div>
                </div>

                @php
                    $nomeUsuario = auth('adotante')->user()->nome_completo ?? 'Adotante';
                    $cidadeUsuario = auth('adotante')->user()->cidade ?? 'sua cidade';
                    $mensagem = "Olá, meu nome é $nomeUsuario e tenho interesse no pet {$pet->nome}. Moro em $cidadeUsuario.";
                    $mensagemUrl = urlencode($mensagem);
                    $numeroOng = preg_replace('/\D/', '', $pet->ong->telefone);
                @endphp

                <a href="https://wa.me/{{ $numeroOng }}?text={{ $mensagemUrl }}" target="_blank" class="btn btn-primary w-100"> Quero Adotar!</a>

                <div class="mt-3">
                    <span>Compartilhar</span><br>
                    <div class="share-icons mt-1">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <i class="bi bi-facebook text-primary"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode(request()->fullUrl()) }}" target="_blank">
                            <i class="bi bi-whatsapp text-success"></i>
                        </a>
                        <i class="bi bi-share-fill text-dark"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- História -->
    <div class="history-box mt-4">
        <h5><strong>História do pet {{ $pet->nome ?? 'Sem nome ainda' }}</strong></h5>
        <p>{{ $pet->descricao ?? 'Sem história informada para este pet.' }}</p>
    </div>
</div>
@endsection

