@extends ('layouts.main')

@section('head')

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .login-container .card input.form-control {
            padding: 0.9rem 7rem 0.8rem 1rem;
            font-size: 1rem;
            border-radius: 10px;
        }

        .login-container .row {
            margin-top: 30px;
        }

        .welcome-banner {
            text-align: center;
            margin-top: -90px;
        }

        .welcome-banner h1 {
            font-size: 2rem;
            font-weight: 600;
        }

        .login-container {
            padding-top: 1.5rem;
            padding-bottom: 3rem;
        }

        .login-container .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            text-align: left;
        }

        .login-container h4 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        @media (max-width: 767.98px) {
            .welcome-banner {
                margin-top: 80px;
            }

            .welcome-banner h1 {
                font-size: 1.5rem;
            }

            .login-container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .login-container .card {
                margin-bottom: 1.5rem;
            }
        }
    </style>
@endsection

@section('menu')
@endsection

<div class="welcome-banner">
    <h1>Bem-vindo ao Projeto Pet</h1>
</div>

<div class="login-container">
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-lg-10">
                <div class="row g-4">
                    <!-- Login -->
                    <div class="col-12 col-md-6">
                        <div class="card p-4">
                            <h4>Acesse sua conta</h4>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $erro)
                                            <li>{{ $erro }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('adotante.login') }}" method="POST">
                                @csrf
                                <input type="email" name="email" class="form-control my-2" placeholder="E-mail"
                                    required>
                                <input type="password" name="password" class="form-control my-2"
                                    placeholder="Digite sua senha" required>

                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" id="manterConectado">
                                    <label class="form-check-label" for="manterConectado">Mantenha-me conectado</label>
                                </div>

                                <button type="submit" class="btn btn-orange w-100 mt-3">Entrar</button>
                            </form>
                        </div>
                    </div>

                    <!-- Cadastro -->
                    <div class="col-12 col-md-6">
                        <div class="card p-4">
                            <h4>Crie sua conta!</h4>
                            <p class="mb-3">Ainda não possui uma conta? Cadastre-se abaixo.</p>
                            <a href="{{ route('cadastro') }}" class="btn btn-outline-primary w-100 mt-2">
                                Criar conta Adotante
                            </a>
                        </div>
                    </div>
                </div> <!-- row g-4 -->
            </div> <!-- col-12 col-lg-10 -->
        </div> <!-- row justify-content-center -->
    </div> <!-- container -->
</div>

{{-- Se o layouts.main já carrega jQuery/Bootstrap, pode REMOVER isso daqui --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>