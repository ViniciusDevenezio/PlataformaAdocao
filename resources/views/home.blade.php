@extends ('layouts.main')

@section('head')

@endsection

@section('menu')

@endsection

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
      <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
      <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="/img/carrossel 1.png" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="/img/carrossel 2.png" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="/img/carrossel3.png" alt="Third slide">
      </div>
    </div>

    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </a>
  </div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    var myCarousel = new bootstrap.Carousel(document.querySelector('#carouselExampleIndicators'), {
      interval: 3000, // Tempo de troca em milissegundos
      ride: 'carousel',
      wrap: true // Habilita o loop infinito
    });
  });
</script>
