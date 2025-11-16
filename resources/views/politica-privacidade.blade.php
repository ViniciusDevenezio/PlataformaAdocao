@extends('layouts.main')

@section('title', 'Política de Privacidade')

@section('head')
<style>
    .pp-wrapper {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 1rem 4rem;
        font-family: 'Poppins', sans-serif;
        color: #3d3a40;
    }

    .pp-header {
        text-align: center;
        margin-bottom: 2rem;
        margin-top: 3rem;
    }
    
    .pp-header h1 {
        font-weight: 700;
        font-size: 2.3rem;
        color: #592374ff;
    }

    .pp-header p {
        color: #7d7a82;
        font-size: .95rem;
    }

    .pp-card {
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

    .pp-card h2 {
        font-size: 1.35rem;
        font-weight: 600;
        margin-top: 2rem;
        color: #5a3d69;
    }

    .pp-card h3 {
        font-size: 1.15rem;
        font-weight: 600;
        margin-top: 1.4rem;
        color: #6e4c81;
    }

    .pp-card ul {
        padding-left: 1.2rem;
    }

    .pp-card ul li {
        margin-bottom: .5rem;
        font-size: .95rem;
        color: #504c54;
    }

    .pp-card p {
        font-size: .97rem;
        line-height: 1.65rem;
        margin-bottom: 1rem;
        color: #444045;
    }

    .pp-divider {
        border: none;
        border-top: 1px solid #e7dff0;
        margin: 2rem 0;
    }

    .pp-highlight {
        background: #f7f2fa;
        border-left: 4px solid #8c5db5;
        padding: 1rem 1.2rem;
        border-radius: 10px;
        margin: 1.5rem 0;
        line-height: 1.6rem;
    }

    a {
        color: #8c5db5;
        text-decoration: none;
    }


</style>
@endsection

@section('content')
<div class="pp-wrapper">

    <div class="pp-header">
        <h1>Política de Privacidade</h1>
        <p>Última atualização: {{ now()->format('d/m/Y') }}</p>
    </div>

    <div class="pp-card">

        <p>
            Bem-vindo(a) à <strong>Pet projeto – Plataforma de Adoção Inteligente</strong>.  
            Esta Política de Privacidade explica como coletamos, utilizamos e protegemos seus dados
            ao acessar nossa plataforma, realizar cadastros, solicitar adoções, conectar redes sociais
            ou utilizar recursos de análise inteligente.
        </p>

        <div class="pp-highlight">
            Ao utilizar a plataforma, você declara estar ciente e de acordo com esta Política.
        </div>

        <h2>1. Quem Somos</h2>
        <p>
            A Pet projeto é uma plataforma digital que conecta ONGs e adotantes,
            utilizando tecnologias de automação e inteligência artificial para facilitar o processo
            de adoção responsável.
        </p>

        <h2>2. Dados Coletados</h2>
        <p>Dependendo do seu perfil e das funcionalidades utilizadas, coletamos:</p>

        <h3>2.1 Dados de ONGs</h3>
        <ul>
            <li>Nome da ONG</li>
            <li>Responsável e informações de contato</li>
            <li>E-mail e senha (criptografada)</li>
            <li>Cidade, estado, endereço aproximado</li>
            <li>CNPJ</li>
            <li>Links e dados de redes sociais</li>
        </ul>

        <h3>2.2 Dados de Adotantes</h3>
        <ul>
            <li>Nome completo</li>
            <li>CPF</li>
            <li>E-mail e senha (criptografada)</li>
            <li>Telefone / WhatsApp</li>
            <li>Cidade e estado</li>
            <li>Preferências de adoção</li>
            <li>Histórico de solicitações</li>
        </ul>

        <h3>2.3 Dados de Pets e Solicitações</h3>
        <ul>
            <li>Cadastro de animais (nome, porte, raça, idade, temperamento, foto, descrições)</li>
            <li>Status de adoção</li>
            <li>Solicitações de adoção e histórico</li>
            <li>Mensagens enviadas entre adotantes e ONGs</li>
        </ul>

        <h3>2.4 Integração com Facebook (Meta)</h3>
        <ul>
            <li>ID e nome da página conectada</li>
            <li>Foto e dados públicos relevantes</li>
            <li>Lista de páginas administradas</li>
            <li>Tokens de acesso para automações autorizadas</li>
        </ul>

        <p><strong>Importante:</strong> nós nunca coletamos sua senha do Facebook ou Instagram.</p>

        <h3>2.5 Dados de Uso do Sistema</h3>
        <ul>
            <li>IP, data e hora</li>
            <li>Navegador, dispositivo e sistema operacional</li>
            <li>Ações realizadas e páginas visitadas</li>
            <li>Cookies e logs técnicos</li>
        </ul>

        <h3>2.6 Dados enviados para Inteligência Artificial (IA)</h3>
        <p>
            Utilizamos IA (como OpenAI) para auxiliar na análise de perfis e sugestões de match.
            Podemos enviar textos descritivos sobre pets, perfis e formulários — sempre evitando dados sensíveis.
        </p>

        <hr class="hr hr-blurry" />

        <h2>3. Finalidade do Uso dos Dados</h2>
        <ul>
            <li>Gerenciar cadastros de ONG e adotantes</li>
            <li>Exibir e divulgar animais para adoção</li>
            <li>Organizar solicitações e comunicações</li>
            <li>Automatizar publicações em redes sociais autorizadas</li>
            <li>Fornecer análise inteligente e sugestões</li>
            <li>Melhorar segurança, estabilidade e desempenho</li>
        </ul>

        <h2>4. Base Legal (LGPD)</h2>
        <ul>
            <li>Execução de contrato</li>
            <li>Legítimo interesse</li>
            <li>Consentimento (quando aplicável)</li>
            <li>Cumprimento de obrigação legal</li>
        </ul>

        <h2>5. Compartilhamento de Dados</h2>
        <h3>5.1 Provedores de Serviço</h3>
        <ul>
            <li>Hospedagem e banco de dados</li>
            <li>Plataformas de e-mail</li>
            <li>Sistemas de IA</li>
            <li>Serviços de segurança e monitoramento</li>
        </ul>

        <h3>5.2 Facebook / Instagram (Meta)</h3>
        <p>Compartilhamos dados necessários para executar automações autorizadas por você.</p>

        <h3>5.3 Requisitos Legais</h3>
        <p>Podemos fornecer dados a autoridades quando legalmente obrigatório.</p>

        <h2>6. Segurança dos Dados</h2>
        <p>
            Utilizamos boas práticas de segurança, incluindo criptografia de senhas, controle de acesso,
            logs e monitoramento, porém nenhum sistema é 100% inviolável.
        </p>

        <h2>7. Direitos do Usuário</h2>
        <p>Você pode solicitar:</p>
        <ul>
            <li>Acesso, correção ou exclusão de dados</li>
            <li>Portabilidade</li>
            <li>Revogação de consentimento</li>
            <li>Informações sobre tratamento e finalidade</li>
        </ul>

        <h2>8. Cookies</h2>
        <p>
            Utilizamos cookies para autenticação, análise e melhoria da experiência.
            Você pode desativar no navegador, mas algumas partes da plataforma podem deixar de funcionar.
        </p>

        <h2>9. Contato</h2>
        <p>Para exercer seus direitos ou tirar dúvidas:</p>
        <ul>
            <li>E-mail: <a  >viniciusdevenezio@gmail.com</a></li>
        </ul>

        <h2>10. Atualizações</h2>
        <p>
            Esta Política pode ser atualizada a qualquer momento. A data no topo sempre mostrará a versão mais recente.
        </p>

    </div>

</div>
@endsection
