<?php
$host = "localhost"; // ou o endereço do seu servidor de banco de dados
$username = "root"; // seu nome de usuário do MySQL
$password = ""; // sua senha do MySQL
$database = "clinica_estetica"; // nome do seu banco de dados

// Conectar ao banco de dados
$conn = new mysqli($host, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
