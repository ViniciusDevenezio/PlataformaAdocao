@extends('layouts.main')

@section('title', 'Meus Pets')

{{-- Só estilos específicos da página (sem .sidebar/.main-content) --}}
@section('head')
<style>
  body { overflow-x: hidden; background-color: #f8f9fa; }
  .table img { max-width: 70px; height: auto; }
</style>
@endsection

@section('content')
  <h2 class="mb-4">🐾 Pets cadastrados pela ONG</h2>

  <a href="{{ route('ong.pets.novo') }}" class="btn btn-success mb-3">+ Novo Pet</a>

  @if($pets->isEmpty())
    <div class="alert alert-info">Nenhum pet cadastrado ainda.</div>
  @else
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>Foto</th>
            <th>Nome</th>
            <th>Gênero</th>
            <th>Idade</th>
            <th>Porte</th>
            <th style="width:16rem;">Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pets as $pet)
            <tr @class(['table-warning'=>$pet->status=='reservado','table-danger'=>$pet->status=='adotado'])>
              <td><img src="{{ Storage::url('images/' . $pet->imagem_url) }}" alt="Foto do pet" class="rounded"></td>
              <td>{{ $pet->nome }}</td>
              <td>{{ ucfirst($pet->genero) }}</td>
              <td>{{ $pet->idade ?? 'Não informado' }}</td>
              <td>{{ ucfirst($pet->porte) }}</td>
              <td>
                <form action="{{ route('ong.pets.atualizar.status', $pet->id) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja alterar o status do pet?')"
                      class="d-flex align-items-center gap-2">
                  @csrf @method('PUT')
                  <select name="status" class="form-select form-select-sm w-auto">
                    <option value="disponivel" {{ $pet->status=='disponivel' ? 'selected' : '' }}>Disponível</option>
                    <option value="reservado"  {{ $pet->status=='reservado'  ? 'selected' : '' }}>Reservado</option>
                    <option value="adotado"    {{ $pet->status=='adotado'    ? 'selected' : '' }}>Adotado</option>
                  </select>
                  <button type="submit" class="btn btn-sm btn-primary">Confirmar</button>
                </form>
              </td>
              <td>
                <a href="{{ route('ong.pets.editar', $pet->id) }}" class="btn btn-sm btn-warning">✏️</a>
                <form action="{{ route('ong.pets.excluir', $pet->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Deseja mesmo excluir este pet?')">🗑️</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
@endsection
