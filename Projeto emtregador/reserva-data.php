<?php

include('conecta.php');





if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quadra = $_POST['quadra'];
    $data = $_POST['dia'];
    list($idquadra, $nomequadra, $valorquadra) = explode(',', $quadra);
    $horas = $_POST['horas'];
    $cliente = $_POST['cliente'];  
    //$horainicio = '0';
    $horainicio = isset($_POST['horario']) ? $_POST['horario'] : '';
   
  

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

            $sqlitem = "INSERT INTO tb_reservas (iv_valortotal, iv_horas, iv_cod_iv, fk_qd_id, fk_cli_id, iv_status, dia, horainicio)
            VALUES ($valortotal, $horas, '$codigo_reserva', $idquadra, $cliente, '1', '$data',  '$horainicio')";
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





//echo $data;

//DEFINE HORARIO PARA O MESMO DE SP
date_default_timezone_set('America/Sao_Paulo');

// Define a data desejada
$data_reserva = $data;
echo $idquadra;

// Consulta SQL para buscar horários reservados
$sql = "SELECT horainicio, horafim FROM tb_reservas WHERE dia = ? and fk_qd_id = $idquadra";
//echo $sql;
// Prepara a consulta
$stmt = mysqli_prepare($link, $sql);

// Liga o parâmetro da data à consulta preparada
mysqli_stmt_bind_param($stmt, "s", $data_reserva);

// Executa a consulta
mysqli_stmt_execute($stmt);

// Pega o resultado
$result = mysqli_stmt_get_result($stmt);

// Armazena os horários reservados em um array
$horarios_reservados = [];
while ($row = mysqli_fetch_assoc($result)) {
    $horarios_reservados[] = $row;
}

//print_r($horarios_reservados);

// Lista de horários disponíveis
$horarios_disponiveis = [
    '09:00',
    '09:30',
    '10:00',
    '10:30',
    '11:00',
    '11:30',
    '12:00',
    '12:30',
    '13:00',
    '13:30',
    '14:00',
    '14:30',
    '15:00',
    '15:30',
    '16:00',
    '16:30',
    '17:00',
    '17:30'
];

// Função para verificar se o horário está reservado
function horarioEstaReservado($hora, $reservas)
{
    foreach ($reservas as $reserva) {
        $hora_inicio = strtotime($reserva['horainicio']);
        $hora_fim = strtotime($reserva['horafim']);
        $hora_atual = strtotime($hora);

        if ($hora_atual >= $hora_inicio && $hora_atual < $hora_fim) {
            return true;
        }
    }
    return false;
    
}


 

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>HORARIO DA RESERVA</title>
</head>

<body>
    <div class="container-global">
        <form class="formulario" action="reserva-finalizar.php" method="post">

            <input type="hidden" name="horas" value="<?= $horas?>">

            <label>Selecione o horário:</label>
            <select name="horario">
                <?php foreach ($horarios_disponiveis as $horario) { ?>
                    <?php if (horarioEstaReservado($horario, $horarios_reservados)) { ?>
                        <option value="<?php echo $horario; ?>" disabled><?php echo $horario; ?> (Indisponível)</option>
                    <?php } else { ?>
                        <option value="<?php echo $horario; ?>"><?php echo $horario; ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <br>
            <br>
            <input type="submit" value="Reservar">

        </form>
    </div>
</body>

</html>