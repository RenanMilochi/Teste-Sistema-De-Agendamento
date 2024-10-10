<?php
// Parâmetros de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clinica_lotus";

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Pegando os dados do formulário
$medico = $_POST['medico'];
$especializacao = $_POST['especializacao'];
$data = $_POST['data'];

// SQL para inserir os dados na tabela consultas
$sql = "INSERT INTO consultas (medico, especializacao, data) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $medico, $especializacao, $data);

if ($stmt->execute()) {
    echo "Consulta adicionada com sucesso!";
} else {
    echo "Erro ao adicionar consulta: " . $stmt->error;
}

// Fechando a conexão
$stmt->close();
$conn->close();
?>
