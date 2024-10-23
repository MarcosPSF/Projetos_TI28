
<?php
    //LOCALIZADOR ONDE ESTA O BANCO DE DADOS 
    $servidor = "localhost";

    //NOME DO BANCO : mafia 
    $banco = "projetoquadra";

    //QUAL USUARIO VA OPERAR NA BASE DE DADOS
    $usuario = "root";

    //QUAL A SENHA DO USUARIO NA BASE DE DADOS 
    $senha = "";

    //LNK QUE A FERRAMENTA VA USAR PARA CONECTAR NO BANCO
    $link = mysqli_connect($servidor, $usuario, $senha, $banco);
?>