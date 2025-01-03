<?php 

// @author 
// Vítor Hugo Mendes
// @since 30/11/2024        

// Configurações do Banco de Dados
include('../conexão.php');

// Variáveis para mensagem e campos
$mensagem = '';
$nome = $cpf = $data_nascimento = $telefone = $email = '';

// Função para validar CPF
function validarCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);
    if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

// Lógica de Processamento do Formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar e limpar os dados do formulário
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $cpf = isset($_POST['cpf']) ? preg_replace('/\D/', '', $_POST['cpf']) : '';
    $data_nascimento = isset($_POST['data_nascimento']) ? $_POST['data_nascimento'] : '';
    $telefone = isset($_POST['telefone']) ? preg_replace('/\D/', '', $_POST['telefone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : '';

    // Validações básicas
    if (strlen($cpf) !== 11) {
        $mensagem = "O CPF deve ter exatamente 11 números.";
    } elseif (!validarCPF($cpf)) {
        $mensagem = "O CPF informado é inválido.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "O email informado é inválido.";
    } else {
        // Verificar se o CPF ou o email já estão cadastrados
        $sqlCheck = "SELECT COUNT(*) FROM pacientes WHERE cpf = :cpf OR email = :email";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([':cpf' => $cpf, ':email' => $email]);
        $registroExistente = $stmtCheck->fetchColumn();

        if ($registroExistente > 0) {
            $mensagem = "O CPF ou email já está cadastrado.";
        } elseif (!empty($nome) && !empty($cpf) && !empty($data_nascimento) && !empty($telefone) && !empty($email) && !empty($senha)) {
            // Inserção dos dados no banco de dados
            try {
                $sql = "INSERT INTO pacientes (nome, cpf, data_nascimento, telefone, email, senha)
                        VALUES (:nome, :cpf, :data_nascimento, :telefone, :email, :senha)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':nome' => $nome,
                    ':cpf' => $cpf,
                    ':data_nascimento' => $data_nascimento,
                    ':telefone' => $telefone,
                    ':email' => $email,
                    ':senha' => $senha
                ]);
                $mensagem = "Cadastro realizado com sucesso!";
                // Limpar os campos do formulário após o sucesso
                $nome = $cpf = $data_nascimento = $telefone = $email = '';
            } catch (PDOException $e) {
                $mensagem = "Erro ao realizar o cadastro: " . $e->getMessage();
            }
        } else {
            $mensagem = "Por favor, preencha todos os campos.";
        }
    }
}
?>

<!DOCTYPE html>

<!--  @author > Aline Nunes
      @since 28/11/2024        -->

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motivare - Cadastro</title>
    <link rel="icon" type="image/png" href="../img/Principal/Ícone-Navegador/motivare.png">
    <link rel="stylesheet" href="cadastro.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
            <a href="../index/index.php" class="voltarPagina">Voltar para página inicial</a>
        </div>

        <div class="voltarPaginaLogin">
            <a href="../login/login.php" class="voltarPaginaLogin">Ir para página de login</a>
        </div>

        <main>
            <div class="form-container">
                <form action="" method="POST">
                    <h2>Faça seu cadastro</h2>     
                    <input type="text" name="nome" placeholder="Nome completo" required value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>">
                    <input type="text" name="cpf" id="cpf" placeholder="CPF" maxlength="14" required value="<?php echo htmlspecialchars($cpf, ENT_QUOTES); ?>">
                    <input type="date" name="data_nascimento" placeholder="Data de nascimento" required value="<?php echo htmlspecialchars($data_nascimento, ENT_QUOTES); ?>">
                    <input type="tel" name="telefone" id="telefone" placeholder="Número de telefone" required value="<?php echo htmlspecialchars($telefone, ENT_QUOTES); ?>">
                    <input type="email" name="email" placeholder="E-mail" required value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>">
                    <input type="password" name="senha" placeholder="Senha" required>
                    <button type="submit">Avançar</button>
                </form>
            </div>
            <div class="image-container">
                <img src="../img/Cadastro/fisioterapia.jpg" alt="Sessão de fisioterapia">
            </div>
        </main>
    </section>

    <!-- Exibindo a mensagem de sucesso ou erro -->
    <?php if (isset($mensagem)): ?>
        <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'success' : 'error'; ?>">
            <?php echo $mensagem; ?>
            <br>
        </div>
    <?php endif; ?>
    </div>

    <script src="cadastro.js"></script>
</body>
</html>
