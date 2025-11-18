<?php
session_start();
include('conexao.php');

// Segurança: Apenas logados podem ver relatórios
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}

// Busca todos os eventos ordenados por data
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
    <title>Relatório de Eventos</title>

    <style>
        /* CSS Específico para Relatório (Visual Limpo) */
        body {
            font-family: Arial, sans-serif;
            color: #000;
            /* Texto preto para impressão */
            background-color: #fff;
            /* Fundo branco */
            padding: 20px;
        }

        h1 {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f0f0f0;
            /* Cinza claro */
        }

        /* Ocultar botões na hora da impressão */
        @media print {
            .no-print {
                display: none;
            }
        }

        .btn-imprimir {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .btn-voltar {
            background-color: #666;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn-imprimir">🖨️ Imprimir Relatório</button>
        <a href="area_restrita.php" class="btn-voltar">Voltar ao Sistema</a>
    </div>

    <h1>Relatório Geral de Agendamentos</h1>
    <p>Gerado em: <?php echo date('d/m/Y H:i'); ?> | Por: <?php echo $_SESSION['usuario_logado']; ?></p>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Horário</th>
                <th>Evento</th>
                <th>Local</th>
                <th>Responsável</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($evento = mysqli_fetch_assoc($resultado)) {
                    $data = date('d/m/Y', strtotime($evento['data_evento']));
                    $hora = date('H:i', strtotime($evento['hora_inicio'])) . ' - ' . date('H:i', strtotime($evento['hora_termino']));

                    echo "<tr>";
                    echo "<td>" . $data . "</td>";
                    echo "<td>" . $hora . "</td>";
                    echo "<td>" . $evento['titulo'] . "</td>";
                    echo "<td>" . $evento['nome_local'] . "</td>";
                    echo "<td>" . $evento['nome_responsavel'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum registro encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>

</html>