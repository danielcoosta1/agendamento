<?php
session_start();
include('conexao.php');

// 1. Segurança
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// 2. Buscar Locais para preencher o <select> (Conceito novo!)
$sql_locais = "SELECT * FROM locais ORDER BY nome ASC";
$resultado_locais = mysqli_query($conexao, $sql_locais);

// 3. Processar o Formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $data = $_POST['data_evento'];
    $inicio = $_POST['hora_inicio'];
    $termino = $_POST['hora_termino'];
    $local_id = $_POST['local_id'];
    $descricao = $_POST['descricao'];

    // Pegamos o ID do usuário da sessão (que acabamos de configurar)
    $usuario_id = $_SESSION['id_usuario'];

    // --- VALIDAÇÃO DE CONFLITO (Lógica Nova) ---

    // A regra de ouro de sobreposição de horários:
    // (NovoInicio < EventoFim) E (NovoFim > EventoInicio)

    $sql_conflito = "SELECT * FROM eventos 
                     WHERE local_id = '$local_id' 
                     AND data_evento = '$data'
                     AND (
                        (hora_inicio < '$termino' AND hora_termino > '$inicio')
                     )";

    $res_conflito = mysqli_query($conexao, $sql_conflito);

    if (mysqli_num_rows($res_conflito) > 0) {
        // OPA! Já existe um evento nesse horário
        echo "<script>
                alert('ERRO: Já existe um evento agendado neste local e horário!');
                window.history.back(); // Volta para o formulário
              </script>";
    } else {
        // Tudo limpo! Pode salvar.
        $sql = "INSERT INTO eventos (titulo, descricao, data_evento, hora_inicio, hora_termino, local_id, usuario_id) 
                VALUES ('$titulo', '$descricao', '$data', '$inicio', '$termino', '$local_id', '$usuario_id')";

        if (mysqli_query($conexao, $sql)) {
            header('Location: eventos_listar.php');
            exit;
        } else {
            echo "Erro ao agendar: " . mysqli_error($conexao);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Novo Agendamento</title>
</head>

<body>
    <h1>Novo Agendamento</h1>

    <form method="POST">
        <label>Título do Evento:</label>
        <input type="text" name="titulo" required placeholder="Ex: Culto de Jovens">
        <br><br>

        <label>Data:</label>
        <input type="date" name="data_evento" required>
        <br><br>

        <label>Início:</label>
        <input type="time" name="hora_inicio" required>

        <label>Término:</label>
        <input type="time" name="hora_termino" required>
        <br><br>

        <label>Local:</label>
        <select name="local_id" required>
            <option value="">Selecione um local...</option>
            <?php
            // Loop PHP gerando HTML
            while ($local = mysqli_fetch_assoc($resultado_locais)) {
                // O 'value' é o ID (que vai pro banco), o texto é o Nome (que o usuário vê)
                echo "<option value='" . $local['id'] . "'>" . $local['nome'] . "</option>";
            }
            ?>
        </select>
        <br><br>

        <label>Descrição (Opcional):</label><br>
        <textarea name="descricao" rows="4" cols="50"></textarea>
        <br><br>

        <input type="submit" value="Agendar">
    </form>

    <br>
    <a href="eventos_listar.php">Cancelar</a>
</body>

</html>