<?php
// 1. INICIAR A SESSÃO (Aula 9, slide 26) 
// TEMOS de iniciar a sessão em TODAS as páginas que
// precisam de saber se o utilizador está logado.
session_start();

// 2. VERIFICAR SE O UTILIZADOR ESTÁ LOGADO (Aula 9, slide 33) 
// Verificamos se a "chave" 'usuario_logado' que criámos em 'verificar_login.php'
// existe e não está vazia na $_SESSION.
if (isset($_SESSION['usuario_logado']) && !empty($_SESSION['usuario_logado'])) {

    // Se sim, o utilizador está logado.
    // Guardamos o nome dele numa variável para facilitar.
    $nome_usuario = $_SESSION['usuario_logado'];
} else {
    // Se não, o utilizador NÃO está logado.
    // Redirecionamos ele de volta para a página de login (Aula 9, slide 33) 
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="menu-container">
        <h1>Bem-vindo, <?php echo $nome_usuario; ?>!</h1>
        <p>Painel de Controle</p>
        <br>

        <a href="locais_listar.php" class="btn-menu">Gerenciar Locais</a>
        <a href="eventos_listar.php" class="btn-menu">Gerenciar Eventos</a>
        <br><br>
        <a href="logout.php">Sair</a>
    </div>
</body>

</html>