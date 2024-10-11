<?php
    $erro_email = "";

    if(isset($_POST['botao'])){
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $senha = htmlspecialchars($_POST['senha']);

        // Conexão com o banco de dados
        $db = new mysqli('localhost', 'root', '', 'pokemons_dataset');

        // Verifica se o email é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Por favor, insira um endereço de e-mail válido.";
        } else {
            // Verifica se o email já existe no banco de dados
            $stmt = $db->prepare("SELECT email FROM pessoa WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $erro_email = "Este e-mail já foi registrado. Por favor, use um e-mail diferente.";
            } else {
                // Se o email for válido e não existir, insere o novo usuário
                $password_hash = password_hash($_POST['senha'], PASSWORD_BCRYPT);
                $stmt = $db->prepare("INSERT INTO pessoa (email, senha) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $password_hash);
                $stmt->execute();

                header("Location: index.php");
                exit();
            }
        }
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar-se</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class='container'>
        <header>
            <h1>A Pokedex Social</h1>
        </header>
        <div class='borda'>
            <div class='containerElementos'>
                <div class='bolinha'></div><div class='bolinha'></div>
            </div>
            <div class='box'>
                <form method='post' action='form_add_treinador.php'>
                    <h1 class='comando'>Cadastrar-se</h1>
                    <div class='insercao'>
                        <label>E-mail:</label>
                        <input type='email' name='email' class='entrada' required>
                        <div class="erro">
                            <!-- Exibe a mensagem de erro caso haja -->
                            <?php if ($erro_email) echo "<p style='color: red;'>$erro_email</p>"; ?>
                        </div>
                    </div>
                    <div class='insercao'>
                        <label>Senha:</label>
                        <input type='password' name='senha' class='entrada' required>
                    </div>
                    <div class='grupo_botao'>
                        <input type='submit' name='botao' class='botaoVermelho' value='Cadastrar'>
                        <a href='index.php'>Voltar</a>
                    </div>
                </form>
            </div>
        </div>
        <div class='footer'>
            <h3>Sabrina Hahn Melo, Gabriel Klafke Teixeira e Ana Ariel Avila Escobar - 3TI - Programação III</h3>
        </div>
    </div>
</body>
</html>
