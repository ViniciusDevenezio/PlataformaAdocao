<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pet Projeto')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Seu CSS -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    @yield('head')
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        @auth('ong')
            <button id="btn-toggle-sidebar" type="button" class="btn btn-outline-dark me-3" aria-label="Alternar menu">☰</button>
        @endauth

        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="/img/logo2.png" alt="Logo" class="logo-navbar">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Cachorros</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Gatos</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn-adotar" href="{{ route('adotar') }}">Quero Adotar</a>
                </li>

                @auth('adotante')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuAdotante" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Olá, {{ Auth::guard('adotante')->user()->nome_completo }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuAdotante">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="/painelAdotante">Meus Pets</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item m-0 p-0">
                                    @csrf
                                    <button type="submit" class="btn w-100 text-start" style="padding: 8px 16px;">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @elseif(Auth::guard('ong')->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuOng" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ONG: {{ Auth::guard('ong')->user()->nome }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuOng">
                            <li><a class="dropdown-item" href="/painel-ong">Painel da ONG</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item m-0 p-0">
                                    @csrf
                                    <button type="submit" class="btn w-100 text-start" style="padding: 8px 16px;">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link btn-menu" id="btn-login" href="{{ route('login') }}">Entrar</a></li>
                    <li class="nav-item"><a class="nav-link btn-menu" id="btn-parceiro" href="#">Seja um parceiro</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    {{-- SIDEBAR (fora da navbar) --}}
    @auth('ong')
    <div class="sidebar" id="sidebar-lateral-ong">
        <a href="{{ route('painel.ong') }}" class="{{ request()->routeIs('painel.ong') ? 'active-link' : '' }}">🏠 Início</a>
        <a href="{{ route('ong.pets') }}">Meus Pets</a>
        <a href="{{ route('ong.pets.novo') }}">Novo Pet</a>
        <a href="{{ route('ong.interesses') }}">Pedidos de Adoção</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
    @endauth

    <!-- CONTEÚDO -->
    <div class="main-content">
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <!-- RODAPÉ -->
    <footer class="text-center mt-4">
        <p>Pet Projeto &copy; 2025</p>
    </footer>

    <!-- Bootstrap JS (bundle inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- Script global da sidebar -->
    <script>
      function applySidebarState() {
        const hidden = localStorage.getItem("sidebarVisible") === "false";
        document.body.classList.toggle("sidebar-hidden", hidden);
      }

      window.addEventListener("DOMContentLoaded", () => {
        applySidebarState();

        const btn = document.getElementById("btn-toggle-sidebar");
        if (btn) {
          btn.addEventListener("click", () => {
            const hidden = document.body.classList.toggle("sidebar-hidden");
            localStorage.setItem("sidebarVisible", hidden ? "false" : "true");
          });
        }
      });
    </script>
</body>
</html>
