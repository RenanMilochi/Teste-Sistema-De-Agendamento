<?php
// Parâmetros de conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Troque pelo seu usuário do MySQL
$password = ""; // Troque pela sua senha do MySQL
$dbname = "clinica_lotus";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Pegando os dados do formulário
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$endereco = $_POST['endereco'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$perfil = $_POST['perfil'];
$especializacao = isset($_POST['especializacao']) ? $_POST['especializacao'] : NULL;

// SQL para inserir os dados na tabela usuarios
$sql = "INSERT INTO usuarios (nome, idade, endereco, cpf, telefone, email, senha, perfil, especializacao)
        VALUES ('$nome', '$idade', '$endereco', '$cpf', '$telefone', '$email', '$senha', '$perfil', '$especializacao')";

// Executando a query
if ($conn->query($sql) === TRUE) {
    echo "<div style='text-align: center; font-weight: bold; font-size: 1.5em;'>Cadastro realizado com sucesso!</div>";
} else {
    echo "<div style='text-align: center; font-weight: bold; font-size: 1.5em;'>Erro ao cadastrar: " . $conn->error . "</div>";
}

// Fechando a conexão
$conn->close();
?>
