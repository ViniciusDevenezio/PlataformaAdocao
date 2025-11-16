@extends ('layouts.main')

@section('head')
@endsection

@section('menu')
@endsection

<div class="welcome-banner">
    <h1>Cadastro de Tutor</h1>
</div>

<div class="login-container text-center">
    <div class="row mt-4 justify-content-center">
        <div class="col-12">
            
            {{-- 🔥 Esse cara usa o CSS do #cadastro-container que você mostrou --}}
            <div id="cadastro-container">

                <h4 id="cadastro-titulo" class="text-center mb-4">
                    Crie sua conta de Tutor
                </h4>

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

                <form action="{{ route('adotantes.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nome">Nome completo</label>
                            <input type="text" id="nome" name="nome_completo" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cpf">CPF</label>
                            <input type="text" id="cpf" name="cpf" class="form-control"
                                   maxlength="11" pattern="\d{11}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nascimento">Data de nascimento</label>
                            <input type="text"
                                   id="nascimento"
                                   name="nascimento"
                                   class="form-control"
                                   placeholder="dd/mm/aaaa"
                                   value="{{ old('nascimento') }}"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>

                    <div id="cadastro-celular" class="row">
                        <div class="col-md-6">
                            <label for="celular" class="text-danger">Celular*</label>
                            <input type="text"
                                   id="celular"
                                   name="celular"
                                   class="form-control"
                                   placeholder="(00) 00000-0000"
                                   value="{{ old('celular') }}"
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha"
                                   class="form-control" placeholder="Digite sua senha" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <label for="cep">CEP</label>
                            <input type="text" id="cep" name="cep" class="form-control" required>
                        </div>
                        <div class="col-md-8">
                            <label for="endereco">Endereço</label>
                            <input type="text" id="endereco" name="endereco" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label for="numero">Número</label>
                            <input type="text" id="numero" name="numero" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="bairro">Bairro</label>
                            <input type="text" id="bairro" name="bairro" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="estado">Estado</label>
                            <select id="estado" name="estado" class="form-select py-2" required>
                                <option value="">Selecione um estado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="cidade">Cidade</label>
                            <select id="cidade" name="cidade" class="form-select py-2" required>
                                <option value="">Selecione uma cidade</option>
                            </select>
                        </div>
                    </div>

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

                    <div id="cadastro-botao" class="text-center mt-4">
                        <button type="submit" class="btn btn-custom">Cadastrar</button>
                    </div>
                </form>

            </div> {{-- #cadastro-container --}}
        </div>
    </div>
</div>

{{-- scripts iguais aos do login --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="{{ secure_asset('js/validarCpf.js') }}"></script>
<script src="{{ secure_asset('js/cepAutoComplete.js') }}"></script>
<script src="{{ secure_asset('js/cidadesEstados.js') }}"></script>

<script>
    $(function () {
        $('#nascimento').mask('00/00/0000');
        $('#celular').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
    });
</script>
