<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$id_pessoa = $_GET['idTreinador'];

$isMyProfile = false;
if ($_SESSION['id'] == $id_pessoa) {
    $isMyProfile = true;
}

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

// Busca o email da pessoa
$emailQuery = "SELECT email FROM pessoa WHERE id_pessoa = ?";
$emailStmt = $db->prepare($emailQuery);
$emailStmt->bind_param("i", $id_pessoa);
$emailStmt->execute();
$emailResult = $emailStmt->get_result();
$pessoa = $emailResult->fetch_assoc();
$email_pessoa = $pessoa['email']; // Armazena o email

// Busca os Pokémons da coleção da pessoa
$query = "SELECT p.* FROM pokemon p 
           JOIN pessoa_pokemon pp 
          ON p.Pokedex_number = pp.pokedex_number 
          WHERE pp.id_pessoa = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id_pessoa);
$stmt->execute();
$resultado = $stmt->get_result();
$pokemonCount = $resultado->num_rows; // Conta quantos Pokémons foram encontrados
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
            <?php include 'header.php'; // Inclui o cabeçalho ?>
        </div>

        <div class='main'>
            <?php if($isMyProfile){
                echo "<h2>Meu perfil</h2>";
            } ?>
            <h2><?php echo ($email_pessoa); ?></h2>
            <h1>Coleção de Pokémons</h1>

            <div class='listagem'>
                <?php if ($pokemonCount > 0) { // Verifica se a pessoa tem Pokémons ?>
                    <?php while ($pokemon = $resultado->fetch_assoc()) { ?>
                        <div class='pokemon'>
                            <h2><?php echo htmlspecialchars($pokemon['Name']); ?></h2>
                            <p><strong>Ataque:</strong> <?php echo htmlspecialchars($pokemon['Attack']); ?></p>
                            <p><strong>Defesa:</strong> <?php echo htmlspecialchars($pokemon['Defense']); ?></p>
                            <p><strong>Número da Pokedex:</strong> <?php echo htmlspecialchars($pokemon['Pokedex_number']); ?></p>
                            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($pokemon['Type']); ?></p>
                            <p><strong>Legendário:</strong> <?php echo $pokemon['Is_legendary'] ? 'Sim' : 'Não'; ?></p>
                            <?php if($isMyProfile){
                                echo "<a href='tirarPokemon.php?pokedex_number={$pokemon["Pokedex_number"]}'>Excluir Pokemon da minha coleção</a>";
                            } ?>
                        </div>
                    <?php } ?>
                <?php } else { // Se não houver Pokémons ?>
                    <h2>Este usuário ainda não tem Pokémons em sua coleção.</h2>
                <?php } ?>
            </div>
            
        </div>

        <div class='footer'>
            <!-- Você pode adicionar conteúdo para o rodapé aqui -->
        </div>
    </div>

    <?php
    // Fecha a conexão
    $emailStmt->close(); // Fecha a consulta de email
    $stmt->close(); // Fecha a consulta de Pokémon
    $db->close(); // Fecha a conexão com o banco de dados
    ?>
</body>
</html>
