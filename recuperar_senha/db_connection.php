<?php
// Configurações do banco de dados
$servername = "autorack.proxy.rlwy.net"; // Substitua pelo endereço do seu servidor
$username = "root";        // Substitua pelo seu nome de usuário
$password = "vTXbknegVUXpISrGhIxFLHBMvaONdwCh";            // Substitua pela sua senha
$dbname = "railway";      // Substitua pelo nome do seu banco de dados
$port = "25369";
// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}
?>