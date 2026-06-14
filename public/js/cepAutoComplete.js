document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');
    const estadoSelect = document.getElementById('estado');
    const cidadeSelect = document.getElementById('cidade');
    const enderecoInput = document.getElementById('endereco');
    const bairroInput = document.getElementById('bairro');

    if (!cepInput) return;

    let cepAbortController = null;

    cepInput.addEventListener('blur', async function () {
        const cep = cepInput.value.replace(/\D/g, '');

        if (cep.length !== 8) return;

        if (cepAbortController) {
            cepAbortController.abort();
        }

        cepAbortController = new AbortController();

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`, {
                signal: cepAbortController.signal,
            });
            const data = await response.json();

            if (data.erro) {
                alert('CEP nao encontrado');
                return;
            }

            if (enderecoInput) enderecoInput.value = data.logradouro || '';
            if (bairroInput) bairroInput.value = data.bairro || '';

            const estado = data.uf;
            const cidade = data.localidade;

            if (estadoSelect && typeof window.carregarEstadosCadastro === 'function') {
                await window.carregarEstadosCadastro();
                estadoSelect.value = estado;
            }

            if (cidadeSelect && typeof window.carregarCidadesCadastro === 'function') {
                await window.carregarCidadesCadastro(estado);

                const cidadeOption = [...cidadeSelect.options].find((option) => option.value === cidade || option.textContent === cidade);

                if (cidadeOption) {
                    cidadeSelect.value = cidadeOption.value;
                    cidadeSelect.disabled = false;
                }
            }
        } catch (error) {
            if (error.name !== 'AbortError') {
                alert('Erro ao buscar o CEP');
            }
        }
    });
});
