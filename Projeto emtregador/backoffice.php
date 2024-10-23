<?php
session_start();
$nomeusuario = $_SESSION['nomeusuario'];

// include ("header.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>HOME PRINCIPAL</title>
</head>
<body>
    <div class="container-home">
    <!-- TOPO SEM MOBILE -->
        <div class="topo">
            <?php
                if ($nomeusuario != null) {
                ?>
              <label>BEM VINDO <?= strtoupper($nomeusuario)?></label>
            <?php
                }
                else {
                    echo"<script>window.alert('USUARIO NÃO LOGADO');window.location.href='login.php';</script>";
                }
            ?>
            <a href="login.php"><img src='img/Exit-02-WF-256.png'width="50" height="50"></a>
        </div>
  
        <!-- BOTÕES DE MENU -->
         <div class="menu">
            <!-- <a href="usuario-cadastro.php"><span class="tooltiptext">Cadastro de Usuario</span><img src="icons/user-add.png"></a> -->
            <a href="cliente-cadastro.php"><span class="tooltiptext">Cadastro de cliente</span><img src="icons/user-add.png"></a>
            <a href="adicionar-quadra.php"><span class="tooltiptext">Cadastro De Quadras</span><img src="icons/quadra.png"></a>
            <a href="fazer-reserva.php"><span class="tooltiptext">Fazer Reserva</span><img src="icons/data.png"></a>
            <a href="quadra-lista.php"><span class="tooltiptext">Lista de Quadras</span><img src="icons/quadra.png"></a>

            
         </div>
    </div>
    
</body>
</html>