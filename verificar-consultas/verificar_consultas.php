<?php


// Incluindo a conexão com o banco de dados
include('C:\xampp\htdocs\motivare\conexão.php'); // Caminho para o arquivo de conexão

// Inicia a sessão. Isso permite que o PHP gerencie e mantenha informações do usuário através de várias páginas.
session_start();


// Verifica se a variável de sessão 'user_id' está definida. Isso indica se o usuário está autenticado.
if (!isset($_SESSION['user_id'])) {
  // Se 'user_id' não estiver definida, o usuário não está autenticado.
  // Redireciona o usuário para a página de login.
  header('Location: ../login/login.php');

  // Encerra a execução do script. Isso garante que o restante do código não seja executado após o redirecionamento.
  exit;
}
// O ID do paciente agora é obtido a partir da sessão
$id_paciente = $_SESSION['user_id'];  // Usando o ID do usuário da sessão

// Consulta SQL para buscar consultas em aberto
$sql = "SELECT data, hora, cl.nome as colaborador, area, fp.descricao as pagamento, cn.nome as convenio 
        FROM consultas c 
        INNER JOIN colaboradores cl ON c.id_colaborador = cl.id_colaborador 
        INNER JOIN convenio cn ON c.id_convenio = cn.id_convenio 
        INNER JOIN forma_de_pagamento fp ON c.pagamento = fp.id_forma
        WHERE id_paciente = :id_paciente AND status = 'P'";
/*
// Suponha que o ID do usuário seja obtido de alguma forma, como por exemplo, a partir de uma sessão
$id_paciente = 1;  // Exemplo de ID do usuário

// Consulta SQL para buscar consultas em aberto
$sql = "SELECT data, hora, cl.nome as colaborador, pagamento, cn.nome as convenio FROM consultas c inner join colaboradores cl on c.id_colaborador = cl.id_colaborador inner
join convenio cn on c.id_convenio = cn.id_convenio WHERE id_paciente = :id_paciente AND status = 'a'";

*/
$stmt = $pdo->prepare($sql);  // Usando PDO para preparar a consulta
$stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);  // Ligando o parâmetro ao ID do paciente
$stmt->execute();  // Executando a consulta

// Verificando se o usuário tem consultas em aberto
$has_open_consultations = $stmt->rowCount() > 0;  // Usando rowCount para verificar se existem resultados

// Consulta SQL para buscar informações do convênio
$sql_convenio = "SELECT id_convenio, nome FROM convenio";

$stmt_convenio = $pdo->prepare($sql_convenio);  //Usando PDO para preparar a consulta
//$stmt_convenio->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);  // Ligando o parâmetro ao ID do paciente
$stmt_convenio->execute();  // Executando a consulta

// Verificando se o usuário tem informações de convênio
$has_convenio = $stmt_convenio->rowCount() > 0;  // Usando rowCount para verificar se existem resultados

?>


<!DOCTYPE html>
<html>

<head>
  <title>Minhas Consultas - Motivare</title>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link href="verificar_consultas.css" rel="stylesheet">
</head>

<body>
  <section class="container">
    <div class="container_principal">
      <header>
        <img src="..\img\Principal\logo.png" alt="Logo Motivare" class="logo">
        <button class="voltar" onclick="location.href = '../index/index.php'">
          <img src="..\img\Consultas\botão.png" alt="Voltar" class="botão">
        </button>
        <h1>MINHAS CONSULTAS</h1>
      </header>
      <main>
        <h2>Consultas em aberto</h2>

        <div class="table-container">
          <?php if ($has_open_consultations): ?>
            <table class="styled-table">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Horário</th>
                  <th>Especialista</th>
                  <th>Área</th>
                  <th>Convênio</th>
                  <th>Pagamento</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                  <tr>
                    <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                    <td><?= $row['hora'] ?></td>
                    <td><?= htmlspecialchars($row['colaborador']) ?></td>
                    <td><?= htmlspecialchars($row['area']) ?></td>
                    <td><?= htmlspecialchars($row['convenio']) ?></td>
                    <td><?= htmlspecialchars($row['pagamento']) ?></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
        </div>
      <?php else: ?>
        <p class="no-consultations">Nenhuma consulta em aberto.</p>
      <?php endif; ?>
      </main>

    </div>
  </section>
</body>

</html>

<?php
// Fechando a conexão
$pdo = null;
?>