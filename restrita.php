<?php
session_start();
if(!isset($_SESSION['id'])){
    header("location: index.php");
    exit;
}


$id_pessoa = $_SESSION['id'];

    $db = new mysqli("localhost", "root", "", "pokemons_dataset");

    $stmt = $db->prepare("SELECT email FROM pessoa WHERE id_pessoa = ?");
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pessoa = $resultado->fetch_assoc();
    
    $stmt = $db->prepare("select * from pokemon");
    $stmt->execute();
    $resultado = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A pokedex Social</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h1>A Pokedex Social</h1>
        </div>

        <div class='main' style='flex-direction:column;'>
            <div class='cabecalhoOpcoes'>  
                <a class='meuPerfil' href='minha_colecao.php'>S</a>
                <a class='botao' href='todos_treinadores.php'>Todos os treinadores</a>

          
            </div>
          <div class='opcoes'>

            </div>
        </div>

        <div class='footer'>
            <a class='botao' style='text-decoration: none;' href='logout.php'>Sair</a>
        </div>

    
    </div>
</body>
</html>