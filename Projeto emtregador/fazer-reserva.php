<?php
include("conecta.php");
include("topo.php");



// TRAZ LISTA DE CLIENTES
$sqlcli = "SELECT cli_id, cli_nome FROM tb_clientes";
$retornocli = mysqli_query($link, $sqlcli);

// TRAZ LISTA DE QUADRAS PARA RESERVA
$sqlquadra = "SELECT * FROM tb_quadras";
$retornoquadra = mysqli_query($link, $sqlquadra);

// TRAZ LISTA DE QUADRAS RESERVADAS
$sqllistaquadras = "SELECT
qd.qd_id, qd.qd_nome, qd.qd_valor_hora,
iv.iv_horas, iv.iv_valortotal, iv.iv_id
FROM tb_quadras qd
JOIN tb_reservas iv ON qd.qd_id = iv.fk_qd_id 
WHERE iv.iv_status = 1";
$retornoreservas = mysqli_query($link, $sqllistaquadras);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>RESERVA DE QUADRAS</title>
</head>

<body>
    <div class="container-global">

    <!-- Formulário para adicionar uma reserva -->
    <form class="formulario" action="reserva-data.php" method="post">
        <!-- Selecionar cliente -->
        <label>SELECIONE O CLIENTE</label>
        <select name='cliente' required>
            <?php while ($tblcli = mysqli_fetch_array($retornocli)) { ?>
                <option value="<?= $tblcli[0] ?>"><?= strtoupper($tblcli[1]) ?></option>
            <?php } ?>
        </select>
        <br>
        <!-- Selecionar quadra -->
        <label>SELECIONE A QUADRA</label>
        <select name='quadra' required>
            <?php while ($tblquadra = mysqli_fetch_array($retornoquadra)) { ?>
                <option value="<?= $tblquadra[0] . ',' . $tblquadra[1] . ',' . $tblquadra[4] ?>"><?= strtoupper($tblquadra[1]) ?></option>
            <?php } ?>
        </select>
        <br>

        <!-- Selecionar data e horas -->
        <label>DIA</label>
        <input type="date" name="dia" required>
        <br>
        <label>DURAÇÃO</label>
        <input type='number' name='horas' step="0.5" min="0" required>
        <br>
        <input type="submit" value="CONFIRMAR">
    </form>

    </div>
    
    <br>

   

</body>

</html>
