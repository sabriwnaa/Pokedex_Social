<?php

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: restrita.php');
    exit;
}

$db = new mysqli("localhost", "root", "", "pokemons_dataset");

// Inicializar variável de pesquisa
$pesquisar = "";

// Verificar se o campo de pesquisa foi preenchido no método POST
if (isset($_POST['pesquisar'])) {
    $pesquisar = $_POST['pesquisar'];
    $sql = "SELECT * FROM pessoa WHERE email LIKE '%$pesquisar%'";
} else {
    $sql = "SELECT * FROM pessoa";
}

$resultado = $db->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Treinadores</title>
</head>
<body>
<h1>Todos os Treinadores</h1>
<form action="todos_treinadores.php" method="post">
    <input type="text" name="pesquisar" class="pesquisar" placeholder="Pesquisar" value="<?php echo htmlspecialchars($pesquisar); ?>">
    <button type="submit">Filtrar</button>
</form>

<?php
if ($resultado->num_rows > 0) {
    while($row = $resultado->fetch_assoc()) {
        $id_pessoa = $row['id_pessoa'];
        echo "<a href='perfilTreinador.php?idTreinador={$row["id_pessoa"]}'> Email: " . $row["email"] . "</a> <br>";
    }
} else {
    echo "Nenhum resultado encontrado.";
}
?>

</body>
</html>