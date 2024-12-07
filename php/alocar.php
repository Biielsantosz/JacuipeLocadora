<?php
// Inclui a conexão com o banco de dados
require_once 'db_connection.php';

// Verifica se o usuário está logado
session_start();
if (!isset($_SESSION['id'])) {
    die('Usuário não está logado.');
}

// Obtém o ID do cliente logado
$cliente_id = (int) $_SESSION['id']; // Usando o ID do usuário logado

// Verifica se o ID do carro foi enviado
if (!isset($_GET['id'])) {
    die('ID do carro não fornecido.');
}

$carro_id = (int) $_GET['id'];

// Busca informações do carro no banco de dados
$sql = "SELECT * FROM carros WHERE id = $carro_id AND status = 'Disponível'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die('Carro não encontrado ou já alocado.');
}

$carro = $result->fetch_assoc();

// Calcula o preço com base no ano do carro
$ano_atual = (int) date('Y');
$diferenca_anos = $ano_atual - $carro['ano'];
$preco_base = 100.00; // Preço base em reais
$preco_por_ano = 10.00; // Incremento por ano mais recente
$preco = $preco_base + max(0, (10 - $diferenca_anos)) * $preco_por_ano; // Carros recentes custam mais

// Salva a alocação no banco de dados
$conn->begin_transaction();
try {
    // Insere a alocação
    $sql_alocacao = "INSERT INTO alocacoes (carro_id, usuario_id, preco) VALUES ($carro_id, $cliente_id, $preco)";
    $conn->query($sql_alocacao);

    // Atualiza o status do carro
    $sql_update_carro = "UPDATE carros SET status = 'Indisponível' WHERE id = $carro_id";
    $conn->query($sql_update_carro);

    $conn->commit();
    $mensagem = "Carro alocado com sucesso! Preço: R$ " . number_format($preco, 2, ',', '.');
} catch (Exception $e) {
    $conn->rollback();
    die("Erro ao alocar o carro: " . $e->getMessage());
}

// Exibe a mensagem de sucesso
echo $mensagem;
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alocação de Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


<style></style>

</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Alocação de Carro</h1>
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($mensagem) ?>
        </div>
        <div class="text-center">
            <a href="catalogo.php" class="btn btn-primary">Voltar ao Catálogo</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>