@extends('layouts.sidebarpainelong')
<script>
    (function () {
        const nav = document.querySelector('.navbar');
        const setNavH = () => {
            const h = nav ? nav.offsetHeight : 56;
            document.documentElement.style.setProperty('--nav-h', h + 'px');
        };
        setNavH();
        window.addEventListener('resize', setNavH);
    })();
</script>
<style>
    /* zera a margem que o layout aplica aqui só nesta view */
    #main-content.mt-4 {
        margin-top: 0 !important;
    }

    /* ===== Wrapper que centraliza TUDO (descontando a navbar real) ===== */
    :root {
        --nav-h: 56px;
        --offset-top: clamp(8px, 20vh, 560px);
    }

    /* fallback; o JS abaixo mede a navbar de verdade */

 .dash-wrap{
  min-block-size: calc(100dvh - var(--nav-h));
  display: grid;
  justify-content: center;   /* centraliza horizontal */
  align-content: start;      /* cola no topo do wrapper */
  padding-block-start: var(--offset-top);  /* controla “o quanto sobe” */
  padding-inline: clamp(8px, 2vw, 24px);
}

    /* bloco interno com “lift” (sobe um pouco, responsivo) */
    .dash-stack {
        transform: none !important;
    }

    @media (max-width: 575.98px) {
        .dash-stack {
            transform: translateY(calc(-1 * var(--lift-mobile, var(--lift, 0px))));
        }
    }

    /* ===== Grid e cards (sua proporção mantida) ===== */
    .dash-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 18px;
        margin-top: 8px;
        max-inline-size: min(960px, 92vw);
        margin-inline: auto;
    }

    .dash-grid>[class*="col-"] {
        flex: 0 0 auto;
        width: auto;
        padding: 0;
    }

    .dash-card {
        --theme: #2e5672;
        width: 300px;
        max-width: 100%;
        aspect-ratio: 6/3;
        /* retângulo deitadinho */
        border: 1px solid rgba(0, 0, 0, .06);
        border-radius: 14px;
        padding: 14px;
        background: linear-gradient(180deg, #fff 0%, #fafbff 100%);
        box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-align: center;
        color: inherit;
        text-decoration: none;
        transition: transform .18s, box-shadow .18s, border-color .18s;
    }

    .dash-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, .09);
        border-color: color-mix(in srgb, var(--theme) 30%, #fff);
    }

    .dash-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: color-mix(in srgb, var(--theme) 12%, #fff);
        border: 1px solid color-mix(in srgb, var(--theme) 22%, #fff);
    }

    .dash-icon i {
        font-size: 20px;
        color: var(--theme);
    }

    .dash-text h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: .2px;
    }

    .dash-text p {
        margin: 0;
        color: #6b7280;
        font-size: .85rem;
    }

    .dash-arrow {
        display: none;
    }

    @media (max-width:575.98px) {
        .dash-card {
            width: 200px;
            border-radius: 12px;
            padding: 12px;
        }

        .dash-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
        }
    }

    /* header compacto opcional */
    .dash-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
        max-inline-size: min(960px, 92vw);
        margin-inline: auto;
    }

    .dash-header h2 {
        margin: 0;
    }
</style>

<div class="dash-wrap">
    <div class="dash-stack"">
        <div class="dash-header">
            <h2 class="mb-0">Painel da ONG</h2>
        </div>

        <div class="row dash-grid">
            <div class="col-md-4">
                <a href="{{ route('ong.pets') }}" class="dash-card" style="--theme:#1f7a8c">
                    <span class="dash-icon"><i class="bi bi-collection"></i></span>
                    <div class="dash-text">
                        <h5>Meus Pets</h5>
                        <p>Gerencie os pets cadastrados</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('ong.pets.novo') }}" class="dash-card" style="--theme:#22a06b">
                    <span class="dash-icon"><i class="bi bi-plus-circle"></i></span>
                    <div class="dash-text">
                        <h5>Novo Pet</h5>
                        <p>Cadastrar um novo pet para adoção</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="{{ route('ong.interesses') }}" class="dash-card" style="--theme:#8e5aa1">
                    <span class="dash-icon"><i class="bi bi-envelope-paper-heart"></i></span>
                    <div class="dash-text">
                        <h5>Pedidos de Adoção</h5>
                        <p>Veja quem demonstrou interesse</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>