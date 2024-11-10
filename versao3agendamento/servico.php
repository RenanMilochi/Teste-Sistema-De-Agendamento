<!-- servico.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Serviço - Clínica de Estética</title>
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
                <li><a href="servico.php">Cadastrar Serviço</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <h2>Cadastrar Serviço</h2>
    <form action="servico.php" method="post">
        <label for="nome">Nome do Serviço:</label>
        <input type="text" name="nome" required>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required></textarea>

        <label for="duracao">Duração (em minutos):</label>
        <input type="number" name="duracao" required>

        <label for="preco">Preço (R$):</label>
        <input type="text" name="preco" required>

        <button type="submit">Cadastrar Serviço</button>
    </form>

    <?php
    // Processar o cadastro de serviço
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $duracao = $_POST["duracao"];
        $preco = $_POST["preco"];

        $conn = new mysqli("localhost", "root", "", "clinica_estetica");

        // Verifique a conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sql = "INSERT INTO servicos (nome, descricao, duracao, preco) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $nome, $descricao, $duracao, $preco);

        if ($stmt->execute()) {
            echo "Serviço cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar serviço: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
