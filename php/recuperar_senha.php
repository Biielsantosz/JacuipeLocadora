<?php
// Inicia a sessão
session_start();

// Incluir o autoloader do Composer (PHPMailer)
require '../vendor/autoload.php';  // Caminho correto para o autoload.php

// Conexão com o banco de dados
require_once 'db_connection.php';

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verificar se o email existe na base de dados
    $sql = "SELECT id, nome FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se o email não foi encontrado
    if ($result->num_rows === 0) {
        echo "Email não encontrado. Tente novamente.";
    } else {
        // Usuário encontrado, gerando o token de recuperação
        $usuario = $result->fetch_assoc();
        $usuarioId = $usuario['id'];
        $nomeUsuario = $usuario['nome'];

        // Gerar um token único e salvar no banco
        $token = bin2hex(random_bytes(50)); // Gerando um token aleatório
        $expire = date("U") + 1800; // Token expira em 30 minutos

        // Salvar o token no banco de dados
        $sql_token = "INSERT INTO recuperacao_senha (usuario_id, token, expire) VALUES (?, ?, ?)";
        $stmt_token = $conn->prepare($sql_token);
        $stmt_token->bind_param("isi", $usuarioId, $token, $expire);
        $stmt_token->execute();

        // Enviar o link de recuperação para o e-mail do usuário
        $reset_link = "http://jacuipelocadora-production.up.railway.app/recuperar_senha/resetar.php?token=" . $token;

        // Configuração do PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Exemplo: Usando Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'petcardiocontact@gmail.com';  // Seu e-mail
            $mail->Password = 'ddpl czzn xffy vdlh';  // Sua senha de e-mail ou senha de app (Gmail)
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom('petcardiocontact@gmail.com', 'Recuperação de Senha');
            $mail->addAddress($email, $nomeUsuario); // Destinatário

            // Assunto e corpo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Recuperação de Senha';
            $mail->Body    = "Olá, $nomeUsuario. Clique no link abaixo para redefinir sua senha:<br><br><a href='$reset_link'>$reset_link</a>";

            // Envia o e-mail
            if ($mail->send()) {
                echo "Instruções de recuperação enviadas para seu e-mail.";
            } else {
                echo "Erro ao enviar o e-mail. Tente novamente.";
            }
        } catch (Exception $e) {
            echo "Erro ao enviar o e-mail. Erro: {$mail->ErrorInfo}";
        }
    }
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
