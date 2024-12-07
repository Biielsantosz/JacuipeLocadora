<?php
// Iniciar a sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

// Conexão com o banco de dados
require_once 'db_connection.php';

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Recupera o ID do usuário
$usuarioId = $_SESSION['id'];

// Consulta para buscar os carros alocados pelo usuário, incluindo o preço
$query = "SELECT c.id AS carro_id, c.modelo, c.marca, c.ano, c.placa, c.cor, c.status, a.preco 
FROM carros AS c 
INNER JOIN alocacoes AS a ON c.id = a.carro_id 
WHERE a.usuario_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result();

// Função para desistir da locação
if (isset($_POST['cancelar'])) {
    $carro_id = (int)$_POST['carro_id'];

    // Inicia a transação
    $conn->begin_transaction();
    try {
        // Remove a alocação da tabela de alocações
        $sql_alocacao = "DELETE FROM alocacoes WHERE carro_id = ? AND usuario_id = ?";
        $stmt = $conn->prepare($sql_alocacao);
        $stmt->bind_param("ii", $carro_id, $usuarioId);
        $stmt->execute();

        // Atualiza o status do carro para 'Disponível'
        $sql_update_carro = "UPDATE carros SET status = 'Disponível' WHERE id = ?";
        $stmt = $conn->prepare($sql_update_carro);
        $stmt->bind_param("i", $carro_id);
        $stmt->execute();

        // Se a transação foi bem-sucedida, confirma as mudanças
        $conn->commit();
        $mensagem = "Locação cancelada com sucesso!";
    } catch (Exception $e) {
        // Se ocorrer algum erro, desfaz as mudanças
        $conn->rollback();
        $mensagem = "Erro ao cancelar a locação: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Carros Alocados</title>
    <link rel="stylesheet" href="styles.css">


<style>
    /* Reset básico para consistência */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

/* Estilos gerais */
body {
  background-color: #f4f7fb;
  color: #333;
  line-height: 1.6;
  font-size: 16px;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.alert {
  padding: 10px;
  border-radius: 5px;
  margin-bottom: 20px;
}

.alert-info {
  background-color: #e3f7ff;
  color: #007bff;
}

.alert-warning {
  background-color: #fff3cd;
  color: #856404;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  margin-top: 10px;
  text-align: center;
  font-weight: bold;
  border-radius: 5px;
  text-decoration: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

.btn-danger:hover {
  background-color: #c82333;
}

/* Estilização da tabela */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 30px;
}

th, td {
  padding: 12px 15px;
  text-align: left;
}

th {
  background-color: #007bff;
  color: white;
  font-size: 1rem;
  text-transform: uppercase;
}

td {
  background-color: #fff;
  border-bottom: 1px solid #ddd;
}

td:hover {
  background-color: #f8f9fa;
}

/* Estilos para dispositivos móveis */
@media (max-width: 768px) {
  h1 {
    font-size: 2rem;
  }

  table {
    font-size: 14px;
  }

  .btn {
    width: 100%;
    text-align: center;
  }

  .container {
    padding: 10px;
  }

  .alert {
    font-size: 14px;
  }
}

@media (max-width: 480px) {
  th, td {
    padding: 10px;
  }

  table {
    font-size: 12px;
  }
}

</style>


</head>

<body>
    <div class="container mt-4">
        <h1>Meus Carros Alocados</h1>

        <?php if (isset($mensagem)): ?>
            <p class="alert alert-info"><?= $mensagem; ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Ano</th>
                        <th>Placa</th>
                        <th>Cor</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($carro = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($carro['modelo']) ?></td>
                            <td><?= htmlspecialchars($carro['marca']) ?></td>
                            <td><?= htmlspecialchars($carro['ano']) ?></td>
                            <td><?= htmlspecialchars($carro['placa']) ?></td>
                            <td><?= htmlspecialchars($carro['cor']) ?></td>
                            <td><?= htmlspecialchars($carro['status']) ?></td>
                            <td>R$ <?= number_format($carro['preco'], 2, ',', '.') ?></td>
                            <td>
                                <!-- Formulário para cancelar a locação -->
                                <form method="POST">
                                    <input type="hidden" name="carro_id" value="<?= $carro['carro_id'] ?>">
                                    <button type="submit" name="cancelar" class="btn btn-danger">Desistir da Locação</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-warning">Você ainda não alocou nenhum carro.</p>
        <?php endif; ?>

        <a href="/main.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>

</html>

<?php
// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
