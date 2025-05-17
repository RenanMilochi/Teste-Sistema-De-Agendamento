<?php
// Conectar ao banco de dados (corrija o nome do banco de dados aqui)
$servername = "localhost";
$username = "root";
$password = ""; // caso esteja usando a senha padrão do XAMPP
$dbname = "clinica_estetica"; // Nome correto do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
