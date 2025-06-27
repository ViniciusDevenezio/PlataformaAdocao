@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleCadastro.css') }}">
@endsection

@section('menu')
@endsection

@section('content')
<div class="container">
    <h1>Pets disponíveis</h1>
    <div class="row">
        @foreach ($pets as $pet)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('images/' . $pet->imagem_url) }}" class="card-img-top" alt="{{ $pet->nome }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet->nome }}</h5>
                        <p><strong>Raça:</strong> {{ $pet->raca }} @if($pet->mistura) (Mistura com {{ $pet->misturado_com }}) @endif</p>
                        <p><strong>Temperamento:</strong> {{ $pet->temperamento }}</p>
                        <p><strong>Porte:</strong> {{ ucfirst($pet->porte) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($pet->status) }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
