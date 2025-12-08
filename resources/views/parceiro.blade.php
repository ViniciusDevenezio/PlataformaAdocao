@extends('layouts.main')

@section('title', 'Seja um parceiro')

@section('head')
<style>
    .partner-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 3rem 1rem 4rem;
        font-family: 'Poppins', sans-serif;
        color: #3d3a40;
    }

    .partner-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 2.5rem 2rem;
        box-shadow: 0px 8px 24px rgba(0,0,0,0.08);
        animation: fadeIn .4s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .partner-title {
        font-weight: 700;
        font-size: 2.2rem;
        color: #592374ff;
        margin-bottom: 1rem;
        text-align: center;
    }

    .partner-lead {
        color: #7d7a82;
        font-size: 1rem;
        text-align: center;
        margin-bottom: 2rem;
    }

    .partner-steps {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 1rem;
    }

    .partner-steps li {
        background: #f7f2fa;
        border-left: 4px solid #8c5db5;
        padding: 1rem 1.2rem;
        border-radius: 10px;
        line-height: 1.6rem;
    }

    .partner-email {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-weight: 600;
        color: #8c5db5;
        text-decoration: none;
    }
</style>
@endsection

@section('content')
<div class="partner-wrapper">
    <div class="partner-card">
        <h1 class="partner-title">Torne-se uma ONG parceira</h1>
        <p class="partner-lead">
            Quer divulgar seus animais para adoção na plataforma? Envie seus dados e entraremos em contato.
        </p>

        <ul class="partner-steps">
            <li>Apresente o nome da ONG e o CNPJ.</li>
            <li>Inclua as informações de contato do responsável.</li>
            <li>Compartilhe cidade, estado e links de redes sociais.</li>
            <li>Envie tudo para o e-mail <a class="partner-email" href="mailto:viniciusdevenezio@gmail.com">viniciusdevenezio@gmail.com</a>.</li>
        </ul>
    </div>
</div>
@endsection
