<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento - Administrador</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    // Conexão com o banco de dados
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
    
    // Pegando o nome do administrador que fez o login
    session_start();
    $email = $_SESSION['email']; // Armazene o e-mail na sessão após o login
    $sql = "SELECT nome FROM usuarios WHERE email = ? AND perfil = 'administrador'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $adminName = $admin['nome'];
    ?>
    
    <h1>Painel de Agendamento - Administrador - <?php echo htmlspecialchars($adminName); ?></h1>
    
    <h2>Adicionar Nova Consulta</h2>
    <form action="adicionar_consulta.php" method="POST">
        <label for="medico">Nome do Médico</label>
        <input type="text" id="medico" name="medico" required>

        <label for="especializacao">Especialização</label>
        <input type="text" id="especializacao" name="especializacao" required>

        <label for="data">Data</label>
        <input type="date" id="data" name="data" required>

        <button type="submit">Adicionar</button>
    </form>
    
    <h2>Consultas Agendadas</h2>
    <div id="consultas-lista">
        <?php
        // Listar todas as consultas agendadas
        $sql = "SELECT * FROM consultas";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='consulta-item'>";
                echo "<p>Médico: " . htmlspecialchars($row['medico']) . "</p>";
                echo "<p>Especialização: " . htmlspecialchars($row['especializacao']) . "</p>";
                echo "<p>Data: " . htmlspecialchars($row['data']) . "</p>";
                echo "<button onclick=\"editarConsulta(" . $row['id'] . ")\">Editar</button>";
                echo "<button onclick=\"deletarConsulta(" . $row['id'] . ")\">Deletar</button>";
                echo "</div>";
            }
        } else {
            echo "<p>Nenhuma consulta agendada.</p>";
        }
        $conn->close();
        ?>
    </div>

    <script>
        function editarConsulta(id) {
            // Lógica para editar consulta
            alert("Editar consulta com ID: " + id);
        }

        function deletarConsulta(id) {
            // Lógica para deletar consulta
            alert("Deletar consulta com ID: " + id);
        }
    </script>
</body>
</html>
