<?php
include('conecta.php');
include('topo.php');

// COLETA O VALOR id LÁ DA URL
$id = $_GET['id'];
$sql = "SELECT * FROM tb_quadras WHERE qd_id = '$id'";

$retorno = mysqli_query($link, $sql);
    while($tbl = mysqli_fetch_array($retorno)){
        $id = $tbl[0];
        $login = $tbl[1];
        $email = $tbl[2];
        $senha = $tbl[3];
        $senha2 = $tbl[3];
        $status = $tbl[4];
        $tempero = $tbl[5];
    }

// BORA FAZER O UPDATE??
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $senha = $_POST['txtsenha'];
    $email = $_POST['txtemail'];
    $status = $_POST['status'];
    $tempero = $_POST['tempero'];
    $senha2 = $_POST['txtsenha2'];

    ///
    //verifica se a senha foi alterada caso seja, refazer md5
    if($senha2 != $senha){
        $senha = md5($tempero . $senha);
    }
    ///

    $sql = "UPDATE tb_quadras 
    SET qd_nome = '$email', qd_status = '$status'
    WHERE qd_id = $id";

    mysqli_query($link, $sql);

    echo"<script>window.alert('USUARIO ALTERADO COM SUCESSO!');</script>";
    echo"<script>window.location.href='usuario-lista.php';</script>";
    exit();
}


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://fonts.cdnfonts.com/css/curely" rel="stylesheet">
                
    <title>ALTERAÇÃO DE USUARIO</title>
</head>
<body>
    <br>
    <div class="container-global">
        <!-- BOTÃO DE VOLTAR -->
        

    <form class="formulario" action="usuario-altera.php" method="post">
                

                
                
                <label>NOME</label>
                <input type="text" name="txtemail" placeholder="Digite seu email" value="<?= $email?>" required>
                <br>

                <!-- SELETOR DE ATIVO E INATIVO -->
                 <div class="bullets">
                <input type="radio" name="status" value="1" <?= $status == '1'?"checked" : ""?>>ATIVO
                <input type="radio" name="status" value="0" <?= $status == '0'?"checked" : ""?>>INATIVO
                </div>
                <br>
                <br>
                <input type="submit" value="CONFIRMAR">
        </form>

    </div>
    
</body>
</html>