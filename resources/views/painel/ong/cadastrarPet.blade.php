@extends('layouts.sidebarpainelong')

<style>
    .banner-editar-pet {
        background-color: #c2b5c5;
        padding: 7rem 0.25vw;
        text-align: center;
        position: absolute;
        top: 0;
        left: 0;
        width: 100vw;
        z-index: -1;
    }

    .banner-editar-pet h1 {
        font-size: 2.5rem;
        color: #523f5f;
        margin: 0;
        padding-top: 1rem;
        transform: translateY(-2.5rem);
    }

    #formulario-editar-pet {
        max-width: 800px;
        background-color: #f8f8f8;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        margin: auto;
        margin-top: 9rem;
        min-height: 400px;
    }

    /* Temperamento como retângulo com chips dentro */
    .temperamento-panel {
        border: 1px solid #ddd;
        border-radius: 10px;
        background: #fff;
        padding: 0.75rem;
        min-height: 6.5rem;
        /* aprox. visual de "rows=3" do textarea */
        display: flex;
        align-items: flex-start;
    }

    .temperamento-boxes {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        width: 100%;
    }

    .temperamento-item {
        border: 1px solid #ccc;
        border-radius: 20px;
        padding: 0.35rem 0.9rem;
        cursor: pointer;
        background: #fff;
        transition: all 0.2s;
        user-select: none;
    }

    .temperamento-item input {
        display: none;
    }

    .temperamento-item.active {
        background: #523f5f;
        color: #fff;
        border-color: #523f5f;
    }
</style>

<div class="banner-editar-pet">
    <h1>Cadastrar Pet</h1>
</div>

<div class="container mt-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formulario-editar-pet" action="{{ route('ong.pets.salvar') }}" method="POST"
        enctype="multipart/form-data">
        @csrf

        {{-- Nome + Raça (mantido) --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome') }}" required>
            </div>
            <div class="col-md-6">
                <label for="raca">Raça</label>
                <input type="text" name="raca" id="raca" class="form-control" value="{{ old('raca') }}">
            </div>
        </div>

        {{-- Espécie + Saúde (novo) --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="especie">Espécie</label>
                <select name="especie" id="especie" class="form-select py-2" required>
                    <option value="">Selecione</option>
                    <option value="cachorro" {{ old('especie') == 'cachorro' ? 'selected' : '' }}>Cachorro</option>
                    <option value="gato" {{ old('especie') == 'gato' ? 'selected' : '' }}>Gato</option>
                </select>
            </div>
            <div class="col-md-6">
                <label>Saúde</label>
                <div class="form-check">
                    <input type="checkbox" name="vacinado" id="vacinado" class="form-check-input" value="1" {{ old('vacinado') ? 'checked' : '' }}>
                    <label for="vacinado" class="form-check-label">Vacinado</label>
                </div>
                <div class="form-check mt-2">
                    <input type="checkbox" name="vermifugado" id="vermifugado" class="form-check-input" value="1" {{ old('vermifugado') ? 'checked' : '' }}>
                    <label for="vermifugado" class="form-check-label">Vermifugado</label>
                </div>
            </div>
        </div>

        {{-- Mistura + Misturado com (mantido) --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="mistura">É uma mistura?</label>
                <select name="mistura" id="mistura" class="form-select py-2" required>
                    <option value="">Selecione</option>
                    <option value="1" {{ old('mistura') == 1 ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ old('mistura') == 0 ? 'selected' : '' }}>Não</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="misturado_com">Misturado com (opcional)</label>
                <input type="text" name="misturado_com" id="misturado_com" class="form-control"
                    value="{{ old('misturado_com') }}">
            </div>
        </div>

        {{-- Porte + Gênero (mantido) --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="porte">Porte</label>
                <select name="porte" class="form-select py-2">
                    <option value="pequeno" {{ old('porte') == 'pequeno' ? 'selected' : '' }}>Pequeno</option>
                    <option value="medio" {{ old('porte') == 'medio' ? 'selected' : '' }}>Médio</option>
                    <option value="grande" {{ old('porte') == 'grande' ? 'selected' : '' }}>Grande</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="genero">Gênero</label>
                <select name="genero" class="form-select py-2">
                    <option value="macho" {{ old('genero') == 'macho' ? 'selected' : '' }}>Macho</option>
                    <option value="femea" {{ old('genero') == 'femea' ? 'selected' : '' }}>Fêmea</option>
                </select>
            </div>
        </div>

        {{-- Idade (normalizada) --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="idade_num">Idade</label>
                <div class="d-flex gap-2">
                    <input type="number" min="0" step="1" name="idade_num" id="idade_num"
                        class="form-select py-2"" value=" {{ old('idade_num') }}" placeholder="Ex.: 2">
                    <select name="idade_unidade" id="idade_unidade" class="form-select" style="max-width: 10rem;">
                        <option value="anos" {{ old('idade_unidade') == 'anos' ? 'selected' : '' }}>anos</option>
                        <option value="meses" {{ old('idade_unidade') == 'meses' ? 'selected' : '' }}>meses</option>
                    </select>
                </div>
                <input type="hidden" name="idade" id="idade_str" value="{{ old('idade') }}">
            </div>
        </div>

        {{-- Status + Disponível até (mantido) --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="status">Status</label>
                <select name="status" class="form-select py-2">
                    <option value="disponivel" {{ old('status') == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                    <option value="reservado" {{ old('status') == 'reservado' ? 'selected' : '' }}>Reservado</option>
                    <option value="adotado" {{ old('status') == 'adotado' ? 'selected' : '' }}>Adotado</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="disponivel_ate">Disponível até (opcional)</label>
                <input type="date" name="disponivel_ate" class="form-control" value="{{ old('disponivel_ate') }}">
            </div>
        </div>

        {{-- Temperamento (retângulo) --}}
        <div class="row mt-3">
            <div class="col-md-12">
                <label for="temperamento">Temperamento (até 3)</label>
                <div class="temperamento-panel">
                    <div class="temperamento-boxes">
                        @php
                            $opts = ['Calmo', 'Brincalhão', 'Sociável', 'Independente', 'Protetor', 'Dócil', 'Energético', 'Tímido', 'Carinhoso', 'Curioso', 'Vigilante', 'Tranquilo'];
                            $oldTemps = old('temperamento', []);
                        @endphp
                        @foreach ($opts as $op)
                            <label class="temperamento-item {{ in_array($op, $oldTemps ?? []) ? 'active' : '' }}">
                                <input type="checkbox" name="temperamento[]" value="{{ $op }}" {{ in_array($op, $oldTemps ?? []) ? 'checked' : '' }}>
                                {{ $op }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Descrição (mantido) --}}
        <div class="mt-3">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3">{{ old('descricao') }}</textarea>
        </div>

        {{-- Imagem + Localização (lado a lado) --}}
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="imagem_url">Imagem</label>
                <input type="file" name="imagem_url" id="imagem_url" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="localizacao">Localização</label>
                <select name="localizacao" id="localizacao" class="form-select">
                    {{-- Padrão: cidade da ONG; se houver old(), ele prevalece --}}
                    @php
                        $padraoCidade = old('localizacao', $ongCidade ?? '');
                    @endphp
                    @if($padraoCidade)
                        <option value="{{ $padraoCidade }}" selected>{{ $padraoCidade }}</option>
                    @else
                        <option value="">Carregando cidades...</option>
                    @endif
                </select>
            </div>
        </div>

        {{-- Ações (mantido) --}}
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-success px-4">
                <i class="bi bi-plus-circle me-2"></i> Cadastrar Pet
            </button>
            <a href="{{ route('ong.pets') }}" class="btn btn-outline-secondary px-4 ms-2">
                <i class="bi bi-x-circle me-2"></i> Cancelar
            </a>
        </div>

        <script nonce="{{ $cspNonce ?? '' }}">
            // Atualiza a string "idade" (compatibilidade)
            function atualizarIdadeStr() {
                const n = document.getElementById('idade_num').value;
                const u = document.getElementById('idade_unidade').value;
                document.getElementById('idade_str').value = n ? `${n} ${u}` : '';
            }
            document.getElementById('idade_num').addEventListener('input', atualizarIdadeStr);
            document.getElementById('idade_unidade').addEventListener('change', atualizarIdadeStr);
            atualizarIdadeStr();

            // Limita temperamentos a 3 e alterna visual "chip"
            function syncChips() {
                document.querySelectorAll('.temperamento-item').forEach(l => {
                    l.classList.toggle('active', l.querySelector('input').checked);
                });
            }
            document.querySelectorAll('.temperamento-item input').forEach(cb => {
                cb.addEventListener('change', () => {
                    const selecionados = document.querySelectorAll('.temperamento-item input:checked');
                    if (selecionados.length > 3) {
                        cb.checked = false;
                        alert('Selecione no máximo 3 temperamentos.');
                    }
                    syncChips();
                });
            });
            syncChips();

            // IBGE: popula municípios de SP (remove capital). Mantém cidade da ONG se existir.
            (async function carregarCidadesSP() {
                const sel = document.getElementById('localizacao');
                const valorAtual = sel.value; // pode ser a cidade da ONG
                try {
                    const resp = await fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados/SP/municipios');
                    const dados = await resp.json();
                    let cidades = dados.map(c => c.nome).filter(n => n !== 'São Paulo').sort((a, b) => a.localeCompare(b, 'pt-BR'));

                    // Renderiza opções mantendo a cidade padrão no topo selecionada
                    const oldVal = @json(old('localizacao'));
                    const padrao = oldVal ?? @json($ongCidade ?? null);

                    let html = '<option value="">Selecione</option>';
                    if (padrao && cidades.includes(padrao) === false) {
                        // se a cidade padrão não vier da lista (falha de nome exato), ainda assim preserva
                        html += `<option value="${padrao}" selected>${padrao}</option>`;
                    }
                    html += cidades.map(n => `<option value="${n}">${n}</option>`).join('');

                    sel.innerHTML = html;
                    // Seleciona prioridade: old() > cidade da ONG
                    if (oldVal) sel.value = oldVal;
                    else if (padrao) sel.value = padrao;
                } catch (e) {
                    // Se falhar, deixa o que já estava (cidade da ONG ou old)
                    if (!valorAtual) {
                        sel.innerHTML = '<option value="">Falha ao carregar cidades</option>';
                    }
                    console.error(e);
                }
            })();
        </script>