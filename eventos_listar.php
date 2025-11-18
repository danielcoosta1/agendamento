<?php
session_start();
include('conexao.php');

if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// O TRUQUE DO JOIN (Aula 10 - Conceito avançado)
// Estamos dizendo: "Selecione tudo de eventos, MAS TAMBÉM 
// traga o nome do local e o nome do usuário correspondentes."
$sql = "SELECT eventos.*, locais.nome AS nome_local, usuarios.usuario AS nome_responsavel 
        FROM eventos 
        JOIN locais ON eventos.local_id = locais.id 
        JOIN usuarios ON eventos.usuario_id = usuarios.id
        ORDER BY data_evento ASC, hora_inicio ASC";

$resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Agenda de Eventos</title>
</head>

<body>
    <h1>Agenda de Eventos</h1>

    <a href="eventos_adicionar.php">+ Novo Agendamento</a>
    <a href="area_restrita.php"> | Voltar ao Início</a>
    <br><br>

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
                    // Formatar a data para o padrão brasileiro (Dia/Mês/Ano)
                    $data_formatada = date('d/m/Y', strtotime($evento['data_evento']));

                    // Formatar a hora (apenas Hora:Minuto)
                    $hora_inicio = date('H:i', strtotime($evento['hora_inicio']));
                    $hora_fim = date('H:i', strtotime($evento['hora_termino']));

                    echo "<tr>";
                    echo "<td>" . $data_formatada . "</td>";
                    echo "<td>" . $hora_inicio . " às " . $hora_fim . "</td>";
                    echo "<td>" . $evento['titulo'] . "</td>";
                    echo "<td>" . $evento['nome_local'] . "</td>"; // Nome vindo do JOIN
                    echo "<td>" . $evento['nome_responsavel'] . "</td>"; // Nome vindo do JOIN
                    echo "<td>
                            <a href='#'>Editar</a> | 
                            <a href='eventos_excluir.php?id=" . $evento['id'] . "' onclick='return confirm(\"Tem certeza?\")'>Excluir</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nenhum evento agendado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>