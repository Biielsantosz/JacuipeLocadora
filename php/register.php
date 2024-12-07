<?php
session_start();
require_once 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Inclua o autoload do Composer

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar-senha'];

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

    // Gera o código de verificação
    $codigo_verificacao = md5(uniqid($email, true));

    // Insere o novo usuário com o código de verificação
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo, codigo_verificacao) VALUES (?, ?, SHA2(?, 256), 'usuario', ?)");
    $stmt->bind_param("ssss", $nome, $email, $senha, $codigo_verificacao);

    if ($stmt->execute()) {
        // Envia o e-mail de verificação
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'petcardiocontact@gmail.com';
            $mail->Password = 'ddpl czzn xffy vdlh'; // Senha do app do Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('petcardiocontact@gmail.com', 'Locadora Jacuípe');
            $mail->addAddress($email, $nome);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Verificação de E-mail - Locadora Jacuípe';
            $mail->Body = 'Clique no link abaixo para verificar seu e-mail:<br>
                <a href="http://jacuipelocadora-production.up.railway.app/verificar_email.php?codigo=' . $codigo_verificacao . '">Verificar E-mail</a>';

            $mail->send();
            // Depois de enviar o e-mail de verificação
            echo "<script>
                    alert('Verifique seu e-mail para concluir o registro!');
                    window.location.href = '/index.php'; // Redireciona para a página de login
                  </script>";
            exit;
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail de verificação: {$mail->ErrorInfo}";
        }
    } else {
        echo "Erro ao criar conta. Por favor, tente novamente.";
    }

    $stmt->close();
}

$conn->close();
?>