<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
}

if (!isset($_GET['pokedex_number'])) {
    echo "Pokémon não especificado.";
    exit;
}

$id_pessoa = $_SESSION['id'];
$pokedex_number = $_GET['pokedex_number'];

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

$query = "INSERT INTO pessoa_pokemon (id_pessoa, pokedex_number) VALUES (?, ?)";
$stmt = $db->prepare($query);
$stmt->bind_param("ii", $id_pessoa, $pokedex_number);

if ($stmt->execute()) {
    header("Location: restrita.php");
} else {
    echo "Erro ao adicionar Pokémon à coleção.";
}

$stmt->close();
$db->close();
?>
