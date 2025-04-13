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
        echo "<p style='color:green; text-align:center;'>Agendamento realizado com sucesso!</p>";
    } else {
        echo "Erro: " . $conn->error;
    }
}

// Buscar serviços disponíveis
$servicos_result = $conn->query("SELECT id, nome FROM servicos");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agendamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fdf2f8;
            padding: 30px;
        }
        .form-container {
            background: #fff0f5;
            padding: 25px 30px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
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
    </style>
</head>
<body>

<div class="form-container">
    <form method="post">
        <h2>Agendar Procedimento</h2>

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
