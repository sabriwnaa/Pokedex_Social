<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
   
</head>
<body>
        <div class='header'>
            <div class='perfil'>
                <?php 
                $email_cabecalho = $_SESSION['email']; 
                $inicial = strtoupper($email_cabecalho[0]);
                ?>
                <a href='perfilTreinador.php?idTreinador=<?php echo $_SESSION['id']; ?>' class='inicial'><?php echo $inicial; ?></a>
                <p><?php echo $email_cabecalho; ?></p>
            </div>
            <a class='titulo' href='restrita.php'>A Pokedex Social</a>
            <a class='botaoAmarelo' href='todos_treinadores.php'>Todos os treinadores</a>
            
            <a class='botaoVermelho' href='logout.php'>Sair</a>
        </div>
    
</body>
</html>