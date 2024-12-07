<?php
session_start();
require_once 'db_connection.php';

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Verifica o código de verificação no banco
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE codigo_verificacao = ? AND email_verificado = 0");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Marca o e-mail como verificado
        $stmt = $conn->prepare("UPDATE usuarios SET email_verificado = 1 WHERE codigo_verificacao = ?");
        $stmt->bind_param("s", $codigo);
        if ($stmt->execute()) {
            echo "E-mail verificado com sucesso! Agora você pode fazer login.";
        } else {
            echo "Erro ao verificar o e-mail. Tente novamente.";
        }
    } else {
        echo "Código de verificação inválido ou já verificado.";
    }

    $stmt->close();
} else {
    echo "Código de verificação não fornecido.";
}

$conn->close();
?>
