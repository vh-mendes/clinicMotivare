<?php
// Incluindo a conexão com o banco de dados
include('C:\xampp\htdocs\motivare\conexão.php');

// Inicia a sessão
session_start();

// // Verifica se o usuário está autenticado
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ../login/login.php');
//     exit;
// }

// Verifica se um ID de consulta foi enviado para atualização do status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_consulta'])) {
    $id_consulta = intval($_POST['id_consulta']);
    try {
        // Atualiza o status da consulta para "F" (Finalizada)
        $sql_update = "UPDATE consultas SET status = 'F' WHERE id_consulta = :id_consulta";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([':id_consulta' => $id_consulta]);
        $mensagem = "Consulta finalizada com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao atualizar a consulta: " . $e->getMessage();
    }
}

// Consulta SQL para buscar todas as consultas pendentes
$sql = "SELECT c.id_consulta, c.data, c.hora, cl.nome AS colaborador, cn.nome AS convenio, c.pagamento, p.nome AS cliente
        FROM consultas c 
        INNER JOIN colaboradores cl ON c.id_colaborador = cl.id_colaborador 
        INNER JOIN convenio cn ON c.id_convenio = cn.id_convenio 
        INNER JOIN pacientes p ON c.id_paciente = p.id_paciente
        WHERE c.status = 'P'";

$stmt = $pdo->prepare($sql);
$stmt->execute();

// Verifica se há consultas pendentes
$has_open_consultations = $stmt->rowCount() > 0;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>Consultas Pendentes - Motivare</title>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="cadastro.css">
</head>
<body>
<section class="container">
  <div class="container_principal">
    <header class="logo17">        
      <img src="..\img\Principal\logo.png" alt="Logo Motivare" class="logo17">
      <!-- <button class="voltar" onclick="location.href = '../admin/admin.php'">
        <img src="..\img\Consultas\botão.png" alt="Voltar" class="botão">
      </button> -->
      </header> 
      <h1 class="alinhar">CONSULTAS PENDENTES:</h1>
 
    <main>
      <!-- <h2>Consultas em Aberto</h2> -->

      <?php if ($has_open_consultations): ?>
        <form method="POST" action="">
          <table class="styled-table">
            <thead>
              <tr>
                <th>Data</th>
                <th>Horário</th>
                <th>Cliente</th>
                <th>Colaborador</th>
                <th>Convênio</th>
                <th>Pagamento</th>
                <th>Selecionar</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                  <td><?= htmlspecialchars($row['hora'], ENT_QUOTES) ?></td>
                  <td><?= htmlspecialchars($row['cliente'], ENT_QUOTES) ?></td>
                  <td><?= htmlspecialchars($row['colaborador'], ENT_QUOTES) ?></td>
                  <td><?= htmlspecialchars($row['convenio'], ENT_QUOTES) ?></td>
                  <td><?= htmlspecialchars($row['pagamento'], ENT_QUOTES) ?></td>
                  <td>
                    <input type="radio" name="id_consulta" value="<?= $row['id_consulta'] ?>" required>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <button type="submit" class="btn-finalizar">FINALIZAR CONSULTA</button>
        </form>
      <?php else: ?>
        <p class="no-consultations">Nenhuma consulta em aberto.</p>
      <?php endif; ?>

      <?php if (!empty($mensagem)): ?>
        <p class="mensagem"><?= htmlspecialchars($mensagem, ENT_QUOTES) ?></p>
      <?php endif; ?>
    </main>
  </div>
</section>
</body>
</html>
