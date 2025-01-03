<?php
// Configurações do Banco de Dados
$host = 'localhost'; // Endereço do servidor do banco de dados
$db   = 'clinica';   // Nome do banco de dados
$user = 'root';      // Nome de usuário do banco de dados
$pass = 'admin';      // Senha do banco de dados
$charset = 'utf8mb4';// Charset utilizado

// DSN (Data Source Name) para o PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opções adicionais do PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Ativa exceções para erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Configura o modo de busca padrão para associativo
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Desativa a emulação de prepared statements
];

try {
    // Tentando criar a conexão com o banco de dados usando PDO
    $pdo = new PDO($dsn, $user, $pass, $options);
    //echo "Conexão bem-sucedida com o banco de dados!";
} catch (PDOException $e) {
    // Em caso de erro na conexão, captura a exceção e exibe uma mensagem de erro
    die("Erro na conexão: " . $e->getMessage());
}
?>
