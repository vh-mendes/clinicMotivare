<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$codigo = $nome = '';

// Função para listar convênios
function listarConvenios($pdo) {
    $stmt = $pdo->query("SELECT id_convenio, codigo, nome FROM convenio ORDER BY id_convenio ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir convênio
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM convenio WHERE id_convenio = :id");
        $stmt->execute([':id' => $id]);
        $mensagem = "Convênio excluído com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao excluir convênio: " . $e->getMessage();
    }
}

// Lógica de Cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';

    if (!empty($codigo) && !empty($nome)) {
        try {
            $sql = "INSERT INTO convenio (codigo, nome) VALUES (:codigo, :nome)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':codigo' => $codigo,
                ':nome' => $nome,
            ]);
            $mensagem = "Convênio cadastrado com sucesso!";
            $codigo = $nome = ''; // Limpar campos após sucesso
        } catch (PDOException $e) {
            $mensagem = "Erro ao cadastrar convênio: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}

// Obter lista de convênios
$convenios = listarConvenios($pdo);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivare - Gerenciamento de Convênios</title>
    <link rel="stylesheet" href="cadastro.css">
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
</head>
<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <h2 class=editcl> GERENCIAR CONVÊNIOS</h2>
                </header>
            </div>
            <div class="voltarPagina">
                <a href="../admin/admin.php" class="voltarPagina">Voltar para página administrativa</a>
            </div>

            <main>
                <!-- Formulário de Cadastro -->
                <div class="form-container">
                    <h3>Cadastrar Convênio</h3>
                    <form action="" method="POST">
                        <input type="text" name="codigo" id="codigo" placeholder="Código do convênio" required value="<?php echo htmlspecialchars($codigo, ENT_QUOTES); ?>">
                        <input type="text" name="nome" id="nome" placeholder="Nome do convênio" required value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>">
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>

                <!-- Exibir Mensagem -->
                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <!-- Tabela de Convênios -->
                <div class="table-container">
                    <h3 class="h3teste">Convênios Cadastrados</h3>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($convenios as $convenio): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($convenio['id_convenio'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($convenio['codigo'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($convenio['nome'], ENT_QUOTES); ?></td>
                                    <td>
                                        <a href="editar_convenio.php?id=<?php echo $convenio['id_convenio']; ?>" class="btn-edit">Alterar</a>
                                        <a href="?delete=<?php echo $convenio['id_convenio']; ?>" onclick="return confirm('Tem certeza que deseja excluir este convênio?')" class="btn-delete">Excluir</a>
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
