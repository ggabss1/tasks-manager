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
//se não tem get
if(empty($_GET['id'])){
//mensagem de erro
echo "<script>
alert('Tarefa não encontrada!'); 
window.location.href='home.php'
</script>";
}else{
//pega id
$id = $_GET['id'];
}
//seleciona task com esse id no banco
$usuario = $_SESSION['usuario'];
$resultado = $conn->prepare("SELECT * FROM TASKS WHERE ID = ? AND USUARIO = ?");
$resultado->bindParam(1,$id);
$resultado->bindParam(2,$usuario);
$resultado->execute();
$resultado = $resultado->fetch();
//se a task não for do usuário vai retornar vazio
if(empty($resultado)){
  //mensagem de erro
echo "<script>
alert('Tarefa não encontrada!'); 
window.location.href='home.php'
</script>";  
}
$titulo = $resultado['titulo'];
$status = $resultado['status'];
$descricao = $resultado['descricao'];
$prazo = $resultado['prazo'];
?>    
<!-- mostrar inputs de titulo, status -vai poder ser pendente ou concluido-, descrição e prazo para editar informações dessa task -->
<!-- inputs já vem preenchidos do banco -->
<!-- botão para salvar -->
<!-- botão excluir -->
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
<input type="submit" name="Excluir" value="Excluir"><br>
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
$query = $conn->prepare("UPDATE TASKS SET titulo = ? , status = ?, descricao = ?, prazo = ? WHERE ID = ?");
$query->bindParam(1,$titulo);
$query->bindParam(2,$status);
$query->bindParam(3,$descricao);
$query->bindParam(4,$prazo);
$query->bindParam(5,$id);
$query->execute();
//mensagem de sucesso e redireciona para a home
echo "<script>
    alert('Tarefa editada!'); 
    window.location.href='home.php'
    </script>";
}
//se o usuário pressionou excluir
if(isset($_POST['Excluir'])){
    //deleta task
    $query = $conn->prepare("DELETE FROM TASKS WHERE ID = ?");
    $query->bindParam(1,$id);
    $query->execute();
    //mensagem de sucesso e redireciona para a home
echo "<script>
alert('Tarefa deletada!'); 
window.location.href='home.php'
</script>";
}
?>