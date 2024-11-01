<?php
include("conecta.php");

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegar o ID do cliente (se necessário) - se não precisar mais do cliente para finalizar, pode ser omitido
    // Pegando o id do cliente que participou da última reserva ativa

    $horas = $_POST['horas'];
    $horainicio = $_POST['horario'];

    $horafim = date("H:i", strtotime($horainicio) + ($horas * 3600));


    $sqlcliente = "SELECT fk_cli_id FROM tb_reservas WHERE iv_status = 1 LIMIT 1";
    $resultadocliente = mysqli_query($link, $sqlcliente);
    $idcliente = mysqli_fetch_array($resultadocliente)[0];

    // Verificar se existem reservas com abertas
    $sqlreservasativas = "SELECT COUNT(iv_id) FROM tb_reservas WHERE iv_status = 1";
    $retorno = mysqli_query($link, $sqlreservasativas);
    $reservasativas = mysqli_fetch_array($retorno)[0];

    if ($reservasativas == 0) {
        echo "<script>alert('Nenhuma reserva ativa encontrada.');</script>";
        echo "<script>window.location.href='fazer-reserva.php';</script>";
    } else {
        // Finalizar todas as reservas abertas
        $sqlfinalizar = "UPDATE tb_reservas SET iv_status = 0, horainicio = '$horainicio', horafim ='$horafim' WHERE iv_status = 1";
        echo  $sqlfinalizar;
        if (mysqli_query($link, $sqlfinalizar)) {
            echo "<script>alert('Reserva finalizada com sucesso!');</script>";
            echo "<script>window.location.href='backoffice.php';</script>";
        } else {
            echo "<script>alert('Erro ao finalizar a reserva.');</script>";
            echo "<script>window.location.href='fazer-reserva.php';</script>";
        }
    }
}
?>