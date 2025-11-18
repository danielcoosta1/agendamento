<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Conta</title>
    <link rel="stylesheet" href="style.css"> </head>
<body>
    <h1>Criar Nova Conta</h1>

    <form action="cadastrar_usuario.php" method="POST">
        <div>
            <label>Usuário (Login):</label>
            <input type="text" name="usuario" required>
        </div>
        
        <div>
            <label>Senha:</label>
            <input type="password" name="senha" required>
        </div>

        <br>
        <input type="submit" value="Cadastrar">
    </form>
    
    <br>
    <a href="login.php">Já tenho conta (Voltar ao Login)</a>
</body>
</html>