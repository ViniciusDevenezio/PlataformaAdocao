@extends('layouts.main')

@section('head')
@endsection

@section('menu')
@endsection

@section('content')
<div class="container">
    <br>
    <br>
    <h2 class="h2cad" style="font-size: 24px; display: block;">Cadastro de Animais</h2>
    <form class="formcad" action="#" method="POST">
        <label class="labelcad" for="nome">Nome do Animal:</label>
        <input class="inputcad" type="text" id="nome" name="nome" required>

        <label class="labelcad" for="idade">Idade:</label>
        <input class="inputcad" type="number" id="idade" name="idade" min="0" required>

        <label class="labelcad" for="especie">Espécie:</label>
        <select class="selectcad" id="especie" name="especie">
            <option value="Cachorro">Cachorro</option>
            <option value="Gato">Gato</option>
            <option value="Outro">Outro</option>
        </select>

        <label class="labelcad" for="raca">Raça:</label>
        <input class="inputcad" type="text" id="raca" name="raca">

        <label class="labelcad" for="descricao">Descrição:</label>
        <textarea class="textareacad" id="descricao" name="descricao" rows="3"></textarea>

        <label class="labelcad" for="foto">Foto do Animal:</label>
        <input class="inputcad" type="file" id="foto" name="foto" accept="image/*">

        <button class="buttoncad" type="submit">Cadastrar</button>
    </form>
</div>
@endsection

