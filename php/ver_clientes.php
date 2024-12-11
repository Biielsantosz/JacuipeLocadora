<?php
// Inclui a conexão com o banco de dados
require_once 'db_connection.php';

// Consulta os clientes no banco de dados
$sql = "SELECT id, nome, email FROM usuarios";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H7Jt9QzS6D4n5ymQzHFfPpZB2Hlf91ElVw6j7dH5lV+1J8D4zX3a4z+Zl" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Estilo Global */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #6e7cfc, #f6c7db);
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 900px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .container:hover {
            transform: scale(1.02);
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Estilo para a tabela */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 15px;
            vertical-align: middle;
            text-align: center;
        }

        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }

        .table-dark {
            background-color: #343a40;
            color: white;
        }

        /* Estilo do botão "Voltar" */
        .btn-voltar {
            background-color: #007bff; /* Cor Azul */
            border: none;
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 8px;
            display: block;
            width: 100%;
            max-width: 220px;
            margin: 30px auto;
            transition: background-color 0.3s, transform 0.2s ease;
            text-align: center;
            color: #fff;
        }

        .btn-voltar:hover {
            background-color: #0056b3; /* Azul mais escuro no hover */
            transform: translateY(-2px);
        }

        /* Mensagem de "Nenhum cliente" */
        .alert-info {
            background-color: #17a2b8;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .btn-voltar {
                padding: 10px;
                font-size: 1rem;
            }

            .table th,
            .table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Clientes Cadastrados</h1>

        <!-- Botão para Voltar ao Painel -->
        <div class="text-center mb-3">
            <button href="adm.php" class="btn btn-voltar">Voltar ao Painel</button>
        </div>

        <!-- Verificação de resultados -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                Nenhum cliente cadastrado.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0g3+X7cWVG7G+HeR5bxmd0j2OniTTxECvTpI3jmjrT2kPZG5" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
