<?php
header('Content-Type: application/json');
require 'db.php'; // Seu arquivo de conexão com o banco

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'error' => 'ID do lead não fornecido.']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM capturas WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Nenhum lead encontrado com este ID.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
?>