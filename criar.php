<?php
//inclui arquivo de conexão com o banco de dados
require_once 'conexao.php';
//inicia a sessão
session_start();
//define o 'fuso horário' brasileiro como padrão
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href='includes/notepad.jpg'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Criar - Tasks Manager</title>
</head>
<!-- mostrar inputs de titulo, descrição e prazo -->
<!-- botão para salvar -->
<!-- botão para voltar -->
<form action="#" method="post">
    <span>Título</span><br>
    <input type="text" name="titulo" required><br>
    <span>Descrição</span><br>
    <textarea name="descricao"cols="30" rows="10" required></textarea><br>
    <span>Prazo</span><br>
    <input type="date" name="prazo" required><br>
<button type="submit">Salvar</button>
</form>
<a href='home.php'><button>Voltar</button></a>
<?php
//se o formulário fou preenchido
if(!empty($_POST['titulo'])){
    //veririca qual o maior id das tasks
    $query = pg_query($connect,"SELECT max((id)) FROM tasks");
    $resultado = pg_fetch_array($query);
    //se não existe nenhuma task:
    if($resultado[0]==NULL){
        //o id será 1
        $maxid = 1;
    }else{
        //se não o id será o máximo + 1
        $maxid = $resultado[0] + 1;
    }
    //user
    $usuario = $_SESSION['usuario'];
    //titulo
    $titulo = $_POST['titulo'];
    //status
    $status = 'PENDENTE';
    //descrição
    $descricao = $_POST['descricao'];
    //pega a data de hoje
    $hoje = date("Y-m-d");
    //prazo
    $prazo = $_POST['prazo'];
    //insere a task no banco de dados
    $query = pg_query($connect,"INSERT INTO TASKS(id, usuario, titulo, status, descricao, data_registro, prazo) 
    VALUES($maxid, '$usuario', '$titulo', '$status', '$descricao', '$hoje', '$prazo')");
    //mensagem de sucesso e redireciona para a home
    echo "<script>
        alert('Tarefa registrada!'); 
        window.location.href='home.php'
        </script>";
}