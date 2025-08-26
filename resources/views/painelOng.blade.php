
@section('head')

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
            /* azul-petróleo */
            color: #fff;
        }

        .sidebar a {
            color: #e0e0e0;
            /* branco opaco */
            border-bottom: 1px solid #ffffff1a;
        }
    </style>
@endsection

@section('content')

    {{-- Sidebar Lateral --}}

    {{-- Conteudo  --}}
    <div class="main-content mb-4">
        <h2 class="mb-5" id="titulo-painel">Painel da ONG - {{ auth('ong')->user()->nome }}</h2>

        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="{{ route('ong.pets') }}" class="card card-link p-3 shadow-sm">
                    <h5 class="fw-bold">📋 Meus Pets</h5>
                    <p class="text-muted">Gerencie os pets cadastrados</p>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('ong.pets.novo') }}" class="card card-link p-3 shadow-sm">
                    <h5 class="fw-bold">➕ Novo Pet</h5>
                    <p class="text-muted">Cadastrar um novo pet para adoção</p>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('ong.interesses') }}" class="card card-link p-3 shadow-sm">
                    <h5 class="fw-bold">📨 Pedidos de Adoção</h5>
                    <p class="text-muted">Veja quem demonstrou interesse</p>
                </a>
            </div>
        </div>
    </div>
@endsection