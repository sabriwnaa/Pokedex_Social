<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <link rel="stylesheet" href="style.css">
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
            
                <form action='login.php' method='post'>
                    <h2 class='comando'>Entre na sua conta</h2>
                    <div class='insercao'>
                        <label>E-mail</label>
                        <input type='text' name='email' class='entrada' require>
                    
                    </div>
                    <div class='insercao'>
                        <label>Senha</label>
                        <input type='password' name='senha' class='entrada' require>
                    </div>
                    <div class='grupo_botao'>
                        <input type='submit' name='botao' class='botaoVermelho' value='Entrar'>
                        <a  href='form_add_treinador.php'>Cadastre-se</a>
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