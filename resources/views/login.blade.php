@extends ('layouts.main')

@section('head')

    <style>
        @media (max-width: 768px) {

            .welcome-banner {
                margin-top: 2rem !important;
                /* empurra pra baixo da navbar */
                margin-bottom: 0.1rem;
                text-align: center;
                padding: 0 1rem;
            }

            .welcome-banner h1 {
                font-size: 1.4rem;
                /* menor, bonitinho */
                font-weight: 600;
                line-height: 1.2;
                margin: 0;
                /* sem gambiarra de margin-top gigante */
            }

            /* Container principal */
            .login-container {
                margin-top: 1rem;
                padding: 0 1rem;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .login-container .col-md-6:first-of-type {
                margin-bottom: 2rem;
                /* aumenta/diminui o espaçamento aqui */
            }

            /* Cada card ocupa largura máxima */
            .login-container .col-md-6 {
                width: 100%;
                max-width: 380px;
            }

            /* Card refinado */
            .login-container .card {
                border-radius: 16px;
                padding: 1.7rem !important;
                box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
                text-align: center;
                background: #fff;
            }

            .login-container h4 {
                font-weight: 600;
                font-size: 1.3rem;
            }

            /* Inputs */
            .login-container input.form-control {
                padding: 0.1rem;
                border-radius: 12px;
                font-size: 1rem;
            }

            /* Checkbox */
            .form-check {
                margin-top: .5rem;
                text-align: left;
            }

            .form-check-label {
                font-size: .9rem;
            }

            /* Botões */
            .btn {
                padding: 0.9rem 1rem;
                border-radius: 12px !important;
                font-size: 1rem;
                font-weight: 600;
            }
    </style>
@endsection

@section('menu')
@endsection




<div class="welcome-banner">
    <h1>Bem-vindo ao Projeto Pet</h1>
</div>

<div class="login-container text-center">
    <div class="row mt-4">
        <!-- Login -->
        <div class="col-md-6">
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
                    <input type="email" name="email" class="form-control my-2" placeholder="E-mail" required>
                    <input type="password" name="password" class="form-control my-2" placeholder="Digite sua senha"
                        required>

                    <div class="form-check text-start">
                        <input type="checkbox" class="form-check-input" id="manterConectado">
                        <label class="form-check-label" for="manterConectado">Mantenha-me conectado</label>
                    </div>

                    <button type="submit" class="btn btn-orange w-100 mt-3">Entrar</button>

                </form>
            </div>
        </div>

        <!-- Cadastro -->
        <div class="col-md-6">
            <div class="card p-4">
                <h4>Crie sua conta!</h4>
                <p class="mb-3">Ainda não possui uma conta? Cadastre-se abaixo.</p>
                <a href="{{ route('cadastro') }}" class="btn btn-outline-primary w-100 mt-2">Criar conta Adotante</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery primeiro -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Bootstrap depois -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>