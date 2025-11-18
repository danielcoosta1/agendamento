<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agendamento - Login</title>
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
        <input type="submit" value="Entrar">
    </form>

</body>
</html>