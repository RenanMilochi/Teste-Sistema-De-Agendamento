<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Clínica de Estética</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <h1>Clínica de Estética</h1>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="agendamento.php">Agendar</a></li>
                <li><a href="cadastro.php">Cadastrar</a></li>
            </ul>
        </nav>
    </header>

    <h2>Cadastrar Usuário</h2>
    <form action="cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Cadastrar</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

        $conn = new mysqli("localhost", "root", "", "clinica_estetica");

        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
    
    <footer class="footer">
        <p>&copy; 2024 Clínica de Estética. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
