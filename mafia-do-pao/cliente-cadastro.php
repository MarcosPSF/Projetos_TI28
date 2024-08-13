<?php
include("conectadb.php");
include('topo.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cpf = $_POST['txtcpf'];
    $nome = $_POST['txtnome'];
    $email = $_POST['txtemail'];
    $cel = $_POST['txtcel'];

// VALIDA SE CLIENTE A CADASTRAR EXISTE
    $sql = "SELECT COUNT(cli_id) FROM tb_clientes WHERE cli_cpf = '$cpf' ";

 // RETORNO DO BANCO
    $retorno = mysqli_query($link, $sql);
    $contagem = mysqli_fetch_array($retorno) [0];

// VERIFICA SE CLIENTE EXISTE
    if($contagem == 0){
        $sql = "INSERT INTO tb_clientes(cli_cpf, cli_nome, cli_email, cli_cel, cli_status)
        VALUES ('$cpf', '$nome', '$email', '$cel', '1')";
        mysqli_query($link, $sql);
        echo"<script>window.alert('CLIENTE CADASTRADO COM SUCESSO');</script>";
        echo"<script>window.location.href='backoffice.php';</script>";
    }
    else if($contagem >= 1){
        echo"<script>window.alert('CLIENTE JÁ EXISTENTE');</script>";
    }
}       

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://fonts.cdnfonts.com/css/curely" rel="stylesheet">
    <title>Cadastro cliente</title>
</head>
<body>
<br>
<div class="container-global">


    <form class="formulario" action="cliente-cadastro.php" method="post">
    <img src="img/logo.jfif" width="100" height="100">
        <label>CPF</label>
        <input type="text" id="cpf" name="txtcpf" placeholder="000.000.000-00" maxlength="14" oninput="formatarCPF(this)">
        <br>
        <label>DIGITE SEU NOME</label>
        <input type="text" name="txtnome" placeholder="Digite seu Nome" required>
        <br>
        <label>EMAIL</label>
        <input type="email" name="txtemail" placeholder="Digite seu email" required>
        <br>
        <label>NUMERO DE CELULAR</label>
        <input type="text" name="txtcel" id="telefone"placeholder="(00) 00000-0000"maxlength="15">

        <br>
        <input type="submit" value="CRIAR">
    </form>

</div>

<script src="scripts/script.js"></script>

</body>
</html>