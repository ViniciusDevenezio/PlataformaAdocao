document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');
    const enderecoInput = document.getElementById('endereco');
    const bairroInput = document.getElementById('bairro');

    if (!cepInput) return;

    cepInput.addEventListener('blur', function () {
        const cep = cepInput.value.replace(/\D/g, '');

        if (cep.length !== 8) return;

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado');
                    return;
                }

                // Preencher os campos imediatamente disponíveis
                enderecoInput.value = data.logradouro || '';
                bairroInput.value = data.bairro || '';

                // Selecionar o estado (sigla)
                const estado = data.uf;
                const cidade = data.localidade;

                // Espera até os estados estarem carregados
                const tryFillCidade = setInterval(() => {
                    const estadoOptions = [...estadoSelect.options].map(o => o.value);
                    if (estadoOptions.includes(estado)) {
                        estadoSelect.value = estado;
                        estadoSelect.dispatchEvent(new Event('change')); // dispara para carregar cidades

                        // Espera as cidades carregarem
                        const waitCidade = setInterval(() => {
                            const cidadeOptions = [...cidadeSelect.options].map(o => o.textContent);
                            if (cidadeOptions.includes(cidade)) {
                                cidadeSelect.value = cidade;
                                cidadeSelect.disabled = false;
                                clearInterval(waitCidade);
                            }
                        }, 300);

                        clearInterval(tryFillCidade);
                    }
                }, 300);
            })
            .catch(() => {
                alert('Erro ao buscar o CEP');
            });
    });
});
