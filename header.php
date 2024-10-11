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
                $cor = 'amarelo';
                if (in_array($inicial, ['A', 'B', 'C', 'D', 'E', 'F'])){
                    $cor = 'azul';
                } 
                if (in_array($inicial, ['G', 'H', 'I', 'J', 'K', 'L'])) {
                    $cor = 'vermelho';
                } 
                if (in_array($inicial, ['M', 'N', 'O', 'P', 'Q', 'R'])) {
                    $cor = 'verde';
                }

                ?>
                <a href='perfilTreinador.php?idTreinador=<?php echo $_SESSION['id']; ?>' class='inicial <?php echo $cor;?>'><?php echo $inicial; ?></a>
                <p><?php echo $email_cabecalho; ?></p>
            </div>
            <a class='titulo' href='restrita.php'>A Pokedex Social</a>
            <a class='botaoVerde' href='todos_treinadores.php'>Todos os treinadores</a>
            
            <a class='botaoAmarelo' href='logout.php'>Sair</a>
        </div>
    
</body>
</html>