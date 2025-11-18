<?php
session_start();
include('conexao.php');

// Segurança
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// Lógica de cadastro (Só executa se o form for enviado via POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];

    // Aula 10 - INSERT [cite: 1900-1902]
    $sql = "INSERT INTO locais (nome, endereco) VALUES ('$nome', '$endereco')";
    
    if (mysqli_query($conexao, $sql)) {
        // Sucesso! Volta para a lista
        header('Location: locais_listar.php');
        exit;
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Local</title>
</head>
<body>
    <h1>Novo Local</h1>
    <form method="POST">
        <label>Nome do Local:</label>
        <input type="text" name="nome" required><br><br>
        
        <label>Endereço:</label>
        <input type="text" name="endereco"><br><br>
        
        <input type="submit" value="Salvar">
    </form>
    <br>
    <a href="locais_listar.php">Cancelar</a>
</body>
</html>