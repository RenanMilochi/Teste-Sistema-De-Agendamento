<?php
session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["id"];

// Buscar dados do usuário logado
$sqlUsuario = "SELECT * FROM usuarios WHERE id='$id'";
$resultUsuario = $conn->query($sqlUsuario);
$usuario = $resultUsuario->fetch_assoc();
$tipoUsuario = $usuario['tipo'];

// Ações de cancelamento
if (isset($_GET["acao"]) && isset($_GET["agendamento_id"])) {
    $agendamento_id = intval($_GET["agendamento_id"]);
    $acao = $_GET["acao"];

    // Depuração: Verificar se a URL está sendo processada corretamente
    error_log("Ação: $acao, Agendamento ID: $agendamento_id");

    if ($acao === "cancelar") {
        $sql = "UPDATE agendamentos SET status='cancelado' WHERE id=$agendamento_id";
        if ($conn->query($sql) === TRUE) {
            error_log("Agendamento cancelado com sucesso.");
        } else {
            error_log("Erro ao cancelar agendamento: " . $conn->error);
        }
    }

    // Redirecionar para a página de usuário após a ação
    header("Location: usuario.php");
    exit();
}

// Buscar agendamentos com descrição do status
$sqlAgendamentos = "SELECT a.id, a.data, a.horario, sa.descricao AS status_descricao, s.nome AS nome_servico 
                    FROM agendamentos a 
                    JOIN servicos s ON a.id_servico = s.id
                    LEFT JOIN status_agendamento sa ON a.status = sa.id";

if ($tipoUsuario == "cliente") {
    $sqlAgendamentos .= " WHERE a.id_usuario = '$id'";
}

$agendamentos = $conn->query($sqlAgendamentos);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clínica Lótus Saúde - Perfil</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .cta-btn:hover {
            opacity: 0.8;
        }

        .hero {
            background-image: url('https://salaslotus.com.br/wp-content/uploads/2023/03/foto-atencao-2.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 100px 20px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #ffe6f0;
            margin: 0;
            padding: 0;
        }

        .form-container, .agendamentos {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center; /* Centraliza o conteúdo */
            gap: 20px;
            padding: 20px;
            height: 100vh; /* Para que o container ocupe toda a altura da tela */
            align-items: center; /* Centraliza o conteúdo verticalmente */
        }

        .form-container {
            max-width: 45%;
        }

        .agendamentos {
            max-width: 45%;
            display: flex;
            flex-direction: column;
            align-items: center; /* Centraliza os itens dentro da div */
        }

        h2, .agendamentos h3 {
            text-align: center;
            margin-bottom: 25px;
            color: #cc0066;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #cc0066;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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

        a.botao {
            padding: 6px 12px;
            background-color: #cc0066;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            margin: 0 3px;
        }

        a.botao:hover {
            opacity: 0.8;
        }

        .header {
            background-color: #cc0066;
            padding: 10px 0;
            color: white;
        }

        .logo h1 {
            margin: 0;
            text-align: center;
        }

        .nav ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        .nav ul li {
            display: inline;
            margin-right: 20px;
        }

        .nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .nav ul li a:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>

<header class="header">
    <div class="logo">
        <h1>Clínica Lótus Saúde</h1>
    </div>
    <nav class="nav">
        <ul>
            <li><a href="index.php">Home</a></li>

            <?php if (isset($_SESSION['id'])): ?>
                <li><a href="usuario.php">Perfil</a></li>

                <?php
                // Verifica se o usuário está logado e é administrador
                if (
                    isset($_SESSION['usuario']) &&
                    isset($_SESSION['usuario']['tipo']) &&
                    $_SESSION['usuario']['tipo'] === 'administrador'
                ): ?>
                    <li><a href="servico.php">Serviços</a></li>
                <?php endif; ?>

                <li><a href="agendamento.php">Agendamentos</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="cadastro.php">Cadastre-se</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<div style="text-align: center; margin-bottom: 10px;">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk-ks4vjv5nulPY3nZBwkpT866lsTbf8OXFQ&s" alt="Logo" style="width: 150px; margin-bottom: 10px;">
</div>

<div class="container">
    <div class="form-container">
        <form method="post">
            <h2>Meu Perfil</h2>

            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>

            <label>Telefone:</label>
            <input type="text" name="telefone" value="<?php echo $usuario['telefone']; ?>" required>

            <label>CPF:</label>
            <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>" required>

            <label>Endereço:</label>
            <input type="text" name="endereco" value="<?php echo $usuario['endereco']; ?>" required>

            <label>Data de Nascimento:</label>
            <input type="date" name="data_nascimento" value="<?php echo $usuario['data_nascimento']; ?>" required>

            <button type="submit" name="atualizar_perfil">Atualizar</button>
        </form>
    </div>

    <div class="agendamentos">
        <h3>Meus Agendamentos</h3>
        <table>
            <tr>
                <th>Serviço</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $agendamentos->fetch_assoc()) {
                $statusDescricao = $row['status_descricao'];
                $aguardando = is_null($statusDescricao) || $statusDescricao === '' || strtolower($statusDescricao) === 'null' || strtolower($statusDescricao) === 'aprovação pendente';
            ?>
                <tr>
                    <td><?php echo $row['nome_servico']; ?></td>
                    <td><?php echo $row['data']; ?></td>
                    <td><?php echo $row['horario']; ?></td>
                    <td><?php echo $aguardando ? 'Aguardando aprovação' : $statusDescricao; ?></td>
                    <td>
                        <?php if ($aguardando): ?>
                            <a class="botao" href="usuario.php?acao=cancelar&agendamento_id=<?php echo $row['id']; ?>">Cancelar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
