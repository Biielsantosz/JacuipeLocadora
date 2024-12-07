<?php
session_start();
require_once 'db_connection.php';

// Verificar se o usuário está logado como administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../404.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $ano = $_POST['ano'];
    $placa = $_POST['placa'];
    $cor = $_POST['cor'];

    // Inserir os dados no banco
    $sql = "INSERT INTO carros (modelo, marca, ano, placa, cor) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Liga os parâmetros
        $stmt->bind_param("ssiss", $modelo, $marca, $ano, $placa, $cor); // Tipos: string, string, inteiro, string, string

        if ($stmt->execute()) {
            echo "<div class='alert alert-success mt-4'>Carro cadastrado com sucesso!</div>";
            header("Location: adm.php");
        } else {
            echo "<div class='alert alert-danger mt-4'>Erro ao cadastrar: " . $stmt->error . "</div>";
        }

        $stmt->close(); // Fecha a declaração
    } else {
        echo "<div class='alert alert-danger mt-4'>Erro ao preparar a consulta: " . $conn->error . "</div>";
    }

    $conn->close(); // Fecha a conexão
}
?>
