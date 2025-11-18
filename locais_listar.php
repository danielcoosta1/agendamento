<?php
session_start();
include('conexao.php');

// 1. Verificar se o usuário está logado (Segurança)
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// 2. NOVO: Verifica se é ADMIN
// Se o nível NÃO for 'admin', expulsa o usuário para a área restrita
if ($_SESSION['nivel_acesso'] !== 'admin') {
    echo "<script>
            alert('Acesso Negado! Apenas administradores podem gerenciar locais.');
            window.location.href = 'area_restrita.php';
          </script>";
    exit;
}

// 2. Buscar os locais no banco (Aula 10, slide 31 - SELECT)
$sql = "SELECT * FROM locais";
$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciar Locais</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Locais Cadastrados</h1>

    <a href="locais_adicionar.php">+ Adicionar Novo Local</a>
    <br><br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // 3. Loop para exibir cada local (Aula 5/6 - while/foreach)
            // mysqli_fetch_assoc transforma a linha do banco num array associativo
            while ($local = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $local['id'] . "</td>";
                echo "<td>" . $local['nome'] . "</td>";
                echo "<td>" . $local['endereco'] . "</td>";
                echo "<td>
                        <a href='locais_editar.php?id=" . $local['id'] . "'>Editar</a> | 
                        <a href='locais_excluir.php?id=" . $local['id'] . "'>Excluir</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="area_restrita.php">Voltar para o Início</a>
</body>

</html>