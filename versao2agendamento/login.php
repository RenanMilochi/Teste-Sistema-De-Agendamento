<!-- login.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Clínica de Estética</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" placeholder="Digite seu e-mail" required>
                </div>

                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="submit-btn">Entrar</button>
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $senha = $_POST["senha"];

                $conn = new mysqli("localhost", "root", "", "clinica_estetica");
                
                if ($conn->connect_error) {
                    die("Falha na conexão: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM usuarios WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    if (password_verify($senha, $user["senha"])) {
                        session_start();
                        $_SESSION["user_id"] = $user["id"];
                        $_SESSION["user_tipo"] = $user["tipo"];
                        header("Location: agendamento.php");
                        exit();
                    } else {
                        echo "<p class='error-msg'>Senha incorreta.</p>";
                    }
                } else {
                    echo "<p class='error-msg'>E-mail não encontrado.</p>";
                }

                $stmt->close();
                $conn->close();
            }
            ?>
        </div>
    </div>
</body>
</html>
