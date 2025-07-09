@extends('layouts.main')

@section('content')
<div class="pet-list-container">
    <h1>Gerenciamento de Animais</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pets.create') }}" class="btn-cadastrar-pet">+ Adicionar Animal</a>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Espécie</th>
                    <th>Idade</th>
                    <th>ONG Responsável</th>
                    <th>Disponível?</th>
                    <th style="width: 140px;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animais as $animal)
                <tr>
                    <td>{{ $animal->id }}</td>
                    <td>{{ $animal->nome }}</td>
                    <td>{{ $animal->especie }}</td>
                    <td>{{ $animal->idade ?? '-' }}</td>
                    <td>{{ $animal->ong->nome ?? '-' }}</td>
                    <td>{{ $animal->disponivel ? 'Sim' : 'Não' }}</td>
                    <td>
                        <a href="{{ route('pets.edit', $animal) }}" class="btn btn-sm btn-primary" title="Editar">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('pets.destroy', $animal) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="fas fa-trash-alt"></i> Excluir
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($animais->isEmpty())
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhum animal cadastrado.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
