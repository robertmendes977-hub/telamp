<?php
// Define o tipo de resposta como JSON
header('Content-Type: application/json');
require 'db.php'; // Inclui a conexão com o banco

// Pega os dados enviados no corpo da requisição
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

// Validação simples do ID
if (empty($id) || !is_numeric($id)) {
    echo json_encode(['success' => false, 'error' => 'ID do lead inválido ou não fornecido.']);
    exit;
}

try {
    // Prepara a query de deleção para evitar SQL Injection
    $stmt = $pdo->prepare("DELETE FROM captura_login WHERE id = ?");
    $stmt->execute([$id]);

    // Verifica se alguma linha foi realmente afetada
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Nenhum lead encontrado com o ID fornecido.']);
    }
} catch (PDOException $e) {
    // Em caso de erro no banco, retorna uma mensagem de erro genérica
    http_response_code(500); // Erro de servidor
    echo json_encode(['success' => false, 'error' => 'Erro no banco de dados.']);
}
?>