<?php
include("conecta.php");
include("topo.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quadra = $_POST['quadra'];
    $data = $_POST['dia'];
    list($idquadra, $nomequadra, $valorquadra) = explode(',', $quadra);
    $horas = $_POST['horas'];
    $cliente = $_POST['cliente'];  

    // VERIFICANDO SE A QUADRA ESTÁ DISPONÍVEL
    $sqlverificar = "SELECT qd_disponibilidade FROM tb_quadras WHERE qd_id = $idquadra";
    $retornodisponibilidade = mysqli_query($link, $sqlverificar);
    $disponibilidade = mysqli_fetch_array($retornodisponibilidade)[0];

    if ($disponibilidade == 0) {
        echo "<script>window.alert('QUADRA INDISPONÍVEL.')</script>";
        echo "<script>window.location.href='fazer-reservas.php'</script>";
    } else {
        // CALCULANDO VALOR TOTAL
        $valortotal = floatval($valorquadra) * floatval($_POST['horas']);

        // VERIFICA SE EXISTE UMA RESERVA JÁ ABERTA
        $sql = "SELECT COUNT(iv_status) FROM tb_reservas WHERE iv_status = 1";
        $retorno = mysqli_query($link, $sql);
        $cont = mysqli_fetch_array($retorno)[0];

        if ($cont == 0) {
            // INSERINDO RESERVA
            $codigo_reserva = md5(rand(1, 9999) . date('h:i:s'));

            $sqlitem = "INSERT INTO tb_reservas (iv_valortotal, iv_horas, iv_cod_iv, fk_qd_id, fk_cli_id, iv_status, dia)
            VALUES ($valortotal, $horas, '$codigo_reserva', $idquadra, $cliente, '1', '$data')";
            mysqli_query($link, $sqlitem);
        } else {
            // SE RESERVA EXISTE, CONSULTA O NÚMERO DA RESERVA PARA ADICIONAR MAIS HORAS
            $sql = "SELECT iv_cod_iv FROM tb_reservas WHERE iv_status = 1";
            $reservasabertas = mysqli_query($link, $sql);

            $codigo_reserva_ok = mysqli_fetch_array($reservasabertas)[0];

            $sqlitem = "INSERT INTO tb_reservas (iv_valortotal, iv_horas, iv_cod_iv, fk_qd_id, fk_cli_id, iv_status, dia)
                        VALUES ($valortotal, $horas, '$codigo_reserva_ok', $idquadra, $cliente, '1', '$data')";
            mysqli_query($link, $sqlitem);
        }
    }
}

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
    <form class="formulario" action="fazer-reserva.php" method="post">
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

    <!-- Lista de quadras reservadas -->
    <div class="container-listaquadra">
        <table class="lista">
            <tr>
                <th>ID</th>
                <th>NOME DA QUADRA</th>
                <th>VALOR/HORA</th>
                <th>HORAS</th>
                <th>DELETAR</th>
            </tr>
            <?php while ($tbl = mysqli_fetch_array($retornoreservas)) { ?>
                <tr>
                    <td><?= $tbl[0] ?></td>
                    <td><?= $tbl[1] ?></td>
                    <td><?= $tbl[2] ?></td>
                    <td><?= $tbl[3] ?></td>
                    <td><a href="reserva-deleta-item.php?id=<?= $tbl[5] ?>">
                            <input type="button" value="EXCLUIR">
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    </div>
    <br>

    <!-- Formulário para finalizar reservas -->
    <div class="container-global">
        <form class="formulario" action="reserva-finalizar.php" method="post">
            <label>VALOR TOTAL</label>
            <?php 
            $valortotal = "SELECT SUM(iv_valortotal) FROM tb_reservas WHERE iv_status = 1"; 
            $retornovalortotal = mysqli_query($link, $valortotal);
            $tblvalortotal = mysqli_fetch_array($retornovalortotal);
            echo "R$ ". ($tblvalortotal[0] ?? 0);
            ?>

            <input type="submit" value="FINALIZAR RESERVA">
        </form>
    </div>

</body>

</html>
