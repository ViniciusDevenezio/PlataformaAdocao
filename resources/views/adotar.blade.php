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
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ asset('images/' . $pet->imagem_url) }}" class="card-img-top" alt="{{ $pet->nome }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pet->nome }}</h5>
                        <p><strong>Raça:</strong> {{ $pet->raca }} 
                            @if($pet->mistura)
                                (Mistura com {{ $pet->misturado_com }})
                            @endif
                        </p>
                        <p><strong>Temperamento:</strong> {{ $pet->temperamento }}</p>
                        <p><strong>Porte:</strong> {{ ucfirst($pet->porte) }}</p>
                        <p><strong>Status:</strong> {{ $mudaStatus[$pet->status] ?? 'Não informado' }}</p>

                        @if($pet->status === 'aguardando_aprovacao')
                            <button class="btn btn-secondary w-100 mt-3" disabled>Aguardando Ong</button>
                        @else
                            <form action="{{ route('pets.reservar', $pet->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100 mt-3">Reservar</button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection