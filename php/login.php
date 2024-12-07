<?php
session_start();
require_once 'db_connection.php';

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$email = $_POST['email'];
$senha = $_POST['senha'];

if ($stmt = $conn->prepare("SELECT id, tipo FROM usuarios WHERE email = ? AND senha = SHA2(?, 256)")) {
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $tipo);
        $stmt->fetch();
        $_SESSION['id'] = $id;
        $_SESSION['tipo'] = $tipo;
        $_SESSION['nome'] = $nome;

        if ($tipo === 'admin') {
            header("Location: adm.php");
        } else {
            header("Location: /main.php");
        }
    } else {
        echo "Login ou senha inválidos.";
        header("Location: /403.html");
    }

    $stmt->close();
} else {
    echo "Erro na consulta.";
    header("Location: /402.html");
}

$conn->close();
?>
