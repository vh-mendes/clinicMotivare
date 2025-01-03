<?php
require_once 'conexão.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = $_POST['tipo']; // Tipo de agendamento (exame, fisioterapia, ortopedia)
    $data = $_POST['date'];
    $hora = $_POST['time'];
    $pagamento = $_POST['payment'];
    $id_colaborador = $_POST['colaborador'];

    // Validar horário dentro do intervalo permitido
    $hora_inicial = strtotime('08:00');
    $hora_final = strtotime('17:30');
    $hora_sabado_final = strtotime('12:00');
    $hora_atual = strtotime($hora);

    $dia_semana = date('N', strtotime($data)); // 1 (segunda) a 7 (domingo)

    if (
        ($dia_semana >= 1 && $dia_semana <= 5 && ($hora_atual < $hora_inicial || $hora_atual > $hora_final)) ||
        ($dia_semana == 6 && ($hora_atual < $hora_inicial || $hora_atual > $hora_sabado_final)) ||
        ($dia_semana == 7)
    ) {
        die("Horário inválido para agendamento.");
    }

    // Verificar se já existe um agendamento no mesmo horário
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM consultas WHERE data = ? AND hora = ? AND id_colaborador = ?");
    $stmt->execute([$data, $hora, $id_colaborador]);
    $existe = $stmt->fetchColumn();

    if ($existe > 0) {
        die("Já existe um agendamento nesse horário para o colaborador selecionado.");
    }

    // Inserir no banco de dados
    $stmt = $pdo->prepare("INSERT INTO consultas (id_paciente, id_colaborador, data, hora, status) VALUES (?, ?, ?, ?, ?)");
    $id_paciente = 1; // Aqui você pode integrar com o login do paciente.
    $status = 'P'; // Status: Pendente

    if ($stmt->execute([$id_paciente, $id_colaborador, $data, $hora, $status])) {
        echo "Agendamento de $tipo realizado com sucesso!";
    } else {
        echo "Erro ao realizar o agendamento de $tipo.";
    }
}
?>
