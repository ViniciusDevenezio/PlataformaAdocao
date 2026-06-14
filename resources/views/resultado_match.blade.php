@extends('layouts.main')

@section('title', 'Resultado do Match')

@section('content')
<div class="container py-5" style="max-width: 800px; margin-top:5vh;">

  <div class="text-center mb-4">
    <i class="bi bi-stars fs-1" style="color:#ff8a00;"></i>
    <h2 class="fw-bold">Seu Pet Ideal</h2>
    <p class="text-muted">A IA analisou suas respostas e encontrou o match perfeito para você!</p>
  </div>

  @if(!empty($erro))
    <div class="alert alert-danger text-center mb-4">
      {{ $erro }}
    </div>
  @elseif(!$pet)
    <div class="alert alert-warning text-center mb-4">
      O pet sugerido pela IA não foi encontrado no banco de dados.
    </div>
  @else
    <div class="card shadow-sm p-4 d-flex flex-row gap-4 align-items-center">

      @php
        $img = $pet->imagem_url
            ? asset('storage/images/' . ltrim($pet->imagem_url, '/'))
            : 'https://placehold.co/200x200?text=Pet';
      @endphp

      <img src="{{ $img }}" alt="Foto do pet"
           class="rounded"
           style="width:200px;height:200px;object-fit:cover;">

      <div>
        <h3 class="fw-bold">{{ $pet->nome }}</h3>
        <p class="text-muted mb-2">
          <em>{{ $sugestao['motivo'] ?? 'Este pet combina com você!' }}</em>
        </p>

        <ul class="list-unstyled">
          <li><strong>Espécie:</strong> {{ $pet->especie }}</li>
          <li><strong>Porte:</strong> {{ $pet->porte }}</li>
          <li><strong>Temperamento:</strong> {{ $pet->temperamento }}</li>
          <li><strong>Faixa etária:</strong> {{ $pet->faixa_etaria }}</li>
          <li><strong>Idade:</strong> {{ $pet->idade }} anos</li>
          @if(!empty($pet->descricao))
            <li><strong>Sobre:</strong> {{ $pet->descricao }}</li>
          @endif
        </ul>

        <a href="{{ route('pet.mostrar', $pet->slug) }}" class="btn btn-success mt-3" target="_blank" rel="noopener">
          <i class="bi bi-heart-fill me-2"></i> Quero Adotar
        </a>
      </div>
    </div>
  @endif

</div>
@endsection
