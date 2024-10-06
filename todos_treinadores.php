<?php

session_start();
if (!isset($_SESSION['id'])) {
    header('Location: restrita.php');
    exit;
}

$id_pessoa = $_SESSION['id'];

$db = new mysqli("localhost","root","","pokemons_dataset");

$sql = "select * from pessoa";

$resultado = $db->query($sql);

if ($resultado->num_rows > 0) {
    
    while($row = $resultado->fetch_assoc()) {
        echo "<a href='perfilTreinador.php?idTreinador={$row["id_pessoa"]}'> email: " . $row["email"]."</a> <br>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Treinadores</title>
</head>
<body>
    
<h1>Treinadores</h1>
<?php

while($treinador = $resultado->fetch_assoc()){
    echo $treinador['email'];
    echo "<br>";
}
?>


</body>
</html>