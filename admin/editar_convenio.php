<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$codigo = $nome = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validar o ID
if ($id <= 0) {
    die("ID de convênio inválido.");
}

// Obter os dados do convênio
try {
    $stmt = $pdo->prepare("SELECT id_convenio, codigo, nome FROM convenio WHERE id_convenio = :id");
    $stmt->execute([':id' => $id]);
    $convenio = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$convenio) {
        die("Convênio não encontrado.");
    }

    $codigo = $convenio['codigo'];
    $nome = $convenio['nome'];
} catch (PDOException $e) {
    die("Erro ao buscar convênio: " . $e->getMessage());
}

// Atualizar os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';

    if (!empty($codigo) && !empty($nome)) {
        try {
            $sql = "UPDATE convenio SET codigo = :codigo, nome = :nome WHERE id_convenio = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':codigo' => $codigo,
                ':nome' => $nome,
                ':id' => $id,
            ]);
            $mensagem = "Convênio atualizado com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar convênio: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Convênio</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <h2>Editar Convênio</h2>
                </header>
            </div>

            <main>
                <!-- Formulário de Edição -->
                <div class="form-container">
                    <form action="" method="POST">
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" id="codigo" value="<?php echo htmlspecialchars($codigo, ENT_QUOTES); ?>" required>

                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>" required>

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
