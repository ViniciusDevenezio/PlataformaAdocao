@extends ('layouts.main')

@section('head')
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
                    <input type="password" name="password" class="form-control my-2" placeholder="Digite sua senha" required>

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

