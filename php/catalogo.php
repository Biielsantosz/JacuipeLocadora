<?php
// Inclui a conexão com o banco de dados
require_once 'db_connection.php';

// Verifica os filtros enviados via GET
$whereClauses = [];
if (!empty($_GET['status'])) {
  $status = $_GET['status'] === 'disponivel' ? 'Disponível' : 'Indisponível';
  $whereClauses[] = "status = '$status'";
}
if (!empty($_GET['cor'])) {
  $cor = $conn->real_escape_string($_GET['cor']);
  $whereClauses[] = "cor LIKE '%$cor%'";
}
if (!empty($_GET['ano'])) {
  $ano = (int) $_GET['ano'];
  $whereClauses[] = "ano = $ano";
}
if (!empty($_GET['marca'])) {
  $marca = $conn->real_escape_string($_GET['marca']);
  $whereClauses[] = "marca LIKE '%$marca%'";
}
if (!empty($_GET['modelo'])) {
  $modelo = $conn->real_escape_string($_GET['modelo']);
  $whereClauses[] = "modelo LIKE '%$modelo%'";
}

if (isset($_GET['ano'])) {
  $ano = (int) $_GET['ano']; // Converte o valor para inteiro
  if ($ano < 0) {
    // Exibe um alerta e interrompe o processamento
    echo "<script>alert('Ano inválido! O valor não pode ser negativo.'); window.history.back();</script>";
    exit;
  }
}
// Monta a consulta SQL com os filtros
$whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';
$sql = "SELECT id, modelo, marca, ano, placa, cor, status FROM carros $whereSQL";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Catálogo de Carros</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
      transition: all 0.3s ease;
    }

    /* Estilos gerais */
    body {
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.6;
      font-size: 1rem;
    }

    .container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 30px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 3.5rem;
      color: #1e3d58;
      text-align: center;
      margin-bottom: 40px;
      font-weight: bold;
    }

    /* Filtros */
    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-label {
      font-weight: 600;
      font-size: 1.1rem;
    }

    .form-control {
      border-radius: 8px;
      border: 1px solid #ced4da;
      padding: 12px;
      transition: border-color 0.3s, box-shadow 0.3s ease-in-out;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    /* Botões */
    .btn {
      display: inline-block;
      padding: 14px 24px;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
      text-decoration: none;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s ease;
    }

    .btn-primary {
      background-color: #007bff;
      color: white;
    }

    .btn-primary:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn-secondary:hover {
      background-color: #5a6268;
      transform: translateY(-2px);
    }

    /* Cards de carros */
    .card {
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .card-body {
      padding: 20px;
    }

    .card-title {
      font-size: 1.8rem;
      color: #333;
      font-weight: 700;
      margin-bottom: 15px;
    }

    .card-text {
      font-size: 1.1rem;
      color: #555;
    }

    .card-text strong {
      color: #1e3d58;
    }

    .card-footer {
      text-align: center;
      padding-top: 15px;
    }

    .card-footer .btn-success {
      background-color: #28a745;
      color: white;
    }

    .card-footer .btn-success:hover {
      background-color: #218838;
      transform: translateY(-2px);
    }

    /* Alertas */
    .alert {
      padding: 20px;
      border-radius: 10px;
      font-size: 1.1rem;
      margin-bottom: 30px;
    }

    .alert-warning {
      background-color: #fff3cd;
      color: #856404;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    /* Responsividade */
    @media (max-width: 992px) {
      h1 {
        font-size: 3rem;
      }

      .container {
        padding: 25px;
      }

      .card-title {
        font-size: 1.5rem;
      }

      .form-control {
        font-size: 1rem;
      }
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 2.5rem;
      }

      .container {
        padding: 15px;
      }

      .card-title {
        font-size: 1.3rem;
      }

      .card {
        margin-bottom: 20px;
      }

      .form-control,
      .btn {
        font-size: 0.9rem;
      }
    }

    @media (max-width: 576px) {

      .form-control,
      .btn {
        width: 100%;
      }

      .col-md-3 {
        margin-bottom: 15px;
      }

      .btn {
        padding: 14px 20px;
      }
    }

    /* Imagem dos carros */
    .carro-imagem {
      width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .carro-imagem:hover {
      transform: scale(1.05);
    }
  </style>

</head>

<body>
  <div class="container mt-4">
    <h1 class="text-center">Catálogo de Carros</h1>

    <!-- Filtros -->
    <form method="GET" class="row g-3 mb-4" onsubmit="return validarFiltros()">
      <div class="col-md-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
          <option value="">Todos</option>
          <option value="disponivel" <?= isset($_GET['status']) && $_GET['status'] === 'disponivel' ? 'selected' : '' ?>>
            Disponíveis</option>
          <option value="indisponivel" <?= isset($_GET['status']) && $_GET['status'] === 'indisponivel' ? 'selected' : '' ?>>Indisponíveis</option>
        </select>
      </div>
      <div class="col-md-3">
        <label for="cor" class="form-label">Cor</label>
        <input type="text" name="cor" id="cor" class="form-control" value="<?= htmlspecialchars($_GET['cor'] ?? '') ?>"
          placeholder="Ex: Preto">
      </div>
      <div class="col-md-3">
        <label for="ano" class="form-label">Ano</label>
        <input type="number" name="ano" id="ano" class="form-control"
          value="<?= htmlspecialchars($_GET['ano'] ?? '') ?>" placeholder="Ex: 2023" min="0">
      </div>
      <div class="col-md-3">
        <label for="marca" class="form-label">Marca</label>
        <input type="text" name="marca" id="marca" class="form-control"
          value="<?= htmlspecialchars($_GET['marca'] ?? '') ?>" placeholder="Ex: Audi">
      </div>
      <div class="col-md-3">
        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" name="modelo" id="modelo" class="form-control"
          value="<?= htmlspecialchars($_GET['modelo'] ?? '') ?>" placeholder="Ex: A3">
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100 mt-4">Filtrar</button>
      </div>
      <div class="col-md-3">
        <a href="catalogo.php" class="btn btn-secondary w-100 mt-4">Limpar Filtros</a>
      </div>
      <div class="col-md-3">
        <a href="/main.php" class="btn btn-secondary w-100 mt-4">Voltar</a>
      </div>
    </form>

    <script>
      function validarFiltros() {
        const cor = document.getElementById('cor').value.trim();
        const marca = document.getElementById('marca').value.trim();
        const modelo = document.getElementById('modelo').value.trim();
        const ano = document.getElementById('ano').value.trim();

        // Validar se pelo menos um campo foi preenchido com valor válido
        if (cor === "" && marca === "" && modelo === "" && ano === "") {
          alert("Pelo menos um campo (Cor, Marca, Modelo, Ano) deve ser preenchido.");
          return false;
        }

        // Validar se os campos não contêm apenas espaços em branco
        if (cor === "" && cor !== "") {
          alert("O campo 'Cor' não pode ser vazio ou conter apenas espaços em branco.");
          return false;
        }
        if (marca === "" && marca !== "") {
          alert("O campo 'Marca' não pode ser vazio ou conter apenas espaços em branco.");
          return false;
        }
        if (modelo === "" && modelo !== "") {
          alert("O campo 'Modelo' não pode ser vazio ou conter apenas espaços em branco.");
          return false;
        }

        // Expressões regulares para validação
        const regexTexto = /^[a-zA-Z\s]*$/;  // Somente letras e espaços
        const regexModelo = /^[a-zA-Z0-9\s]*$/;  // Letras, números e espaços

        // Validar campo 'Cor' (somente letras e espaços)
        if (cor && !regexTexto.test(cor)) {
          alert("O campo 'Cor' deve conter apenas letras e espaços.");
          return false;
        }

        // Validar campo 'Marca' (somente letras e espaços)
        if (marca && !regexTexto.test(marca)) {
          alert("O campo 'Marca' deve conter apenas letras e espaços.");
          return false;
        }

        // Validar campo 'Modelo' (letras, números e espaços permitidos)
        if (modelo && !regexModelo.test(modelo)) {
          alert("O campo 'Modelo' deve conter apenas letras, números e espaços.");
          return false;
        }

        // Validar campo 'Ano' (número positivo)
        if (ano && (isNaN(ano) || parseInt(ano) < 0)) {
          alert("O campo 'Ano' deve ser um número positivo.");
          return false;
        }

        return true; // Submeter o formulário se todas as validações forem passadas
      }
    </script>





    <!-- Resultados -->
    <?php if ($result && $result->num_rows > 0): ?>
      <div class="row">
        <?php while ($carro = $result->fetch_assoc()): ?>
          <?php
          // Calcula o preço
          $ano_atual = (int) date('Y');
          $diferenca_anos = $ano_atual - $carro['ano'];
          $preco_base = 100.00; // Preço base
          $preco_por_ano = 10.00; // Incremento para carros mais novos
          $preco = $preco_base + max(0, (10 - $diferenca_anos)) * $preco_por_ano;
          ?>
          <div class="col-md-4 mb-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($carro['modelo']) ?> (<?= htmlspecialchars($carro['ano']) ?>)
                </h5>
                <p class="card-text">
                  <strong>Marca:</strong> <?= htmlspecialchars($carro['marca']) ?><br>
                  <strong>Cor:</strong> <?= htmlspecialchars($carro['cor']) ?><br>
                  <strong>Placa:</strong> <?= htmlspecialchars($carro['placa']) ?><br>
                  <strong>Status:</strong> <?= htmlspecialchars($carro['status']) ?><br>
                  <strong>Preço:</strong> R$ <?= number_format($preco, 2, ',', '.') ?>
                </p>
                <?php if ($carro['status'] === 'Disponível'): ?>
                  <a href="alocar.php?id=<?= $carro['id'] ?>" class="btn btn-success">Alocar</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-warning text-center">Nenhum carro encontrado com os filtros aplicados.</div>
    <?php endif; ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>