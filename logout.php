<?php
// 1. Iniciar a sessão (temos de iniciá-la para poder destruí-la)
session_start();

// 2. Destruir TODAS as variáveis da sessão (Aula 9, slide 30)
session_destroy();

// 3. Redirecionar o utilizador de volta para a página de login
header('Location: login.php');
exit;

?>