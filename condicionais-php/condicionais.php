<?php
// CONDICIONAIS SIMPLES EM PHP
$numero1 = 20;
$numero2 = 20;
echo("numero 1: ".$numero1 . "<br>". "numero 2: ".$numero2);
echo("<br>");
if($numero1 == $numero2){
    echo("É Igual");
}
else{
    echo("É Diferente");
}
echo("<br>");
// OPERADOR TERNARIO
$numero1 >= $numero2?print("É maior"):print("É menor");
?>