<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href='includes/notepad.jpg'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Concluídas - Tasks Manager</title>
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
//armazena o usuário em uma variável pra acessar mais fácil
$usuario = $_SESSION['usuario'];
//se o usuário tentar acessar a página sem estar logado é redirecionado para a página de login
if(empty($_SESSION['logado'])){
    echo "<script>window.location.replace('index.php')</script>";
}
?>
<body>
<?php
//busca no banco tasks concluídas
    $resultado = $conn->prepare("SELECT * FROM TASKS WHERE USUARIO = ? AND STATUS = 'CONCLUÍDA'");
    $resultado->bindParam(1,$usuario);
    $resultado->execute();
    $resultado = $resultado->fetchAll();
//enquanto existirem resultados pendentes
$r=0;
while(!empty($resultado[$r])){
//id
$id=$resultado[$r]['id'];
//titulo
$titulo=$resultado[$r]['titulo'];
//data
$data=$resultado[$r]['prazo'];
//data convertida
$conv = date('d/m/Y',strtotime($data));
//link de acesso
$link = 'editar.php?id='.$id;
?>
<!-- só vai exibir título, data e botão para acessar detalhe -->
<a href='<?=$link;?>'><button>Detalhes</button></a>
<?php
$r++;
}
?>
<!-- botão para voltar à home -->
<a href='home.php'><button>Voltar</button></a>
</body>
</html>