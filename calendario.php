<?php
session_start();
// Verificação de segurança básica
if (!isset($_SESSION['usuario_logado'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Calendário de Eventos</title>
    <link rel="stylesheet" href="style.css">

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    
    <style>
        /* Ajuste para o calendário não ficar gigante */
        #calendar {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff; /* Fundo branco para contraste */
            color: #1a1a2e; /* Texto escuro */
            padding: 20px;
            border-radius: 8px;
        }
        /* Ajustar cor dos botões do calendário para combinar com nosso tema */
        .fc-button-primary {
            background-color: #e94560 !important;
            border-color: #e94560 !important;
        }
    </style>
</head>
<body>

    <div class="menu-container" style="margin-bottom: 20px;">
        <h1>Calendário de Eventos</h1>
        <a href="area_restrita.php" class="btn-menu">Voltar ao Painel</a>
        <a href="eventos_adicionar.php" class="btn-menu">+ Novo Evento</a>
    </div>

    <div id='calendar'></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pega o elemento div pelo ID (Conceito da Aula 12 - Manipulação DOM)
            var calendarEl = document.getElementById('calendar');

            // Inicializa o FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Começa na visão de Mês
                locale: 'pt-br',             // Traduz para Português
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia'
                },
                
                // AQUI É O PULO DO GATO: Conecta com a sua API PHP!
                events: 'api_eventos.php', 
                
                // Quando clicar num evento (Extra: mostrar detalhes)
                eventClick: function(info) {
                    alert('Evento: ' + info.event.title);
                    // Você poderia redirecionar para editar:
                    // window.location.href = 'eventos_editar.php?id=' + info.event.id;
                }
            });

            calendar.render(); // Desenha o calendário na tela
        });
    </script>

</body>
</html>