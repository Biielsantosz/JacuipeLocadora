<?php
session_start();

// Verificar se o usuário está logado como administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../404.html");
    exit;
}

$error_message = 'Houve um erro ao cadastrar o carro. Tente novamente.';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro ao Cadastrar Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H7Jt9QzS6D4n5ymQzHFfPpZB2Hlf91ElVw6j7dH5lV+1J8D4zX3a4z+Zl" crossorigin="anonymous">
    <style>
        .container {
            max-width: 800px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Erro ao Cadastrar Carro</h1>

        <!-- Exibe a mensagem de erro -->
        <div class="alert alert-danger mt-4"><?php echo $error_message; ?></div>

        <div class="text-center">
            <a href="/php/cadastrar_carro.php" class="btn btn-primary">Tentar Novamente</a>
            <a href="/php/adm.php" class="btn btn-secondary">Voltar ao Dashboard</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0g3+X7cWVG7G+HeR5bxmd0j2OniTTxECvTpI3jmjrT2kPZG5" crossorigin="anonymous"></script>
</body>
</html>
