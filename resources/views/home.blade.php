@extends ('layouts.main')

@section('head')
<style>
    /* ===== SEÇÃO DO CARROSSEL ===== */

    .home-section {
        padding: 1.5rem 0 2.5rem;
    }

    .campaign-carousel .carousel-item img {
        width: 100%;
        height: 420px;         /* altura do banner */
        object-fit: cover;
        border-radius: 18px;
    }

    .campaign-carousel .carousel-inner {
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(0, 0, 0, .12);
    }

    .campaign-carousel .carousel-caption {
        left: 0;
        right: 0;
        bottom: 0;
        text-align: left;
        padding: 1.5rem 2rem 1.8rem;
        background: linear-gradient(to top, rgba(0,0,0,.75), rgba(0,0,0,.0));
    }

    .campaign-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .8rem;
        padding: .25rem .8rem;
        border-radius: 999px;
        background-color: rgba(255, 255, 255, .12);
        margin-bottom: .6rem;
    }

    .campaign-badge span {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .06em;
    }

    .campaign-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: .25rem;
    }

    .campaign-text {
        font-size: .9rem;
        margin-bottom: .8rem;
        max-width: 460px;
    }

    .campaign-btn {
        border-radius: 999px;
        padding: .4rem 1.3rem;
        font-size: .85rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .campaign-carousel .carousel-item img {
            height: 320px;
        }

        .campaign-carousel .carousel-caption {
            padding: 1.1rem 1.2rem 1.4rem;
        }
    }

    /* ===== NÚMEROS / INDICADORES ===== */

    .home-stats {
        padding: 1.5rem 0 3rem;
    }

    .stat-item h3 {
        font-weight: 700;
        margin-bottom: .15rem;
        color: #ff7a3c;
    }

    .stat-item p {
        margin: 0;
        font-size: .9rem;
        color: #6c757d;
    }
</style>
@endsection

@section('content')

{{-- CARROSSEL DE CAMPANHAS --}}
<section class="home-section">
    <div class="container">
        <div class="campaign-carousel">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
                </ol>

                <div class="carousel-inner">
                    {{-- Campanha 1 --}}
                    <div class="carousel-item active">
                        <img src="/img/carrossel 1.png" class="d-block w-100" alt="Campanha de adoção especial">
                        <div class="carousel-caption">
                            <div class="campaign-badge">
                                <span>Campanha ativa</span>
                            </div>
                            <div class="campaign-title">Adote um adulto: amor sem idade</div>
                            <div class="campaign-text">
                                Animais adultos esperam há meses por uma chance. Veja os pets dessa campanha e mude uma vida hoje.
                            </div>
                            <a href="{{ url('/adotar') }}" class="btn btn-light campaign-btn">
                                Ver pets da campanha
                            </a>
                        </div>
                    </div>

                    {{-- Campanha 2 --}}
                    <div class="carousel-item">
                        <img src="/img/carrossel 2.png" class="d-block w-100" alt="Campanha de doação de ração">
                        <div class="carousel-caption">
                            <div class="campaign-badge">
                                <span>Apoie as ONGs</span>
                            </div>
                            <div class="campaign-title">Doe ração e ajude abrigos lotados</div>
                            <div class="campaign-text">
                                Sua doação mantém animais resgatados alimentados e saudáveis enquanto aguardam um lar definitivo.
                            </div>
                            <a href="{{ url('/apoie') }}" class="btn btn-light campaign-btn">
                                Quero apoiar
                            </a>
                        </div>
                    </div>

                    {{-- Campanha 3 --}}
                    <div class="carousel-item">
                        <img src="/img/carrossel3.png" class="d-block w-100" alt="Campanha de castração">
                        <div class="carousel-caption">
                            <div class="campaign-badge">
                                <span>Prevenção</span>
                            </div>
                            <div class="campaign-title">Mutirão de castração solidária</div>
                            <div class="campaign-text">
                                Parceria com clínicas e voluntários para castrar animais de rua e de famílias de baixa renda.
                            </div>
                            <a href="{{ url('/campanhas/castracao') }}" class="btn btn-light campaign-btn">
                                Ver detalhes
                            </a>
                        </div>
                    </div>
                </div>

                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Anterior</span>
                </a>

                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Próximo</span>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- NÚMEROS DA PLATAFORMA / ONG --}}
<section class="home-stats">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="stat-item">
                    <h3>+{{ $petsAdotados ?? 0 }}</h3>
                    <p>pets adotados pela plataforma</p>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="stat-item">
                    <h3>{{ $ongsParceiras ?? 0 }}</h3>
                    <p>ONGs parceiras ativas</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <h3>{{ $cidadesAtendidas ?? 0 }}</h3>
                    <p>cidades atendidas atualmente</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
