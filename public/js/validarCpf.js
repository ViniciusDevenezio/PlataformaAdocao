function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');

    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }

    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) return false;

    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }

    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(10))) return false;

    return true;
}

document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const cpfInput = document.getElementById("cpf");

    cpfInput.addEventListener("blur", function () {
        if (cpfInput.value.trim() === '') {
            cpfInput.classList.remove("is-invalid");
            return;
        }

        if (!validarCPF(cpfInput.value)) {
            cpfInput.classList.add("is-invalid");
        } else {
            cpfInput.classList.remove("is-invalid");
        }
    });

    form.addEventListener("submit", function (e) {
        if (!validarCPF(cpfInput.value)) {
            cpfInput.classList.add("is-invalid");
            alert("Por favor, corrija seu CPF antes de continuar");
            e.preventDefault();
        }
    });
});

$(document).ready(function () {
    $('#cadastro-container').fadeIn(0);
});
