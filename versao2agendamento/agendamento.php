<!-- agendamento.php -->
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
                <li><a href="index.php">Início</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="agendamento.php">Agendar</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <h2>Agendar Procedimento</h2>
    <form action="agendamento.php" method="post">
        <label for="servico">Serviço:</label>
        <select name="servico" required>
            <option value="1">Limpeza de Pele - R$ 100.00</option>
            <option value="2">Massagem Relaxante - R$ 120.00</option>
            <option value="3">Tratamento Facial - R$ 150.00</option>
        </select>

        <label for="data">Data:</label>
        <input type="date" name="data" required>

        <label for="horario">Horário:</label>
        <input type="time" name="horario" required>

        <button type="submit">Agendar</button>
    </form>

    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["user_id"])) {
        $id_usuario = $_SESSION["user_id"];
        $id_servico = $_POST["servico"];
        $data = $_POST["data"];
        $horario = $_POST["horario"];

        $conn = new mysqli("localhost", "root", "", "clinica_estetica");

        // Verifica se a conexão foi bem-sucedida
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sql = "INSERT INTO agendamentos (id_usuario, id_servico, data, horario) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Verifica se a preparação da instrução foi bem-sucedida
        if (!$stmt) {
            die("Erro na preparação da instrução: " . $conn->error);
        }

        $stmt->bind_param("iiss", $id_usuario, $id_servico, $data, $horario);

        if ($stmt->execute()) {
            echo "Agendamento realizado com sucesso!";
        } else {
            echo "Erro ao agendar: " . $stmt->error;
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
