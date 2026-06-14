@extends ('layouts.main')

@section('head')
    <style>
        /* Tira qualquer animaçãozinha chata dessa página */
        .welcome-banner,
        .login-container,
        #cadastro-container {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
            transition: none !important;
        }

        .welcome-banner {
            margin-top: -1px;
        }

        #cadastro-container {
            background: #ffffff;
            border-radius: 26px;
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.10);
            max-width: 1100px;
            text-align: left;
            position: relative;
            z-index: 10;
        }

        .form-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 1.8rem;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background-color: #fafafa;
            min-height: 48px;
            padding: 10px 14px;
            font-size: 0.95rem;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #f97316;
            outline: none;
            box-shadow: 0 0 0 1px rgba(249, 115, 22, 0.08);
            background-color: #ffffff;
        }

        .row + .row {
            margin-top: 12px;
        }

        .alert {
            border-radius: 12px;
        }

        /* LGPD igual do cadastro */
        .lgpd-box {
            background: #f9fafb;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: .9rem;
            color: #4b5563;
            margin-top: 1rem;
        }

        .lgpd-box a {
            color: #f97316;
            text-decoration: none;
            font-weight: 600;
        }

        .lgpd-box a:hover {
            text-decoration: underline;
        }

        .btn-custom {
            background-color: #ffb321;
            border: none;
            border-radius: 999px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 1rem;
            color: #ffffff;
            width: 100%;
        }

        .btn-custom:hover,
        .btn-custom:focus {
            background-color: #ffb321;
            color: #ffffff;
            box-shadow: none;
        }

        #cadastro-botao {
            margin-top: 28px;
        }

        @media (max-width: 992px) {
            #cadastro-container {
                padding: 26px 22px 30px;
                border-radius: 20px;
                margin-top: -30px;
            }
        }

        @media (max-width: 576px) {
            .form-title {
                font-size: 1.3rem;
            }
        }
    </style>
@endsection

@section('menu')
@endsection

<div class="welcome-banner">
    <h1>Cadastro de ONG</h1>
</div>

<div class="login-container text-center">
    <div class="row mt-4 justify-content-center">
        <div class="col-12">
            <div id="cadastro-container">

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $erro)
                                <li>{{ $erro }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('ong.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nome">Nome da ONG</label>
                            <input type="text" id="nome" name="nome" class="form-control"
                                   value="{{ old('nome') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" id="cnpj" name="cnpj" class="form-control"
                                   value="{{ old('cnpj') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control"
                                   value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control"
                                   value="{{ old('telefone') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" class="form-control"
                                   placeholder="Digite sua senha" minlength="8" maxlength="72" autocomplete="new-password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" class="form-control"
                                   value="{{ old('cep') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" class="form-control"
                                   value="{{ old('endereco') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" class="form-control"
                                   value="{{ old('numero') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label for="bairro">Bairro</label>
                            <input type="text" id="bairro" name="bairro" class="form-control"
                                   value="{{ old('bairro') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" class="form-control"
                                   value="{{ old('cidade') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="estado">Estado</label>
                            <input type="text" id="estado" name="estado" class="form-control"
                                   maxlength="2" value="{{ old('estado') }}" required>
                        </div>
                    </div>

                    {{-- LGPD igual ao cadastro de tutor --}}
                    <div class="lgpd-box mt-3">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                id="lgpd_aceite"
                                name="lgpd_aceite"
                                value="1"
                                required
                            >
                            <label class="form-check-label" for="lgpd_aceite">
                                Li e concordo com a
                                <a href="{{ route('politica') }}" target="_blank">
                                    Política de Privacidade
                                </a>
                                e autorizo o tratamento dos meus dados pessoais.
                            </label>
                        </div>
                    </div>

                    <div id="cadastro-botao" class="row mt-4">
                        <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-custom">Cadastrar ONG</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- Scripts iguais (máscaras + CEP), adaptados pros campos da ONG --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="{{ asset('js/cidadesEstados.js') }}"></script>
<script src="{{ asset('js/cepAutoComplete.js') }}"></script>

<script>
    $(function () {
        $('#telefone').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
        $('#cnpj').mask('00.000.000/0000-00');
    });
</script>
