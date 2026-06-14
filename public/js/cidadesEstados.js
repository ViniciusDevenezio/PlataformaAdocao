document.addEventListener('DOMContentLoaded', () => {
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');

    if (!estadoSelect || !cidadeSelect) {
        return;
    }

    let estadosPromise = null;

    const carregarEstados = () => {
        if (estadosPromise) {
            return estadosPromise;
        }

        estadoSelect.innerHTML = '<option value="">Carregando estados...</option>';
        estadoSelect.disabled = true;

        estadosPromise = fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
            .then((res) => res.json())
            .then((estados) => {
                estadoSelect.innerHTML = '<option value="">Selecione um estado</option>';

                estados.forEach((estado) => {
                    const option = document.createElement('option');
                    option.value = estado.sigla;
                    option.textContent = estado.nome;
                    estadoSelect.appendChild(option);
                });

                estadoSelect.disabled = false;

                return estados;
            })
            .catch((err) => {
                estadoSelect.innerHTML = '<option value="">Erro ao carregar estados</option>';
                estadoSelect.disabled = false;
                estadosPromise = null;
                console.error('Erro ao carregar estados:', err);

                throw err;
            });

        return estadosPromise;
    };

    const carregarCidades = (sigla) => {
        if (!sigla) {
            cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
            cidadeSelect.disabled = true;

            return Promise.resolve([]);
        }

        cidadeSelect.innerHTML = '<option value="">Carregando cidades...</option>';
        cidadeSelect.disabled = true;

        return fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${sigla}/municipios`)
            .then((res) => res.json())
            .then((cidades) => {
                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

                cidades.forEach((cidade) => {
                    const option = document.createElement('option');
                    option.value = cidade.nome;
                    option.textContent = cidade.nome;
                    cidadeSelect.appendChild(option);
                });

                cidadeSelect.disabled = false;

                return cidades;
            })
            .catch((err) => {
                cidadeSelect.innerHTML = '<option value="">Erro ao carregar cidades</option>';
                cidadeSelect.disabled = true;
                console.error('Erro ao carregar cidades:', err);

                throw err;
            });
    };

    window.carregarEstadosCadastro = carregarEstados;
    window.carregarCidadesCadastro = carregarCidades;

    estadoSelect.addEventListener('focus', carregarEstados, { once: true });
    estadoSelect.addEventListener('click', carregarEstados, { once: true });
    estadoSelect.addEventListener('touchstart', carregarEstados, { once: true, passive: true });
    estadoSelect.addEventListener('change', function () {
        carregarCidades(this.value).catch(() => {});
    });
});
