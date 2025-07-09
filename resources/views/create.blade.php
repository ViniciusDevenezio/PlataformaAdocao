@extends('layouts.main')

@section('content')
<div id="form-pet-container">
    <h2>Cadastrar Animal</h2>

    <form action="{{ route('pets.store') }}" method="POST">
        @csrf

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>

        <div class="form-row">
    <label for="especie">Espécie:</label>
    <select name="especie" id="especie" required>
        <option value="Cachorro">Cachorro</option>
        <option value="Gato">Gato</option>
        <option value="Outro">Outro</option>
    </select>
</div>

        <label for="idade">Idade (anos):</label>
        <input type="number" name="idade" id="idade" min="0">

        <label for="saude">Condição de Saúde:</label>
        <textarea name="saude" id="saude" rows="3"></textarea>

       <div class="form-row">
    <label for="ong_id">ONG responsável:</label>
    <select name="ong_id" id="ong_id" required>
        @foreach($ongs as $ongId => $ongNome)
            <option value="{{ $ongId }}">{{ $ongNome }}</option>
        @endforeach
    </select>
</div>

        <div class="form-check">
    <input type="checkbox" name="disponivel" id="disponivel" value="1" checked>
    <label for="disponivel">Disponível para adoção</label>
</div>

        <button type="submit" class="btn-update">Salvar</button>
    </form>
</div>
@endsection
