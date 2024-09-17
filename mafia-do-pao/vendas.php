<?php
include('conectadb.php');
include('topo.php');
 
#VERIFICAÇÃO DO POST
if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    $produto = $_POST['produto'];
    //QUEBRAR A VARIÁVEL PRODUTO EM 3 OUTARS VARIÁVEIS
    list($idproduto, $nomeproduto, $valorproduto) = explode(',', $produto);
    $qtditem = $_POST['qtditem'];
    //CALCULAR O VALO DOS ITENS
    $valorlista = $valorproduto * $_POST['qtditem'];
 
    #VERIFICAÇÃO SE O CARRINHO ESTÁ ABERTO
    $sql = "SELECT COUNT(iv_status) FROM tb_item_venda WHERE iv_status = 1";
    $retorno = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($retorno)) {
        $cont = $tbl[0];
 
        # SE NÃO EXISTIR O CARRINHO ABERTO, CRIAR UM NOVO
        if ($cont == 0) {
            //CRIA O CÓDIGO ITEM_VENDA
            $codigo_itemvenda = md5(rand(1, 99999) . date('h:i:s'));
 
            //INSERINDO O ITEM NA VENDA
            $sqlitem = "INSERT INTO tb_item_venda(iv_valortotal, iv_quantidade, iv_cod_iv, fk_pro_id, iv_status)
        VALUES ($valorlista,$qtditem,'$codigo_itemvenda',$idproduto,'1')";
       
            mysqli_query($link, $sqlitem);
        } else { # SE O CARRINHO JA EXISTIR, RETORNA O NÚMERO IV_COD_IV ATIVO E INSERE MAIS ITENS NA VENDA
            $sql = "SELECT iv_cod_iv FROM tb_item_venda WHERE iv_status = 1";
            $carrinhoaberto = mysqli_query($link, $sql);
 
            $tbl = mysqli_fetch_array($carrinhoaberto);
 
            $codigo_itemvenda_ok = $tbl[0];
 
            //INSERINDO O ITEM NA VENDA
            $sqlitem = "INSERT INTO tb_item_venda(iv_valortotal, iv_quantidade, iv_cod_iv, fk_pro_id, iv_status)
        VALUES ($valorlista,$qtditem,'$codigo_itemvenda_ok',$idproduto,'1')";
            mysqli_query($link, $sqlitem);
        }
    }
}
 
#SELEÇÃO DE ITENS
//SELECT E INSERT
$sqlpro = "SELECT * FROM tb_produtos";
$retornopro = mysqli_query($link, $sqlpro);
 
#LISTA DE CLIENTES
$sqlcli = "SELECT cli_id, cli_nome FROM tb_clientes";
$retornocli = mysqli_query($link, $sqlcli);
 
#LISTA DE PRODUTOS PARA COMPRA
$sqllistapro = "SELECT pro.pro_id, pro.pro_nome, pro.pro_imagem, pro.pro_preco, iv.iv_quantidade, iv.iv_valortotal, iv.iv_id FROM tb_produtos pro
JOIN tb_item_venda iv ON pro.pro_id = iv.fk_pro_id
WHERE iv.iv_status = 1";
$retorno = mysqli_query($link, $sqllistapro);
 

?>
 
 
 
 
 
<!DOCTYPE html>
<html lang="pt-br">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>VENDAS</title>
</head>
 
<body>
    <div class="container-global">
        <form class="formulario" action="vendas.php" method="post">
            <label>SELECIONE O PRODUTO</label>
            <select name='produto'>
                <!-- PUXA OS DADOS DO SERVER PREENCHENDO O OPTION-->
                <?php while ($tblpro = mysqli_fetch_array($retornopro)) {
                ?>
                    <option value="<?= $tblpro[0] . ',' . $tblpro[1] . ',' . $tblpro[4] ?>">
                        <?= strtoupper($tblpro[1]) ?></option>
                <?php
                }
                ?>
            </select>
            <br>
            <label>QUANTIDADE</label>
            <input type="deciaml" name="qtditem">
            <br>
            <input type="submit" name="CONFIRMAR">
        </form>
        </div>
        <br>
        <div class="container-listaproduto">
            <table class="lista">
                <tr>
                    <th>ID</th>
                    <th>NOME PRODUTO</th>
                    <th>VALOR UN.</th>
                    <th>QUANTIDADE</th>
                    <th>IMAGEM</th>
                    <th>DELETAR</th>
                </tr>
                <?php
 
                while ($tbl = mysqli_fetch_array($retorno)) {
                ?>
                <tr>
                    <td><?= $tbl[0] ?></td> <!--COLETA ID-->
                    <td><?= $tbl[1] ?></td> <!--COLETA NOME-->
                    <td><?= $tbl[3] ?></td> <!--COLETA QTD-->
                    <td><?= $tbl[4] ?></td> <!--COLETA VALOR UNITÁRIO-->
                    <td><img src='data:image/jpeg;base64,<?= $tbl[2] ?>' width="200" height="200"></td> <!--COLETA IMG-->
                    <td><a href="venda-deleta-item.php?id=<?= $tbl[6] ?>">
                            <input type="button" value="EXCLUIR">
                        </a>
                    </td>
                </tr>
 
                <?php
                }
 
                ?>
 
 
            </table>
        </div>
    </div>
    <!-- FORMULARIO FINAL DE NOME E ENVIO-->
     <br>
     <br>
    <div class="container-global">
        <form class="formulario" action="vendas-finalizar.php" method="POST">
            <label>SELECIONE O CLIENTE</label>
            <select name="nomecliente">
                <!-- PUXAR OS NOMES DOS CLIENTES-->
                <?php while ($tblcli = mysqli_fetch_array($retornocli)) {
                ?>
                    <option value="<?=$tblcli[0] ?>">
                        <?= strtoupper($tblcli[1])?>
                    </option>
                <?php
                }
                ?>
            </select>
            <label>VALOR TOTAL</label>
            <!-- SELECT PARA RETORNAR A SOMA DO VALOR TOTAL -->
             <?php $valortotal = "SELECT SUM(iv_valortotal) FROM tb_item_venda WHERE iv_status = 1";
             $retornovalortotal = mysqli_query($link, $valortotal);
             while ($tblvalortotal = mysqli_fetch_array($retornovalortotal)) {
                echo"R$". $tblvalortotal[0];
             }
             ?>
            <input type="submit" value="CONFIRMAR">
        </form>
    </div>
</body>
 
</html>
 