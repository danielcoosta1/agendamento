<?php
session_start();
include('conexao.php');

// 1. Segurança
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// 2. Verificar se temos o ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 3. Deletar o evento
    $sql = "DELETE FROM eventos WHERE id = $id";

    if (mysqli_query($conexao, $sql)) {
        header('Location: eventos_listar.php');
        exit;
    } else {
        echo "Erro ao excluir: " . mysqli_error($conexao);
    }
} else {
    header('Location: eventos_listar.php');
    exit;
}
?>