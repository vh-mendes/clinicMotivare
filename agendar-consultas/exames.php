<?php
require_once '../conexão.php';

// Inicializar mensagem de feedback
$mensagem = '';
session_start();


// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['date'] ?? '';
    $hora = $_POST['time'] ?? '';
    $convenio = $_POST['convenio'] ?? '';
    $forma_pagamento = $_POST['payment'] ?? '';
    $id_colaborador = $_POST['colaborador'] ?? '';
    $area = 'Fisioterapia';
    $id_paciente = $_SESSION['user_id']; // Substituir pelo ID do paciente logado, se houver integração
    $status = 'P'; // Status inicial: Pendente

    // Validar data e hora
    if (empty($data) || empty($hora)) {
        $mensagem = 'Por favor, informe data e horário válidos.';
    } else {
        // Verificar se a data é no passado (apenas permitir agendamentos a partir do dia seguinte)
        $data_atual = date('Y-m-d'); // Obtém a data atual no formato Y-m-d
        if ($data <= $data_atual) {
            $mensagem = 'Não é permitido agendar para datas passadas ou para o mesmo dia.';
        } else {
            // Verificar dia da semana e horário permitido
            $dia_semana = date('N', strtotime($data)); // 1 (segunda) a 7 (domingo)
            $hora_inicial = strtotime('08:00');
            $hora_final = strtotime('17:30');
            $hora_sabado_final = strtotime('12:00');
            $hora_atual = strtotime($hora);

            if (
                ($dia_semana >= 1 && $dia_semana <= 5 && ($hora_atual < $hora_inicial || $hora_atual > $hora_final)) ||
                ($dia_semana == 6 && ($hora_atual < $hora_inicial || $hora_atual > $hora_sabado_final)) ||
                ($dia_semana == 7)
            ) {
                $mensagem = 'Horário inválido para agendamento.';
            } else {
                // Verificar se já existe um agendamento nesse horário
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM consultas WHERE data = ? AND hora = ? AND id_colaborador = ?");
                $stmt->execute([$data, $hora, $id_colaborador]);
                $existe = $stmt->fetchColumn();

                if ($existe > 0) {
                    $mensagem = 'Já existe um agendamento nesse horário para o especialista selecionado.';
                } else {
                    // Inserir no banco de dados
                    $stmt = $pdo->prepare("INSERT INTO consultas (id_paciente, id_colaborador, data, hora, id_convenio, area, pagamento, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    if ($stmt->execute([$id_paciente, $id_colaborador, $data, $hora, $convenio, $area, $forma_pagamento, $status])) {
                        $mensagem = 'Agendamento realizado com sucesso!';
                    } else {
                        $mensagem = 'Erro ao realizar o agendamento.';
                    }
                }
            }
        }
    }
}
$stmt = $pdo->prepare("SELECT * FROM convenio");
$stmt->execute();
// Verifica se há resultados
$convenios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM colaboradores WHERE especialidade = 'Radiologista'");
$stmt->execute();
// Verifica se há resultados
$colaboradores = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT * FROM forma_de_pagamento");
$stmt->execute();
// Verifica se há resultados
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exames - Agendamento</title>
    <link rel="stylesheet" href="fisioterapia.css">
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
</head>

<body>
    <button class="voltar" onclick="location.href = 'agendesuaconsulta.php'">
        <img src="..\img\Consultas\botão.png" alt="Voltar" class="botão">
    </button>
    <div class="container">
        <header class="logo">
            <img src="../img/Principal/logo.png" alt="Logo Motivare">
            <h1></h1>
            <p></p>
        </header>
        <main>
            <div class="title-banner">
                <h2>Exames</h2>
            </div>
            <!-- Mensagem de feedback -->
            <?php if (!empty($mensagem)): ?>
                <div class="mensagem-feedback">
                    <p><?= htmlspecialchars($mensagem) ?></p>
                </div>
            <?php endif; ?>
            <form class="appointment-form" method="POST" action="">
    <!-- Linha 1: Data e Horário -->
    <div class="form-row">
        <div class="form-group">
            <label for="date">Data</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Horário</label>
            <input type="time" id="time" name="time" required step="1800">

        </div>
    </div>

    <!-- Linha 2: Convênio e Forma de Pagamento -->
    <div class="form-row">
        <div class="form-group">
            <label for="convenio">Convênio</label>
            <select id="convenio" name="convenio" required>
                <option value="">Selecione...</option>
                <?php
                foreach ($convenios as $convenio) {
                    echo "<option value=\"{$convenio['id_convenio']}\">{$convenio['nome']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="forma_pagamento">Pagamento</label>
            <select id="payment" name="payment" required>
                <option value="">Selecione...</option>
                <?php
                foreach ($payments as $payment) {
                    echo "<option value=\"{$payment['id_forma']}\">{$payment['descricao']}</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Linha 3: Colaborador Responsável -->
    <div class="form-row">
        <div class="form-group last">
            <label for="colaborador">Especialista</label>
            <select id="colaborador" name="colaborador" required>
                <option value="">Selecione...</option>
                <?php
                foreach ($colaboradores as $colaborador) {
                    echo "<option value=\"{$colaborador['id_colaborador']}\">{$colaborador['nome']}</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <!-- Linha 4: Botão Confirmar -->
    <div class="form-row">
        <div class="form-group last">
            <button class="botãoz" type="submit">Confirmar</button>
        </div>
    </div>
</form>
        </main>
    </div>
</body>

</html>