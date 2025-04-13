<?php
session_start();
include 'db.php';

// Buscar todos os agendamentos com a descrição do status
$sqlAgendamentos = "SELECT a.id, a.data, a.horario, sa.descricao AS status_descricao, s.nome AS nome_servico, u.nome AS nome_usuario
                    FROM agendamentos a
                    JOIN servicos s ON a.id_servico = s.id
                    JOIN usuarios u ON a.id_usuario = u.id
                    JOIN status_agendamento sa ON a.status = sa.id";

$agendamentos = $conn->query($sqlAgendamentos);

// Atualizar o status do agendamento
if (isset($_GET["acao"]) && isset($_GET["agendamento_id"])) {
    $agendamento_id = intval($_GET["agendamento_id"]);
    $acao = $_GET["acao"];

    // Mapear as ações para os IDs dos status na tabela status_agendamento
    $status_id = 0; // valor padrão

    switch ($acao) {
        case 'realizado':
            $status_id = 3; // ID correspondente ao status "realizado" (ajustar conforme seu banco de dados)
            break;
        case 'cancelado':
            $status_id = 4; // ID correspondente ao status "cancelado" (ajustar conforme seu banco de dados)
            break;
        case 'confirmado':
            $status_id = 2; // ID correspondente ao status "confirmado" (ajustar conforme seu banco de dados)
            break;
        case 'Aprovação pendente':
            $status_id = 1; // ID correspondente ao status "Aprovação pendente" (ajustar conforme seu banco de dados)
            break;
    }

    if ($status_id) {
        $sql = "UPDATE agendamentos SET status='$status_id' WHERE id=$agendamento_id";
        if ($conn->query($sql) === TRUE) {
            header("Location: administrativo.php");
            exit();
        } else {
            echo "Erro ao atualizar o status: " . $conn->error;
        }
    }
}

// Criar um novo serviço
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome_servico'])) {
    $nome_servico = $_POST['nome_servico'];
    $descricao_servico = $_POST['descricao_servico'];
    $duracao_servico = $_POST['duracao_servico'];
    $preco_servico = $_POST['preco_servico'];

    $sqlCriarServico = "INSERT INTO servicos (nome, descricao, duracao, preco) VALUES ('$nome_servico', '$descricao_servico', '$duracao_servico', '$preco_servico')";

    if ($conn->query($sqlCriarServico) === TRUE) {
        echo "Novo serviço criado com sucesso!";
        header("Location: administrativo.php");
        exit();
    } else {
        echo "Erro ao criar serviço: " . $conn->error;
    }
}

// Buscar todos os serviços
$sqlServicos = "SELECT * FROM servicos";
$servicos = $conn->query($sqlServicos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Administração - Agendamentos e Serviços</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        header {
            background-color: #cc0066;
            color: white;
            padding: 20px 0;
            text-align: center;
            width: 100%;
            margin-bottom: 20px;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        nav {
            margin-top: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin: 0 15px;
            font-size: 16px;
        }

        nav a:hover {
            opacity: 0.8;
        }

        .container {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            width: 100%;
        }

        .box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 48%;
        }

        .box h3 {
            color: #cc0066;
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .box form {
            display: flex;
            flex-direction: column;
        }

        .box input, .box textarea {
            margin: 10px 0;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .box button {
            background-color: #cc0066;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .box button:hover {
            background-color: #99004c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #ffe6f0;
            color: #cc0066;
        }

        td {
            background-color: #fff;
        }

        a {
            padding: 8px 15px;
            background-color: #cc0066;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 5px;
            font-size: 14px;
        }

        a:hover {
            opacity: 0.8;
        }

        a:active {
            background-color: #99004c;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1>Administração - Agendamentos e Serviços</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <!-- Box de Agendamentos -->
    <div class="box">
        <h3>Agendamentos</h3>
        <table>
            <tr>
                <th>Usuário</th>
                <th>Serviço</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $agendamentos->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['nome_usuario']; ?></td>
                    <td><?php echo $row['nome_servico']; ?></td>
                    <td><?php echo $row['data']; ?></td>
                    <td><?php echo $row['horario']; ?></td>
                    <td><?php echo $row['status_descricao']; ?></td>
                    <td class="action-buttons">
                        <a href="administrativo.php?acao=realizado&agendamento_id=<?php echo $row['id']; ?>">Realizado</a>
                        <a href="administrativo.php?acao=cancelado&agendamento_id=<?php echo $row['id']; ?>">Cancelar</a>
                        <a href="administrativo.php?acao=confirmado&agendamento_id=<?php echo $row['id']; ?>">Confirmar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Box de Serviços -->
    <div class="box">
        <h3>Criar Novo Serviço</h3>
        <form action="administrativo.php" method="POST">
            <input type="text" name="nome_servico" placeholder="Nome do Serviço" required>
            <textarea name="descricao_servico" placeholder="Descrição do Serviço" rows="4" required></textarea>
            <input type="number" name="duracao_servico" placeholder="Duração (minutos)" required>
            <input type="number" step="0.01" name="preco_servico" placeholder="Preço" required>
            <button type="submit">Criar Serviço</button>
        </form>

        <h3>Serviços Criados</h3>
        <table>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Duração</th>
                <th>Preço</th>
            </tr>
            <?php while ($row = $servicos->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['descricao']; ?></td>
                    <td><?php echo $row['duracao']; ?> min</td>
                    <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
