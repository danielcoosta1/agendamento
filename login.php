<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agendamento - Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <h1>Acessar o Sistema de Agendamento</h1>

    <form action="verificar_login.php" method="POST">
        <div>
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
        </div>
        <br>
        <?php
        if (isset($_GET['erro'])) {
            if ($_GET['erro'] == 'senha') {
                echo "<p style='color: red;'>Senha incorreta. Tente novamente.</p>";
            } elseif ($_GET['erro'] == 'usuario') {
                echo "<p style='color: red;'>Usuário não encontrado. Tente novamente.</p>";
            }
        }
        ?>
        <input type="submit" value="Entrar">

        <br>
        <div style="text-align: center;">
              <br>
            <a href="cadastro.php">Não tem conta? Cadastre-se aqui</a>
            <br><br>
            <a href="#" onclick="alert('Procure o administrador para resetar sua senha.')" style="font-size: 0.8em; color: #888;">Esqueci minha senha</a>
        </div>
    </form>

</body>

</html>