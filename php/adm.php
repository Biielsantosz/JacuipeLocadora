<?php
session_start();

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../404.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Administrativa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H7Jt9QzS6D4n5ymQzHFfPpZB2Hlf91ElVw6j7dH5lV+1J8D4zX3a4z+Zl" crossorigin="anonymous">
    <style>
       /* Reset básico */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background-color: #f1f3f5;
}

/* Sidebar */
.sidebar {
    background-color: #343a40;
    color: #fff;
    padding: 20px;
    height: 100vh;
    position: fixed;
    width: 250px;
    top: 0;
    left: 0;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar h2 {
    color: #fff;
    font-size: 1.5rem;
    margin-bottom: 30px;
    font-weight: bold;
}

.sidebar a {
    text-decoration: none;
    color: #fff;
    display: block;
    margin: 15px 0;
    padding: 10px;
    font-size: 1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.sidebar a:hover {
    background-color: #007bff;
    color: #fff;
}

/* Botão de Sair */
.sidebar .btn-danger {
    width: 100%;
    margin-top: 20px;
    padding: 12px;
    font-size: 1rem;
    border-radius: 5px;
}

/* Conteúdo Principal */
.main-content {
    margin-left: 270px;
    padding: 20px;
}

/* Títulos e Descrições */
h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: #343a40;
    margin-bottom: 20px;
}

p {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 30px;
}

/* Cards */
.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 30px;
}

.card-body h5 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #007bff;
}

.card-body p {
    font-size: 1rem;
    color: #495057;
    margin-bottom: 20px;
}

.card-body .btn-primary {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.card-body .btn-primary:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

/* Responsividade */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding: 10px;
    }

    .main-content {
        margin-left: 0;
        padding: 10px;
    }

    .card-body h5 {
        font-size: 1.3rem;
    }

    .card-body p {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 2rem;
    }

    p {
        font-size: 1.1rem;
    }

    .card-body .btn-primary {
        width: 100%;
    }
}

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2 class="mb-4">Dashboard Administrativo</h2>
        <a href="cadastrar_carro.php">Cadastrar Carro</a>
        <a href="ver_clientes.php">Ver Todos os Clientes</a>
        <a href="ver_carros.php">Ver Todos os Carros</a>
        <a href="logout.php" class="btn btn-danger mt-3">Sair</a>
    </div>

    <!-- Conteúdo Principal -->
    <div class="main-content">
        <div class="container">
            <h1 class="text-center mb-4">Bem-vindo à Área Administrativa</h1>
            <p class="text-center">Aqui você pode gerenciar todos os aspectos da locadora, como cadastrar carros, visualizar clientes e carros cadastrados.</p>
            
            <!-- Cards para funcionalidades -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Cadastrar Carros</h5>
                            <p class="card-text">Cadastre novos carros para a locadora.</p>
                            <a href="cadastrar_carro.php" class="btn btn-primary">Cadastrar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Ver Todos os Clientes</h5>
                            <p class="card-text">Visualize todos os clientes cadastrados.</p>
                            <a href="ver_clientes.php" class="btn btn-primary">Ver Clientes</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">Ver Todos os Carros</h5>
                            <p class="card-text">Visualize todos os carros disponíveis para locação.</p>
                            <a href="ver_carros.php" class="btn btn-primary">Ver Carros</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0g3+X7cWVG7G+HeR5bxmd0j2OniTTxECvTpI3jmjrT2kPZG5" crossorigin="anonymous"></script>
</body>
</html>
