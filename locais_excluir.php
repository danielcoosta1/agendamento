<?php
session_start();
include('conexao.php');

// 1. Segurança: Só logado entra
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// 2. Verificar se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id_excluir = $_GET['id'];

    // 3. Montar o comando SQL de Exclusão
    // CUIDADO: O 'WHERE' é obrigatório, senão apaga tudo!
    $sql = "DELETE FROM locais WHERE id = $id_excluir";

    // 4. Executar
    if (mysqli_query($conexao, $sql)) {
        // Sucesso: Volta para a lista
        header('Location: locais_listar.php');
        exit;
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }

} else {
    // Se tentar entrar direto sem ID, manda volta para a lista
    header('Location: locais_listar.php');
    exit;
}
?>