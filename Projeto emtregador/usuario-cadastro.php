<!-- <?php
include ('conecta.php');
include ('topo.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['txtnome'];
    $email = $_POST['txtemail'];
    
    $senha = $_POST['txtsenha'];

    $sql = "INSERT INTO usuarios (nome, email,  senha, usu_status) VALUES ('$nome','$email','$senha','1')";
    mysqli_query($link, $sql);
    echo"<script>window.alert('USUARIO CADASTRADO COM SUCESSO');</script>";
    echo"<script>window.location.href='backoffice.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/estilo.css">

    <title>Adicionar Usuário</title>
</head>
<body>
<br>

<div class="container-global">
        
        <form class="formulario" action="usuario-cadastro.php" method="post">
       

            <label>NOME</label>
            <input type="text" name="txtnome" placeholder="Digite seu Nome" required>
            <br>
            <label>EMAIL</label>
            <input type="email" name="txtemail" placeholder="Digite seu email" required>            
            <br>
            <label>SENHA</label>
            <input type="password" name="txtsenha" placeholder="Digite sua senha" required>
            <br>
            <input type="submit" value="CRIAR">

        </form>

</div>




</body>
</html> -->
