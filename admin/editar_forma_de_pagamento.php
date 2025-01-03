<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$codigo = $descricao = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validar o ID
if ($id <= 0) {
    die("ID da forma de pagamento inválido.");
}

// Obter os dados da forma de pagamento
try {
    $stmt = $pdo->prepare("SELECT id_forma, codigo, descricao FROM forma_de_pagamento WHERE id_forma = :id");
    $stmt->execute([':id' => $id]);
    $forma = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$forma) {
        die("Forma de pagamento não encontrada.");
    }

    $codigo = $forma['codigo'];
    $descricao = $forma['descricao'];
} catch (PDOException $e) {
    die("Erro ao buscar forma de pagamento: " . $e->getMessage());
}

// Atualizar os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

    if (!empty($codigo) && !empty($descricao)) {
        try {
            $sql = "UPDATE forma_de_pagamento SET codigo = :codigo, descricao = :descricao WHERE id_forma = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':codigo' => $codigo,
                ':descricao' => $descricao,
                ':id' => $id,
            ]);
            $mensagem = "Forma de pagamento atualizada com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar forma de pagamento: " . $e->getMessage();
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
    <title>Editar Forma de Pagamento</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <h2>Editar Forma de Pagamento</h2>
                </header>
            </div>

            <main>
                <!-- Formulário de Edição -->
                <div class="form-container">
                    <form action="" method="POST">
                        <label for="codigo">Código</label>
                        <input type="text" name="codigo" id="codigo" value="<?php echo htmlspecialchars($codigo, ENT_QUOTES); ?>" required>

                        <label for="descricao">Descrição</label>
                        <input type="text" name="descricao" id="descricao" value="<?php echo htmlspecialchars($descricao, ENT_QUOTES); ?>" required>

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
