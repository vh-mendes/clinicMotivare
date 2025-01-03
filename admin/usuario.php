<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$email = '';

// Função para listar usuários
function listarUsuarios($pdo)
{
    $stmt = $pdo->query("SELECT id_usuario, email FROM usuario ORDER BY id_usuario ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir usuário
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM usuario WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $mensagem = "Usuário excluído com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao excluir usuário: " . $e->getMessage();
    }
}

// Lógica de Inserção do Formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar e limpar os dados do formulário
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "O email informado é inválido.";
    } else {
        // Verificar se o email já está cadastrado
        $sqlCheck = "SELECT COUNT(*) FROM usuario WHERE email = :email";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':email' => $email]);
        $registroExistente = $stmtCheck->fetchColumn();

        if ($registroExistente > 0) {
            $mensagem = "O email já está cadastrado.";
        } elseif (!empty($email) && !empty($senha)) {
            // Inserir no banco de dados
            try {
                $sql = "INSERT INTO usuario (email, senha) VALUES (:email, :senha)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':email' => $email,
                    ':senha' => $senha
                ]);
                $mensagem = "Usuário cadastrado com sucesso!";
                $email = ''; // Limpar o campo de email após o cadastro
            } catch (PDOException $e) {
                $mensagem = "Erro ao cadastrar usuário: " . $e->getMessage();
            }
        } else {
            $mensagem = "Por favor, preencha todos os campos.";
        }
    }
}

// Obter lista de usuários
$usuarios = listarUsuarios($pdo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivare - Gerenciamento de Usuários</title>
    <link rel="stylesheet" href="cadastro.css">
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
</head>

<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <img src="../img/Cadastro/logo.png" alt="Motivare Logo" class="cabecalho-logo">
                </header>
            </div>

            <div class="voltarPagina">
                <a href="../admin/admin.php" class="voltarPagina">Voltar para página administrativa</a>
            </div>

            <main class="principal">
                <!-- Formulário de Cadastro -->
                <div class="form-container">
                    <h2>Cadastrar Usuário ADMIN</h2>
                    <form action="" method="POST">
                        <input type="email" name="email" placeholder="E-mail" required 
                            value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                        <input type="password" name="senha" placeholder="Senha" required>
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>

                <!-- Exibindo a mensagem de sucesso ou erro -->
                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <!-- Tabela de usuários -->
                <div class="table-container">
                    <h2 class="uc2">Usuários Cadastrados:</h2>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>E-mail</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($usuario['email'], ENT_QUOTES); ?></td>
                                    <td>
                                        <a href="editar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn-edit">Alterar ou</a>
                                        <a href="?delete=<?php echo $usuario['id_usuario']; ?>" 
                                           onclick="return confirm('Tem certeza que deseja excluir este usuário?')" 
                                           class="btn-delete">Excluir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </section>
</body>

</html>