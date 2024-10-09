<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
}

// Verifica se o número da Pokedex foi passado na URL
if (!isset($_GET['pokedex_number'])) {
    echo "Pokémon não especificado.";
    exit;
}

$id_pessoa = $_SESSION['id'];
$pokedex_number = $_GET['pokedex_number'];

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

// Prepara e executa a query para inserir na tabela pessoa_pokemon
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
