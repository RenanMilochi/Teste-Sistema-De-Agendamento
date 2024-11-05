<!-- cadastro.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Clínica de Estética</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Cadastro</h2>
            <form action="cadastro.php" method="post">
                <div class="input-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" placeholder="Digite seu nome" required>
                </div>

                <div class="input-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="submit-btn">Cadastrar</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Obtenha os valores do formulário
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

                // Conectar ao banco de dados
                $conn = new mysqli("localhost", "root", "", "clinica_estetica");

                // Verificar conexão
                if ($conn->connect_error) {
                    die("Falha na conexão: " . $conn->connect_error);
                }

                // Preparar a consulta
                $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Vincular e executar
                    $stmt->bind_param("sss", $nome, $email, $senha);

                    if ($stmt->execute()) {
                        // Redirecionar para a página de login após o sucesso
                        header("Location: login.php");
                        exit(); // Encerra o script após o redirecionamento
                    } else {
                        echo "<p>Erro ao cadastrar: " . $stmt->error . "</p>";
                    }

                    $stmt->close();
                } else {
                    echo "<p>Erro na preparação da consulta: " . $conn->error . "</p>";
                }

                // Fechar a conexão
                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>
