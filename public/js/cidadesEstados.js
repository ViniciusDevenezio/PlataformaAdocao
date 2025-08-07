document.addEventListener('DOMContentLoaded', function () {
    console.log("Script cidadesEstados.js carregado");

    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');

    if (!estadoSelect || !cidadeSelect) {
        console.warn("Campos de estado ou cidade não encontrados no DOM.");
        return;
    }

    console.log("Buscando estados...");

    fetch('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome')
        .then(res => res.json())
        .then(estados => {
            estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.sigla;
                option.textContent = estado.nome;
                estadoSelect.appendChild(option);
            });
            console.log("Estados carregados com sucesso.");
        })
        .catch(err => {
            console.error("Erro ao carregar estados:", err);
        });

    estadoSelect.addEventListener('change', function () {
        const sigla = this.value;

        if (!sigla) return;

        cidadeSelect.innerHTML = '<option value="">Carregando cidades...</option>';
        cidadeSelect.disabled = true;

        console.log(`Buscando cidades para o estado: ${sigla}`);

        fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${sigla}/municipios`)
            .then(res => res.json())
            .then(cidades => {
                cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';

                cidades.forEach(cidade => {
                    const option = document.createElement('option');
                    option.value = cidade.nome;
                    option.textContent = cidade.nome;
                    cidadeSelect.appendChild(option);
                });

                cidadeSelect.disabled = false;
                console.log(`Cidades de ${sigla} carregadas com sucesso.`);
            })
            .catch(err => {
                cidadeSelect.innerHTML = '<option value="">Erro ao carregar cidades</option>';
                cidadeSelect.disabled = true;
                console.error("Erro ao carregar cidades:", err);
            });
    });
});
