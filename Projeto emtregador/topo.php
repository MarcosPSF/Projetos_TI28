<?php
session_start();
$nomeusuario = $_SESSION['nomeusuario'];

// include ("header.php");
?>

<div class="topo">
    <?php
    if ($nomeusuario != null) {
        ?>
        <label>BEM VINDO <?= strtoupper($nomeusuario) ?></label>
        <?php
    } else {
        echo "<script>window.alert('USUARIO NÃO LOGADO');window.location.href='login.php';</script>";
    }
    ?>
    <a href="backoffice.php"><img src='img/Exit-02-WF-256.png' width="50" height="50"></a>
</div>