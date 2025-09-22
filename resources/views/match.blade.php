@extends('layouts.main')

@section('title', 'Encontre seu Match')

@section('content')
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm p-4" style="max-width: 650px; width: 100%;">
      <div class="text-center mb-4">
        <i class="bi bi-stars fs-1" style="color:#ff8a00;"></i>
        <h2 class="fw-bold">Encontre seu Match</h2>
        <p class="text-muted">Responda o questionário e descubra o pet ideal para o seu estilo de vida.</p>
      </div>

      <form method="POST" action="{{ route('match') }}">
        @csrf

        {{-- Modelo de trabalho --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Como é sua rotina de trabalho?</label>
          <select class="form-select" name="trabalho" required>
            <option value="home_office">Home office</option>
            <option value="hibrido">Híbrido / Misto</option>
            <option value="presencial">Presencial</option>
          </select>
        </div>

        {{-- Tempo em casa --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Quanto tempo você passa em casa por dia?</label>
          <select class="form-select" name="tempo_em_casa" required>
            <option value="baixo">Menos de 2h</option>
            <option value="medio">2 a 4 horas</option>
            <option value="alto">4 a 8 horas</option>
            <option value="quase_todo">Quase o dia todo</option>
          </select>
        </div>

        {{-- Tamanho da casa --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Qual a área aproximada do espaço disponível na sua casa?</label>
          <select class="form-select" name="espaco" required>
            <option value="apto_pequeno">Apartamento pequeno (até 60 m²)</option>
            <option value="apto_grande">Apartamento grande (61 a 100 m²)</option>
            <option value="casa_pequena">Casa com quintal pequeno (até 200 m²)</option>
            <option value="casa_grande">Casa com quintal grande (acima de 200 m²)</option>
          </select>
        </div>
        {{-- Atividades de lazer --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Quais atividades de lazer mais combinam com você?</label>
          <select class="form-select" name="lazer" required>
            <option value="casa">Prefiro ficar em casa, ambiente tranquilo</option>
            <option value="moderado">Gosto de sair de vez em quando, passeios moderados</option>
            <option value="ativo">Sou bem ativo, pratico esportes e gosto de movimento</option>
          </select>
        </div>

        {{-- Com quem mora (checkbox múltiplo) --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Com quem você mora?</label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="moradia[]" value="sozinho" id="moradiaSozinho">
            <label class="form-check-label" for="moradiaSozinho">Moro sozinho</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="moradia[]" value="adultos" id="moradiaAdultos">
            <label class="form-check-label" for="moradiaAdultos">Moro com adultos</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="moradia[]" value="criancas" id="moradiaCriancas">
            <label class="form-check-label" for="moradiaCriancas">Moro com crianças</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="moradia[]" value="idosos" id="moradiaIdosos">
            <label class="form-check-label" for="moradiaIdosos">Moro com idosos</label>
          </div>
        </div>

        {{-- Experiência com pets --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Qual sua experiência com pets?</label>
          <select class="form-select" name="experiencia" required>
            <option value="nenhuma">Nunca tive pets</option>
            <option value="alguma">Já tive alguns pets</option>
            <option value="muita">Tenho bastante experiência</option>
          </select>
        </div>

        {{-- Tolerância a cuidados --}}
        <div class="mb-3">
          <label class="form-label fw-semibold">Como você enxerga os cuidados veterinários do seu futuro pet?</label>
          <select class="form-select" name="tolerancia" required>
            <option value="minimo">Apenas em emergências</option>
            <option value="preventivo">Sempre que necessário, incluindo cuidados preventivos</option>
            <option value="especial">Estou disposto(a) a acompanhar tratamentos contínuos ou necessidades especiais
            </option>
          </select>
        </div>

        {{-- Renda familiar aproximada --}}
        <div class="mb-4">
          <label class="form-label fw-semibold">Qual sua renda familiar aproximada?</label>
          <select class="form-select" name="renda" required>
            <option value="baixa">Até 2 salários mínimos</option>
            <option value="media">Entre 2 e 5 salários mínimos</option>
            <option value="alta">Acima de 5 salários mínimos</option>
          </select>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-stars me-2"></i>Encontrar meu Match
          </button>
        </div>
      </form>
    </div>
  </div>
@endsection