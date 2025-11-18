<?php
session_start();
include('conexao.php'); // 1. Traz a conexão com o banco de dados

// 1. Verificação de Login - Usamos o seu método seguro
if (isset($_SESSION['usuario_logado']) && !empty($_SESSION['usuario_logado'])) {

    $nome_usuario = $_SESSION['usuario_logado'];

    // 2. ID do usuário logado (Usado para o cálculo "Meus Agendamentos")
    $id_usuario = $_SESSION['id_usuario'] ?? 0; // Pega o ID da sessão. 
    // Se não encontrar (?? 0), usa 0 como segurança.

    // 3. BUSCAR MÉTRICAS (Usando a conexão)

    // Contar Total de Eventos (SQL COUNT)
    $res_total = mysqli_query($conexao, "SELECT COUNT(*) as total FROM eventos");
    $total_eventos = mysqli_fetch_assoc($res_total)['total'];

    // Contar Meus Eventos
    $res_meus = mysqli_query($conexao, "SELECT COUNT(*) as total FROM eventos WHERE usuario_id = $id_usuario");
    $meus_eventos = mysqli_fetch_assoc($res_meus)['total'];

    // Contar Locais
    $res_locais = mysqli_query($conexao, "SELECT COUNT(*) as total FROM locais");
    $total_locais = mysqli_fetch_assoc($res_locais)['total'];
} else {
    // Se não estiver logado, redireciona
    header('Location: login.php');
    exit;
}

// Fechamos a conexão aqui, antes do HTML começar
mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS extra só para os cards do dashboard */
        .dashboard-cards {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .card {
            background-color: #0f3460;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            min-width: 150px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        .card h3 {
            margin: 0;
            font-size: 2.5em;
            color: #e94560;
        }

        .card p {
            margin: 5px 0 0;
            color: #a0a0a0;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="menu-container">
        <h1>Painel de Controle</h1>
        <p>Bem-vindo, <strong><?php echo $nome_usuario; ?></strong>!</p>
        <br>

        <div class="dashboard-cards">
            <div class="card">
                <h3><?php echo $total_eventos; ?></h3>
                <p>Total de Eventos</p>
            </div>
            <div class="card">
                <h3><?php echo $meus_eventos; ?></h3>
                <p>Meus Agendamentos</p>
            </div>
            <div class="card">
                <h3><?php echo $total_locais; ?></h3>
                <p>Locais Disponíveis</p>
            </div>
        </div>

        <?php if ($_SESSION['nivel_acesso'] === 'admin'): ?>
            <a href="locais_listar.php" class="btn-menu" style="background-color: #e94560;">Gerenciar Locais</a>
        <?php endif; ?>

        <a href="eventos_listar.php" class="btn-menu">Gerenciar Eventos</a>
        <a href="calendario.php" class="btn-menu">📅 Calendário</a>
        <a href="relatorio_eventos.php" class="btn-menu" target="_blank">📄 Relatório</a>

        <br><br>
        <a href="logout.php" style="color: #888;">Sair do Sistema</a>
    </div>
</body>

</html>