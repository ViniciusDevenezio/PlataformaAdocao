@extends ('layouts.main')

@section('head')
    <style>
        /* ===== SEÇÃO DO CARROSSEL ===== */

        .home-section {
            padding: .5rem 0 2.25rem;
        }

        .carousel-control-prev {
            left: 1.25rem;
           
        }

        .carousel-control-next {
            right: 1.25rem;
         
        }

        .campaign-carousel .carousel-item img {
            width: 100%;
            height: clamp(360px, 52vw, 520px);
            object-fit: cover;
            border-radius: 8px;
        }

        .campaign-carousel .carousel-inner {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .18);
            border: 1px solid rgba(255, 255, 255, .65);
        }

        .campaign-carousel .carousel-caption {
            left: 0;
            right: 0;
            bottom: 0;
            text-align: left;
            padding: 2rem clamp(1.25rem, 4vw, 3rem) 2.25rem;
            background: linear-gradient(to top, rgba(15, 23, 42, .82), rgba(15, 23, 42, .32), rgba(15, 23, 42, .04));
        }

        .campaign-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .8rem;
            padding: .35rem .85rem;
            border-radius: 999px;
            background-color: rgba(255, 255, 255, .18);
            border: 1px solid rgba(255, 255, 255, .22);
            backdrop-filter: blur(8px);
            margin-bottom: .75rem;
        }

        .campaign-badge span {
            font-size: .75rem;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .campaign-title {
            font-size: clamp(1.35rem, 3vw, 2.35rem);
            font-weight: 700;
            margin-bottom: .4rem;
            max-width: 680px;
        }

        .campaign-text {
            font-size: .98rem;
            margin-bottom: 1rem;
            max-width: 560px;
            color: rgba(255, 255, 255, .9);
        }

        .campaign-btn {
            border-radius: 999px;
            padding: .55rem 1.35rem;
            font-size: .88rem;
            font-weight: 700;
            color: #0B5ED7;
            box-shadow: 0 12px 25px rgba(255, 255, 255, .2);
        }

        @media (max-width: 768px) {
            .campaign-carousel .carousel-item img {
                height: 320px;
            }

            .campaign-carousel .carousel-caption {
                padding: 1.1rem 1.2rem 1.4rem;
            }
        }


        .home-stats {
            padding: .5rem 0 3.25rem;
        }

        .home-stats .row {
            background: rgba(255, 255, 255, .9);
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .1);
            margin: 0;
            padding: 1.1rem .5rem;
        }

        .stat-item {
            padding: .75rem;
        }

        .stat-item h3 {
            font-weight: 700;
            margin-bottom: .15rem;
            color: #ff7a3c;
        }

        .stat-item p {
            margin: 0;
            font-size: .9rem;
            color: #667085;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 3rem;
            height: 3rem;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 50%;
            backdrop-filter: blur(6px);
            background: rgba(255, 255, 255, .22);
            transition: all .25s ease;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(255, 255, 255, .35);
            transform: translateY(-50%) scale(1.1);
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
                        <picture>
                            <source srcset="/img/carrossel-1.webp" type="image/webp">
                            <img src="/img/carrossel 1.png" class="d-block w-100" alt="Campanha de adoção especial" width="1435" height="600" fetchpriority="high" decoding="async">
                        </picture>
                        <div class="carousel-caption">
                            <div class="campaign-badge">
                                <span>Campanha ativa</span>
                            </div>
                            <div class="campaign-title">Adote um pet adulto: amor sem idade</div>
                            <div class="campaign-text">
                                Animais adultos esperam há meses por uma chance. Veja os pets dessa campanha e mude uma vida hoje.
                            </div>
                            <a href="{{ route('adotar', ['idade_min' => 4]) }}" class="btn btn-light campaign-btn">
                                Ver pets da campanha
                            </a>
                        </div>
                    </div>

                    {{-- Campanha 2 --}}
                    <div class="carousel-item">
                        <picture>
                            <source srcset="/img/carrossel-2.webp" type="image/webp">
                            <img src="/img/carrossel 2.png" class="d-block w-100" alt="Campanha de doação de ração" width="785" height="435" loading="lazy" decoding="async">
                        </picture>
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
                        <picture>
                            <source srcset="/img/carrossel-3.webp" type="image/webp">
                            <img src="/img/carrossel3.png" class="d-block w-100" alt="Campanha de castração" width="2000" height="1194" loading="lazy" decoding="async">
                        </picture>
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
