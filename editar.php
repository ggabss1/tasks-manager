<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href='includes/notepad.jpg'>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Detalhes - Tasks Manager</title>
</head>
<body>
<?php
//inclui arquivo de conexão com o banco de dados
require_once 'conexao.php';
//inicia a sessão
session_start();
//pega id
$id = $_GET['id'];
//seleciona task com esse id no banco
$query = pg_query($connect,"SELECT * FROM TASKS WHERE ID = $id");
$resultado = pg_fetch_array($query);
$titulo = $resultado['titulo'];
$status = $resultado['status'];
$descricao = $resultado['descricao'];
$prazo = $resultado['prazo'];
?>    
<!-- mostrar inputs de titulo, status -vai poder ser pendente ou concluido-, descrição e prazo para editar informações dessa task -->
<!-- inputs já vem preenchidos do banco -->
<!-- botão para salvar -->
<!-- botão para voltar -->
<form action="#" method="post">
    <!-- titulo -->
    <span>Título</span><br>
    <input type="text" name="titulo" value="<?=$titulo;?>" required><br>
    <!-- status -->
    <span>Status</span><br>
    <!-- se o status vier do banco pendente, vem marcado -->
    <?php if($status == 'PENDENTE'){?> 
    Pendente<input type="radio" name="Status" value="PENDENTE" checked>
    Concluída<input type="radio" name="Status" value="CONCLUÍDA">
    <!-- se o status vier do banco concluído, vem marcado -->
    <?php }elseif($status == 'CONCLUÍDA'){ ?>
    Pendente<input type="radio" name="Status" value="PENDENTE">
    Concluída<input type="radio" name="Status" value="CONCLUÍDA" checked>
    <?php } ?>
    <br>
    <!-- descrição -->
    <span>Descrição</span><br>
    <textarea name="descricao"cols="30" rows="10" required><?=$descricao;?></textarea><br>
    <!-- prazo -->
    <span>Prazo</span><br>
    <input type="date" name="prazo" value="<?=$prazo;?>"required><br>
<input type="submit" name="Salvar" value="Salvar">
</form>
<a href='home.php'><button>Voltar</button></a>
</body>
<?php
//se o usuário salvou o formulário
if(isset($_POST['Salvar'])){
//titulo
$titulo = $_POST['titulo'];
//status
$status = $_POST['Status'];
//descrição
$descricao = $_POST['descricao'];
//prazo
$prazo = $_POST['prazo'];
//update da task no banco de dados
$query = pg_query($connect,"UPDATE TASKS SET titulo = '$titulo', status = '$status', descricao = '$descricao', prazo = '$prazo' WHERE ID = $id");
//mensagem de sucesso e redireciona para a home
echo "<script>
    alert('Tarefa editada!'); 
    window.location.href='home.php'
    </script>";
}
?>