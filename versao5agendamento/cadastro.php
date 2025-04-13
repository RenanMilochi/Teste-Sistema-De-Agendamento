<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $telefone = $_POST["telefone"];
    $cpf = $_POST["cpf"];
    $endereco = $_POST["endereco"];
    $data_nascimento = $_POST["data_nascimento"];

    $sql = "INSERT INTO usuarios (nome, email, senha, telefone, cpf, endereco, data_nascimento, tipo)
            VALUES ('$nome', '$email', '$senha', '$telefone', '$cpf', '$endereco', '$data_nascimento', 'cliente')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8e4e4; /* Rosa claro */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 360px;
            box-sizing: border-box;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 20px;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            text-align: left;
            font-size: 14px;
            margin-bottom: 5px;
            padding-left: 5px; /* Distância da borda esquerda */
        }

        .form-container input {
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .form-container button {
            padding: 10px;
            width: 100%;
            background-color: #ff66b2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
        }

        .form-container button:hover {
            background-color: #ff3385;
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
    <div class="form-container">
        <div class="logo-container">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk-ks4vjv5nulPY3nZBwkpT866lsTbf8OXFQ&s" alt="Logo" style="width: 150px;">
        </div>

        <form method="post">
            <h2>Cadastro</h2>

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" required>

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" required>

            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" required>

            <button type="submit">Cadastrar</button>
        </form>

        <div class="first-access-link">
            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
        </div>
    </div>
</body>
</html>
