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
$email = $_POST['email'];
$senha = $_POST['senha']; // Senha deve ser criptografada na base de dados, adicione o hashing aqui se necessário
$perfil = $_POST['perfil'];

// SQL para selecionar o usuário
$sql = "SELECT * FROM usuarios WHERE email = ? AND senha = ? AND perfil = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $senha, $perfil);
$stmt->execute();
$result = $stmt->get_result();

// Verificando se há um usuário correspondente
if ($result->num_rows > 0) {
    // Redirecionando para a página correspondente
    if ($perfil === 'administrador') {
        header("Location: paginaadm.php");
    } elseif ($perfil === 'cliente') {
        header("Location: paginacliente.html");
    } elseif ($perfil === 'profissional') {
        header("Location: paginaprofissional.html");
    }
    exit();
} else {
    echo "<p style='color: red; text-align: center;'>E-mail, senha ou perfil inválidos.</p>";
}

// Fechando a conexão
$conn->close();
?>
