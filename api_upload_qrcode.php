<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

// Validação dos dados recebidos
if (!isset($_POST['lead_id']) || !isset($_FILES['qrcode_image'])) {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos.']);
    exit;
}

$lead_id = $_POST['lead_id'];
$file = $_FILES['qrcode_image'];

// Validação do arquivo de imagem
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'Erro no upload do arquivo.']);
    exit;
}
$allowed_types = ['image/png', 'image/jpeg', 'image/gif'];
if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['success' => false, 'error' => 'Tipo de arquivo inválido.']);
    exit;
}

// Cria um nome de arquivo único e define o caminho para salvar
$upload_dir = 'qrcodes/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}
$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION) ?: 'png';
$file_name = 'qr_' . $lead_id . '_' . time() . '.' . $file_extension;
$file_path = $upload_dir . $file_name;

// Move o arquivo para a pasta de uploads
if (move_uploaded_file($file['tmp_name'], $file_path)) {
    try {
        // Salva o caminho do arquivo no banco de dados
        $sql = "UPDATE captura_login SET qrcode_path = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$file_path, $lead_id]);

        echo json_encode(['success' => true, 'path' => $file_path]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erro de banco de dados: ' . $e->getMessage()]);
    }
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Falha ao salvar o arquivo no servidor.']);
}
?>