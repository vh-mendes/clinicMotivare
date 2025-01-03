<!-- @author > Vítor Hugo Mendes
     @since 26/11/2024           -->

<!-- @author - Sessões & Script/Criação/Estilo do Logout > Uéslei Daniel Ribeiro de Oliveira 
     @since 15/12/2024           -->
     <?php
// Inicia uma nova sessão ou retoma a sessão existente
session_start();

// Verifica se o botão de logout foi clicado (se o formulário foi enviado)
if (isset($_POST['logout'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destroi a sessão atual
    session_destroy();

    // Redireciona o usuário para a página de login
    header("Location: ../login/login.php");
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS8to5wMEThrVZ4CV8Z1PVGvSQ1BLqByA&callback=initMap" async defer></script>
    <script src="mapa.js" defer></script>
</head>

<body>
    <header class="header">
        <nav class="navbar">
            <ul class="listacabecalho">
                <li class="logocabecalho"><img src="../img/Principal/Cabeçalho/teste.png" alt="Logo"></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Se o usuário estiver logado, exibe o botão de logout -->
                    <li>
                        <form action="" method="POST">
                            <button style="background-color:#13547a; color: #ffffff; border: none; padding: 10px 20px;
                            font-size: 16px; cursor: pointer; border-radius: 5px; transition: background-color 0.3s ease;" id="logout-button" type="submit" name="logout">Sair</button>
                        </form>
                    </li>
                <?php else: ?>
                    <!-- Se o usuário não estiver logado, exibe o botão de login -->
                    <li class="itenscabecalho"><a href="../login/login.php">Faça seu login</a></li>
                    <li class="itenscabecalho"><a href="../cadastro/cadastro.php">Cadastre-se</a></li>
                <?php endif; ?>

                <li class="itenscabecalho"><a href="#quemsomos">Quem somos</a></li>
                <li class="itenscabecalho"><a href="#servicos">Serviços</a></li>
                <li class="itenscabecalho"><a href="#equipe">Nossa Equipe</a></li>
                <li class="itenscabecalho"><a href="../agendar-consultas/agendesuaconsulta.php">Agende seu horário</a></li>
                <li class="itenscabecalho"><a href="../verificar-consultas/verificar_consultas.php">Verifique suas consultas</a></li>
                <li class="itenscabecalho"><a href="#nossoscontatos">Contatos</a></li>
            </ul>
        </nav>
    </header>

    <script>
        // Obtém o elemento do botão de logout pelo seu ID
        var button = document.getElementById('logout-button');

        // Adiciona um ouvinte de evento para o evento 'mouseover'
        button.addEventListener('mouseover', () => {
            // Altera a cor de fundo do botão para '#0a3c59' quando o mouse está sobre o botão
            button.style.backgroundColor = '#4c9755';
        });

        // Adiciona um ouvinte de evento para o evento 'mouseout'
        button.addEventListener('mouseout', () => {
            // Restaura a cor de fundo do botão para '#0a3c59' quando o mouse sai do botão
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

    <section id="quemsomos" class="parte-dois">
        <div class="containterp2_img">
            <img src="../img/Principal/Section-02/seção2.jpg" alt="Imagem">
        </div>

        <div class="container__p2">
            <h2 class="containerp2__título">QUEM SOMOS</h2>
            <p class="containerp2__descricao">A <strong class="strong">Motivare</strong> é uma clínica de fisioterapia e
                ortopedia com preços acessíveis e se dedica em oferecer serviços médicos e fisioterapêuticos <strong
                    class="strong"> especializados</strong>, assim como exames de qualidade e precisão, para o
                diagnóstico e tratamento de pacientes de <strong class="strong"> todas as idades</strong>. Contamos
                também com equipamentos modernos e equipe treinada para melhorar a experiência dos nossos pacientes.</p>
        </div>
    </section>

    <section id="servicos" class="parte-tres">
        <h3 class="p3__titulo"> NOSSOS SERVIÇOS </h3>

        <div class="containerp3_imgs">
            <ul class="servicos">
                <li class="servicosimg">
                    <img src="../img/Principal/Section-03/fisioterapia.jpg" alt="imagem">
                    <p class="servicos-txt">FISIOTERAPIA</p>
                </li>
                <li class="servicosimg">
                    <img src="../img/Principal/Section-03/exames.jpg" alt="imagem">
                    <p class="servicos-txt">EXAMES</p>
                </li>
                <li class="servicosimg">
                    <img src="../img/Principal/Section-03/ortopedia.jpg" alt="imagem">
                    <p class="servicos-txt">ORTOPEDIA</p>
                </li>
            </ul>
        </div>
    </section>

    <section id="equipe" class="parte-quatro">
        <h4 class="p4__titulo"> NOSSA EQUIPE </h4>

        <div class="containerp4_imgs">
            <ul class="equipe">
                <li class="equipeimg">
                    <img src="../img/Principal/Equipe-Motivare/Cláudia - Fisioterapeuta.jpeg" alt="imagem">
                    <p class="equipe-txt">CLÁUDIA <p class="profissão"> Fisioterapeuta </p> </p>
                </li>
                <li class="equipeimg">
                    <img src="../img/Principal/Equipe-Motivare/Amanda - Fisioterapeuta.jpeg" alt="imagem">
                    <p class="equipe-txt">AMANDA <p class="profissão"> Fisioterapeuta </p> </p>
                </li>
                <li class="equipeimg">
                    <img src="../img/Principal/Equipe-Motivare/Gustavo - Ortopédico.jpeg" alt="imagem">
                    <p class="equipe-txt">Dr. GUSTAVO <p class="profissão"> Ortopédico </p> </p>
                </li>
                <li class="equipeimg">
                    <img src="../img/Principal/Equipe-Motivare/Gabriel - Ortopédico.jpeg" alt="imagem">
                    <p class="equipe-txt">Dr. GABRIEL <p class="profissão"> Ortopédico </p> </p>
                </li>
                <li class="equipeimg">
                    <img src="../img/Principal/Equipe-Motivare/Lucas - Biomédico.jpeg" alt="imagem">
                    <p class="equipe-txt">LUCAS <p class="profissão"> Radiologista </p> </p>
                </li>
                <li class="equipeimg">
                    <img src="../img/Principal/Equipe-Motivare/Jéssica - Biomédica.jpeg" alt="imagem">
                    <p class="equipe-txt">JÉSSICA <p class="profissão"> Radiologista </p> </p>
                </li>
            </ul>
        </div>
    </section>

    <section class="parte-cinco">
        <h5 class="p5__titulo"> O QUE OFERECEMOS </h5>
            <div class="containerp5">
                <ul class="oferecemos">                
                    <li class="oferecemosbox">
                        <h6 class="descof"> Fisioterapia traumato-ortopédica </h6>
                        <br>
                        <p class="desc-txt">Nosso foco e o cuidado e a prevenção de lesões ortopédicas causadas por traumas. Nesse sentido, a fisioterapia traumato-ortopédica é utilizada em casos de luxação, torção, fratura e pós-amputação. Esse ramo tem diversos pacientes como público-alvo, desde crianças até idosos e atletas.</p>
                    </li>
                    <li class="oferecemosbox">
                        <h6 class="descof"> Fisioterapia esportiva </h6>
                        <br>
                        <p class="desc-txt"> Nosso foco é ajudar no desempenho físico de atletas, sejam amadores sejam profissionais. Por isso, nossos fisioterapeutas se dedicam às avaliações funcionais periódicas. O seu papel é garantir melhores performances por meio da prevenção e, se necessário, do tratamento e da reabilitação de lesões ou traumas causados pela prática das atividades físicas. </p>
                    </li>
                    <li class="oferecemosbox">
                        <h6 class="descof"> Ortopedia e traumatologia </h6>
                        <br>
                        <p class="desc-txt">A  ortopedia é uma especialidade que cuida da saúde e prevenção de problemas de saúde relacionados ao aparelho locomotor. Já a traumatologia é uma ramificação da ortopedia que cuida apenas de traumas ocorridos no aparelho musculoesquelético.</p>
                    </li>  
                    <li class="oferecemosbox">
                        <h6 class="descof"> Exames </h6>
                        <br>
                        <p class="desc-txt"> Exames laboratoriais e exames por imagem. </p>
                    </li>   
                </ul>
        </div>
        <img src="../img/Principal/Section-05/img-section5.jpg" alt="Imagem" class="imagem-section5">   
    </section>

    <section class="parte-seis">
        <div class="containerp6">
            <ul class="funcionamento">                
                <li class="horariofuncionamento">
                    <h7 class="titulohorariofuncionamento">Horário de funcionamento: </h7>
                    
                    <p class="desc-txtp6">
                        Segunda-feira: 08:00 - 17:30 <br> 
                        Terça-feira: 08:00 - 17:30 <br> 
                        Quarta-feira: 08:00 - 17:30 <br> 
                        Quinta-feira: 08:00 - 17:30 <br> 
                        Sexta-feira: 08:00 - 17:30 <br> 
                        Sábado: 08:00 - 12:00
                    </p>
                </li>
            </ul>  
        </div>
        <h6 class="p6__titulo">
            <a href="../agendar-consultas/agendesuaconsulta.php" class="link-titulo">AGENDE SEU HORÁRIO </a>
        </h6>
    </section>

    <section class="parte-sete">
        <h4 class="p7__titulo">FEEDBACK DOS NOSSOS CLIENTES</h4>
        <div class="containerp7">
            <div class="feedback-box">
                <p class="feedback-text">"Excelente atendimento! Profissionais qualificados e muito atenciosos. Recomendo a todos!"</p>
                <p class="client-name">João Silva</p>
                <div class="stars">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                </div>
            </div>
    
            <div class="feedback-box">
                <p class="feedback-text">"Me senti muito bem acolhida. Os profissionais são incríveis e o tratamento foi perfeito!"</p>
                <p class="client-name">Maria Oliveira</p>
                <div class="stars">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                </div>
            </div>
    
            <div class="feedback-box">
                <p class="feedback-text">"A clínica é maravilhosa! Me ajudaram a melhorar muito. Realmente voltarei pelo atendimento top!"</p>
                <p class="client-name">Carlos Pereira</p>
                <div class="stars">
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                    <span class="star">&#9733;</span>
                </div>
            </div>
        </div>
    </section>

    <section id="nossoscontatos" class="parte-oito">
        <div class="enderecos">
            <h4 class="titulo-endereco">ENDEREÇO:</h4>       
                <img src="../img/Principal/Ícones/localizaçao.png" alt="Localização" class="icon-localizacao">
                <p class="endereco">Avenida Teodoreco n1000 - Mário Arantes, Prata MG</p>
        </div>
        <div class="contatos">
            <h4 class="titulo-contatos">CONTATOS:</h4>
                <img src="../img/Principal/Ícones/telefone.png" alt="Telefone" class="icon-contato">
                <p class="info-contato">(34) 3431-2020</p>
                <img src="../img/Principal/Ícones/whatsapp.png" alt="WhatsApp" class="icon-contato">
                <p class="info-contato">(34) 9 9484-0002</p>          
                <img src="../img/Principal/Ícones/email.png" alt="Email" class="icon-contato">
                <p class="info-contato">atendimento@motivare.com.br</p>          
        </div>
        <div class="midias-sociais">
            <h4 class="titulo-midias">MÍDIAS SOCIAIS:</h4>
                <img src="../img/Principal/Ícones/instagram.png" alt="Instagram" class="icon-midia">
                <p class="info-midia">@motivareclinica</p>
                <img src="../img/Principal/Ícones/facebook.png" alt="Facebook" class="icon-midia">
                <p class="info-midia">@clinica.motivare</p>
        </div>
        <div id="map"></div>
    </section>


</body>


</html>