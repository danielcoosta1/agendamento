<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// 1. Buscar os dados do Evento
if (!isset($_GET['id'])) {
    header('Location: eventos_listar.php');
    exit;
}
$id = $_GET['id'];
$sql_evento = "SELECT * FROM eventos WHERE id = $id";
$res_evento = mysqli_query($conexao, $sql_evento);
$evento = mysqli_fetch_assoc($res_evento);

// 2. Buscar a lista de Locais (para o dropdown)
$sql_locais = "SELECT * FROM locais ORDER BY nome ASC";
$res_locais = mysqli_query($conexao, $sql_locais);

// 3. Salvar as alterações (UPDATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $data = $_POST['data_evento'];
    $inicio = $_POST['hora_inicio'];
    $termino = $_POST['hora_termino'];
    $local_id = $_POST['local_id'];
    $descricao = $_POST['descricao'];

    $sql_update = "UPDATE eventos SET 
                    titulo='$titulo', 
                    data_evento='$data', 
                    hora_inicio='$inicio', 
                    hora_termino='$termino', 
                    local_id='$local_id', 
                    descricao='$descricao' 
                   WHERE id=$id";

    if (mysqli_query($conexao, $sql_update)) {
        header('Location: eventos_listar.php');
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
    <title>Editar Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Editar Evento</h1>

    <form method="POST">
        <label>Título:</label>
        <input type="text" name="titulo" value="<?php echo $evento['titulo']; ?>" required>
        <br><br>

        <label>Data:</label>
        <input type="date" name="data_evento" value="<?php echo $evento['data_evento']; ?>" required>
        <br><br>

        <label>Início:</label>
        <input type="time" name="hora_inicio" value="<?php echo $evento['hora_inicio']; ?>" required>
        
        <label>Término:</label>
        <input type="time" name="hora_termino" value="<?php echo $evento['hora_termino']; ?>" required>
        <br><br>

        <label>Local:</label>
        <select name="local_id" required>
            <option value="">Selecione...</option>
            <?php
                while ($local = mysqli_fetch_assoc($res_locais)) {
                    // O TRUQUE DO SELECTED:
                    // Se o ID deste local for igual ao ID que está salvo no evento, marcamos como 'selected'
                    $selecionado = ($local['id'] == $evento['local_id']) ? 'selected' : '';
                    
                    echo "<option value='" . $local['id'] . "' $selecionado>" . $local['nome'] . "</option>";
                }
            ?>
        </select>
        <br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" rows="4" cols="50"><?php echo $evento['descricao']; ?></textarea>
        <br><br>

        <input type="submit" value="Atualizar Evento">
    </form>
    <br>
    <a href="eventos_listar.php">Cancelar</a>
</body>
</html>