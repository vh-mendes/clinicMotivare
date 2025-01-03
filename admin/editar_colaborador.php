<?php

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$nome = $crm = $telefone = $especialidade = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validar o ID
if ($id <= 0) {
    die("ID de colaborador inválido.");
}

// Obter os dados do colaborador
try {
    $stmt = $pdo->prepare("SELECT * FROM colaboradores WHERE id_colaborador = :id");
    $stmt->execute([':id' => $id]);
    $colaborador = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$colaborador) {
        die("Colaborador não encontrado.");
    }

    $nome = $colaborador['nome'];
    $crm = $colaborador['crm_crf'];
    $telefone = $colaborador['telefone'];
    $especialidade = $colaborador['especialidade'];
} catch (PDOException $e) {
    die("Erro ao buscar colaborador: " . $e->getMessage());
}

// Atualizar os dados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $crm = isset($_POST['crm']) ? trim($_POST['crm']) : '';
    $telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
    $especialidade = isset($_POST['especialista']) ? trim($_POST['especialista']) : '';

    if (!empty($nome) && !empty($crm) && !empty($telefone) && !empty($especialidade)) {
        try {
            $sql = "UPDATE colaboradores SET nome = :nome, crm_crf = :crm, telefone = :telefone, especialidade = :especialidade WHERE id_colaborador = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':crm' => $crm,
                ':telefone' => $telefone,
                ':especialidade' => $especialidade,
                ':id' => $id
            ]);
            $mensagem = "Colaborador atualizado com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro ao atualizar colaborador: " . $e->getMessage();
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
    <title>Editar Colaborador</title>
    <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <section>
        <div class="container">
            <div class="cabecalho">
                <header class="header">
                    <h2 class="editcl">EDITAR COLABORADOR</h2>
                </header>
            </div>

            <main>
                <!-- Formulário de Edição -->
                <div class="form-container">
                    <form action="" method="POST">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>" required>

                        <label for="crm">CRM/CRF</label>
                        <input type="text" name="crm" id="crm" value="<?php echo htmlspecialchars($crm, ENT_QUOTES); ?>" required>

                        <label for="telefone">Telefone</label>
                        <input type="tel" name="telefone" id="telefone" value="<?php echo htmlspecialchars($telefone, ENT_QUOTES); ?>" required>

                        <label for="especialista">Especialidade</label>
                        <select id="especialista" name="especialista" required>
                            <option value="">Selecione...</option>
                            <option value="Radiologista" <?php echo $especialidade == 'Radiologista' ? 'selected' : ''; ?>>Radiologista</option>
                            <option value="Ortopedista" <?php echo $especialidade == 'Ortopedista' ? 'selected' : ''; ?>>Ortopedista</option>
                            <option value="Fisioterapeuta" <?php echo $especialidade == 'Fisioterapeuta' ? 'selected' : ''; ?>>Fisioterapeuta</option>
                        </select>

                        <button type="submit">Salvar</button>
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
