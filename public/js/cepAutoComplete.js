// public/js/cepAutoComplete.js

document.addEventListener('DOMContentLoaded', function () {
    const cepInput      = document.getElementById('cep');
    const estadoSelect  = document.getElementById('estado');
    const cidadeSelect  = document.getElementById('cidade');
    const enderecoInput = document.getElementById('endereco');
    const bairroInput   = document.getElementById('bairro');

    if (!cepInput) return;

    function limparCampos() {
        if (enderecoInput) enderecoInput.value = '';
        if (bairroInput)   bairroInput.value   = '';
        if (cidadeSelect)  cidadeSelect.value  = '';
        if (estadoSelect)  estadoSelect.value  = '';
    }

    cepInput.addEventListener('blur', function () {
        const cep = cepInput.value.replace(/\D/g, '');

        // CEP vazio ou com tamanho errado: só limpa e sai
        if (!cep) {
            limparCampos();
            return;
        }

        if (cep.length !== 8) {
            alert('CEP inválido. Digite 8 dígitos.');
            limparCampos();
            return;
        }

        // Busca ViaCEP sempre em HTTPS
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Erro ao consultar o ViaCEP');
                }
                return res.json();
            })
            .then(data => {
                if (data.erro) {
                    alert('CEP não encontrado.');
                    limparCampos();
                    return;
                }

                const logradouro = data.logradouro || '';
                const bairro     = data.bairro     || '';
                const uf         = data.uf         || '';
                const cidade     = data.localidade || '';

                if (enderecoInput) enderecoInput.value = logradouro;
                if (bairroInput)   bairroInput.value   = bairro;

                // Preenche estado se o select existir
                if (estadoSelect && uf) {
                    estadoSelect.value = uf;
                }

                // Preenche cidade se o select existir
                if (cidadeSelect && cidade) {
                    // Tenta encontrar uma option já existente com esse texto
                    const options = Array.from(cidadeSelect.options);
                    const existente = options.find(o =>
                        o.textContent.trim().toLowerCase() === cidade.toLowerCase()
                    );

                    if (existente) {
                        cidadeSelect.value = existente.value;
                    } else {
                        // Se não existir, cria uma option nova e seleciona
                        const opt = document.createElement('option');
                        opt.value = cidade;
                        opt.textContent = cidade;
                        cidadeSelect.appendChild(opt);
                        cidadeSelect.value = cidade;
                    }

                    cidadeSelect.disabled = false;
                }
            })
            .catch(err => {
                console.error('Erro na requisição ViaCEP:', err);
                alert('Não foi possível consultar o CEP no momento.');
                limparCampos();
            });
    });
});
