<?php
// api_salvar_identificador.php

// Define o cabeçalho de resposta como JSON
header('Content-Type: application/json');

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
    // Prepara a query SQL para inserir os dados de forma segura
    $stmt = $pdo->prepare("INSERT INTO captura_login (identificador) VALUES (?)");
    $stmt->execute([$identificador]);
    
    // Pega o ID da última inserção
    $lastId = $pdo->lastInsertId();

    // Retorna uma resposta de sucesso com o ID
    echo json_encode(['success' => true, 'id' => $lastId]);

} catch (PDOException $e) {
    // Em caso de erro no banco de dados, retorna uma mensagem de erro
    echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()]);
}

?>