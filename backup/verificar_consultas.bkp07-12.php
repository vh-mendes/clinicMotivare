
              <?php
// Incluindo a conexão com o banco de dados
include('./conexão.php'); // Caminho relativo para incluir o arquivo de conexão

// Suponha que o ID do usuário seja obtido de alguma forma, como por exemplo, a partir de uma sessão
$user_id = 1;  // Exemplo de ID do usuário

// Consulta SQL para buscar consultas em aberto
$sql = "SELECT data, hora, area, id_colaborador, valor FROM consultas WHERE id_paciente = ? AND status = 'aberta'";
$stmt = $dsn->prepare($sql);
$stmt->bind_param("i", $user_id); // "i" significa que o parâmetro é um inteiro
$stmt->execute();
$result = $stmt->get_result();

// Verificando se o usuário tem consultas em aberto
$has_open_consultations = $result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
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
        <img src="..\img\Consultas\botão.png" alt="Voltar" class= "botão">
      </button>
      <h1>MINHAS CONSULTAS</h1>
    </header> 
    <main>
        <h2>Consultas em aberto</h2>
        
        <?php if ($has_open_consultations): ?>
          <ul class="table">
            <li class="cell">Data</li>
            <li class="cell">Horário</li>
            <li class="cell">Área</li>
            <li class="cell">Especialista</li>
            <li class="cell">Pagamento</li>
          </ul>

          <?php while ($row = $result->fetch_assoc()): ?>
            <ul class="table">
              <li class="cell"><?= date('d/m/Y', strtotime($row['data'])) ?></li>
              <li class="cell"><?= $row['hora'] ?></li>
              <li class="cell"><?= $row['area'] ?></li>
              <li class="cell"><?= $row['especialista'] ?></li>
              <li class="cell"><?= $row['pagamento']?></li>
            </ul>
          <?php endwhile; ?>
        
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
$stmt->close();
$conexao->close();
?>