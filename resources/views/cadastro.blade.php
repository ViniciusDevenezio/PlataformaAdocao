@extends ('layouts.main')

@section('head')
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('menu')
@endsection


<style>
    #cadastro-container {
        display: none;
    }
</style>
<div class="welcome-banner">
    <h1>Cadastro de Tutor</h1>
</div>

<div class="login-container text-center">
    <div class="row mt-4">
        <div class="col-md-6"></div>

        <div id="cadastro-container" class="container" >

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('adotantes.store') }}" method="POST">
                @csrf

                <div class="row mt-4">
                    <div class="col-md-6">
                        <label for="nome">Nome completo</label>
                        <input type="text" id="nome" name="nome_completo" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cpf">CPF</label>
                        <input type="text" id="cpf" name="cpf" class="form-control" maxlength="11" pattern="\d{11}" required>
                        <div class="invalid-feedback">CPF inválido.</div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="nascimento">Data de nascimento</label>
                        <input type="text"
                               id="nascimento"
                               name="nascimento"
                               class="form-control @error('nascimento') is-invalid @enderror"
                               placeholder="dd/mm/aaaa"
                               value="{{ old('nascimento') }}"
                               required>
                        @error('nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email">E-mail</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                </div>

                <div id="cadastro-celular" class="row mt-3">
                    <div class="col-md-6">
                        <label for="celular" class="text-danger">Celular*</label>
                        <input type="text" id="celular" name="celular" class="form-control @error('celular') is-invalid @enderror" placeholder="(00) 00000-0000" value="{{ old('celular') }}" required>
                        @error('celular')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" class="form-control" placeholder="Digite sua senha" required>
                    </div>
                </div>

                <div class="row mt-3">
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

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="bairro">Bairro</label>
                        <input type="text" id="bairro" name="bairro" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="">Selecione um estado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="cidade">Cidade</label>
                        <select id="cidade" name="cidade" class="form-control" required>
                            <option value="">Selecione uma cidade</option>
                        </select>
                    </div>
                </div>

                <div id="cadastro-botao" class="text-center mt-4">
                    <button type="submit" class="btn btn-custom">Cadastrar</button>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success mt-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Scripts necessários -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script src="{{ asset('js/validarCpf.js') }}"></script>
<script src="{{ asset('js/cepAutoComplete.js') }}"></script>
<script src="{{ asset('js/cidadesEstados.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#nascimento').mask('00/00/0000');
        $('#celular').mask('(00) 00000-0000');
        $('#cep').mask('00000-000');
    });
</script>