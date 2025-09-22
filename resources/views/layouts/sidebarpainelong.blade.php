<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Pet Projeto')</title>

  <!-- Fonts e Bootstrap -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Roboto&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- CSS custom -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  @yield('head')
  <style>
    #btn-toggle-sidebar {
      background: none;
      border: none;
      padding: 0.6rem 1rem;
      font-size: 1.1rem;
      border-radius: 0.5rem;
      color: #333;
      cursor: pointer;
      box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.1),
        inset -2px -2px 5px rgba(255, 255, 255, 0.6),
        1px 1px 4px rgba(0, 0, 0, 0.05);
    }

    .topbar {
      position: sticky;
      top: 0;
      z-index: 1050;
    }

    /* Sidebar */
    /* Sidebar sempre logo abaixo da navbar */
    .sidebar {
      position: fixed;
      left: 0;
      top: var(--nav-h);
      bottom: 0;
      width: 240px;
      background: #2e2e2e;
      padding-top: 1rem;
      overflow-y: auto;
      transform: translateX(0);
      transition: transform .3s, box-shadow .3s;
      z-index: 1000;
      /* abaixo da navbar (1050) */
      box-shadow: 2px 0 8px rgba(0, 0, 0, .25);
    }

    .sidebar.closed {
      transform: translateX(-100%);
    }

    .sidebar a {
      color: #e0e0e0;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      border-bottom: 1px solid #ffffff1a;
      transition: all 0.3s ease;
    }

    .sidebar a:hover {
      background: #4b6374;
      color: #fff;
      padding-left: 28px;
    }

    .active-link {
      background: #2e5672 !important;
      color: #fff !important;
      font-weight: 700;
      border-left: 4px solid #fff;
    }

    .sidebar-backdrop.show {
      opacity: 1;
      pointer-events: auto;
    }

    @media (min-width: 992px) {
      body.push-main #main-content {
        margin-left: 240px;
        transition: margin-left .3s;
      }
    }
  </style>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    {{-- botão ☰ só para ONG logada --}}
    @auth('ong')
      <button id="btn-toggle-sidebar" class="btn btn-dark me-2" type="button" aria-label="Abrir menu lateral">
        <span class="menu-icon">☰</span>
      </button>
    @endauth
    {{-- logo --}}
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="/img/logo2.png" alt="Logo" class="logo-navbar">
    </a>

    {{-- colapso padrão do bootstrap --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      {{-- links à esquerda --}}
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Cachorros</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Gatos</a></li>
      </ul>

      {{-- à direita --}}
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link btn-adotar" href="{{ route('adotar') }}">Quero Adotar</a>
        </li>

        {{-- MENU ADOTANTE --}}
        @auth('adotante')
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="menuAdotante" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
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

          {{-- MENU ONG (com nome da ONG) --}}
        @elseif(auth('ong')->check())
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="menuOng" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              ONG: {{ Auth::guard('ong')->user()->nome }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuOng">
              <li><a class="dropdown-item" href="{{ route('painel.ong') }}">Painel da ONG</a></li>
              <li><a class="dropdown-item" href="{{ route('ong.pets') }}">Meus Pets</a></li>
              <li>
                <form action="{{ route('logout') }}" method="POST" class="dropdown-item m-0 p-0">
                  @csrf
                  <button type="submit" class="btn w-100 text-start" style="padding: 8px 16px;">Sair</button>
                </form>
              </li>
            </ul>
          </li>

          {{-- VISITANTE --}}
        @else
          <li class="nav-item"><a class="nav-link btn-menu" id="btn-login" href="{{ route('login') }}">Entrar</a></li>
          <li class="nav-item"><a class="nav-link btn-menu" id="btn-parceiro" href="#">Seja um parceiro</a></li>
        @endauth
      </ul>
    </div>
  </nav>


  {{-- Sidebar só aparece para ONG --}}
  @auth('ong')
    <div id="sidebar-lateral-ong"
      class="sidebar {{ request()->routeIs('ong.pets.novo', 'ong.pets.editar') ? 'closed' : '' }}">
      <a href="{{ route('painel.ong') }}"
   class="{{ request()->routeIs('painel.ong') ? 'active-link' : '' }}">
  <i class="bi bi-house-door-fill me-2" aria-hidden="true"></i> Início
</a>

      {{-- "Meus Pets" ativo só em index/lista/detalhe/editar (NÃO pega .novo) --}}
      <a href="{{ route('ong.pets') }}"
        class="{{ request()->routeIs('ong.pets', 'ong.pets.index', 'ong.pets.show*', 'ong.pets.editar*') ? 'active-link' : '' }}">
        Meus Pets
      </a>

      {{-- "Novo Pet" ativo só no formulário de criação --}}
      <a href="{{ route('ong.pets.novo') }}" class="{{ request()->routeIs('ong.pets.novo') ? 'active-link' : '' }}">
        Novo Pet
      </a>

      <a href="{{ route('ong.solicitacoes') }}"
        class="{{ request()->routeIs('ong.interesses', 'ong.interesses*') ? 'active-link' : '' }}">
        Pedidos de Adoção
      </a>

      <a href="{{ route('logout') }}"onclick="event.preventDefault(); document.getElementById('logout-form-side').submit();">Sair</a>
      <form id="logout-form-side" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
    <div id="sidebar-backdrop" class="sidebar-backdrop"></div>
  @endauth

  <!-- Conteúdo da página -->
  <div id="main-content" class="container mt-4">
    @yield('content')
  </div>

  <!-- Rodapé -->
  <footer class="text-center mt-4">
    <p>Pet Projeto &copy; 2025</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  @auth('ong')
    <script>
      (function () {
        const btn = document.getElementById('btn-toggle-sidebar');
        const sidebar = document.getElementById('sidebar-lateral-ong');
        const backdrop = document.getElementById('sidebar-backdrop');
        if (!btn || !sidebar || !backdrop) return;

        function toggleSidebar() {
          const closed = sidebar.classList.toggle('closed'); // agora controla "fechado"
          backdrop.classList.toggle('show', !closed); // backdrop só aparece se estiver aberto
          document.body.classList.toggle('push-main', !closed);
        }

        btn.addEventListener('click', toggleSidebar);
        backdrop.addEventListener('click', toggleSidebar);
        document.addEventListener('keydown', e => {
          if (e.key === 'Escape' && !sidebar.classList.contains('closed')) toggleSidebar();
        });
      })();

      document.addEventListener("DOMContentLoaded", function () {
        const navbar = document.querySelector(".navbar");
        const sidebar = document.querySelector(".sidebar");

        if (navbar && sidebar) {
          const alturaNavbar = navbar.offsetHeight; // mede a altura real da navbar
          sidebar.style.top = alturaNavbar + "px";
        }
      });
    </script>
  @endauth
</body>

</html>