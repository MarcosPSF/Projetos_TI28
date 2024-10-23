<?php
session_start();

include("conecta.php");

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $login = $_POST['txtlogin'];
    $senha = $_POST['txtsenha'];

    

    // COMEÇA VALIDAR BANCO DE DADOS
    $sql = "SELECT COUNT(cli_id) FROM tb_clientes
    WHERE cli_nome = '$login' AND cli_senha = '$senha'";
    // RETORNO DO BANCO
    $retorno = mysqli_query($link, $sql);

    $contagem = mysqli_fetch_array($retorno) [0];

    // VERIFICA SE NATAN EXISTE
    if($contagem == 1){
        $sql = "SELECT cli_id, cli_nome FROM tb_clientes
        WHERE cli_nome = '$login'AND cli_senha = '$senha'";
        $retorno = mysqli_query($link, $sql);
        //RETORNANDO O NOME DO NATAN + ID DELE
        while($tbl = mysqli_fetch_array($retorno)){
            $_SESSION['idusuario'] = $tbl[0];
            $_SESSION['nomeusuario'] = $tbl[1];
        }
        echo"<script>window.location.href='backoffice.php';</script>";
    }
    else{
        echo"<script>window.alert('USUARIO OU SENHA INCORRETOS');</script>";
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
                
    <title>LOGIN USUARIO</title>
</head>
<body>
    <div class="container-global">
    

    <form class="formulario" action="login.php" method="post">
        <img src="img/logo.jfif" width="50" height="50">
                <label>LOGIN</label>
                <input type="text" name="txtlogin" placeholder="Digite seu login" required>
                <br>
                <label>SENHA</label>
                <input type="password" name="txtsenha" placeholder="Digite sua senha" required>
                <br>
                <br>
                <input type="submit" value="ACESSAR">
              
               
        </form>

    </div>
    
</body>
</html>