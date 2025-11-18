<?php
// Aula 10, slide 20: Conexão com o SGBD [cite: 1917-1919]

// 1. Variáveis de Conexão
// (Valores padrão do XAMPP, como visto no slide 21) [cite: 1923]
$servidor = "localhost"; // O servidor que o XAMPP usa
$usuario = "root";       // O utilizador padrão do XAMPP
$senha = "";             // A senha padrão do XAMPP é vazia
$nome_banco = "agendamentos_db"; // O nome da base de dados que criámos

// 2. Criar a Conexão
// A função mysqli_connect() tenta ligar-se à base de dados
$conexao = mysqli_connect($servidor, $usuario, $senha, $nome_banco);

// 3. Checar a Conexão (Aula 10, slide 21) 
if (!$conexao) {
    // Se a conexão falhar, o script para (die) e mostra o erro
    die("Falha na conexão: " . mysqli_connect_error());
}

/* // Opcional: Descomente a linha abaixo SÓ para testar se funcionou
// echo "Conexão estabelecida com sucesso!"; 
*/

?>