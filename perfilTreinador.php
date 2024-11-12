<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$id_pessoa = $_GET['idTreinador'];
$isMyProfile = $_SESSION['id'] == $id_pessoa;

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

//somar os ataques e junto também contar os Pokémons de um treinador
$soma = 0;
$pokemonList = [];
$query = "SELECT p.* FROM pokemon p 
           JOIN pessoa_pokemon pp 
           ON p.Pokedex_number = pp.pokedex_number 
           WHERE pp.id_pessoa = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id_pessoa);
$stmt->execute();
$resultado = $stmt->get_result();

while ($pokemon = $resultado->fetch_assoc()) {
    $pokemonList[] = $pokemon;
    $soma += $pokemon['Attack'];
}
$pokemonCount = count($pokemonList);

//email do treinador
$emailQuery = "SELECT email FROM pessoa WHERE id_pessoa = ?";
$emailStmt = $db->prepare($emailQuery);
$emailStmt->bind_param("i", $id_pessoa);
$emailStmt->execute();
$emailResult = $emailStmt->get_result();
$pessoa = $emailResult->fetch_assoc();
$email_pessoa = $pessoa['email'];

//cálculo para média de ataque sem dividir divisão por zero
$mediaAtaque = $pokemonCount > 0 ? $soma / $pokemonCount : 0; //net

$emailStmt->close();
$stmt->close();
$db->close();
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
        <?php include 'header.php'; ?>

        <div class='main'>
            <div class='containerBotao'>
                <?php if ($isMyProfile) { ?>
                    <h3>Meu perfil</h3>
                <?php } ?>
                <h2><?php echo htmlspecialchars($email_pessoa); ?></h2>
                <h2><?php echo "Média de ataque: " . number_format($mediaAtaque, 2); ?></h2>
            </div>

            <h1>Coleção de Pokémons</h1>
            <div class='listagem'>
                <?php if ($pokemonCount > 0) { ?>
                    <?php foreach ($pokemonList as $pokemon) { ?>
                        <div class='pokemon'>
                            <h2><?php echo htmlspecialchars($pokemon['Name']); ?></h2>
                            <div class='informacoes'>
                                <p><strong>Ataque:</strong> <?php echo htmlspecialchars($pokemon['Attack']); ?></p>
                                <p><strong>Defesa:</strong> <?php echo htmlspecialchars($pokemon['Defense']); ?></p>
                                <p><strong>Número da Pokedex:</strong> <?php echo htmlspecialchars($pokemon['Pokedex_number']); ?></p>
                                <p><strong>Tipo:</strong> <?php echo htmlspecialchars($pokemon['Type']); ?></p>
                                <p><strong>Legendário:</strong> <?php echo $pokemon['Is_legendary'] ? 'Sim' : 'Não'; ?></p>
                            </div>

                            <?php if ($isMyProfile) { ?>
                                <a class='botaoVermelho' href='tirarPokemon.php?pokedex_number=<?php echo $pokemon["Pokedex_number"]; ?>'>Retirar pokémon</a>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <h2>Este usuário ainda não tem Pokémons em sua coleção.</h2>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
