<?php
include('conecta.php');
include('topo.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomequadra = $_POST['nome_quadra'];
    $local = $_POST['localizacao'];
    $capacidade = $_POST['capacidade'];
    $preco = $_POST['txtpreco'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem = file_get_contents($imagem_temp);
        //criptografa imagem em base64
        $imagem_base64 = base64_encode($imagem);

    }
    ;


    // verifica se quadra existe 
    $sql = "SELECT COUNT(qd_id) FROM tb_quadras WHERE qd_nome = '$nomequadra'";
    $retorno = mysqli_query($link, $sql);
    $contagem = mysqli_fetch_array($retorno)[0];


    if ($contagem == 0) {
        $sql = "INSERT INTO tb_quadras (qd_nome, qd_localizacao, qd_capacidade, qd_valor_hora, qd_status, qd_imagem) VALUES ('$nomequadra', '$local', $capacidade,$preco,'1','$imagem_base64')";
        echo ($sql);
        $retorno = mysqli_query($link, $sql);

        echo "<script>window.alert('QUADRA CADASTRADO COM SUCESSO');</script>";
        echo "<script>window.location.href='backoffice.php';</script>";
    } else {
        echo "<script>window.alert('QUADRA JA EXISTENTE MEU BOM!!');</script>";
    }


}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/estilo.css">

    <title>Adicionar Quadra</title>
</head>

<body>
    <br>
    <div class="container-global">


        <form class="formulario" action="adicionar-quadra.php" method="post" enctype="multipart/form-data">


            <label>NOME</label>
            <input type="text" name="nome_quadra" placeholder="Digite o Nome da quadra" required>
            <br>
            <label>ENDEREÇO</label>
            <input type="text" name="localizacao" placeholder="Edereço" required>
            <br>
            <label>CAPACIDADE</label>
            <input type="number" name="capacidade" id="capacidade" placeholder="Numero de jogadores">
            <br>
            <label>IBAGENS</label>
            <input type="file" name='imagem' id='imagem'>
            <br>
            <label>PREÇO</label>
            <input type="decimal" name='txtpreco' id='imagem'>
            <br>

            <br>
            <input type="submit" value="CRIAR">

        </form>

    </div>
</body>

</html>