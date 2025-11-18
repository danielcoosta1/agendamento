<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// --- LÓGICA DE FILTRO ---

// 1. Inicializar variáveis de filtro vazias
$busca = "";
$filtro_data = "";
$filtro_local = "";

// 2. Montar a base da consulta SQL (com LEFT JOIN para mostrar orfãos)
$sql = "SELECT eventos.*, locais.nome AS nome_local, usuarios.usuario AS nome_responsavel 
        FROM eventos 
        LEFT JOIN locais ON eventos.local_id = locais.id 
        LEFT JOIN usuarios ON eventos.usuario_id = usuarios.id ";

// 3. Adicionar condições (WHERE) dinamicamente
$condicoes = []; // Array para guardar as frases do WHERE

if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $busca = $_GET['busca'];
    // LIKE permite buscar partes do texto (%texto%)
    $condicoes[] = "eventos.titulo LIKE '%$busca%'";
}

if (isset($_GET['data']) && !empty($_GET['data'])) {
    $filtro_data = $_GET['data'];
    $condicoes[] = "eventos.data_evento = '$filtro_data'";
}

if (isset($_GET['local']) && !empty($_GET['local'])) {
    $filtro_local = $_GET['local'];
    $condicoes[] = "eventos.local_id = '$filtro_local'";
}

// Se tiver alguma condição, adicionamos ao SQL
if (count($condicoes) > 0) {
    // Junta todas as condições com " AND "
    $sql .= " WHERE " . implode(" AND ", $condicoes);
}

// Ordenação
$sql .= " ORDER BY data_evento ASC, hora_inicio ASC";

$resultado = mysqli_query($conexao, $sql);

// Buscar locais para o dropdown de filtro
$res_locais = mysqli_query($conexao, "SELECT * FROM locais ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Agenda de Eventos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Agenda de Eventos</h1>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="eventos_adicionar.php" class="btn-menu">+ Novo Evento</a>
            <a href="calendario.php" class="btn-menu">📅 Visualizar CalendárioCalendário</a>
            <a href="area_restrita.php" class="btn-menu">Voltar</a>
        </div>
    </div>

    <br>

    <form method="GET" style="max-width: 100%; background-color: #1f2b4a; padding: 20px; display: flex; gap: 15px; align-items: flex-end;">

        <div style="flex: 1;">
            <label>Buscar por Nome:</label>
            <input type="text" name="busca" value="<?php echo $busca; ?>" placeholder="Ex: Culto...">
        </div>

        <div>
            <label>Data:</label>
            <input type="date" name="data" value="<?php echo $filtro_data; ?>">
        </div>

        <div>
            <label>Local:</label>
            <select name="local">
                <option value="">Todos os Locais</option>
                <?php
                while ($l = mysqli_fetch_assoc($res_locais)) {
                    $sel = ($l['id'] == $filtro_local) ? 'selected' : '';
                    echo "<option value='" . $l['id'] . "' $sel>" . $l['nome'] . "</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn-menu" style="margin: 0; padding: 12px 20px;">Filtrar</button>

        <?php if (!empty($busca) || !empty($filtro_data) || !empty($filtro_local)): ?>
            <a href="eventos_listar.php" style="margin-left: 10px; color: #e94560;">Limpar</a>
        <?php endif; ?>
    </form>

    <br>

    <table border="1">
        <thead>
            <tr>
                <th>Data</th>
                <th>Horário</th>
                <th>Evento</th>
                <th>Local</th>
                <th>Responsável</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($evento = mysqli_fetch_assoc($resultado)) {
                    $data_formatada = date('d/m/Y', strtotime($evento['data_evento']));
                    $hora_inicio = date('H:i', strtotime($evento['hora_inicio']));
                    $hora_fim = date('H:i', strtotime($evento['hora_termino']));
                    // Verifica se o nome do local veio vazio (ou seja, local excluído)
                    $nome_local = !empty($evento['nome_local']) ? $evento['nome_local'] : '<span style="color: red;">(Local Excluído)</span>';
                    $nome_resp = !empty($evento['nome_responsavel']) ? $evento['nome_responsavel'] : '<span style="color: red;">(Usuário Excluído)</span>';

                    echo "<tr>";
                    echo "<td>" . $data_formatada . "</td>";
                    echo "<td>" . $hora_inicio . " às " . $hora_fim . "</td>";
                    echo "<td>" . $evento['titulo'] . "</td>";
                    echo "<td>" . $nome_local . "</td>"; // Use a variável tratada
                    echo "<td>" . $nome_resp . "</td>";  // Use a variável tratada
                    echo "<td>
                            <a href='eventos_editar.php?id=" . $evento['id'] . "'>Editar</a> | 
                            <a href='eventos_excluir.php?id=" . $evento['id'] . "' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center; padding: 20px;'>Nenhum evento encontrado com esses filtros.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>