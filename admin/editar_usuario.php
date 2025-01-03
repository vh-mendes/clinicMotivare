<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$email = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validar se o ID do usuário foi enviado
if ($id <= 0) {
    die("ID de usuário inválido.");
}

// Obter os dados do usuário para edição
try {
    $stmt = $pdo->prepare("SELECT id_usuario, email FROM usuario WHERE id_usuario = :id");
    $stmt->execute([':id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        die("Usuário não encontrado.");
    }

    $email = $usuario['email'];
} catch (PDOException $e) {
    die("Erro ao buscar usuário: " . $e->getMessage());
}

// Processar o formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "O e-mail informado é inválido.";
    } else {
        try {
            // Atualizar os dados no banco de dados
            $sql = "UPDATE usuario SET email = :email" . (!empty($_POST['senha']) ? ", senha = :senha" : "") . " WHERE id_usuario = :id";
            $stmt = $pdo->prepare($sql);

            // Bind dos parâmetros
            $params = [':email' => $email, ':id' => $id];
            if (!empty($_POST['senha'])) {
                $params[':senha'] = $senha;
            }

            $stmt->execute($params);
            $mensagem = "Usuário atualizado com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar usuário: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <h2>Editar Usuário</h2>
                </header>
            </div>

            <div class="voltarPagina">
                <a href="usuario.php" class="voltarPagina">Voltar para lista de usuários</a>
            </div>

            <main>
                <!-- Formulário de Edição -->
                <div class="form-container">
                    <form action="" method="POST">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" required>
                        
                        <label for="senha">Nova Senha (opcional)</label>
                        <input type="password" name="senha" id="senha" placeholder="Digite uma nova senha (opcional)">
                        
                        <button type="submit">Salvar Alterações</button>
                    </form>
                </div>

                <!-- Exibir Mensagem -->
                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </section>
</body>
</html>
