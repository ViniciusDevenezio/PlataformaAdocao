<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pet Projeto')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <!-- Seu CSS personalizado -->
    <link rel="stylesheet" href="{{asset('css/styles.css') }}">



    <!-- Fonte utilizada -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto" rel="stylesheet">

    @yield('head')

</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->

    <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="/img/logo2.png" alt="Logo" class="logo-navbar">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pets.cachorros') }}">Cachorros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pets.gatos') }}">Gatos</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn-adotar" href="{{ route('adotar') }}">Quero Adotar</a>
                </li>

                @auth('adotante')
                    <li class="nav-item">
                        <a class="nav-link match-btn" href="{{ route('match') }}">
                            <i class="bi bi-stars" aria-label="Match"></i> Match
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuAdotante" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Olá, {{ Auth::guard('adotante')->user()->nome_completo }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuAdotante">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="/painelAdotante">Meus Pets</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item m-0 p-0">
                                    @csrf
                                    <button type="submit" class="btn w-100 text-start"
                                        style="padding: 8px 16px;">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @elseif(auth('ong')->check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="menuOng" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            ONG: {{ Auth::guard('ong')->user()->nome }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="menuOng">
                            <li><a class="dropdown-item" href="/painel-ong">Painel da ONG</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-item m-0 p-0">
                                    @csrf
                                    <button type="submit" class="btn w-100 text-start"
                                        style="padding: 8px 16px;">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn-menu" id="btn-login" href="{{ route('login') }}">Entrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-menu" id="btn-parceiro" href="{{ route('parceiro') }}">Seja um parceiro</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Conteúdo da página -->
    <main class="main-content flex-fill">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- footer -->
    <footer class="site-footer text-center py-4 mt-auto">
        <p class="footer-copy">Pet Projeto &copy; 2025</p>

        <a href="{{ route('politica') }}" class="footer-link">
            Política de Privacidade
        </a>
    </footer>

    <!-- Bootstrap JS e Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gyb6E2S8oE71p66t5H4FwE1g12xj2lZC4Q6yWs7Nq+q8g7Exm0S"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const buttons = document.querySelectorAll('#btn-login, #btn-logout, #btn-parceiro');

        buttons.forEach(btn => {
            // Define estado inicial
            btn.classList.add('is-off');

            let isAnimating = false;

            const setOn = () => {
                if (isAnimating) return;
                btn.classList.remove('is-off');
                btn.classList.add('is-on');
            };

            const setOff = () => {
                // permite a reversão suave mesmo no meio da animação
                btn.classList.remove('is-on');
                btn.classList.add('is-off');
            };

            // eventos principais
            btn.addEventListener('mouseenter', setOn);
            btn.addEventListener('mouseleave', setOff);
            btn.addEventListener('focus', setOn);
            btn.addEventListener('blur', setOff);

            // suporte a toque (mobile)
            btn.addEventListener('touchstart', setOn, { passive: true });
            btn.addEventListener('touchend', setOff);

            // segurança: se perder o foco da aba, reseta
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) setOff();
            });

            // evita que o clique dispare seleção de texto
            btn.addEventListener('mousedown', e => e.preventDefault());
        });
    });
</script>

</html>