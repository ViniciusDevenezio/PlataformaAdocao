@extends('layouts.main')

@section('title', 'Encontre seu Match')

@section('head')
    <style>
        :root {
            --match-primary: #7f4ca5;
            --match-primary-dark: #6c3f93;
            --match-soft-bg: #f7f3fb;
        }

        /* ===== LAYOUT GERAL DA PÁGINA ===== */
        .match-page {
            padding-top: 7rem;
            padding-bottom: 3rem;

        }

        .match-layout {
            max-width: 920px;
            margin: 0 auto;
            min-height: calc(100vh - 9rem);
          
            display: flex;
            justify-content: center;
   
            padding-inline: .75rem;
            margin-bottom: -3rem;
  
        }


        @media (max-width: 768px) {
            .match-layout {
                align-items: flex-start;
                min-height: auto;
                padding-top: 0.5rem;
            }
        }

        /* ===== CARD PRINCIPAL ===== */
        .match-card {
            width: 100%;
            max-width: 720px;
            border-radius: 1.2rem;
            border: 1px solid #e3d8f2;
            background: #ffffff;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.10);
            color: #2f2440;
            position: relative;
            padding: 2.25rem 2rem;
        }

        @media (max-width: 1280px) {
            .match-layout {
                margin-bottom: -4rem;
      
            }
        }


        @media (max-width: 1024px) {
            .match-layout {
                margin-bottom: -2rem;
            }
        }

      
        @media (max-width: 768px) {
            .match-layout {
                margin-bottom: 0;
             
                min-height: auto;
              
                align-items: flex-start;
          
                padding-top: 0.5rem;
            }
        }

        /* ===== OVERLAY CARREGAMENTO IA ===== */
        .match-loading {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 30% 20%, rgba(127, 76, 165, 0.08), transparent 40%),
                radial-gradient(circle at 75% 80%, rgba(45, 156, 219, 0.1), transparent 45%),
                rgba(255, 255, 255, 0.94);
            border-radius: 1.2rem;
            z-index: 5;
        }

        .match-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.9rem;
            color: #4e4561;
        }

        .match-loader .gemini-orb {
            width: 120px;
            height: 120px;
            position: relative;
            display: grid;
            place-items: center;
        }

        @media (max-width: 576px) {
            .match-loader .gemini-orb {
                width: 90px;
                height: 90px;
            }
        }

        .gemini-orb .gemini-ring {
            width: 100%;
            height: 100%;
            border-radius: 999px;
            background: conic-gradient(from 0deg, #ff8a00, #e52e71, #9b51e0, #2d9cdb, #ff8a00);
            filter: drop-shadow(0 8px 18px rgba(127, 76, 165, 0.25));
            animation: spin 6s linear infinite;
            mask: radial-gradient(circle at center, transparent 52%, black 52%);
            -webkit-mask: radial-gradient(circle at center, transparent 52%, black 52%);
        }

        .gemini-orb .gemini-star {
            position: absolute;
            width: 62px;
            height: 62px;
            border-radius: 18px;
            background: linear-gradient(135deg, #fff8f0, #f4e8ff);
            display: grid;
            place-items: center;
            color: #7f4ca5;
            font-size: 2rem;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            animation: float 3s ease-in-out infinite;
        }

        @media (max-width: 576px) {
            .gemini-orb .gemini-star {
                width: 50px;
                height: 50px;
                font-size: 1.6rem;
            }
        }

        .gemini-orb .gemini-dot {
            position: absolute;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.08);
            animation: orbit 4s ease-in-out infinite;
        }

        .gemini-orb .gemini-dot:nth-of-type(2) {
            animation-delay: -0.6s;
        }

        .gemini-orb .gemini-dot:nth-of-type(3) {
            animation-delay: -1.2s;
        }

        .match-loading-text {
            text-align: center;
            max-width: 260px;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes orbit {
            0% {
                transform: rotate(0deg) translateX(46px) rotate(0deg);
                opacity: 0.9;
            }

            50% {
                transform: rotate(180deg) translateX(46px) rotate(-180deg);
                opacity: 0.4;
            }

            100% {
                transform: rotate(360deg) translateX(46px) rotate(-360deg);
                opacity: 0.9;
            }
        }

        /* ===== CABEÇALHO DO FORM ===== */
        .match-header h2 {
            color: #523f5f;
        }

        .match-header p {
            margin-bottom: 0;
            color: #7d6f8a;
            max-width: 420px;
            margin-inline: auto;
        }

        .match-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #fff5ea;
            color: #ff8a00;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.06);
        }

        .match-step-indicator {
            font-size: .9rem;
            font-weight: 500;
            color: #8a7199;
        }

        .match-step-indicator span.badge {
            background: #f1e9ff;
            color: #523f5f;
            border-radius: 999px;
            padding: .35rem .85rem;
            font-size: .8rem;
            border: 1px solid #e0d2f2;
        }

        .match-divider {
            height: 1px;
            width: 100%;
            background: linear-gradient(to right, transparent, #e3d8f2, transparent);
            margin: .75rem 0 1.25rem;
        }

        /* ===== FORM ===== */
        .match-form .form-label {
            font-weight: 600;
            color: #5a4b66;
            font-size: 0.95rem;
        }

        .match-form .form-select,
        .match-form .form-control {
            border-radius: .6rem;
            border-color: #e0d4f0;
            background-color: #fbf9ff;
            color: #2f2440;
            font-size: 0.93rem;
        }

        .match-form .form-select:focus,
        .match-form .form-control:focus {
            border-color: var(--match-primary);
            box-shadow: 0 0 0 0.15rem rgba(127, 76, 165, 0.18);
        }

        .match-form .form-check-label {
            color: #5c5464;
            font-size: 0.9rem;
        }

        .match-form .form-check-input {
            border-color: #c7badf;
        }

        .match-form .form-check-input:checked {
            background-color: var(--match-primary);
            border-color: var(--match-primary);
        }

        /* ===== ETAPAS ===== */
        .match-steps-wrapper {
            position: relative;
        }

        .match-step {
            display: none;
            opacity: 0;
        }

        .match-step.active {
            display: block;
            opacity: 1;
        }

        /* animações */
        .match-step.anim-enter-right {
            animation: slideInRight .35s ease forwards;
        }

        .match-step.anim-enter-left {
            animation: slideInLeft .35s ease forwards;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(35px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-35px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* ===== AÇÕES / BOTÕES ===== */
        .match-actions {
            display: flex;
            gap: .75rem;
            margin-top: 1.5rem;
            align-items: center;
        }

        .match-btn {
            font-weight: 600;
            color: #fff !important;
            background: linear-gradient(270deg, #ff8a00, #e52e71, #9b51e0, #2d9cdb);
            background-size: 800% 800%;
            border-radius: 25px;
            padding: 10px 18px !important;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            animation: gradientMove 8s ease infinite;
            border: 2px solid transparent;
            z-index: 1;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .match-btn i {
            font-size: 1rem;
            animation: starGlow 2s infinite ease-in-out;
        }

        .match-btn::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 25px;
            padding: 2px;
            background: linear-gradient(90deg,
                    rgba(255, 255, 255, 0.9),
                    rgba(255, 255, 255, 0.3),
                    rgba(255, 255, 255, 0.9));
            background-size: 300% 300%;
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            animation: borderWhiteRun 3s linear infinite;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .match-btn:hover::before {
            opacity: 1;
        }

        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes borderWhiteRun {
            0% {
                background-position: 0% 50%;
            }

            100% {
                background-position: 300% 50%;
            }
        }

        @keyframes starGlow {
            0% {
                color: #fff;
                text-shadow: 0 0 3px #fff;
            }

            50% {
                color: #fff;
                text-shadow: 0 0 8px rgba(255, 255, 255, 0.6);
            }

            100% {
                color: #fff;
                text-shadow: 0 0 3px #fff;
            }
        }

        #btnPrev,
        #btnNext {
            border-radius: 999px;
            padding-inline: 18px;
            font-weight: 500;
            border-width: 1px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        #btnPrev {
            border-color: #d4c6ea;
            color: #6b5a7d;
            background: #f6f1ff;
        }

        #btnPrev:disabled {
            opacity: 0.4;
            cursor: default;
        }

        #btnNext {
            border-color: transparent;
            color: #ffffff;
            background: #7f4ca5;
            box-shadow: 0 6px 14px rgba(127, 76, 165, 0.35);
        }

        #btnNext:hover {
            background: #6c3f93;
        }

        @media (max-width: 576px) {
            .match-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            #btnPrev,
            #btnNext {
                width: 100%;
                justify-content: center;
            }

            .match-actions .ms-auto {
                margin-left: 0 !important;
                width: 100%;
            }
        }

        /* ===== ÁREA DE RESULTADO DA IA (EXEMPLO) ===== */
        .match-result-wrapper {
            max-width: 720px;
            margin: 1.75rem auto 0 auto;
        }

        .match-result-card {
            border-radius: 1.2rem;
            border: 1px solid #e3d8f2;
            background: #ffffff;
            box-shadow: 0 14px 32px rgba(0, 0, 0, 0.08);
            padding: 1.75rem 1.5rem;
        }

        @media (max-width: 576px) {
            .match-result-card {
                padding: 1.3rem 1.1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="match-page">
        <div class="match-layout">
            <div class="card border-0 match-card">
                <div class="match-loading d-none" id="matchLoading">
                    <div class="match-loader">
                        <div class="gemini-orb">
                            <div class="gemini-ring"></div>
                            <div class="gemini-star"><i class="bi bi-stars"></i></div>
                            <span class="gemini-dot"></span>
                            <span class="gemini-dot"></span>
                            <span class="gemini-dot"></span>
                        </div>
                        <div class="match-loading-text">
                            <div class="fw-semibold">Buscando o melhor match com a IA...</div>
                            <div class="text-secondary small">Aguarde enquanto personalizamos a recomendação</div>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-3 match-header">
                    <div class="match-icon mb-3">
                        <i class="bi bi-stars fs-3"></i>
                    </div>
                    <h2 class="fw-bold">Encontre seu Match</h2>
                    <p>
                        Responda o questionário por etapas e descubra o pet ideal para o seu estilo de vida.
                    </p>
                    <div class="match-step-indicator mt-2">
                        <span class="badge">
                            Etapa <span id="matchStepNumber">1</span> de <span id="matchStepTotal">3</span>
                        </span>
                    </div>
                </div>

                <div class="match-divider"></div>

                <form method="POST" action="{{ route('match') }}" class="match-form" id="matchForm">
                    @csrf

                    <div class="match-steps-wrapper">
                        {{-- ETAPA 1 --}}
                        <div class="match-step active" data-step="1">
                            <div class="mb-3">
                                <label class="form-label">Como é sua rotina de trabalho?</label>
                                <select class="form-select" name="trabalho" required>
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="home_office">Home office</option>
                                    <option value="hibrido">Híbrido / Misto</option>
                                    <option value="presencial">Presencial</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quanto tempo você passa em casa por dia?</label>
                                <select class="form-select" name="tempo_em_casa" required>
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="baixo">Menos de 2h</option>
                                    <option value="medio">2 a 4 horas</option>
                                    <option value="alto">4 a 8 horas</option>
                                    <option value="quase_todo">Quase o dia todo</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Qual a área aproximada do espaço disponível na sua casa?</label>
                                <select class="form-select" name="espaco" required>
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="apto_pequeno">Apartamento pequeno (até 60 m²)</option>
                                    <option value="apto_grande">Apartamento grande (61 a 100 m²)</option>
                                    <option value="casa_pequena">Casa com quintal pequeno (até 200 m²)</option>
                                    <option value="casa_grande">Casa com quintal grande (acima de 200 m²)</option>
                                </select>
                            </div>
                        </div>

                        {{-- ETAPA 2 --}}
                        <div class="match-step" data-step="2">
                            <div class="mb-3">
                                <label class="form-label">Quais atividades de lazer mais combinam com você?</label>
                                <select class="form-select" name="lazer" required>
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="casa">Prefiro ficar em casa, ambiente tranquilo</option>
                                    <option value="moderado">Gosto de sair de vez em quando, passeios moderados</option>
                                    <option value="ativo">Sou bem ativo, pratico esportes e gosto de movimento</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Com quem você mora?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="moradia[]" value="sozinho"
                                        id="moradiaSozinho">
                                    <label class="form-check-label" for="moradiaSozinho">Moro sozinho</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="moradia[]" value="adultos"
                                        id="moradiaAdultos">
                                    <label class="form-check-label" for="moradiaAdultos">Moro com adultos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="moradia[]" value="criancas"
                                        id="moradiaCriancas">
                                    <label class="form-check-label" for="moradiaCriancas">Moro com crianças</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="moradia[]" value="idosos"
                                        id="moradiaIdosos">
                                    <label class="form-check-label" for="moradiaIdosos">Moro com idosos</label>
                                </div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Qual sua experiência com pets?</label>
                                <select class="form-select" name="experiencia" required>
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="nenhuma">Nunca tive pets</option>
                                    <option value="alguma">Já tive alguns pets</option>
                                    <option value="muita">Tenho bastante experiência</option>
                                </select>
                            </div>
                        </div>

                        {{-- ETAPA 3 --}}
                        <div class="match-step" data-step="3">
                            <div class="mb-3">
                                <label class="form-label">Como você enxerga os cuidados veterinários do seu futuro
                                    pet?</label>
                                <select class="form-select" name="tolerancia" required>
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="minimo">Apenas em emergências</option>
                                    <option value="preventivo">Sempre que necessário, incluindo cuidados preventivos
                                    </option>
                                    <option value="especial">Estou disposto(a) a acompanhar tratamentos contínuos ou
                                        necessidades especiais</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Qual sua renda familiar aproximada?</label>
                                <select class="form-select" name="renda" required>
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="baixa">Até 2 salários mínimos</option>
                                    <option value="media">Entre 2 e 5 salários mínimos</option>
                                    <option value="alta">Acima de 5 salários mínimos</option>
                                </select>
                            </div>

                            <p class="text-muted small mt-3 mb-0">
                                Ao continuar, você concorda em utilizar seus dados apenas para recomendação de pets
                                e contato com as ONGs participantes.
                            </p>
                        </div>
                    </div>

                    <div class="match-actions">
                        <button type="button" class="btn" id="btnPrev" disabled>
                            Voltar
                        </button>

                        <div class="ms-auto d-flex gap-2">
                            <button type="button" class="btn" id="btnNext">
                                Próximo
                            </button>
                            <button type="submit" class="btn match-btn w-100 d-none" id="btnSubmit">
                                <i class="bi bi-stars"></i>
                                Encontrar meu Match
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- EXEMPLO: BLOCO DE RESULTADO DA IA MAIS “PARA BAIXO” --}}
        {{-- Quando você tiver o resultado, pode renderizar algo assim: --}}
        {{--
        @if(session('match_result'))
        <div class="match-result-wrapper">
            <div class="match-result-card">
                ... conteúdo do resultado ...
            </div>
        </div>
        @endif
        --}}
    </div>

    <script nonce="{{ $cspNonce ?? '' }}">
        document.addEventListener('DOMContentLoaded', function () {
            const steps = Array.from(document.querySelectorAll('.match-step'));
            const totalSteps = steps.length;
            let currentStep = 1;

            const stepNumberEl = document.getElementById('matchStepNumber');
            const stepTotalEl = document.getElementById('matchStepTotal');
            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');
            const btnSubmit = document.getElementById('btnSubmit');
            const form = document.getElementById('matchForm');

            stepTotalEl.textContent = totalSteps;

            function updateUI() {
                stepNumberEl.textContent = currentStep;
                btnPrev.disabled = currentStep === 1;
                btnNext.classList.toggle('d-none', currentStep === totalSteps);
                btnSubmit.classList.toggle('d-none', currentStep !== totalSteps);
            }

            function validateCurrentStep() {
                const currentStepEl = steps[currentStep - 1];
                const fields = currentStepEl.querySelectorAll('select[required], input[required]');
                for (const field of fields) {
                    if (!field.checkValidity()) {
                        field.reportValidity();
                        return false;
                    }
                }
                return true;
            }

            function showStep(newStep, direction) {
                if (newStep < 1 || newStep > totalSteps) return;

                steps.forEach(step => {
                    step.classList.remove('active', 'anim-enter-right', 'anim-enter-left');
                });

                const target = steps[newStep - 1];

                if (direction === 'forward') {
                    target.classList.add('active', 'anim-enter-right');
                } else if (direction === 'backward') {
                    target.classList.add('active', 'anim-enter-left');
                } else {
                    target.classList.add('active');
                }

                currentStep = newStep;
                updateUI();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            btnNext.addEventListener('click', function () {
                if (!validateCurrentStep()) return;
                showStep(currentStep + 1, 'forward');
            });

            btnPrev.addEventListener('click', function () {
                showStep(currentStep - 1, 'backward');
            });

            const loadingOverlay = document.getElementById('matchLoading');

            form.addEventListener('submit', function (e) {
                if (!validateCurrentStep()) {
                    e.preventDefault();
                    return;
                }

                btnPrev.disabled = true;
                btnNext.disabled = true;
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Buscando...';

                if (loadingOverlay) {
                    loadingOverlay.classList.remove('d-none');
                }
            });

            steps[0].classList.add('active');
            updateUI();

            // ----- LÓGICA "MORO SOZINHO" vs OUTROS -----
            const chkSozinho = document.getElementById('moradiaSozinho');
            const chkAdultos = document.getElementById('moradiaAdultos');
            const chkCriancas = document.getElementById('moradiaCriancas');
            const chkIdosos = document.getElementById('moradiaIdosos');

            if (chkSozinho && chkAdultos && chkCriancas && chkIdosos) {
                const outros = [chkAdultos, chkCriancas, chkIdosos];

                chkSozinho.addEventListener('change', function () {
                    if (this.checked) {
                        outros.forEach(c => c.checked = false);
                    }
                });

                outros.forEach(chk => {
                    chk.addEventListener('change', function () {
                        if (this.checked) {
                            chkSozinho.checked = false;
                        }
                    });
                });
            }
        });
    </script>

@endsection
