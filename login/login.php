<!-- @author - Sessões & Script do Logout > Uéslei Daniel Ribeiro de Oliveira 
     @since 15/12/2024           -->

<?php
// Inicia uma nova sessão ou retoma a sessão existente
session_start();

include('../conexão.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Verifique se os campos de email e senha estão preenchidos
    if (!empty($email) && !empty($password)) {
        // Preparar a consulta SQL para verificar o usuário no banco de dados
        $sql = "SELECT id_paciente, senha FROM pacientes WHERE email = :email";
        $stmt = $pdo->prepare($sql);

        // Certifique-se de que o array de parâmetros está correto
        $params = [':email' => $email];
        $stmt->execute($params);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifique se o usuário foi encontrado e a senha está correta
        if ($user && password_verify($password, $user['senha'])) {
            // Definir a variável de sessão com o ID do usuário
            $_SESSION['user_id'] = $user['id_paciente'];
            header('Location: ../index/index.php');
            exit;
        } else {
            // Tratar a falha de login
            $mensagem_erro = "Email ou senha inválidos. Tente novamente.";
        }
    } else {
        $mensagem_erro = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Motivare - Login</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="login.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <button class="voltar" onclick="location.href='../index/index.php'">
        <img src="../img/Consultas/botão.png" alt="Voltar" class="botão">
    </button>
    <div class="container">
        <header>
            <img src="../img/Login/logo.png" alt="Motivare Logo" class="logo">
        </header>
        <main>
            <h2>Crie sua conta ou faça login</h2>
            <p>Insira o e-mail e senha</p>
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Senha" required>
                <button type="submit" class="btn btn-primary">Continuar</button>
            </form>
            <p>ou</p>
            <a class="btn btn-secondary" href="../cadastro/cadastro.php">Cadastre-se</a>
        </main>
        <footer>
            <p>Clicando em continuar, você concorda com nossos <a href="#">Termos de Serviço</a> e <a href="#">Política de Privacidade</a>.</p>
        </footer>
        <?php if (isset($mensagem_erro)): ?>
            <div class="erro">
                <p><?php echo $mensagem_erro; ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
