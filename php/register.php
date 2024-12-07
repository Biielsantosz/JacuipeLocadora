<?php
session_start();

// Configuração do banco de dados
require_once 'db_connection.php';

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar-senha'];

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha)) {
        echo "Todos os campos são obrigatórios!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "E-mail inválido!";
        exit;
    }

    if ($senha !== $confirmar_senha) {
        echo "As senhas não correspondem!";
        exit;
    }

    // Verifica se o e-mail já está cadastrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Este e-mail já está cadastrado!";
        $stmt->close();
        $conn->close();
        exit;
    }

    // Insere o novo usuário
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, SHA2(?, 256), 'usuario')");
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        echo "Conta criada com sucesso!";
        header("Location: /index.php");
        exit;
    } else {
        echo "Erro ao criar conta. Por favor, tente novamente.";
    }

    $stmt->close();
}

$conn->close();
?>
