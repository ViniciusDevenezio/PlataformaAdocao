@extends('layouts.main')

@section('head')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .banner-editar-pet {
            background-color: #c2b5c5;
            padding: 7rem 0.25vw;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            z-index: -1;
            /* Fica por trás do formulário */
        }

      .banner-editar-pet h1 {
    font-size: 2.5rem;
    color: #523f5f;
    margin: 0;
    padding-top: 1rem;  /* Adicione isso se quiser mais controle */
    transform: translateY(-2.5rem);; /* Reduza de 4rem para 2rem */
}

        #formulario-editar-pet {
            max-width: 800px;
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 9rem;
            min-height: 400px;

        }
    </style>
@endsection

@section('menu')
@endsection

@section('content')

    <div class="banner-editar-pet">
        <h1>Editar Pet</h1>
    </div>

    <div class="container mt-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formulario-editar-pet" action="{{ route('ong.pets.atualizar', $pet->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $pet->nome) }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="raca">Raça</label>
                    <input type="text" name="raca" id="raca" class="form-control" value="{{ old('raca', $pet->raca) }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="mistura">É uma mistura?</label>
                    <select name="mistura" id="mistura" class="form-select py-2" required>
                        <option value="">Selecione</option>
                        <option value="1" {{ old('mistura', $pet->mistura) == 1 ? 'selected' : '' }}>Sim</option>
                        <option value="0" {{ old('mistura', $pet->mistura) == 0 ? 'selected' : '' }}>Não</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="misturado_com">Misturado com (opcional)</label>
                    <input type="text" name="misturado_com" id="misturado_com" class="form-control"
                        value="{{ old('misturado_com', $pet->misturado_com ?? '') }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="porte">Porte</label>
                    <select name="porte" class="form-select py-2">
                        <option value="pequeno" {{ $pet->porte == 'pequeno' ? 'selected' : '' }}>Pequeno</option>
                        <option value="medio" {{ $pet->porte == 'medio' ? 'selected' : '' }}>Médio</option>
                        <option value="grande" {{ $pet->porte == 'grande' ? 'selected' : '' }}>Grande</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="genero">Gênero</label>
                    <select name="genero" class="form-select py-2">
                        <option value="macho" {{ $pet->genero == 'macho' ? 'selected' : '' }}>Macho</option>
                        <option value="femea" {{ $pet->genero == 'femea' ? 'selected' : '' }}>Fêmea</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="idade">Idade</label>
                    <input type="text" name="idade" id="idade" class="form-control" value="{{ old('idade', $pet->idade) }}">
                </div>
                <div class="col-md-6">
                    <label for="faixa_etaria">Faixa Etária</label>
                    <select name="faixa_etaria" id="faixa_etaria" class="form-select py-2">
                        <option value="">Selecione</option>
                        <option value="Filhote" {{ old('faixa_etaria', $pet->faixa_etaria) == 'Filhote' ? 'selected' : '' }}>
                            Filhote</option>
                        <option value="Jovem" {{ old('faixa_etaria', $pet->faixa_etaria) == 'Jovem' ? 'selected' : '' }}>Jovem
                        </option>
                        <option value="Adulto" {{ old('faixa_etaria', $pet->faixa_etaria) == 'Adulto' ? 'selected' : '' }}>
                            Adulto</option>
                        <option value="Idoso" {{ old('faixa_etaria', $pet->faixa_etaria) == 'Idoso' ? 'selected' : '' }}>Idoso
                        </option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="status">Status</label>
                    <select name="status" class="form-select py-2">
                        <option value="disponivel" {{ $pet->status == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                        <option value="reservado" {{ $pet->status == 'reservado' ? 'selected' : '' }}>Reservado</option>
                        <option value="adotado" {{ $pet->status == 'adotado' ? 'selected' : '' }}>Adotado</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="disponivel_ate">Disponível até (opcional)</label>
                    <input type="date" name="disponivel_ate" class="form-control"
                        value="{{ old('disponivel_ate', $pet->disponivel_ate) }}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="temperamento">Temperamento</label>
                    <input type="text" name="temperamento" class="form-control"
                        value="{{ old('temperamento', $pet->temperamento) }}">
                </div>
                <div class="col-md-6">
                    <label for="localizacao">Localização</label>
                    <input type="text" name="localizacao" class="form-control"
                        value="{{ old('localizacao', $pet->localizacao) }}">
                </div>
            </div>

            <div class="mt-3">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3">{{ old('descricao', $pet->descricao) }}</textarea>
            </div>

            <div class="mt-3">
                <label for="imagem_url">Nova Imagem (opcional)</label>
                <input type="file" name="imagem_url" class="form-control">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Salvar alterações</button>
                <a href="{{ route('ong.pets') }}" class="btn btn-secondary ms-2">Cancelar</a>
            </div>
        </form>
    </div>
@endsection