<?php
// Se não veio do formulário, volta para a página inicial
if(!isset($_POST['botao'])){
    header("location: index.php");
}

$email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
$senha = htmlspecialchars($_POST['senha']);

$db = new mysqli("localhost","root","","votacao");

$stmt = $db->prepare("select * from pessoa where email = ?");
$stmt->bind_param("s",$email);

$stmt->execute();

/* Quando há retorno, busca-se o resultado
    Retorna um objeto mysqli
    https://www.php.net/manual/pt_BR/mysqli-stmt.get-result.php
*/
$resultado = $stmt->get_result();
//armazena resultado encontrado de um select em uma variavel

// Se não tem resultados
if($resultado->num_rows==0){
    // Redireciona para a página inicial
    header("location: index.php");
}else{
    // Transforma um objetivo mysqli em um array associativo
    // Usa-se quando tem um resultado apenas
    // https://www.php.net/manual/pt_BR/mysqli-result.fetch-assoc.php
    $pessoa = $resultado->fetch_assoc();
    //fetch assoc = quando tiver só um resultado, sem paramtero nenhum

    // Verifica se a senha é igual a senha criptografada
    if(password_verify($senha,$pessoa['senha'])){
        // Inicia sessão
        session_start();
        // Cria uma variável de sessão
        $_SESSION['id'] = $pessoa['id'];
        //dá para adicionar qualquer variavel e informação dentro da session, que é um array qualquer
        //_SESSION['email'] = $pessoa['email'] -> se quiser exibir o email no cabecalho
        //Redireciona para área restrita
        
        header("location: restrita.php");
        
       
    }else{
        //Redireciona para a página inicial
        header("location: index.php");
    }
}