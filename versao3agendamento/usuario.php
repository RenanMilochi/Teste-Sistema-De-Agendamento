<!-- usuario.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Usuário - Clínica de Estética</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 280px;
            text-align: center;
        }

        .card h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .card a {
            background: #ff6b6b;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .card a:hover {
            background: #e25454;
        }

        .section-title {
            text-align: center;
            margin: 20px 0;
            font-size: 24px;
            color: #444;
        }
    </style>
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

    <div class="container">
        <h2>Painel do Usuário</h2>

        <?php
        session_start();
        if (!isset($_SESSION["user_id"])) {
            header("Location: login.php");
            exit;
        }

        $conn = new mysqli("localhost", "root", "", "clinica_estetica");

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $id_usuario = $_SESSION["user_id"];
        $user_result = $conn->query("SELECT nome, email FROM usuarios WHERE id = $id_usuario");
        $user = $user_result->fetch_assoc();

        echo "<p><strong>Nome:</strong> {$user['nome']}</p>";
        echo "<p><strong>E-mail:</strong> {$user['email']}</p>";

        echo "<h3 class='section-title'>Agendamentos Disponíveis</h3>";
        $servicos_result = $conn->query("SELECT * FROM servicos");

        if ($servicos_result->num_rows > 0) {
            echo "<div class='cards-container'>";
            while ($servico = $servicos_result->fetch_assoc()) {
                echo "<div class='card'>
                        <h4>{$servico['nome']}</h4>
                        <p>Preço: R$ {$servico['preco']}</p>
                        <a href='agendamento.php?servico_id={$servico['id']}'>Agendar</a>
                      </div>";
            }
            echo "</div>";
        } else {
            echo "<p>Nenhum serviço disponível.</p>";
        }

        echo "<h3 class='section-title'>Meus Agendamentos</h3>";
        $agendamentos_result = $conn->query("SELECT a.data, a.horario, s.nome, s.preco FROM agendamentos a JOIN servicos s ON a.id_servico = s.id WHERE a.id_usuario = $id_usuario");

        if ($agendamentos_result->num_rows > 0) {
            echo "<div class='cards-container'>";
            while ($agendamento = $agendamentos_result->fetch_assoc()) {
                echo "<div class='card'>
                        <h4>{$agendamento['nome']}</h4>
                        <p>Data: {$agendamento['data']} às {$agendamento['horario']}</p>
                        <p>Preço: R$ {$agendamento['preco']}</p>
                      </div>";
            }
            echo "</div>";
        } else {
            echo "<p>Nenhum agendamento encontrado.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
