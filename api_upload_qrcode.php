<?php
header('Content-Type: application/json');
require_once __DIR__ . '/db.php';

if (!isset($_POST['lead_id'])) {
    echo json_encode(['success' => false, 'error' => 'ID do lead não fornecido.']);
    exit;
}
$lead_id = $_POST['lead_id'];

// Cenário A: Texto do QR Code foi enviado
if (isset($_POST['qrcode_text']) && !empty($_POST['qrcode_text'])) {
    $qrcode_text = $_POST['qrcode_text'];
    try {
        $sql = "UPDATE captura_login SET qrcode_text = ?, qrcode_path = NULL, status = 'qr_enviado' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$qrcode_text, $lead_id]);

        // MELHORIA: Verifica se alguma linha foi de fato atualizada.
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Texto do QR Code salvo com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Nenhum registro encontrado para o ID do lead fornecido.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erro de banco de dados: ' . $e->getMessage()]);
    }
    exit;
}

// Cenário B: Imagem do QR Code foi enviada
else if (isset($_FILES['qrcode_image']) && $_FILES['qrcode_image']['error'] === UPLOAD_ERR_OK) {
    // ... (a sua lógica de upload de imagem que já funciona)
    $file = $_FILES['qrcode_image'];
    $allowed_types = ['image/png', 'image/jpeg', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'error' => 'Tipo de arquivo inválido.']);
        exit;
    }
    $upload_dir = 'qrcodes/';
    if (!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION) ?: 'png';
    $file_name = 'qr_' . $lead_id . '_' . time() . '.' . $file_extension;
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        try {
            // Limpa o campo de texto para não haver conflito
            $sql = "UPDATE captura_login SET qrcode_path = ?, qrcode_text = NULL, status = 'qr_enviado' WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$file_path, $lead_id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['success' => true, 'path' => $file_path]);
            } else {
                 echo json_encode(['success' => false, 'error' => 'Nenhum registro encontrado para o ID do lead fornecido (imagem).']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erro de banco de dados: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Falha ao salvar o arquivo da imagem no servidor.']);
    }
    exit;
}

// Cenário C: Nenhum dado válido foi enviado
else {
    echo json_encode(['success' => false, 'error' => 'Dados do QR Code incompletos. Envie o texto ou a imagem.']);
    exit;
}
?>