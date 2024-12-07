<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['msg'];

    $to = "Dev_care@gmail.com"; // Altere para o seu endereço de e-mail
    $subject = "Nova mensagem do formulário de contato";
    $body = "Nome: $name\n";
    $body .= "E-mail: $email\n";
    $body .= "Telefone: $phone\n";
    $body .= "Mensagem:\n$message";

    // Enviar e-mail
    if (mail($to, $subject, $body)) {
        echo "Mensagem enviada com sucesso! Entraremos em contato em breve.";
    } else {
        echo "Desculpe, houve um erro ao enviar a mensagem. Por favor, tente novamente mais tarde.";
    }
}
?>
