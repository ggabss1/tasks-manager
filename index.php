<?php
//inclui arquivo de conexão com o banco de dados
require_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href='includes/notepad.jpg'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Login - Tasks Manager</title>
</head>
<body>
    <!-- divo bloco inteiro -->
    <div class='form-block'>
        <!-- div do formulario -->
        <div class='form'>
            <img src='includes/notepad.jpg' width="50">
            <form action="home.php" method="post">
                <span class='form-span'>Usuário</span><br>
                <?php
                //se está vindo da página de cadastro, já preenche o usuário 
                if(!empty($_GET['us'])){?>
                    <input type='text' name='user' value="<?=$_GET['us'];?>"><br>
                <?php }else{ ?>
                    <input type='text' name='user'><br>
                <?php } ?>
                <span class='form-span'>Senha</span><br>
                <!-- input da senha     -->
                    <input type='password' name='password'><br>
                <!-- botão que faz o login -->
                <button style="margin: 5px 5px 5px 5px; max-width: 80%;" type="submit">Acessar</button>
            </form>
        </div>
        <!-- div do acesso ao cadastro -->
        <div>
            <hr>
            <!-- link para acessar a página de cadastro -->
            <span style="font-family:-apple-system Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif" class='form-span'> Novo por aqui? <a style="color:white;" href='cadastro.php'>Cadastre-se</a></span>
        </div>  
    </div>
</body>
</html>