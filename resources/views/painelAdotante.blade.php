@extends ('layouts.main')

@section('head')

@endsection

@section('menu')

@endsection


@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- MENU LATERAL --}}
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('home') }}" class="list-group-item list-group-item-action">🏠 Início</a>
                <a href="{{ route('adotante.pets') }}" class="list-group-item list-group-item-action active">🐾 Meus Pets</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="list-group-item list-group-item-action text-start text-danger" type="submit">🚪 Sair</button>
                </form>
            </div>
        </div>

        {{-- CONTEÚDO PRINCIPAL --}}
        <div class="col-md-9">
            <h2>🐶 Pets Reservados</h2>
            <div class="row">
                @forelse($pets as $pet)
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <img src="{{ asset('images/' . $pet->imagem_url) }}" class="card-img-top" alt="{{ $pet->nome }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $pet->nome }}</h5>
                                <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $pet->status)) }}</p>
                                <p><strong>Raça:</strong> {{ $pet->raca }}</p>
                                <p><strong>Localização:</strong> {{ $pet->localizacao }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Você ainda não reservou nenhum pet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
