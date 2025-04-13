<?php
session_start();  // Inicia a sessão

// Depuração: Verifica se a sessão foi iniciada corretamente
// var_dump($_SESSION);

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    echo "<p style='text-align:center;'>Você precisa estar logado para acessar esta página.</p>";
    exit();  // Se não estiver logado, exibe a mensagem e interrompe o código
}

$usuario = $_SESSION['usuario'];  // Armazena a informação do usuário na variável $usuario
$tipoUsuario = $usuario['tipo'];  // Pega o tipo do usuário, 'administrador' ou 'cliente'

// Conecta ao banco de dados
$conn = new mysqli("localhost", "root", "", "clinica_estetica");  // Certifique-se de que o banco de dados esteja correto

// Verifica a conexão com o banco
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Serviços - Clínica de Estética</title>
    <link rel="stylesheet" href="styles/servico.css">  <!-- Certifique-se de que o caminho do CSS esteja correto -->
</head>
<body>
    <header>
        <h1>Serviços</h1>
    </header>

    <?php if ($tipoUsuario === 'administrador'): ?>
        <section class="agendamentos">
            <h2>Agendamentos Pendentes</h2>
            <table>
                <tr>
                    <th>Usuário</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Horário</th>
                </tr>

                <?php
                // Query para pegar os agendamentos com status 'Aprovação pendente'
                $sql = "SELECT a.id, u.nome AS nome_usuario, s.nome AS nome_servico, a.data, a.horario 
                        FROM agendamentos a
                        JOIN usuarios u ON a.id_usuario = u.id
                        JOIN servicos s ON a.id_servico = s.id
                        WHERE TRIM(LOWER(a.status)) = 'aprovação pendente'";

                $result = $conn->query($sql);

                // Verifica se há agendamentos
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nome_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($row['nome_servico']); ?></td>
                            <td><?php echo htmlspecialchars(date('d/m/Y', strtotime($row['data']))); ?></td>
                            <td><?php echo htmlspecialchars($row['horario']); ?></td>
                        </tr>
                <?php
                    endwhile;
                else:
                ?>
                    <tr><td colspan="4">Nenhum agendamento pendente encontrado.</td></tr>
                <?php endif; ?>
            </table>
        </section>
    <?php else: ?>
        <p style="text-align:center;">Você não tem permissão para visualizar esta página.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>  <!-- Fecha a conexão com o banco de dados -->
</body>
</html>
