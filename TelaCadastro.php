<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Animais</title>
    <style>
        

      

        body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: left;
        }


        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center; /* Centraliza os inputs corretamente */
        }

        label {
            width: 100%;
            text-align: left;
            margin-bottom: 5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #74B9FF;
            border: none;
            color: white;
            font-size: 16px;
            margin-top: 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0887F2;
        }
    </style>
</head>
<body>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  
  <?php include 'menu.php'; ?>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">Pet Projeto</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="#">Home <span class="sr-only"></span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Cachorros</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Gatos</a>
    </li>
  </ul>
  <ul class="navbar-nav ms-auto">
    <li class="nav-item">
      <a class="nav-link" href="#">Login</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Registro</a>
    </li>
  </ul>
</div>
    <div class="container">
        <h2>Cadastro de Animais</h2>
        <form action="#" method="POST">
            <label for="nome">Nome do Animal:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" min="0" required>
            
            <label for="especie">Espécie:</label>
            <select id="especie" name="especie">
                <option value="Cachorro">Cachorro</option>
                <option value="Gato">Gato</option>
                <option value="Outro">Outro</option>
            </select>

            <label for="raca">Raça:</label>
            <input type="text" id="raca" name="raca">

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="3"></textarea>

            <label for="foto">Foto do Animal:</label>
            <input type="file" id="foto" name="foto" accept="image/*">

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
