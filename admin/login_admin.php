<?php
// Incluindo a conexão com o banco de dados
include('../conexão.php');

// Inicia a sessão
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Consulta para verificar o usuário no banco de dados
    $sql = "SELECT id_usuario, senha FROM usuario WHERE email = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':usuario' => $usuario]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se o usuário existe e a senha está correta
    if ($admin && password_verify($senha, $admin['senha'])) {
        // Define a sessão do usuário
        $_SESSION['admin_id'] = $admin['id_usuario'];
        header('Location: admin.php'); // Redireciona para a página de administração
        exit;
    } else { 
        $mensagem  = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Motivare</title>
    <link rel="stylesheet" href="login_admin.css">
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <header>
            <img src="../img/Login/logo.png" alt="Motivare Logo" class="logo">
        </header>
        <h2 class="login-admin">Login Admin</h2>
        <form method="POST" action="">
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>

            <div class="entrar">
                <button class="btn-primary" type="submit">Entrar</button>
            </div>
        </form>
        <?php if (!empty($mensagem)): ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem, ENT_QUOTES); ?></p>
        <?php endif; ?>
    </div>
</body>

</html>