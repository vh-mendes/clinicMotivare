<!-- @author > Vítor Hugo Mendes
     @since 26/11/2024           -->

<!-- @author - Sessões & Script/Criação/Estilo do Logout > Uéslei Daniel Ribeiro de Oliveira 
     @since 15/12/2024           -->

     <?php
// Inicia uma nova sessão ou retoma a sessão existente
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['admin_id'])) {
    header('Location: login_admin.php'); // Redireciona para a página de login
    exit;
}
// Verifica se o botão de logout foi clicado (se o formulário foi enviado)
if (isset($_POST['logout'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destroi a sessão atual
    session_destroy();

    // Redireciona o usuário para a página de login
    header("Location: ../admin/login_admin.php");
    exit; // Garante que o script pare de executar após o redirecionamento
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivare | Ortopedia e Fisioterapia</title>
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <!-- API para definir a fonte que irei utilizar = MONTSERRAT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Meta para quando compartilhar o link do nosso site aparecer essas informações -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Clínica Motivare - Preocupa com você" />
    <meta property="og:image" content="../img/Principal/logo.png" />
    <meta property="og:description" content=" A melhor clínica de ortopedia e fisioterapia para você!" />
    <meta property="og:site_name" content="Clínica Motivare" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS8to5wMEThrVZ4CV8Z1PVGvSQ1BLqByA&callback=initMap" async defer></script>
    <script src="mapa.js" defer></script>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <ul class="listacabecalho">
                <li class="logocabecalho"><img src="../img/Principal/Cabeçalho/teste.png" alt="Logo"></li>
                <li class="itenscabecalho"><a href="../admin/usuario.php">Usuários</a></li>
                <li class="itenscabecalho"><a href="../admin/colaboradores.php">Colaboradores</a></li>
                <li class="itenscabecalho"><a href="../admin/convenio.php">Convenios</a></li>
                <li class="itenscabecalho"><a href="../admin/formapagto.php">Forma Pagamento</a></li>
                <li class="itenscabecalho"><a href="../admin/atender_paciente.php">Atender Paciente</a>                </li>
                <!-- <li class="itenscabecalho"><a href="../agendar-consultas/agendesuaconsulta.php">Reagendar Consulta</a></li> -->
                
                <li>
                <form action="" method="POST">
                <button style= "background-color:#13547a; color: #ffffff; border: none; padding: 10px 20px;
                  font-size: 16px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease;" id="logout-button" type="submit" name="logout">Sair</button>
                </form>

  
            </li>
            </ul>
        </nav>
    </header>
    <script>
    // Obtém o elemento do botão de logout pelo seu ID
    var button = document.getElementById('logout-button');

    // Adiciona um ouvinte de evento para o evento 'mouseover'
    button.addEventListener('mouseover', () => {
        // Altera a cor de fundo do botão para '#e04351' quando o mouse está sobre o botão
        button.style.backgroundColor = '#4c9755';
    });

    // Adiciona um ouvinte de evento para o evento 'mouseout'
    button.addEventListener('mouseout', () => {
        // Restaura a cor de fundo do botão para '#ff4b5c' quando o mouse sai do botão
        button.style.backgroundColor = '#13547a';
    });
</script>
<section class="parte-um">
        <div class="container__p1">
            <h1 class="containerp1__título">Seu caminho para um <br> melhor bem-estar <br> físico começa aqui! </h1>
            <p class="containerp1__descricao">Conte com nossos especialistas em fisioterapia <br> e ortopedia para
                ajudá-lo a se mover melhor e a <br> se sentir melhor.</p>
        </div>
    </section>




   
</body>


</html>