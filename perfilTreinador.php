<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$id_pessoa = $_GET['idTreinador'];

if($_SESSION['id'] == $id_pessoa){
    $isMyProfile = true;
}

$db = new mysqli('localhost', 'root', '', 'pokemons_dataset');

// Verifica se o usuário já votou
$stmt = $db->prepare("SELECT * FROM pessoa p WHERE p.id_pessoa = ?");
$stmt->bind_param('i', $id_pessoa);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Treinador</title>
</head>
<body>
    


</body>
</html>