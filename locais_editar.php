<?php
session_start();
include('conexao.php');

// 1. Segurança
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// 2. Verificar se temos um ID (para saber QUEM vamos editar)
if (!isset($_GET['id'])) {
    header('Location: locais_listar.php'); // Sem ID, volta pra lista
    exit;
}

$id = $_GET['id'];

// 3. Buscar os dados ATUAIS deste local no banco
$sql = "SELECT * FROM locais WHERE id = $id";
$resultado = mysqli_query($conexao, $sql);
$local = mysqli_fetch_assoc($resultado);

// (Se o ID não existir no banco, voltamos para a lista)
if (!$local) {
    header('Location: locais_listar.php');
    exit;
}

// 4. Processar o Formulário de Edição (QUANDO O USUÁRIO CLICA EM SALVAR)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_novo = $_POST['nome'];
    $endereco_novo = $_POST['endereco'];

    // O Comando SQL de Atualização (Aula 10)
    $sql_update = "UPDATE locais SET nome = '$nome_novo', endereco = '$endereco_novo' WHERE id = $id";

    if (mysqli_query($conexao, $sql_update)) {
        header('Location: locais_listar.php'); // Sucesso!
        exit;
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Local</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Editar Local</h1>

    <form method="POST">
        <label>Nome do Local:</label>
        <input type="text" name="nome" value="<?php echo $local['nome']; ?>" required>
        <br><br>
        
        <label>Endereço:</label>
        <input type="text" name="endereco" value="<?php echo $local['endereco']; ?>">
        <br><br>
        
        <input type="submit" value="Atualizar Dados">
    </form>

    <br>
    <a href="locais_listar.php">Cancelar</a>
</body>
</html>