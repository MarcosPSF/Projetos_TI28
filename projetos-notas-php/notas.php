<?php
//$nota1 = 8;
//$nota2 = 7;
//$nota3 = 5;

// usando metado GET para coleta de notas

$nota1 = $_GET['nota1'];
$nota2 = $_GET['nota2'];
$nota3 = $_GET['nota3'];
$idusu = $_GET['idusu'];


$media = ($nota1 + $nota2 + $nota3) / 3;

echo("Média<br><br>");
echo("Nome do Aluno: ".$idusu."<br>");
echo("Nota 1: ".$nota1."<br>"."Nota 2: ".$nota2."<br>"."Nota 3: ".$nota3);
echo("<br>");

if($media >= 7){
    echo("Aprovado");
}
elseif($media >= 6){
    echo("recuperação");
}
elseif($media <= 6){
    echo("Reprovado");
}
echo("<br>");
echo("Nota final :".$media);

echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");
echo("<br>");

$int = 342;
$porcentagem = 12;
$resultado = ($int * $porcentagem) / 100;
echo("12% de 342 é : " . $resultado);

?>