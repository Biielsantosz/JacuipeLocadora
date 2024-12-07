<?php
// Iniciar a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
  header("Location: php/login.php");
  exit;
}

// Conexão com o banco de dados (ajuste os parâmetros conforme necessário)
require_once 'db_connection.php';

if ($conn->connect_error) {
  die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o usuário está logado
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  // Consulta para obter o nome do usuário
  $query = "SELECT nome FROM usuarios WHERE email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $email); // Substituir o "?" pelo email do usuário
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Nome encontrado
    $row = $result->fetch_assoc();
    $usuario = $row['nome'];
  } else {
    // Caso não encontre o nome
    $usuario = "Usuário";
  }
  $stmt->close();
} else {
  // Caso o usuário não esteja logado
  $usuario = "Usuário";
}

// Fechar a conexão com o banco
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jacuipe - Bem-vindo</title>
  <link rel="stylesheet" href="styles.css">

  <style>
    /* Reset básico para consistência */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      overflow: hidden;
      /* Impede a rolagem de toda a página */
    }


    /* Header */
    header {
      background: linear-gradient(135deg, #007BFF, #0056b3);
      color: #fff;
      padding: 15px 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    header .content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    header .brand {
      font-size: 1.8rem;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1.8px;
    }

    header ul {
      list-style: none;
      display: flex;
      gap: 25px;
    }

    header ul li a {
      text-decoration: none;
      color: #fff;
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    header ul li a:hover {
      color: #ddd;
    }

    .user-menu {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logout-btn,
    .btn-primary {
      background: #333;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      font-size: 0.9rem;
      transition: background 0.3s ease, transform 0.2s;
    }

    .logout-btn:hover,
    .btn-primary:hover {
      background: #333;
      transform: scale(1.05);
    }

    /* Catálogo */
    .catalog {
      padding: 60px 20px;
      background: linear-gradient(to bottom, #f9f9f9, #ececec);
      text-align: center;
      border-top: 2px solid #007BFF;
    }

    .catalog .title-wrapper-catalog p {
      color: #555;
      font-size: 1rem;
      margin-bottom: 10px;
    }

    .catalog .title-wrapper-catalog h3 {
      font-size: 2.2rem;
      font-weight: 700;
      color: #333;
    }

    .catalog .filter-card {
      margin-top: 25px;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 15px;
    }

    .search-input {
      padding: 12px;
      font-size: 1rem;
      width: 320px;
      border: 1px solid #ddd;
      border-radius: 6px;
      transition: box-shadow 0.3s ease;
    }

    .search-input:focus {
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    .search-button {
      background: linear-gradient(135deg, #007BFF, #0056b3);
      color: #fff;
      padding: 12px 25px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .search-button:hover {
      background: linear-gradient(135deg, #0056b3, #003d80);
    }
  </style>

</head>

<body>
  <header>
    <div class="content">
      <nav>
        <p class="brand">Jac<strong>uipe</strong></p>
        <ul>
          <li><a href="#catalog">Catálogo</a></li>

        </ul>
        <div class="user-menu">
          <span>Bem-vindo, <?php echo htmlspecialchars($usuario); ?>!</span>
          <a href="php/logout.php" class="logout-btn">Sair</a>
          <a href="php/meus_carros.php" class="btn btn-primary ms-2">Meus Carros</a>
        </div>
      </nav>
    </div>
  </header>
  <section class="catalog" id="catalog">
    <div class="content">
      <div class="title-wrapper-catalog">
        <p>Encontre o que você quer</p>
        <h3>Catálogo</h3>
      </div>
      <div class="filter-card">
        <form method="GET" action="php/catalogo.php">
          <!--<input type="text" class="search-input" name="query" placeholder="Escolha seu modelo favorito" />-->
          <button type="submit" class="search-button">Ver Carros</button>
        </form>
      </div>

    </div>
  </section>
  <footer>
    <div class="main">
      <div class="content footer-links">
        <div class="footer-company">
          <h4>Empresa</h4>
          <a href="sobre.html">
            <h6>Sobre</h6>
          </a>
          <a href="contato.html">
            <h6>Contato</h6>
          </a>
        </div>
        <div class="footer-rental">
          <h4>Aluguel</h4>
          <h6>Dirigir sozinho</h6>
          <h6>Com motorista</h6>
          <h6>Ajuda</h6>
        </div>
        <div class="footer-social">
          <h4>Fique conectado</h4>
          <div class="social-icons">
            <img src="img/instagram.png" alt="Instagram">
            <img src="img/facebook.png" alt="Facebook">
          </div>
        </div>
        <div class="footer-contact">
          <h4>Contato</h4>
          <h6>+55 75 988776655</h6>
          <h6>contato@jacuipe.com.br</h6>
          <h6>Xique-Xique, BA</h6>
        </div>
      </div>
    </div>
    <div class="last"> Jacuípe 2024 </div>
  </footer>
</body>

</html>