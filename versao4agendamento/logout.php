<!-- logout.php -->
<?php
session_start();
session_destroy(); // Destrói a sessão para efetuar logout
header("Location: login.php"); // Redireciona para a página de login
exit;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Logout - Clínica de Estética</title>
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
                <li><a href="login.php">Login</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="servico.php">Serviços</a></li>
            </ul>
        </nav>
    </header>

    <div class="hero">
        <h2>Logout</h2>
        <p>Você foi desconectado com sucesso. Volte para a página de login.</p>
        <a href="login.php" class="cta-btn">Login</a>
    </div>

    <footer class="footer">
        <p>&copy; 2024 Clínica de Estética. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
