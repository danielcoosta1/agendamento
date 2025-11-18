<?php
session_start();
include('conexao.php');

// Só logado pode ver (segurança da API)
if (!isset($_SESSION['usuario_logado'])) {
    http_response_code(401); // Não autorizado
    exit;
}

// Buscar todos os eventos
$sql = "SELECT eventos.id, eventos.titulo, eventos.data_evento, eventos.hora_inicio, eventos.hora_termino, locais.nome AS nome_local 
        FROM eventos 
        JOIN locais ON eventos.local_id = locais.id";

$resultado = mysqli_query($conexao, $sql);

$eventos_json = [];

while ($row = mysqli_fetch_assoc($resultado)) {
    // O FullCalendar espera um formato específico de objeto:
    // { title: '...', start: '2023-10-27T14:00:00', end: '...' }
    
    $eventos_json[] = [
        'id' => $row['id'],
        'title' => $row['titulo'] . ' (' . $row['nome_local'] . ')',
        'start' => $row['data_evento'] . 'T' . $row['hora_inicio'],
        'end'   => $row['data_evento'] . 'T' . $row['hora_termino'],
        'color' => '#e94560' // Cor do evento (pode ser dinâmica depois)
    ];
}

// Define que a resposta é JSON (igual ao seu backend Node.js)
header('Content-Type: application/json');
echo json_encode($eventos_json);
?>