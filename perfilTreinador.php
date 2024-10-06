<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$id_pessoa = $_SESSION['id'];

if($_SESSION['id'] == $id_pessoa){
    $isMyProfile = true;
}


$db = new mysqli("localhost", "root", "", "pokemons_dataset");

// Busca os Pokémons da coleção da pessoa
$query = "SELECT p.* FROM pokemon p 
           JOIN pessoa_pokemon pp 
          ON p.Pokedex_number = pp.pokedex_number 
          WHERE pp.id_pessoa = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id_pessoa);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Coleção de Pokémons</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
   
</head>
<body>
    <div class='container'>
         <div class='header'>
        <?php
        include 'header.php'; // Inclui o cabeçalho
        ?>

        </div>

        <div class='main'>
            <!-- Exibir perfil com inicial do email e email completo -->
            
            <h1>Minha Coleção de Pokémons</h1>
            <!-- Listagem dos Pokémons -->
            <div class='listagem'>
                <?php while ($pokemon = $resultado->fetch_assoc()) { ?>
                    <div class='pokemon'>
                        <h2><?php echo $pokemon['Name']; ?></h2>
                        <p><strong>Ataque:</strong> <?php echo $pokemon['Attack']; ?></p>
                        <p><strong>Defesa:</strong> <?php echo $pokemon['Defense']; ?></p>
                        <p><strong>Número da Pokedex:</strong> <?php echo $pokemon['Pokedex_number']; ?></p>
                        <p><strong>Tipo:</strong> <?php echo $pokemon['Type']; ?></p>
                        <p><strong>Legendário:</strong> <?php echo $pokemon['Is_legendary'] ? 'Sim' : 'Não'; ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class='footer'>
            
            
        </div>
    </div>

    <?php
    // Fecha a conexão
    $stmt->close();
    $db->close();
    ?>
</body>
</html>
