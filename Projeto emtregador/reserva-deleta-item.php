<?php
include("conecta.php");

$idiv = $_GET['id'];
$sqldeleta = "DELETE FROM tb_reservas WHERE iv_id = $idiv";
$resultado = mysqli_query($link, $sqldeleta);

header("Location: fazer-reserva.php")

?>