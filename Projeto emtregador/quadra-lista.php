<?php
include('conecta.php');
include('topo.php');
// include('header.php');

// CONSULTA USUARIOS CADASTRADOS
$sql = "SELECT *
        FROM tb_quadras WHERE qd_status = '1'";
$retorno = mysqli_query($link, $sql);
$status = '1';


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <link href="https://fonts.cdnfonts.com/css/curely" rel="stylesheet">
    <title>LISTA DE USUARIOS</title>
</head>
<body>


    <div class="container-listausuarios">
        <!-- FAZER DEPOIS DO ROLÊ -->
        <form>

        </form>
        <!-- LISTAR A TABELA DE USUARIOS -->
        <table class="lista">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>LOCALIZAÇÃO</th>
                
                <th>IMAGEM</th>
            </tr>

            <!-- O CHORO É LIVRE! CHOLA MAIS -->
            <!-- BUSCAR NO BANCO OS DADOS DE TODOS OS USUARIOS -->
             <?php
                while($tbl = mysqli_fetch_array($retorno)){
                 ?>
                 <tr>
                    <td><?=$tbl[0]?></td> <!-- COLETA O NOME DO USUARIO-->
                    <td><?=$tbl[1]?></td> <!-- COLETA O EMAIL DO USUARIO-->
                    <td><?=$tbl[2]?></td> <!-- COLETA O STATUS DO USUARIO-->
                    <td><img src='data:image/jpeg;base64,<?= $tbl[7]?>' width="120" height="120"></td>
                    
                        </a>
                    </td>
                 </tr>
                 <?php
                }
                ?>
        </table>

    </div>
    
</body>
</html>