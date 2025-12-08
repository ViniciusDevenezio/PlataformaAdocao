@extends('layouts.main')

@section('title', 'Resultado do Match')

@section('head')
<style>
    :root {
        --match-primary: #7f4ca5;
        --match-primary-dark: #6c3f93;
        --match-soft-bg: #f7f3fb;
        --match-accent: #ff8a00;
    }

    .match-result-page {
        padding-top: 7rem;
        padding-bottom: 3rem;
    }

    .match-result-layout {
        max-width: 900px;
        margin: 0 auto;
        padding-inline: .75rem;
    }

    .match-result-header-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff5ea;
        color: var(--match-accent);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
    }

    .match-result-header h2 {
        color: #523f5f;
    }

    .match-result-header p {
        color: #7d6f8a;
        max-width: 460px;
        margin: .5rem auto 0;
    }

    .match-result-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .25rem .8rem;
        border-radius: 999px;
        border: 1px solid #e0d2f2;
        background: #f8f3ff;
        color: #7b5a9c;
        font-size: .8rem;
        font-weight: 500;
    }

    /* Alerts mais bonitinhos */
    .match-alert {
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        border-width: 1px;
    }

    .match-alert-danger {
        border-color: #f8d7da;
        background: #fff5f6;
        color: #842029;
    }

    .match-alert-warning {
        border-color: #ffe8b3;
        background: #fff9e6;
        color: #7a5b15;
    }

    /* Card do resultado */
    .match-result-card {
        border-radius: 1.2rem;
        border: 1px solid #e3d8f2;
        background: #ffffff;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.08);
        padding: 1.75rem 1.5rem;
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
    }

    @media (min-width: 768px) {
        .match-result-card {
            padding: 2rem 2rem;
            gap: 2rem;
        }
    }

    @media (max-width: 767.98px) {
        .match-result-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
    }

    .match-result-image {
        width: 220px;
        height: 220px;
        border-radius: 1.1rem;
        object-fit: cover;
        object-position: center;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        flex-shrink: 0;
    }

    @media (max-width: 767.98px) {
        .match-result-image {
            width: 100%;
            max-width: 260px;
            height: 260px;
        }
    }

    .match-result-body h3 {
        color: #2f2440;
    }

    .match-result-reason {
        color: #7d6f8a;
        font-size: .95rem;
    }

    .match-result-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: .75rem;
        font-size: .93rem;
    }

    .match-result-list li + li {
        margin-top: .25rem;
    }

    .match-result-list strong {
        color: #5a4b66;
        font-weight: 600;
    }

    .match-result-adopt-btn {
        font-weight: 600;
        border-radius: 999px;
        padding: .55rem 1.4rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        box-shadow: 0 8px 18px rgba(25, 135, 84, 0.35);
    }

    /* Link voltar */
    .match-result-back {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .9rem;
        color: #7d6f8a;
        text-decoration: none;
        margin-top: 1.25rem;
    }

    .match-result-back:hover {
        color: var(--match-primary);
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="match-result-page">
    <div class="match-result-layout">

        <div class="text-center mb-4 match-result-header">
            <div class="match-result-header-icon mb-3">
                <i class="bi bi-stars fs-3"></i>
            </div>
            <h2 class="fw-bold">Seu Pet Ideal</h2>
            <p class="text-muted">
                A IA analisou suas respostas e encontrou o match perfeito para você!
            </p>
            <div class="mt-2">
                <span class="match-result-badge">
                    <i class="bi bi-magic"></i>
                    Match gerado com IA Carinho Pet
                </span>
            </div>
        </div>

        @if(!empty($erro))
            <div class="match-alert match-alert-danger text-center mb-4">
                {{ $erro }}
            </div>
        @elseif(!$pet)
            <div class="match-alert match-alert-warning text-center mb-4">
                O pet sugerido pela IA não foi encontrado no banco de dados.  
                Tente novamente mais tarde ou ajuste suas respostas.
            </div>
        @else
            @php
                $img = $pet->imagem_url
                    ? secure_asset('storage/images/' . ltrim($pet->imagem_url, '/'))
                    : 'https://placehold.co/400x400?text=Pet';
            @endphp

            <div class="match-result-card mb-3">

                <img src="{{ $img }}" alt="Foto do pet {{ $pet->nome }}"
                     class="match-result-image">

                <div class="match-result-body">
                    <h3 class="fw-bold mb-1">{{ $pet->nome }}</h3>

                    <p class="match-result-reason mb-3">
                        <em>{{ $sugestao['motivo'] ?? 'Este pet combina com seu estilo de vida e rotina!' }}</em>
                    </p>

                    <ul class="match-result-list">
                        <li><strong>Espécie:</strong> {{ $pet->especie }}</li>
                        <li><strong>Porte:</strong> {{ $pet->porte }}</li>
                        <li><strong>Temperamento:</strong> {{ $pet->temperamento }}</li>
                        <li><strong>Faixa etária:</strong> {{ $pet->faixa_etaria }}</li>
                        <li><strong>Idade:</strong> {{ $pet->idade }} anos</li>
                        @if(!empty($pet->descricao))
                            <li><strong>Sobre:</strong> {{ $pet->descricao }}</li>
                        @endif
                    </ul>

                    <a href="{{ route('pet.mostrar', $pet->slug) }}"
                       class="btn btn-success match-result-adopt-btn mt-2"
                       target="_blank" rel="noopener">
                        <i class="bi bi-heart-fill"></i>
                        Quero Adotar
                    </a>

                    <div>
                        <a href="{{ route('match.form') ?? url()->previous() }}"
                           class="match-result-back">
                            <i class="bi bi-arrow-left"></i>
                            Refazer o questionário
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
