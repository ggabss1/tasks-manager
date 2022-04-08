<?php
//inclui arquivo de conexão
 require_once 'conexao.php';
//inicia sessão do usuário
 session_start();
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href='includes/notepad.jpg'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Cadastro - Tasks Manager</title>
</head>
<body>
    <!-- formulário de cadastro -->
<form action="#" method="post">
    <!-- se tentou criar usuário e obteve erro na senha já volta preenchido -->
    <span>Usuário</span><br>
    <?php if(!empty($_SESSION['tmp_us'])){?>
        <input type="text" name="usuario" value="<?=$_SESSION['tmp_us'];?>" required><br>
    <!-- se não, o usuário deve preencher -->
    <?php }else{?>
        <input type="text" name="usuario" autocomplete="off" required><br>
    <?php } ?>
    <!-- se tentou criar usuário e obteve erro na senha já volta preenchido -->
    <span>E-mail</span><br>
    <?php if(!empty($_SESSION['tmp_em'])){?>
        <input type="email" name="email" value="<?=$_SESSION['tmp_em'];?>" required><br>
    <!-- se não, o usuário deve preencher -->
    <?php }else{?>
        <input type="email" name="email" required><br>
    <?php } ?>
    <!-- campo da senha -->
    <span>Senha</span><br>
    <input type="password" name="senha" required><br>
    <!-- campo da confirmação da senha -->
    <span>Confirme a senha</span><br>
    <input type="password" name="confirmacao" required><br><br>
    <!-- botão de cadastro -->
    <input type="submit" name="Cadastrar" value="Cadastrar"><br>
</form>
<!-- botão de voltar -->
<a href="index.php"><button>Voltar</button></a>
</body>
</html>
 <?php
 //se o usuário já tentou criar e obteve o erro de senha e confirmção, exclui da sessão os dados armazenados temporariamente
 if(!empty($_SESSION['tmp_us']) && !empty($_SESSION['tmp_em'])){
    unset($_SESSION['tmp_us']);
    unset($_SESSION['tmp_em']);
 }
 //usuário apertou o botão cadastrar
 if(isset($_POST['Cadastrar'])){
     //pega todos os dados que o usuário passou
     $us = $_POST['usuario'];
     $em = $_POST['email'];
     $sn = $_POST['senha'];
     $cf = $_POST['confirmacao'];
     //busca no banco se já existe um usuário com esse nome
    $query = pg_query($connect,"SELECT * FROM USERS WHERE USUARIO = '$us'");
    $resultado = pg_fetch_array($query);
    //se sim, exibe uma mensagem na tela e recarrega a página
    if(!empty($resultado)){
        echo "<script>
        alert('O usuário $us já está sendo utilizado'); 
        window.location.replace('cadastro.php')
        </script>";
    }
    //pega no banco se há existe um usário com essa senha
    $query = pg_query($connect,"SELECT * FROM USERS WHERE EMAIL = '$em'");
    $resultado = pg_fetch_array($query);
    // se sim, exibe uma mensagem na tela e recarega a página
    if(!empty($resultado)){
        echo "<script>
        alert('O e-mail $em já está sendo utilizado por outro usuário'); 
        window.location.replace('cadastro.php')
        </script>";
    }
    //se a senha e a confirmação da senha forem diferentes
    if($sn != $cf){
        //armazena usuario e email para preencher automaticamente na próxima tentativa
        $_SESSION['tmp_us'] = $us;
        $_SESSION['tmp_em'] = $em;
        //mostra mensagem de erro na tela
        echo "<script>
        alert('As senhas não conferem, tente novamente'); 
        window.location.replace('cadastro.php')
        </script>";
    //se está tudo correto, faz o cadastro
    }else{
        //criptografa a senha
        $sn = md5($sn);
        //insere dados de cadastro no banco
        $query = pg_query($connect,"INSERT INTO USERS(USUARIO, EMAIL, SENHA) VALUES('$us', '$em', '$sn')");
        //mostra mensagem de sucesso e redireciona para o login, que já ira com o usuário preenchido
        echo "<script>
        alert('Cadastro realizado!'); 
        window.location.href='index.php?us=$us'
        </script>";
    }
}