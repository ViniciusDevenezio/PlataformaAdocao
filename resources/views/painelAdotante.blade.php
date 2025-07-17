@extends ('layouts.main')

@section('head')
@endsection

@section('menu')
@endsection


  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .sidebar {
      height: 100vh;
      background-color: #343a40;
      color: white;
      padding-top: 1rem;
      min-width: 250px;
    }
    .sidebar a {
      color: #adb5bd;
      text-decoration: none;
    }
    .sidebar a:hover,
    .sidebar .active {
      background-color: #0d6efd;
      color: white !important;
    }
    .sidebar .logo {
      text-align: center;
      margin-bottom: 20px;
    }
    .sidebar .logo img {
      width: 120px;
    }
  </style>
</head>
    <!-- CONTEÚDO PRINCIPAL -->
    <div class="p-4 flex-grow-1">
      <h2>Pets Reservados</h2>

      <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th>Imagem</th>
              <th>Nome</th>
              <th>Raça</th>
              <th>Localização</th>
              <th>Status</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            <!-- Exemplo de pet reservado -->
            <tr>
              <td><img src="/images/pet1.jpg" alt="Pet 1" width="100" /></td>
              <td>Bolinha</td>
              <td>Vira-lata</td>
              <td>São Paulo - SP</td>
              <td>Reservado</td>
              <td><button class="btn btn-primary btn-sm">Entrar em contato com a ONG</button></td>
            </tr>

            <!-- Exemplo de pet pendente -->
            <tr>
              <td><img src="/images/pet2.jpg" alt="Pet 2" width="100" /></td>
              <td>Mel</td>
              <td>Poodle</td>
              <td>Campinas - SP</td>
              <td>Pendente</td>
              <td><span class="badge bg-warning text-dark">Pendente</span></td>
            </tr>

            <!-- Exemplo de pet adotado -->
            <tr>
              <td><img src="/images/pet3.jpg" alt="Pet 3" width="100" /></td>
              <td>Rex</td>
              <td>Golden Retriever</td>
              <td>Ribeirão Preto - SP</td>
              <td>Adotado</td>
              <td><span class="badge bg-success">Adotado</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
