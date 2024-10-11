<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
}

$id_pessoa = $_SESSION['id'];

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'Name'; // Ordenação por nome por padrão
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

$query = "SELECT * FROM pokemon p 
          WHERE p.Pokedex_number NOT IN ( 
          SELECT pp.pokedex_number 
          FROM pessoa_pokemon pp 
          WHERE pp.id_pessoa = ?)
          ORDER BY $sort_column $sort_order";

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
    <title>A Pokedex Social</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class='container'>

        <?php include 'header.php'; ?>

        <div class='main'>
            <div class='cabecalho'>
                <h2>Pokémons fora da sua coleção</h2>

                <div class="dropdown">
                    <button class="botaoVermelho">Ordenar Pokémons</button>
                    <div class="dropdown-content">
                        <a href="?sort_column=Attack&sort_order=ASC">Ordenar Ataque Crescente</a>
                        <a href="?sort_column=Attack&sort_order=DESC">Ordenar Ataque Decrescente</a>
                        <a href="?sort_column=Defense&sort_order=ASC">Ordenar Defesa Crescente</a>
                        <a href="?sort_column=Defense&sort_order=DESC">Ordenar Defesa Decrescente</a>
                    </div>
                </div>
            </div>

            <div class='listagem'>
                <?php while ($pokemon = $resultado->fetch_assoc()) { ?>
                    <div class='pokemon'>
                        <h2><?php echo $pokemon['Name']; ?></h2>
                        <div class='informacoes'>
                            <p><strong>Ataque:</strong> <?php echo $pokemon['Attack']; ?></p>
                            <p><strong>Defesa:</strong> <?php echo $pokemon['Defense']; ?></p>
                            <p><strong>Número da Pokedex:</strong> <?php echo $pokemon['Pokedex_number']; ?></p>
                            <p><strong>Tipo:</strong> <?php echo $pokemon['Type']; ?></p>
                            <p><strong>Legendário:</strong> <?php echo $pokemon['Is_legendary'] ? 'Yes' : 'No'; ?></p>
                        </div>
                        <a class='botaoVerde' href="add_pokemon.php?pokedex_number=<?php echo $pokemon['Pokedex_number']; ?>">Adicionar pokémon</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
