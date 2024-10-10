<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Clínica Lótus Saúde</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Tela de Login -->
    <section id="login" class="login">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>

            <label for="perfil">Perfil</label>
            <select id="perfil" name="perfil" required>
                <option value="administrador">Administrador</option>
                <option value="cliente">Cliente</option>
                <option value="profissional">Profissional</option>
            </select>

            <button type="submit">Entrar</button>
        </form>

        <!-- Link para página de cadastro (Primeiro Acesso) -->
        <p>Primeiro acesso? <a href="cadastro.html">Cadastre-se aqui</a></p>
    </section>
</body>
</html>
