<?php
 
include('conecta.php');
 
//DEFINE HORARIO PARA O MESMO DE SP
date_default_timezone_set('America/Sao_Paulo');
 
// Define a data desejada
$data_reserva = '2024-10-24';
 
 
// Consulta SQL para buscar horários reservados
$sql = "SELECT horainicio, horafim FROM reservas WHERE data_reservas = ?";
 
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
 
// Lista de horários disponíveis
$horarios_disponiveis = [
    '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
    '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
    '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
];
 
// Função para verificar se o horário está reservado
function horarioEstaReservado($hora, $reservas) {
    foreach ($reservas as $reserva) {
        $hora_inicio = strtotime($reserva['hora_inicio']);
        $hora_fim = strtotime($reserva['hora_fim']);
        $hora_atual = strtotime($hora);
 
        if ($hora_atual >= $hora_inicio && $hora_atual < $hora_fim) {
            return true;
        }
    }
    return false;
}
 
// Gera o select com os horários disponíveis
echo '<select name="horario">';
foreach ($horarios_disponiveis as $horario) {
    if (horarioEstaReservado($horario, $horarios_reservados)) {
        echo '<option value="' . $horario . '" disabled>' . $horario . ' (Indisponível)</option>';
    } else {
        echo '<option value="' . $horario . '">' . $horario . '</option>';
    }
}
echo '</select>';
 
// Fecha a conexão
mysqli_close($link);
 
?>