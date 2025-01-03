<!-- @author - Sessões & Script do Logout > Uéslei Daniel Ribeiro de Oliveira 
     @since 15/12/2024           -->

     <?php
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

?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivare - Fisioterapia e Ortopedia</title>
    <link rel="stylesheet" href="agendesuaconsulta.css">
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
</head>
<body>
<button class="voltar" onclick="location.href = '../index/index.php'">
      <img src="..\img\Consultas\botão.png" alt="Voltar" class= "botão">
</button>
    <div class="container">
        <header class="logo">
            <img class="logo-main" src="../img/Principal/logo.png" alt="Logo Motivare">
            <h1></h1>
            <p></p>
        </header>
        <main>
            <h2>Agende sua consulta</h2>
            <div class="services">
            <button class="services" onclick="location.href = 'fisioterapia.php'"> Fisioterapia
            </button>
            <button class="services" onclick="location.href = 'exames.php'"> Exames
            </button>
            <button class="services" onclick="location.href = 'ortopedia.php'"> Ortopedia
            </button>
            </div>
        </main>
    </div>
</body>
</html>