<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$id_pessoa = $_SESSION['id']; 
$pokedex_number = $_GET['pokedex_number'];

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

$checkQuery = "SELECT * FROM pessoa_pokemon WHERE id_pessoa = ? AND pokedex_number = ?";
$checkStmt = $db->prepare($checkQuery);
$checkStmt->bind_param("ii", $id_pessoa, $pokedex_number);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

$deleteQuery = "DELETE FROM pessoa_pokemon WHERE id_pessoa = ? AND pokedex_number = ?";
$deleteStmt = $db->prepare($deleteQuery);
$deleteStmt->bind_param("ii", $id_pessoa, $pokedex_number);
$deleteStmt->execute();

$deleteStmt->close();
$checkStmt->close();
$db->close();

header("Location: perfilTreinador.php?idTreinador=" . $id_pessoa);
exit;
?>
