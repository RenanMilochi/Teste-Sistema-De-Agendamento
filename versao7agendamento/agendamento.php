<?php
session_start();
include 'db.php';

if (!isset($_SESSION["id"])) {
    echo "Acesso negado!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION["id"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];
    $servico_id = $_POST["servico"];

    // Definir o status desejado (neste caso, "Aprovação pendente")
    $status_descricao = 'Aprovação pendente';
    $status_result = $conn->query("SELECT id FROM status_agendamento WHERE descricao = '$status_descricao'");
    $status_row = $status_result->fetch_assoc();
    $status_id = $status_row['id']; // Pegando o ID do status

    // Inserir o agendamento com o ID do status
    $sql = "INSERT INTO agendamentos (id_usuario, id_servico, data, horario, status) 
            VALUES ('$usuario_id', '$servico_id', '$data', '$hora', '$status_id')";

    if ($conn->query($sql) === TRUE) {
        $mensagem = "<p style='color:green; text-align:center;'>Agendamento realizado com sucesso!</p>";
    } else {
        $mensagem = "<p style='color:red; text-align:center;'>Erro: " . $conn->error . "</p>";
    }
}

// Buscar serviços disponíveis
$servicos_result = $conn->query("SELECT id, nome FROM servicos");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Agendamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fdf2f8;
            margin: 0;
            padding: 0;
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

        .form-container {
            background: #fff0f5;
            padding: 25px 30px;
            border-radius: 10px;
            max-width: 400px;
            margin: 50px auto;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
            color: #d63384;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
            color: #333;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
            font-size: 14px;
        }

        button {
            background-color: #d63384;
            color: white;
            border: none;
            padding: 12px 15px;
            margin-top: 20px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            opacity: 0.9;
        }

        .logo-center {
            text-align: center;
            margin-top: 10px;
        }

        .logo-center img {
            width: 150px;
        }

        .mensagem {
            margin-top: 10px;
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

<div class="logo-center">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQk-ks4vjv5nulPY3nZBwkpT866lsTbf8OXFQ&s" alt="Logo">
</div>

<div class="form-container">
    <form method="post">
        <h2>Agendar Procedimento</h2>

        <?php if (isset($mensagem)) echo "<div class='mensagem'>$mensagem</div>"; ?>

        <label for="data">Data:</label>
        <input type="date" name="data" required>

        <label for="hora">Horário:</label>
        <input type="time" name="hora" required>

        <label for="servico">Procedimento:</label>
        <select name="servico" required>
            <option value="">Selecione</option>
            <?php while ($servico = $servicos_result->fetch_assoc()): ?>
                <option value="<?= $servico['id'] ?>"><?= htmlspecialchars($servico['nome']) ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Agendar</button>
    </form>
</div>

</body>
</html>
