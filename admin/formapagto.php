<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$codigo = $descricao = '';

// Função para listar formas de pagamento
function listarFormasDePagamento($pdo) {
    $stmt = $pdo->query("SELECT id_forma, codigo, descricao FROM forma_de_pagamento ORDER BY id_forma ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir forma de pagamento
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM forma_de_pagamento WHERE id_forma = :id");
        $stmt->execute([':id' => $id]);
        $mensagem = "Forma de pagamento excluída com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao excluir forma de pagamento: " . $e->getMessage();
    }
}

// Lógica de Cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

    if (!empty($codigo) && !empty($descricao)) {
        try {
            $sql = "INSERT INTO forma_de_pagamento (codigo, descricao) VALUES (:codigo, :descricao)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':codigo' => $codigo,
                ':descricao' => $descricao,
            ]);
            $mensagem = "Forma de pagamento cadastrada com sucesso!";
            $codigo = $descricao = ''; // Limpar campos após sucesso
        } catch (PDOException $e) {
            $mensagem = "Erro ao cadastrar forma de pagamento: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}

// Obter lista de formas de pagamento
$formasDePagamento = listarFormasDePagamento($pdo);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivare - Gerenciamento de Formas de Pagamento</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <h2 class="editcl">GERENCIAR FORMAS DE PAGAMENTO</h2>
                </header>
            </div>

            <main>
                <!-- Formulário de Cadastro -->
                <div class="form-container">
                    <h3>Cadastrar Forma de Pagamento</h3>
                    <form action="" method="POST">
                        <input type="text" name="codigo" id="codigo" placeholder="Código da forma de pagamento" required value="<?php echo htmlspecialchars($codigo, ENT_QUOTES); ?>">
                        <input type="text" name="descricao" id="descricao" placeholder="Descrição da forma de pagamento" required value="<?php echo htmlspecialchars($descricao, ENT_QUOTES); ?>">
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>

                <!-- Exibir Mensagem -->
                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <!-- Tabela de Formas de Pagamento -->
                <div class="table-container">
                    <h3 class="h3teste">Formas de Pagamento Cadastradas</h3>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($formasDePagamento as $forma): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($forma['id_forma'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($forma['codigo'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($forma['descricao'], ENT_QUOTES); ?></td>
                                    <td>
                                        <a href="editar_forma_de_pagamento.php?id=<?php echo $forma['id_forma']; ?>" class="btn-edit">Alterar</a>
                                        <a href="?delete=<?php echo $forma['id_forma']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta forma de pagamento?')" class="btn-delete">Excluir</a>
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
