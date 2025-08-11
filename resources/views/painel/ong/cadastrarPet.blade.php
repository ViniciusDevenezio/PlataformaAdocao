@extends('layouts.main')
@section('title', 'Cadastrar Pet')

@section('head')
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  /* Banner entra no fluxo normal da página */
  .banner-editar-pet{
    background-color:#c2b5c5;
    padding:2rem .75rem;
    text-align:center;
    border-radius:.5rem;
    margin-top:.5rem;
  }
  .banner-editar-pet h1{
    font-size:2rem;
    color:#523f5f;
    margin:0;
  }

  /* Card do formulário */
  #formulario-editar-pet{
    background:#f8f8f8;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
    margin:1.5rem 0 3rem;
    min-height:400px;
  }

  /* Largura confortável sem centralizar demais */
  .form-wrap{
    max-width:1100px;
    margin-left:.5rem;   /* encosta mais na lateral */
  }

  @media (max-width: 992px){
    .form-wrap{ max-width:100%; margin-left:0; }
  }
</style>
@endsection

@section('content')
  <div class="banner-editar-pet">
    <h1>Cadastrar Pet</h1>
  </div>

  {{-- NÃO recrie sidebar/main-content aqui. Só o conteúdo. --}}
  <div class="container-fluid mt-4 px-2">
    <div class="form-wrap">
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $erro)
              <li>{{ $erro }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form id="formulario-editar-pet" action="{{ route('ong.pets.salvar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
          </div>
          <div class="col-md-6">
            <label for="raca" class="form-label">Raça</label>
            <input type="text" name="raca" id="raca" class="form-control" value="{{ old('raca') }}">
          </div>

          <div class="col-md-6">
            <label for="mistura" class="form-label">É uma mistura?</label>
            <select name="mistura" id="mistura" class="form-select py-2" required>
              <option value="">Selecione</option>
              <option value="1" {{ old('mistura') == 1 ? 'selected' : '' }}>Sim</option>
              <option value="0" {{ old('mistura') == 0 ? 'selected' : '' }}>Não</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="misturado_com" class="form-label">Misturado com (opcional)</label>
            <input type="text" name="misturado_com" id="misturado_com" class="form-control" value="{{ old('misturado_com') }}">
          </div>

          <div class="col-md-6">
            <label for="porte" class="form-label">Porte</label>
            <select name="porte" id="porte" class="form-select py-2">
              <option value="pequeno" {{ old('porte') == 'pequeno' ? 'selected' : '' }}>Pequeno</option>
              <option value="medio"   {{ old('porte') == 'medio'   ? 'selected' : '' }}>Médio</option>
              <option value="grande"  {{ old('porte') == 'grande'  ? 'selected' : '' }}>Grande</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="genero" class="form-label">Gênero</label>
            <select name="genero" id="genero" class="form-select py-2">
              <option value="macho" {{ old('genero') == 'macho' ? 'selected' : '' }}>Macho</option>
              <option value="femea" {{ old('genero') == 'femea' ? 'selected' : '' }}>Fêmea</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="idade" class="form-label">Idade</label>
            <input type="text" name="idade" id="idade" class="form-control" value="{{ old('idade') }}">
          </div>
          <div class="col-md-6">
            <label for="faixa_etaria" class="form-label">Faixa Etária</label>
            <select name="faixa_etaria" id="faixa_etaria" class="form-select py-2">
              <option value="">Selecione</option>
              <option value="Filhote" {{ old('faixa_etaria') == 'Filhote' ? 'selected' : '' }}>Filhote</option>
              <option value="Jovem"   {{ old('faixa_etaria') == 'Jovem'   ? 'selected' : '' }}>Jovem</option>
              <option value="Adulto"  {{ old('faixa_etaria') == 'Adulto'  ? 'selected' : '' }}>Adulto</option>
              <option value="Idoso"   {{ old('faixa_etaria') == 'Idoso'   ? 'selected' : '' }}>Idoso</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select py-2">
              <option value="disponivel" {{ old('status') == 'disponivel' ? 'selected' : '' }}>Disponível</option>
              <option value="reservado"  {{ old('status') == 'reservado'  ? 'selected' : '' }}>Reservado</option>
              <option value="adotado"    {{ old('status') == 'adotado'    ? 'selected' : '' }}>Adotado</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="disponivel_ate" class="form-label">Disponível até (opcional)</label>
            <input type="date" name="disponivel_ate" id="disponivel_ate" class="form-control" value="{{ old('disponivel_ate') }}">
          </div>

          <div class="col-md-6">
            <label for="temperamento" class="form-label">Temperamento</label>
            <input type="text" name="temperamento" id="temperamento" class="form-control" value="{{ old('temperamento') }}">
          </div>
          <div class="col-md-6">
            <label for="localizacao" class="form-label">Localização</label>
            <input type="text" name="localizacao" id="localizacao" class="form-control" value="{{ old('localizacao') }}">
          </div>

          <div class="col-12">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" id="descricao" class="form-control" rows="3">{{ old('descricao') }}</textarea>
          </div>

          <div class="col-12">
            <label for="imagem_url" class="form-label">Imagem</label>
            <input type="file" name="imagem_url" id="imagem_url" class="form-control">
          </div>

          <div class="col-12 text-center mt-3">
            <button type="submit" class="btn btn-primary">Cadastrar Pet</button>
            <a href="{{ route('ong.pets') }}" class="btn btn-secondary ms-2">Cancelar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
