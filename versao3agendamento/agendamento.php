<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "clinica_estetica");

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processar o formulário de agendamento
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION["user_id"];
    $id_servico = $_POST["servico"];
    $data = $_POST["data"];
    $horario = $_POST["horario"];

    $sql = "INSERT INTO agendamentos (id_usuario, id_servico, data, horario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $id_usuario, $id_servico, $data, $horario);

    if ($stmt->execute()) {
        // Agendamento realizado com sucesso, redirecionar para a página do usuário
        header("Location: usuario.php?agendado=true");
        exit;
    } else {
        echo "Erro ao agendar: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendamento - Clínica de Estética</title>
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
                <li><a href="usuario.php">Meu Painel</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Agendar Procedimento</h2>
        <form action="agendamento.php" method="post">
            <label for="servico">Serviço:</label>
            <select name="servico" required>
                <?php
                $result = $conn->query("SELECT * FROM servicos");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']} - R$ {$row['preco']}</option>";
                }
                ?>
            </select>

            <label for="data">Data:</label>
            <input type="date" name="data" required>

            <label for="horario">Horário:</label>
            <input type="time" name="horario" required>

            <button type="submit">Agendar</button>
        </form>
    </main>
</body>
</html>
