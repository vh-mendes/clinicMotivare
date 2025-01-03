<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$nome = $crm = $telefone = $especialidade = '';

// Função para listar colaboradores
function listarColaboradores($pdo) {
    $stmt = $pdo->query("SELECT id_colaborador, nome, crm_crf, telefone, especialidade FROM colaboradores ORDER BY id_colaborador ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir colaborador
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $stmt = $pdo->prepare("DELETE FROM colaboradores WHERE id_colaborador = :id");
        $stmt->execute([':id' => $id]);
        $mensagem = "Colaborador excluído com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao excluir colaborador: " . $e->getMessage();
    }
}

// Lógica de Cadastro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $crm = isset($_POST['crm']) ? trim($_POST['crm']) : '';
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
    $especialidade = isset($_POST['especialista']) ? trim($_POST['especialista']) : '';

    if (!empty($nome) && !empty($crm) && !empty($telefone) && !empty($especialidade)) {
        try {
            $sql = "INSERT INTO colaboradores (nome, crm_crf, telefone, especialidade) 
                    VALUES (:nome, :crm, :telefone, :especialidade)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':crm' => $crm,
                ':telefone' => $telefone,
                ':especialidade' => $especialidade
            ]);
            $mensagem = "Colaborador cadastrado com sucesso!";
            $nome = $crm = $telefone = $especialidade = ''; // Limpar campos após sucesso
        } catch (PDOException $e) {
            $mensagem = "Erro ao cadastrar colaborador: " . $e->getMessage();
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}

// Obter lista de colaboradores
$colaboradores = listarColaboradores($pdo);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivare - Gerenciamento de Colaboradores</title>
    <link rel="stylesheet" href="cadastro.css">
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
</head>
<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <!-- <h2>GERENCIAR COLABORADORES</h2> -->
                </header>
            </div>

            <main>
                <!-- Formulário de Cadastro -->
                <div class="voltarPagina">
                <a href="../admin/admin.php" class="voltarPagina">Voltar para página administrativa</a>
            </div>

                <div class="form-container">
                    <h3 CLASS="cadastc">CADASTRAR COLABORADOR</h3>
                    <form action="" method="POST">
                        <input type="text" name="nome" placeholder="Nome completo" required value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>">
                        <input type="text" name="crm" placeholder="CRM/CRF" maxlength="45" required value="<?php echo htmlspecialchars($crm, ENT_QUOTES); ?>">
                        <input type="tel" name="telefone" placeholder="Número de telefone" required value="<?php echo htmlspecialchars($telefone, ENT_QUOTES); ?>">

                        <label for="especialidade">ESPECIALIDADE:</label>
                        <select id="especialista" name="especialista" required>
                            <option value="">Selecione...</option>
                            <option value="Radiologista" <?php echo $especialidade == 'Radiologista' ? 'selected' : ''; ?>>Radiologista</option>
                            <option value="Ortopedista" <?php echo $especialidade == 'Ortopedista' ? 'selected' : ''; ?>>Ortopedista</option>
                            <option value="Fisioterapeuta" <?php echo $especialidade == 'Fisioterapeuta' ? 'selected' : ''; ?>>Fisioterapeuta</option>
                        </select>

                        <button type="submit">Cadastrar</button>
                    </form>
                </div>

                <!-- Exibir Mensagem -->
                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
                        <?php echo $mensagem; ?>
                    </div>
                <?php endif; ?>

                <!-- Tabela de Colaboradores -->
                <div class="table-container">
                    <h3 class="h3teste">Colaboradores cadastrados:</h3>
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CRM/CRF</th>
                                <th>Telefone</th>
                                <th>Especialidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($colaboradores as $colaborador): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($colaborador['id_colaborador'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($colaborador['nome'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($colaborador['crm_crf'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($colaborador['telefone'], ENT_QUOTES); ?></td>
                                    <td><?php echo htmlspecialchars($colaborador['especialidade'], ENT_QUOTES); ?></td>
                                    <td>
                                        <a href="editar_colaborador.php?id=<?php echo $colaborador['id_colaborador']; ?>" class="btn-edit">Alterar</a>
                                        <a href="?delete=<?php echo $colaborador['id_colaborador']; ?>" onclick="return confirm('Tem certeza que deseja excluir este colaborador?')" class="btn-delete">Excluir</a>
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
