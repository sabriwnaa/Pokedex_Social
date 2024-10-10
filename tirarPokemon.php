<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

// Obtém o ID da pessoa e o número da Pokedex a partir dos parâmetros GET
$id_pessoa = $_SESSION['id']; // ID da pessoa autenticada
$pokedex_number = $_GET['pokedex_number'];

// Conexão com o banco de dados
$db = new mysqli("localhost", "root", "", "pokemons_dataset");

// Verifica se a pessoa realmente possui o Pokémon na coleção
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

// Redireciona de volta para o perfil da pessoa
header("Location: perfilTreinador.php?idTreinador=" . $id_pessoa);
exit;
?>
