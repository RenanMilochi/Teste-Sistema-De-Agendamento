<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email='$email' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        $_SESSION["id"] = $usuario["id"];
        $_SESSION["nome"] = $usuario["nome"];
        $_SESSION["tipo"] = $usuario["tipo"];
        header("Location: index.php");
    } else {
        echo "Login inválido!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8e4e4; /* Rosa bem claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .login-form label {
            margin-bottom: 5px;
        }

        .login-form input {
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .login-form button {
            padding: 10px;
            width: 100%;
            background-color: #ff66b2; /* Rosa claro */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #ff3385; /* Rosa mais escuro ao passar o mouse */
        }

        .first-access-link {
            margin-top: 10px;
            font-size: 14px;
        }

        .first-access-link a {
            color: #ff66b2;
            text-decoration: none;
        }

        .first-access-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logotipo Centralizado -->
        <div class="logo-container">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk-ks4vjv5nulPY3nZBwkpT866lsTbf8OXFQ&s" alt="Logo" style="width: 150px;">
        </div>

        <!-- Formulário de Login -->
        <form method="post" class="login-form">
            <h2>Login</h2>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <button type="submit">Entrar</button>
        </form>

        <!-- Link para o Cadastro (Primeiro Acesso) -->
        <div class="first-access-link">
            <p>Não tem uma conta? <a href="cadastro.php">Primeiro Acesso</a></p>
        </div>
    </div>
</body>
</html>