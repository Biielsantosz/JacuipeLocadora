<?php
session_start();

// Verifica se o usuário é administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../405.html");
    exit;
}

// Conexão com o banco de dados
require_once 'db_connection.php';

$query = "SELECT * FROM carros";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todos os Carros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H7Jt9QzS6D4n5ymQzHFfPpZB2Hlf91ElVw6j7dH5lV+1J8D4zX3a4z+Zl" crossorigin="anonymous">


    <style>
 /* Contêiner centralizado */
.container {
    max-width: 1200px;
    margin-top: 50px; /* Espaçamento acima */
    margin-bottom: 50px; /* Espaçamento abaixo */
    margin-left: auto;
    margin-right: auto; /* Centraliza o conteúdo na tela */
}

/* Estilo do título */
h1 {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    text-align: center;
}

/* Botão de voltar */
.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
    padding: 10px 20px;
    font-size: 1rem;
    transition: background-color 0.3s, border-color 0.3s;
    display: block;
    margin: 0 auto 20px auto; /* Centraliza o botão */
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

/* Estilo da tabela */
.table {
    width: 100%;
    table-layout: auto;
    border-collapse: collapse;  /* Remove as bordas duplicadas */
}

/* Melhorando a aparência das células e bordas */
.table th, .table td {
    padding: 15px;
    text-align: center;
}

.table th {
    background-color: #343a40;
    color: #fff;
    font-weight: bold;
}

.table td {
    background-color: #f8f9fa;
}

.table-striped tbody tr:nth-child(odd) {
    background-color: #e9ecef;
}

/* Responsividade: Tabela com rolagem horizontal */
.table-responsive {
    overflow-x: auto;
    margin-bottom: 20px; /* Espaçamento abaixo da tabela */
}

/* Estilo para a mensagem de "Nenhum carro cadastrado" */
.alert-info {
    font-size: 1.1rem;
    text-align: center;
    background-color: #d1ecf1;
    color: #0c5460;
    border-color: #bee5eb;
    padding: 20px;
    border-radius: 5px;
    margin: 0 auto; /* Centraliza a mensagem */
    width: fit-content; /* Ajusta o tamanho conforme o conteúdo */
}

    </style>

</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Lista de Carros</h1>
        
        <!-- Botão de Voltar -->
        <button href="adm.php" class="btn btn-primary mb-4">Voltar ao Dashboard</button>

        <!-- Tabela com rolagem horizontal -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Ano</th>
                        <th>Placa</th>
                        <th>Cor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['modelo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['marca']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['ano']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['placa']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['cor']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='alert-info'>Nenhum carro cadastrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0g3+X7cWVG7G+HeR5bxmd0j2OniTTxECvTpI3jmjrT2kPZG5" crossorigin="anonymous"></script>
</body>
</html>