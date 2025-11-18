<?php
// 1. INICIAR A SESSÃO (Aula 9, slide 26)
// Sempre a primeira coisa a ser feita!
session_start();

// 2. INCLUIR A CONEXÃO (Aula 9, slide 5)
// Traz a variável $conexao para este script
include('conexao.php');

// 3. PEGAR OS DADOS DO FORMULÁRIO (Aula 3, slide 48)
// Usamos o array associativo $_POST
$usuario_digitado = $_POST['usuario'];
$senha_digitada = $_POST['senha'];

// 4. PREPARAR A CONSULTA SQL (Aula 10, slide 31)
// Vamos buscar o usuário no banco de dados
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario_digitado'";

// 5. EXECUTAR A CONSULTA (Aula 10, slide 31)
$resultado = mysqli_query($conexao, $sql);

// 6. ANALISAR O RESULTADO
// Verificamos se o mysqli_query encontrou algum resultado
if (mysqli_num_rows($resultado) == 1) {
    // Sim, encontrou o usuário. Agora pegamos os dados dele
    $usuario_bd = mysqli_fetch_assoc($resultado);

    // 7. VERIFICAR A SENHA (Conceito do PDF do Projeto)
    // Usamos password_verify() para comparar a senha digitada
    // com o HASH que está salvo no banco de dados.
    
    if (password_verify($senha_digitada, $usuario_bd['senha'])) {
        // 8. SENHA CORRETA!
        // Criamos a sessão (Aula 9, slide 28)
        $_SESSION['usuario_logado'] = $usuario_bd['usuario'];
        $_SESSION['nivel_acesso'] = $usuario_bd['nivel_acesso'];

        // Redirecionamos para a área restrita
        header('Location: area_restrita.php');
        exit;

    } else {
        // Senha incorreta
        echo "Senha incorreta.";
        // (Aqui poderíamos redirecionar de volta com uma msg de erro)
        // header('Location: login.php?erro=senha');
        // exit;
    }

} else {
    // Usuário não encontrado
    echo "Usuário não encontrado.";
    // (Aqui também redirecionaríamos)
    // header('Location: login.php?erro=usuario');
    // exit;
}

// 9. FECHAR A CONEXÃO (Aula 10, slide 33)
mysqli_close($conexao);

?>