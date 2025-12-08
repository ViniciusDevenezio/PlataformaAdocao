@extends('layouts.sidebarpainelong')

<style>
    #titulo-painel {
        margin-top: 2rem;
    }

    .active-link {
        background-color: #2e5672ff !important;
        font-weight: bold;
        color: #fff !important;
    }

    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card-link:hover {
        background-color: #f5f5f5;
    }
</style>

{{-- Conteudo --}}
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="bi bi-clipboard-heart text-success me-2"></i> Pets cadastrados pela ONG
    </h2>

    <a href="{{ route('ong.pets.novo') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle me-2"></i> Novo Pet
    </a>

    @if($pets->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-2"></i> Nenhum pet cadastrado ainda.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm rounded overflow-hidden">
                <thead class="table-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Nome</th>
                        <th>Gênero</th>
                        <th>Idade</th>
                        <th>Porte</th>
                        <th style="width: 16rem;">Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $pet)
                        <tr @class([
                            'table-warning' => $pet->status == 'reservado',
                            'table-danger' => $pet->status == 'adotado',
                        ])>
                            <td style="width: 80px">
                                <img src="{{ secure_asset('storage/images/' . $pet->imagem_url) }}" width="70"
                                    class="rounded shadow-sm" alt="Foto do pet">
                            </td>
                            <td>{{ $pet->nome }}</td>
                            <td>{{ ucfirst($pet->genero) }}</td>
                            <td>{{ $pet->idade ?? 'Não informado' }}</td>
                            <td>{{ ucfirst($pet->porte) }}</td>
                            <td>
                                <form action="{{ route('ong.pets.atualizar.status', $pet->id) }}" method="POST"
                                    onsubmit="return confirm('Tem certeza que deseja alterar o status do pet?')"
                                    class="d-flex justify-content-center align-items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm w-auto">
                                        <option value="disponivel" {{ $pet->status == 'disponivel' ? 'selected' : '' }}>Disponível
                                        </option>
                                        <option value="reservado" {{ $pet->status == 'reservado' ? 'selected' : '' }}>Reservado
                                        </option>
                                        <option value="adotado" {{ $pet->status == 'adotado' ? 'selected' : '' }}>Adotado</option>
                                    </select>

                                    <!-- mantém botão Confirmar azul -->
                                    <button type="submit" class="btn btn-sm btn-primary">Confirmar</button>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('ong.pets.editar', $pet->id) }}" class="btn btn-sm btn-outline-warning me-1"
                                    title="Editar">
                                    <i class="bi bi-pencil-square fs-5"></i>
                                </a>

                                <form action="{{ route('ong.pets.excluir', $pet->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Deseja mesmo excluir este pet?')" title="Excluir">
                                        <i class="bi bi-trash3 fs-5"></i>
                                    </button>
                                </form>
                                <form action="{{ route('ong.pets.facebook', $pet->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-primary" title="Enviar ao Facebook">
                                        <i class="bi bi-send fs-5"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
