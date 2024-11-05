<!-- index.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica de Estética - Bem-vindo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header class="header">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRY1P6C5cr8aJNnKvk376EvtVBbEnu9rYcE0g&s" width="50" alt="Clínica de Estética Logo">
            <h1>Clínica de Estética</h1>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="agendamento.php">Agendamento</a></li>
                <li><a href="contato.php">Contato</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <section class="hero">
            <h2>Bem-vindo à Clínica de Estética</h2>
            <p>Cuidados especializados para sua beleza e bem-estar</p>
            <a href="agendamento.php" class="cta-btn">Agende sua consulta</a>
        </section>

        <section class="services">
            <h3>Nossos Serviços</h3>
            <div class="service-card">
                <img src="data:image/jpeg;base64,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" alt="Serviço 1">
                <h4>Limpeza de Pele</h4>
                <p>Remoção de impurezas para uma pele mais saudável e radiante.</p>
            </div>
            <div class="service-card">
                <img src="data:image/jpeg;base64,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" alt="Serviço 2">
                <h4>Massagem Relaxante</h4>
                <p>Relaxe e alivie o estresse com nossa massagem personalizada.</p>
            </div>
            <div class="service-card">
                <img src="data:image/jpeg;base64,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" alt="Serviço 3">
                <h4>Tratamento Facial</h4>
                <p>Rejuvenescimento da pele com técnicas avançadas de estética.</p>
            </div>
        </section>
    </main>

    <!-- Rodapé -->
    <footer class="footer">
        <p>&copy; 2024 Clínica de Estética. Todos os direitos reservados.</p>
        <p>Rua da Beleza, 123 - Cidade, Estado</p>
    </footer>
</body>
</html>