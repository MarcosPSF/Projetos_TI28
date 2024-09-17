<?php
include("conectadb.php");
include("topo.php");

#pesquisa a data minima e maxima para filtros

$selectdatamin = "SELECT MIN(ven_datavenda) FROM tb_venda";
$selectdatamax = "SELECT MAX(ven_datavenda) FROM tb_venda";

$resultado_data_min = mysqli_query($link, $selectdatamin);
$resultado_data_max = mysqli_query($link, $selectdatamax);

$data_min = mysqli_fetch_array($resultado_data_min);
$data_max = mysqli_fetch_array($resultado_data_max);

//configurando a daa para que o html mostre bonitinho
$data_min_string = date("Y-m-d", strtotime($data_min[0]));
$data_max_string = date("Y-m-d", strtotime($data_max[0]));

//pesquisa os clientes para filtro
$sqlcli = "SELECT cli_id, cli_nome FROM tb_clientes";
$retornocli = mysqli_query($link, $sqlcli);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $idcliente = $_POST['idcliente'];
    $datainicial = $_POST['datainicial'];
    $datafinal = $_POST['datafinal'];

if ($datainicial < 0){
    $datainicial = $data_min_string;
}
if ($datafinal < 0){
    $datafinal = $data_max_string;
}
//a pagina carregou oq ele vai trazer?

//pesquisa no banco todos os produtos do banco
$sql= "SELECT v.ven_id, v.ven_datavenda, v.ven_totalvenda, v.fk_iv_cod_iv, v.fk_cli_id, v.fk_usu_id, c.cli_nome, u.usu_login FROM tb_venda v
JOIN
tb_clientes c ON v.fk_cli_id = c.cli_id
JOIN
tb_usuarios u ON v.fk_usu_id = u.usu_id
WHERE
v.ven_datavenda BETWEEN '$datainicial 0:0:0' AND '$datafinal 23:59:59'";//echo $sql;



$valortotal = "SELECT SUM(ven_totalvenda) FROM tb_venda WHERE
ven_datavenda BETWEEN '$datainicial 0:0:0' AND '$datafinal 23:59:59'";



if($idcliente == 'todos'){
    $retorno = mysqli_query($link, $sql. " ORDER BY v.ven_id");
    $retornovalortotal = mysqli_query($link, $valortotal);
}
else{
    //adicionar ao $sql a conição depesquisa ao nome 
    $sql .= " AND c.cli_id = ".$idcliente ." ORDER BY ven_id";
    
    $retorno = mysqli_query($link, $sql);

    $valortotal .=  "AND fk_cli_id = ".$idcliente ." ORDER BY ven_id";
    $retornovalortotal = mysqli_query($link, $valortotal);
}
}
else{
    $sql= "SELECT v.ven_id, v.ven_datavenda, v.ven_totalvenda, v.fk_iv_cod_iv, v.fk_cli_id, v.fk_usu_id, c.cli_nome, u.usu_login FROM tb_venda v
JOIN
tb_clientes c ON v.fk_cli_id = c.cli_id
JOIN
tb_usuarios u ON v.fk_usu_id = u.usu_id";
$retorno = mysqli_query($link, $sql);
$valortotal = "SELECT SUM(ven_totalvenda) FROM tb_venda";
$retornovalortotal = mysqli_query($link, $valortotal);
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://fonts.cdnfonts.com/css/curely" rel="stylesheet">
    <title>LISTA VENDA</title>
</head>
<body>
    <div class="container-global">
            <form class="formulario" action="venda-lista.php" method="post">
                <label>Valor Total Bruto</label>
                <!-- php para retornar a soma do valor total -->
                 <?php
                 while($tblvalortotal = mysqli_fetch_array($retornovalortotal)){
                    echo "R$ " . $tblvalortotal[0];
                 }?>
                 <br><br>
                 <label for="data"> Selecionar a Data Inicial</label>
                 <input id="datainicial" name="datainicial"
                 min="<?=$data_min_string?>" max="<?=$data_max_string?>" type="date">
                 <label for="data">Selecionar a Data Final:</label>
                 <input id="datafinal" name="datafinal"
                 min="<?=$data_min_string?>" max="<?=$data_max_string?>" type="date">
                 <!-- filtro para pesquisa de cliente -->
                  <label>SELECIONAR CLIENTE</label>
                  <select name="idcliente" >
                    <option value="todos">TODOS</option>
                    <?php WHILE ($tblcli = mysqli_fetch_array($retornocli)){
                        ?>
                        <option value="<?= $tblcli[0]?>"><?=strtoupper($tblcli[1])?></option>
                        <?php
                    }?>
                  </select>
                  <br>
                  <input type="submit" value="PESQUISAR">
            </form>
    </div>
<br>
    <div class="container-listaclientes">

    <table class="lista">
        <tr>
             <br> <br>
            <th>ID</th>
            <th>DATA</th>
            <th>VALOR</th>
            <th>CODIGO</th>
            <th>CLIENTE</th>
            <th>VENDEDOR</th>
            
            
        </tr>

        <?php
        while($tbl = mysqli_fetch_array($retorno)){
            ?>
            <tr>
                
                <td><?=$tbl[0]?></td>
                <td><?=$tbl[1]?></td>
                <td><?=$tbl[2]?></td>
                <td><?=$tbl[3]?></td>
                <td><?=$tbl[6]?></td>
                <td><?=$tbl[7]?></td>
                <td><a href="venda-visualizar.php?id=<?=$tbl[3]?>"><input type="button" value="VISUALIZAR"></td></a>
            </tr>
            <?php
        }
        ?>
    </table>

    </div>



</body>
</html>

