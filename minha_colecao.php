<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit;
}

$id_pessoa = $_SESSION['id'];
$email_pessoa = $_SESSION['email']; // Certifique-se de que o email foi salvo na sessão no login

// Pega a inicial do email
$inicial = strtoupper($email_pessoa[0]);

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

// Verifica se a conexão foi bem-sucedida
if ($db->connect_error) {
    die("Erro de conexão: " . $db->connect_error);
}

// Busca os Pokémons da coleção da pessoa
$query = "SELECT p.* FROM pokemon p 
          INNER JOIN pessoa_pokemon pp 
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
    <style>
        /* Estilos para o círculo com a inicial */
        .perfil {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .inicial {
            width: 50px;
            height: 50px;
