@extends('layouts.main')

@section('head')
    <link rel="stylesheet" href="{{ secure_asset('css/styleCadastro.css') }}">
    <style>
        #container-principal-mostrar {
            padding-top: 6rem;
        }

        .info-box,
        .history-box {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .info-box h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: .5rem;
        }

        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: .9rem;
            font-weight: 600;
        }

        .badge-status.disponivel {
            background: #d4edda;
            color: #155724;
        }

        .badge-status.reservado {
            background: #fff3cd;
            color: #856404;
        }

        .badge-status.adotado {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
@endsection

@section('content')
    <div class="container" id="container-principal-mostrar">
        <div class="row g-4">
            <!-- Coluna da imagem -->
            <div class="col-md-6">
                @php
                    $src = $pet->imagem_url
                        ? secure_asset('storage/images/' . ltrim($pet->imagem_url, '/'))
                        : null;
                @endphp

                @if($src)
                    <img src="{{ $src }}" class="img-fluid rounded shadow" alt="{{ $pet->nome }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" style="height:300px;">
                        <span class="text-muted">Sem foto</span>
                    </div>
                @endif
            </div>

            <!-- Coluna de informações -->
            <div class="col-md-6">
                <div class="info-box">
                    <h1>{{ $pet->nome ?? 'Sem nome' }} </h1>
                    <p>
                        <span class="badge-status {{ $pet->status }}">
                            {{ ucfirst($pet->status) }}
                        </span>
                    </p>
                    <p class="text-muted mb-4">
                        {{ ucfirst($pet->especie ?? '') }} | {{ ucfirst($pet->genero ?? '') }} | Porte:
                        {{ ucfirst($pet->porte ?? '') }} |
                        {{ $pet->faixa_etaria ?? 'Idade não informada' }}
                    </p>

                    <!-- Informações em grid -->
                    <div class="row mb-3 g-3">
                        <!-- Raça e Cruzado -->
                        <div class="col-6">
                            <strong>Raça Predominante:</strong><br>
                            {{ $pet->raca ?? 'SRD' }}
                        </div>
                        <div class="col-6">
                            <strong>É cruzado?</strong><br>
                            {{ $pet->mistura ? 'Sim' : 'Não' }}
                        </div>

                        <!-- Raça aparente -->
                        <div class="col-6">
                            <strong>Raça Secundaria:</strong><br>
                            {{ $pet->mistura && $pet->misturado_com ? $pet->misturado_com : '-' }}
                        </div>
                        <div class="col-6">
                            <strong>Idade:</strong><br>
                            {{ $pet->idade ?? '-' }}
                        </div>

                        <!-- Temperamento -->
                        <div class="col-12">
                            <strong>Temperamento:</strong><br>
                            {{ $pet->temperamento ? implode(', ', explode(',', $pet->temperamento)) : 'Não informado' }}
                        </div>

                        <!-- Idade e Disponibilidade -->


                        <!-- Saúde -->
                        <div class="col-6">
                            <strong>Vacinado:</strong><br>
                            {{ $pet->vacinado ? 'Sim' : 'Não' }}
                        </div>
                        <div class="col-6">
                            <strong>Vermifugado:</strong><br>
                            {{ $pet->vermifugado ? 'Sim' : 'Não' }}
                        </div>

                        <!-- Localização -->
                        <div class="col-12">
                            <strong>Localização:</strong><br>
                            {{ $pet->localizacao ?? (optional($pet->ong)->cidade ?? '-') }}
                        </div>
                    </div>

                    <!-- Botão WhatsApp -->
                    @php
                        // WhatsApp da ONG (fallback)
                        $numeroOng = preg_replace('/\D/', '', optional($pet->ong)->telefone ?? '');
                        if ($numeroOng && !str_starts_with($numeroOng, '55')) {
                            $numeroOng = '55' . $numeroOng;
                        }

                        // Mensagem padrão
                        $nomeUsuario = auth('adotante')->user()->nome_completo ?? 'Adotante';
                        $cidadeUsuario = auth('adotante')->user()->cidade ?? 'sua cidade';
                        $mensagemUrl = urlencode("Olá, meu nome é $nomeUsuario e tenho interesse no pet {$pet->nome}. Moro em $cidadeUsuario.");

                        // Desabilitar se não disponível
                        $desabilitar = in_array($pet->status, ['reservado', 'adotado']);
                    @endphp

                    @auth('adotante')
                        <form method="POST" action="{{ route('solicitacoes.store') }}" class="d-grid gap-2" id="formSolicitacaoAdocao">
                            @csrf
                            <input type="hidden" name="pet_id" value="{{ $pet->id }}">

                            <button type="button" class="btn btn-primary w-100 fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#confirmarAdocaoModal" {{ $desabilitar ? 'disabled' : '' }}>
                                Quero Adotar!
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                            class="btn btn-primary w-100 fw-bold">
                            Faça login para solicitar
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- História -->
        <div class="history-box mt-4">
            <h5><strong>História do pet {{ $pet->nome ?? 'Sem nome' }}</strong></h5>
            <p>{{ $pet->descricao ?? 'Sem história informada.' }}</p>
        </div>
    </div>

    @auth('adotante')
        <div class="modal fade" id="confirmarAdocaoModal" tabindex="-1" aria-labelledby="confirmarAdocaoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmarAdocaoModalLabel">Confirmar solicitação de adoção</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3">Sua solicitação será enviada para a ONG responsável. Ela entrará em contato assim que receber o pedido.</p>
                        <p class="mb-3">O processo passará por análise e você poderá ser convidado para uma conversa antes da aprovação.</p>
                        <p class="fw-semibold mb-0">Tem certeza de que deseja adotar {{ $pet->nome }}?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="confirmarEnvioSolicitacao">Enviar solicitação</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var botaoConfirmar = document.getElementById('confirmarEnvioSolicitacao');
                var formularioSolicitacao = document.getElementById('formSolicitacaoAdocao');

                if (botaoConfirmar && formularioSolicitacao) {
                    botaoConfirmar.addEventListener('click', function () {
                        formularioSolicitacao.submit();
                    });
                }
            });
        </script>
    @endauth

    @if(session('success') || session('error'))
  <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index:1080">

    <div id="toastSolic"
         class="toast align-items-center {{ session('error') ? 'text-bg-danger' : 'text-bg-success' }} border-0"
         role="alert" aria-live="assertive" aria-atomic="true"
         data-bs-delay="3000" data-bs-autohide="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('success') ?? session('error') }}
        </div>
        <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var el = document.getElementById('toastSolic');
      if (el && window.bootstrap && bootstrap.Toast) {
        new bootstrap.Toast(el).show();
      }
    });
  </script>
@endif
@endsection