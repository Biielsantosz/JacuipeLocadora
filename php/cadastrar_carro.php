<?php
session_start();

// Verificar se o usuário está logado como administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../404.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Carro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ6H7Jt9QzS6D4n5ymQzHFfPpZB2Hlf91ElVw6j7dH5lV+1J8D4zX3a4z+Zl" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Estilo global */
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
            max-width: 800px;
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
            letter-spacing: 0.5px;
        }

        /* Estilo do formulário */
        .form-label {
            font-size: 1.1rem;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            border-radius: 12px;
            padding: 15px;
            font-size: 1rem;
            border: 1px solid #ced4da;
            box-shadow: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #6e7cfc;
            box-shadow: 0 0 5px rgba(110, 124, 252, 0.5);
        }

        .form-control::placeholder {
            color: #bbb;
        }

        /* Botões */
        .btn-primary {
            background-color: #6e7cfc;
            border: none;
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 8px;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s ease;
            margin-bottom: 15px; /* Aumentado para dar mais espaço entre os botões */
        }

        .btn-primary:hover {
            background-color: #5a6aec;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #495057;
            border: none;
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 8px;
            width: 100%;
            transition: background-color 0.3s, transform 0.2s ease;
        }

        .btn-secondary:hover {
            background-color: #343a40;
            transform: translateY(-2px);
        }

        /* Mensagens de sucesso ou erro */
        .alert {
            font-size: 1rem;
            text-align: center;
            border-radius: 10px;
            margin-top: 20px;
            padding: 15px;
        }

        .alert-success {
            background-color: #28a745;
            color: #fff;
        }

        .alert-danger {
            background-color: #dc3545;
            color: #fff;
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

            .btn-primary, .btn-secondary {
                padding: 10px;
                font-size: 1rem;
            }

            .form-control {
                font-size: 0.9rem;
            }
        }

        /* Estilo para o botão "Voltar" */
        .btn-secondary {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Cadastrar Carro</h1>

        <!-- Mensagem de Sucesso ou Erro -->
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success">
                <i class="icon bi bi-check-circle"></i> Carro cadastrado com sucesso!
            </div>
        <?php elseif(isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="alert alert-danger">
                <i class="icon bi bi-x-circle"></i> Ocorreu um erro ao cadastrar o carro. Tente novamente!
            </div>
        <?php endif; ?>

        <!-- Formulário de Cadastro de Carro -->
        <form action="cadastrar_carro2.php" method="POST">
            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ex: Gol, Corolla" pattern="[A-Za-z0-9\s]+" title="Somente letras, números e espaços são permitidos"  required>
            </div>
            <div class="mb-3">
                <label for="marca" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marca" name="marca" placeholder="Ex: Volkswagen, Toyota" pattern="[A-Za-z0-9\s]+" title="Somente letras, números e espaços são permitidos"  required>
            </div>
            <div class="mb-3">
                <label for="ano" class="form-label">Ano</label>
                <input type="number" class="form-control" id="ano" name="ano" placeholder="Ex: 2020" min="0" required>
            </div>
            <div class="mb-3">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" class="form-control" id="placa" name="placa" placeholder="Ex: ABC-1234" required>
            </div>
            <div class="mb-3">
                <label for="cor" class="form-label">Cor</label>
                <input type="text" class="form-control" id="cor" name="cor" placeholder="Ex: Preto, Branco" pattern="[A-Za-z0-9\s]+" title="Somente letras, números e espaços são permitidos" required>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Cadastrar Carro</button>
        </form>

        <!-- Link para voltar -->
        <a href="adm.php" class="btn btn-primary w-100 mt-3">Voltar</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0g3+X7cWVG7G+HeR5bxmd0j2OniTTxECvTpI3jmjrT2kPZG5" crossorigin="anonymous"></script>
</body>
</html>
