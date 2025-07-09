@extends('layouts.main')

@section('content')
<div id="form-pet-container">
    <h2>Editar Animal</h2>

    <form action="{{ route('pets.update', $animal) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $animal->nome }}" required>

        <label for="especie">Espécie:</label>
        <select name="especie" id="especie" required>
            @foreach(['Cachorro','Gato','Outro'] as $opc)
                <option value="{{ $opc }}" @selected($animal->especie === $opc)>{{ $opc }}</option>
            @endforeach
        </select>

        <label for="idade">Idade (anos):</label>
        <input type="number" name="idade" id="idade" min="0" value="{{ $animal->idade }}">

        <label for="saude">Condição de Saúde:</label>
        <textarea name="saude" id="saude" rows="3">{{ $animal->saude }}</textarea>

        <label for="ong_id">ONG responsável:</label>
        <select name="ong_id" id="ong_id" required>
            @foreach($ongs as $ongId => $ongNome)
                <option value="{{ $ongId }}" @selected($animal->ong_id == $ongId)>{{ $ongNome }}</option>
            @endforeach
        </select>

        <div class="form-check">
            <input type="checkbox" name="disponivel" id="disponivel" value="1" {{ $animal->disponivel ? 'checked' : '' }}>
            <label for="disponivel">Disponível para adoção</label>
        </div>

        <button type="submit" class="btn-update">Atualizar</button>
    </form>
</div>
@endsection
