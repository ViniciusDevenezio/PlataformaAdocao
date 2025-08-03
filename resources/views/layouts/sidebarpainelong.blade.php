<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Painel da ONG')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
    @yield('head')
</head>
<body>
    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar-lateral-ong">
        <a href="{{ route('painel.ong') }}" class="{{ request()->routeIs('painel.ong') ? 'active-link' : '' }}">🏠 Início</a>
        <a href="{{ route('ong.pets') }}" class="{{ request()->routeIs('ong.pets') ? 'active-link' : '' }}">Meus Pets</a>
        <a href="{{ route('ong.pets.novo') }}" class="{{ request()->routeIs('ong.pets.novo') ? 'active-link' : '' }}">Novo Pet</a>
        <a href="{{ route('ong.interesses') }}" class="{{ request()->routeIs('ong.interesses') ? 'active-link' : '' }}">Pedidos de Adoção</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    {{-- CONTEÚDO PRINCIPAL --}}
    <div class="main-content">
        <h2 id="titulo-painel">Painel da ONG - {{ auth('ong')->user()->nome }}</h2>
        @yield('content_sidebar')
    </div>

    @yield('scripts_sidebar')
</body>
</html>
