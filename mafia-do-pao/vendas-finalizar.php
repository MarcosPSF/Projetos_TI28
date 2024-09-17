<?php
    include ("conectadb.php");
    include ("topo.php");

    //coletar dados post

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $idcliente = ($_POST['nomecliente']);

        #pesquisar os itens da compra
        $sql = "SELECT * FROM tb_item_venda WHERE iv_status = 1";

        #usado para fazer remção de itens no inventario
        $retornoproduto = mysqli_query($link, $sql);

        #usado para fazer o total
        $total =0; //inicializando a variavel
        $valortotal = "SELECT SUM(iv_valortotal) FROM tb_item_venda WHERE iv_status =1";
        $retornovalortotal = mysqli_query($link, $valortotal);

        while($tblvalortotal = mysqli_fetch_array($retornovalortotal)){
            $total = $tblvalortotal[0];
        }


#usando para finalização da venda
$retornocarrinho = mysqli_query($link, $sql);
$usuario = $_SESSION['idusuario'];

///////////////// realizar correção de verificação de item do inventario



#remoção de itens do inventario
while ($tblitem = mysqli_fetch_array($retornoproduto)){
    $produto_id = $tblitem[4];
    $quantidade_item = $tblitem[2];

    //consulta para obter a quantidade atual do produto
    $sqlproduto = "SELECT pro_quantidade FROM tb_produtos WHERE pro_id = $produto_id";
    $retornoproduto_info = mysqli_query($link, $sqlproduto);

    //atualização da quantidade de produtos
    if($row = mysqli_fetch_array($retornoproduto_info)){
        $quantidade_produto = $row[0];
        $nova_quantidade = $quantidade_produto - $quantidade_item;
        $sql_update_produto = "UPDATE tb_produtos SET pro_quantidade = $nova_quantidade WHERE pro_id = $produto_id";
        $resultado_update_produto = mysqli_query($link, $sql_update_produto);
    }

}

$data = date("Y-m-d H:i:s");

$tbl = mysqli_fetch_array($retornocarrinho);

$sqlvenda = "INSERT INTO tb_venda(ven_datavenda, ven_totalvenda, fk_iv_cod_iv, fk_cli_id, fk_usu_id) VALUES('$data', $total, '$tbl[3]', $idcliente, $usuario)";
mysqli_query($link, $sqlvenda);

 
 #TROCAR O STATUS DA VENDA PARA FECHADO
 $sqlfechavenda ="UPDATE tb_item_venda SET iv_status=0 WHERE iv_status=1";
 mysqli_query($link, $sqlfechavenda);
 
 header("Location: venda-lista.php");




    }
?>