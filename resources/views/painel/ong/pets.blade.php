
@extends('layouts.sidebarpainelong')


    <style>
        body {
            overflow-x: hidden;
        }

        #titulo-painel {
            margin-top: 2rem;
        }

        .active-link {
            background-color: #2e5672ff !important;
            font-weight: bold;
            color: #fff !important;
        }

        #sidebar-lateral-ong {
            margin-top: 2.5rem;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
            background-color: #2e2e2eff;
            padding-top: 60px;
        }

        .sidebar a {
            color: #fff;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .main-content {
            margin-left: 220px;
            padding: 3rem 2rem;
        }

        .card-link {
            text-decoration: none;
            color: inherit;
        }

        .card-link:hover {
            background-color: #f5f5f5;
        }

        .sidebar a:nth-child(odd) {
            background-color: #3b3b3b;
        }

        .sidebar a:nth-child(even) {
            background-color: #2f2f2f;
        }

        .sidebar a:hover {
            background-color: #4b6374;
            color: #fff;
        }

        .sidebar a {
            color: #e0e0e0;
            border-bottom: 1px solid #ffffff1a;
        }
    </style>

    {{-- Conteudo --}}
    <div class="container mt-4">
        <h2 class="mb-4">🐾 Pets cadastrados pela ONG</h2>

        <a href="{{ route('ong.pets.novo') }}" class="btn btn-success mb-3">
            + Novo Pet
        </a>

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
                            <th style="width: 16rem;">Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pets as $pet)
                            <tr @class([
                                'table-warning' => $pet->status == 'reservado',
                                'table-danger' => $pet->status == 'adotado',
                            ])>
                                <td style="width: 80px">
                                    <img src="{{ asset('storage/images/' . $pet->imagem_url) }}" width="70" class="rounded" alt="Foto do pet">
                                </td>
                                <td>{{ $pet->nome }}</td>
                                <td>{{ ucfirst($pet->genero) }}</td>
                                <td>{{ $pet->idade ?? 'Não informado' }}</td>
                                <td>{{ ucfirst($pet->porte) }}</td>
                                <td>
                                    <form action="{{ route('ong.pets.atualizar.status', $pet->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja alterar o status do pet?')"
                                        class="d-flex align-items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-select form-select-sm w-auto">
                                            <option value="disponivel" {{ $pet->status == 'disponivel' ? 'selected' : '' }}>Disponível
                                            </option>
                                            <option value="reservado" {{ $pet->status == 'reservado' ? 'selected' : '' }}>Reservado
                                            </option>
                                            <option value="adotado" {{ $pet->status == 'adotado' ? 'selected' : '' }}>Adotado</option>
                                        </select>

                                        <button type="submit" class="btn btn-sm btn-primary">Confirmar</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('ong.pets.editar', $pet->id) }}" class="btn btn-sm btn-warning">✏️</a>

                                    <form action="{{ route('ong.pets.excluir', $pet->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Deseja mesmo excluir este pet?')">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>