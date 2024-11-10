<?php
// Ativando exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Conexão com o banco de dados
    $conn = new mysqli("localhost", "root", "", "clinica_estetica");

    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifica se o e-mail existe
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $user['senha'])) {
            // Inicia a sessão do usuário
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nome'];

            // Redireciona para a página de usuário
            header("Location: usuario.php");
            exit;
        } else {
            $error_message = "Senha incorreta.";
        }
    } else {
        $error_message = "Usuário não encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clínica Lótus Saúde</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="login.php" method="post">
            <h2>Login</h2>
            <?php if (isset($error_message)): ?>
                <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="submit" value="Entrar">
            <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>
        </form>
    </div>
</body>
</html>
