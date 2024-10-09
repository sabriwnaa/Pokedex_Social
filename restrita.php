<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
}

$id_pessoa = $_SESSION['id'];

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

// Parâmetros de ordenação
$sort_column = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'Attack';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Modificação da query para incluir a ordenação
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
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
        <?php
        include 'header.php'; // Inclui o cabeçalho
        ?>

        </div>

        <div class='main'>
            
                <div class="dropdown">
                    <button class="dropbtn">Ordenar Pokémons</button>
                    <div class="dropdown-content">
                        <a href="?sort_column=Attack&sort_order=ASC">Ordenar Ataque Crescente</a>
                        <a href="?sort_column=Attack&sort_order=DESC">Ordenar Ataque Decrescente</a>
                        <a href="?sort_column=Defense&sort_order=ASC">Ordenar Defesa Crescente</a>
                        <a href="?sort_column=Defense&sort_order=DESC">Ordenar Defesa Decrescente</a>
                    </div>
                </div>

            <div class='listagem'>
                <?php while ($pokemon = $resultado->fetch_assoc()) { ?>
                    <div class='pokemon'>
                        <h2><?php echo $pokemon['Name']; ?></h2>
                        <p><strong>Ataque:</strong> <?php echo $pokemon['Attack']; ?></p>
                        <p><strong>Defesa:</strong> <?php echo $pokemon['Defense']; ?></p>
                        <p><strong>Número da Pokedex:</strong> <?php echo $pokemon['Pokedex_number']; ?></p>
                        <p><strong>Tipo:</strong> <?php echo $pokemon['Type']; ?></p>
                        <p><strong>Legendário:</strong> <?php echo $pokemon['Is_legendary'] ? 'Yes' : 'No'; ?></p>
                        <a href="add_pokemon.php?pokedex_number=<?php echo $pokemon['Pokedex_number']; ?>">Adicionar Pokemon à minha coleção</a>

                    </div>
                <?php } ?>
            </div>
        </div>

        <div class='footer'>
            <a class='botao' style='text-decoration: none;' href='logout.php'>Sair</a>
        </div>
    </div>
</body>
</html>
