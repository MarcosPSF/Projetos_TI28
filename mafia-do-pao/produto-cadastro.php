<?php
    include('conectadb.php');
    include('topo.php');

    //vamo cadastra o produto
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nomeproduto = $_POST['txtnome'];
        $quantidade = $_POST['txtqtd'];
        $unidade = $_POST['txtunidade'];
        $preco =$_POST['txtpreco'];
    

    if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK){
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem = file_get_contents($imagem_temp);
        //criptografa imagem em base64
        $imagem_base64 = base64_encode($imagem);
    };


    // verifica se pão de queijo existe 
    $sql = "SELECT COUNT(pro_id) FROM tb_produtos WHERE pro_nome = '$nomeproduto'";

    $retorno = mysqli_query($link, $sql);
    $contagem = mysqli_fetch_array($retorno)[0];

    if($contage == 0){
        $sql = "INSERT INTO tb_produtos(pro_nome, pro_quantidade, pro_unidade, pro_preco, pro_status, pro_imagem) 
        VALUES ('$nomeproduto', $quantidade,'$unidade',$preco,'1','$imagem_base64')";

        $retorno = mysqli_query($link, $sql);

        echo"<script>window.alert('PRODUTO CADASTRADO!');</script>";
        echo"<script>window.location.href='produto-lista.php';</script>";
    }
    else{
        echo"<script>window.alert('PRODUTO JA EXISTENTE MEU BOM!!');</script>";
    }

}   
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Cadastra Produtos</title>
</head>
<body>
<br>
    <div class="container-global">
    <form class="formulario" action="produto-cadastro.php" method="post" enctype="multipart/form-data">
        
        <label>NOME PRODUTO</label>
            <input type="text" name="txtnome" placeholder="Digite o Nome do Produto" required>
        <br>
        <label>QUANTIDADE</label>
            <input type="decimal" name="txtqtd" placeholder="Digite Quantidade" required>
        <br>
            <label>UNIDADE</label>
            <select name="txtunidade">
                <option value="kg">KG</option>
                <option value="g">G</option>
                <option value="un">UN</option>
                <option value="lt">LT</option>  
             </select>
        <br>
        <label>PREÇO</label>
            <input type="decimal" name="txtpreco" placeholder="Digite Preço" required>
        <br>
        <label>IBAGENS</label>
        <input type="file" name='imagem' id='imagem'>
        <br>
        <input type="submit" value="CADASTRAR PRODUTO">
    </form>


    </div>
    
</body>
</html>