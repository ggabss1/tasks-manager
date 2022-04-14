<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href='includes/notepad.jpg'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Home - Tasks Manager</title>
</head>
<?php
//inclui arquivo de conexão com o banco de dados
require_once 'conexao.php';
//inicia a sessão
session_start();
//define o 'fuso horário' brasileiro como padrão
date_default_timezone_set('America/Sao_Paulo');
//pega a data de hoje
$hoje = date("Y-m-d");
//se ele tiver acabo de logar
if(!empty($_POST['user'])){
    //armazena o usuário na variável
    $usuario = $_POST['user'];
    //armazena o usuário na sessão
    $_SESSION['usuario'] = $usuario;
    //armazena a senha na variável
    $senha = $_POST['password'];
    //criptografa a senha 
    $senha = md5($senha);
    //verifica no banco de dados se a senha está correta para esse usuário
    $query = pg_query($connect,"SELECT * FROM USERS WHERE USUARIO = '$usuario' AND SENHA = '$senha'");
    $resultado = pg_fetch_array($query);
    //se sim, define o parâmetro 'logado', na sessão
    if(!empty($resultado)){
    $_SESSION['logado'] = 'SIM';    
    //se não, dá um alerta ao usuário e redireciona para a página de login    
    }else{
    echo "<script> alert('Usuário e/ou senha incorretos'); window.location.replace('index.php')</script>";
    }
}
//armazena o usuário em uma variável pra acessar mais fácil
$usuario = $_SESSION['usuario'];
//se o usuário tentar acessar a página sem estar logado é redirecionado para a página de login
if(empty($_SESSION['logado'])){
    echo "<script>window.location.replace('index.php')</script>";
}
//se o usuário apertou o botão para desconectar
if(isset($_POST['Desconectar'])){
    //encerra a sessão
    session_destroy();
    //redireciona para a página de login
    echo "<script>window.location.replace('index.php')</script>";
}
//se o usuário apertou o botão de excluir perfil
if(isset($_GET['Excluir_Perfil'])){
    //exibe uma mensagem pedindo se o usuário realmente quer excluir o perfil
    echo "<form action='#' method='GET'>
    <span>Tem certeza que deseja excluir seu perfil?</span><br>
    <input type='submit' value='Sim' name='Sim'>
    <input type='submit' value='Não' name='Nao'>
    </form>";
}
//se o usuário confirmar a exclusão
if(isset($_GET['Sim'])){
    //pega o nome do usuário na sessão
    $usr = $_SESSION['usuario'];
    //deleta os registros no banco
    $query = pg_query($connect,"DELETE FROM USERS WHERE USUARIO = '$usr'");
    $query = pg_query($connect,"DELETE FROM TASKS WHERE USUARIO = '$usr'");
    //encerra a sessão
    session_destroy();
    //redireciona para a página de login
    echo "<script>window.location.replace('index.php')</script>";
}elseif(isset($_GET['Nao'])){
    //se não, apenas recarrega a página
    echo "<script>window.location.replace('home.php')</script>";
}
?>
<body>
<!-- a ideia seria criar uma espécie de menu com essas duas opções, desconectar e excluir perfil -->
<form action="#" method="post"><input type='submit' value='Desconectar' name='Desconectar'></form>
<form action="#" method="GET"><input type='submit' value='Excluir Perfil' name='Excluir_Perfil'></form>
<!--  -->
<!-- esse botão leva até a tela de criação de tarefa -->
<a href='criar.php'><button>Criar tarefa</button></a>
<?php
//busca no banco tasks pendentes com prazo de hoje
    $queryhj = pg_query($connect,"SELECT * FROM TASKS WHERE USUARIO = '$usuario' AND STATUS = 'PENDENTE' AND PRAZO = '$hoje' ORDER BY ID ASC");
    $resultadohj = pg_fetch_all($queryhj);
//busca no banco tasks pendentes com prazo de hoje
    $query = pg_query($connect,"SELECT * FROM TASKS WHERE USUARIO = '$usuario' AND STATUS = 'PENDENTE' AND PRAZO != '$hoje' ORDER BY ID ASC");
    $resultado = pg_fetch_all($query);
?>
<!-- div 1 aqui serão mostradas apenas as tasks pendentes, se não existir mostra mensagem -abrange as outras duas divs- -->
<?php
//verifica se não há registros
if(empty($resultadohj) AND empty($resultado)){
?>
<!-- mensagem dizendo que não existe nenhuma task pendente -->
<?php
    //se houverem registros, mostra-os    
        }else{?>
<!-- div 2 aqui serão mostradas apenas as tasks pendentes com prazo hoje, se não existir mostra mensagem -->
<?php
//enquanto exisitirem registros com prazo = hoje
foreach($resultadohj as $value){
//titulo
$titulo=$value['titulo'];
//id
$id=$value['id'];
?>
<!-- só vai exibir título e um botão para acessar os detalhes -->
<form method='get' action='editar.php'><input type='hidden' value='<?=$id;?>' name='id'><button type='submit'>Detalhes</button></form>
<?php
}

?>
<!-- div 3 aqui serão mostradas as tasks pendentes com prazo de outros dias, se não existir mostra mensagem  -->
<?php
//enquanto existirem resultados pendentes
foreach($resultado as $value){
//titulo
$titulo=$value['titulo'];
//id
$id=$value['id'];
//data
$data=$value['prazo'];
//data convertida
$conv = date('d/m/Y',strtotime($data));
?>
<!-- só vai exibir título, data e botão para acessar detalhe -->
<form method='get' action='editar.php'><input type='hidden' value='<?=$id;?>' name='id'><button type='submit'>Detalhes</button></form>
<?php
}
}
?>
<!-- esse botão leva até a tela de tasks concluídas -->
<a href='concluidas.php'><button>Tarefas concluídas</button></a>
</body>
</html>
<?php
