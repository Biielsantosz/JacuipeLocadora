<?php
// Inicia a sessão
session_start();

// Conexão com o banco de dados
require_once 'db_connection.php';

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o token foi passado pela URL
if (!isset($_GET['token'])) {
    die("Token inválido.");
}

$token = $_GET['token'];

// Verificar se o token existe na base de dados
$sql = "SELECT rs.usuario_id, rs.expire, u.email 
        FROM recuperacao_senha AS rs
        INNER JOIN usuarios AS u ON rs.usuario_id = u.id
        WHERE rs.token = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

// Se o token não existir ou tiver expirado
if ($result->num_rows === 0) {
    die("Token inválido ou expirado.");
}

$tokenData = $result->fetch_assoc();

// Verificar se o token expirou (30 minutos)
if ($tokenData['expire'] < time()) {
    die("O link de recuperação expirou.");
}

$usuarioId = $tokenData['usuario_id'];
$email = $tokenData['email'];

// Processar a nova senha
// Processar a nova senha
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nova_senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Verificar se as senhas são iguais
    if ($nova_senha !== $confirmar_senha) {
        $mensagem = "As senhas não coincidem. Tente novamente.";
    } else {
        // Usar SHA-256 para criptografar a senha
        $senha_hash = hash('sha256', $nova_senha);  // SHA-256 para criptografar a senha

        // Atualizar a senha no banco de dados
        $sql_update = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $conn->prepare($sql_update);
        $stmt->bind_param("si", $senha_hash, $usuarioId);
        $stmt->execute();

        // Remover o token após o uso
        $sql_delete_token = "DELETE FROM recuperacao_senha WHERE token = ?";
        $stmt = $conn->prepare($sql_delete_token);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $mensagem = "Senha alterada com sucesso!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link para o CSS -->
</head>
<body>

<nav>
    <div class="logo">
        <a href="index.html">Jacuípe</a>
    </div>
</nav>

<div class="reset-password-container">
    <h1>Redefinir Senha</h1>
    
    <?php if (isset($mensagem)): ?>
        <p class="alert alert-info"><?= $mensagem; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="senha">Nova Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <div class="form-group">
            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required>
        </div>
        <button type="submit">Alterar Senha</button>
    </form>
    
    <div class="links">
        <a href="index.html">Voltar para o login</a>
    </div>
</div>

</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
