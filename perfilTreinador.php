<?php

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: restrita.php');
    exit;
}

$id_pessoa = $_GET['idTreinador'];

$db = new mysqli('localhost', 'root', '', 'pokemons_dataset');

// Verifica se o usuário já votou
$stmt = $db->prepare("SELECT * FROM pessoa p WHERE p.id_pessoa = ?");
$stmt->bind_param('i', $id_pessoa);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>