<?php
// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "clinica_estetica");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Definir o status do agendamento com base no botão pressionado
    if (isset($_POST['status'])) {
        $id_agendamento = $_POST['id_agendamento'];
        $status = $_POST['status']; // 'confirmado' ou 'cancelado'

        // Atualizando o status no banco de dados
        if (!empty($id_agendamento)) {
            $stmt = $conn->prepare("UPDATE agendamentos SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $id_agendamento);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Buscar todos os agendamentos
$agendamentos_result = $conn->query("SELECT a.id, a.data, a.horario, a.status, s.nome AS servico_nome, u.nome AS usuario_nome 
                                     FROM agendamentos a 
                                     JOIN servicos s ON a.id_servico = s.id 
                                     JOIN usuarios u ON a.id_usuario = u.id");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Serviços - Clínica de Estética</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilos Gerais */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #4CAF50;
            padding: 15px 0;
            color: white;
            text-align: center;
        }

        .nav {
            background-color: #333;
            overflow: hidden;
        }

        .nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav ul li {
            display: inline;
            margin-right: 20px;
        }

        .nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
        }

        .nav ul li a:hover {
            background-color: #575757;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Cards de Agendamento */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: space-between;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            width: 280px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h4 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .card p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
        }

        .status {
            font-weight: bold;
        }

        .status.pendente {
            color: red;
        }

        .status.confirmado {
            color: green;
        }

        .status.cancelado {
            color: gray;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .buttons button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .buttons button.confirmar {
            background-color: #4CAF50;
            color: white;
        }

        .buttons button.cancelar {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

<header class="header">
    <h1>Clínica de Estética</h1>
</header>

<nav class="nav">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="agendamento.php">Agendar</a></li>
        <li><a href="cadastro.php">Cadastrar</a></li>
        <li><a href="servico.php">Serviços</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Gerenciar Agendamentos</h2>

    <?php
    if ($agendamentos_result->num_rows > 0) {
        while ($agendamento = $agendamentos_result->fetch_assoc()) {
            echo "<div class='card'>
                    <h4>{$agendamento['servico_nome']}</h4>
                    <p>Usuário: {$agendamento['usuario_nome']}</p>
                    <p>Data: {$agendamento['data']} às {$agendamento['horario']}</p>
                    <p class='status {$agendamento['status']}'>Status: " . ucfirst($agendamento['status']) . "</p>
                    <form method='POST'>
                        <input type='hidden' name='id_agendamento' value='{$agendamento['id']}'>
                        <!-- Confirmar botão -->
                        <input type='hidden' name='status' value='confirmado'>
                        <div class='buttons'>
                            <button type='submit' class='confirmar'>Confirmar</button>
                        </div>
                    </form>
                    <form method='POST'>
                        <input type='hidden' name='id_agendamento' value='{$agendamento['id']}'>
                        <!-- Cancelar botão -->
                        <input type='hidden' name='status' value='cancelado'>
                        <div class='buttons'>
                            <button type='submit' class='cancelar'>Cancelar</button>
                        </div>
                    </form>
                  </div>";
        }
    } else {
        echo "<p>Nenhum agendamento encontrado.</p>";
    }

    $conn->close();
    ?>

</div>

</body>
</html>
