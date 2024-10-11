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
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class='container'>
        <?php include 'header.php'?>
       
        <div class='main'>
            <div class='containerBotao'>
                <h2>Todos os Treinadores</h2>
                <form action="todos_treinadores.php" method="post">
                    <input type="text" name="pesquisar" class="pesquisar" placeholder="Pesquisar" value="<?php echo htmlspecialchars($pesquisar); ?>">
                </form>
            </div>
            
            <div class='listagemTreinadores'>
                <?php
                $cores = ['azul', 'vermelho', 'verde', 'amarelo'];
                if ($resultado->num_rows > 0) {
                    while($row = $resultado->fetch_assoc()) {
                        $inicialT = strtoupper($row['email'][0]);
                        $corAleatoria = $cores[array_rand($cores)];
                        
                        echo "<a href='perfilTreinador.php?idTreinador={$row["id_pessoa"]}' class='treinador'>";
                            echo "<div class='inicial $corAleatoria'>" . $inicialT . "</div>";
                            echo "<p>" . $row["email"] . "</p>";
                        echo "</a>";
                    }
                } else {
                    echo "Nenhum resultado encontrado.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
