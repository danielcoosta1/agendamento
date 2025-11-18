<?php
session_start();
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    
    // 1. Verificar se o usuário JÁ EXISTE
    // (Não queremos dois usuários com o mesmo login)
    $sql_verifica = "SELECT id FROM usuarios WHERE usuario = '$usuario'";
    $resultado_verifica = mysqli_query($conexao, $sql_verifica);

    if (mysqli_num_rows($resultado_verifica) > 0) {
        echo "<script>
                alert('ERRO: Este nome de usuário já está em uso!');
                window.location.href = 'cadastro.php';
              </script>";
        exit;
    }

    // 2. Criptografar a Senha (Obrigatório pelo seu PDF)
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // 3. Inserir no Banco
    // Definimos o nível padrão como 'comum'
    $sql = "INSERT INTO usuarios (usuario, senha, nivel_acesso) VALUES ('$usuario', '$senha_hash', 'comum')";

    if (mysqli_query($conexao, $sql)) {
        echo "<script>
                alert('Usuário cadastrado com sucesso!');
                window.location.href = 'login.php';
              </script>";
        exit;
    } else {
        echo "Erro ao cadastrar: " . mysqli_error($conexao);
    }
} else {
    header('Location: cadastro.php');
    exit;
}
?>