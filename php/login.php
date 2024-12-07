<?php
session_start();
require_once 'db_connection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Inclua o autoload do PHPMailer

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$email = $_POST['email'];
$senha = $_POST['senha'];

// Prepara a consulta para verificar o email, senha e o status de verificação do email
if ($stmt = $conn->prepare("SELECT id, tipo, email_verificado, token_verificacao FROM usuarios WHERE email = ? AND senha = SHA2(?, 256)")) {
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        // Verifica se o email foi verificado
        $stmt->bind_result($id, $tipo, $email_verificado, $token_verificacao);
        $stmt->fetch();

        if ($email_verificado == 0) {
            // Se o email não foi verificado, envia um novo e-mail de verificação

            // Gerar um token de verificação único
            $token = bin2hex(random_bytes(32));

            // Atualiza o token no banco de dados
            $update_stmt = $conn->prepare("UPDATE usuarios SET token_verificacao = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $token, $email);
            $update_stmt->execute();
            $update_stmt->close();

            // Enviar o e-mail de verificação
            $mail = new PHPMailer(true);

            try {
                // Configurações do servidor de e-mail
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'petcardiocontact@gmail.com'; // Seu e-mail
                $mail->Password = 'ddpl czzn xffy vdlh'; // Sua senha de e-mail ou senha de app (Gmail)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Destinatário
                $mail->setFrom('petcardiocontact@gmail.com', 'Locadora Jacuípe');
                $mail->addAddress($email); // E-mail do usuário

                // Assunto e corpo do e-mail
                $mail->isHTML(true);
                $mail->Subject = 'Verificação de E-mail - Locadora Jacuípe';
                $mail->Body    = 'Por favor, clique no link abaixo para verificar seu e-mail: <br><br>';
                $mail->Body   .= '<a href="http://jacuipelocadora-production.up.railway.app/verify_email.php?token=' . $token . '">Clique aqui para verificar seu e-mail</a>';

                $mail->send();
                echo 'Um e-mail de verificação foi enviado para o seu endereço. Por favor, verifique sua caixa de entrada.';
            } catch (Exception $e) {
                echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
            }

            exit;
        }

        // Se o email estiver verificado, armazena as variáveis de sessão
        $_SESSION['id'] = $id;
        $_SESSION['tipo'] = $tipo;

        // Redireciona para a página apropriada de acordo com o tipo de usuário
        if ($tipo === 'admin') {
            header("Location: adm.php");
        } else {
            header("Location: /main.php");
        }
    } else {
        // Se o email e senha não corresponderem
        header("Location: /403.html");
    }

    $stmt->close();
} else {
    // Se houver erro na preparação da consulta
    header("Location: /402.html");
}

$conn->close();
?>
