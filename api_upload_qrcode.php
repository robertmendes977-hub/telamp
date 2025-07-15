<?php
// api_upload_qrcode.php

header('Content-Type: application/json');
require 'db.php'; // Inclui a conexão com o banco de dados

// --- Validação Inicial ---
// Verifica se os dados necessários (ID do lead e a imagem) foram enviados.
if (!isset($_POST['lead_id']) || !isset($_FILES['qrcode_image'])) {
    die(json_encode(['success' => false, 'error' => 'Dados incompletos. ID do lead ou imagem ausente.']));
}

$leadId = $_POST['lead_id'];
$file = $_FILES['qrcode_image'];

// --- Validação do Arquivo ---

// Verifica se houve algum erro no upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    die(json_encode(['success' => false, 'error' => 'Erro no upload do arquivo. Código: ' . $file['error']]));
}

// Verifica o tipo de arquivo (MIME type)
$allowedTypes = ['image/png', 'image/jpeg', 'image/gif'];
if (!in_array($file['type'], $allowedTypes)) {
    die(json_encode(['success' => false, 'error' => 'Tipo de arquivo não permitido. Apenas PNG, JPG ou GIF.']));
}

// Verifica o tamanho do arquivo (limite de 2MB)
if ($file['size'] > 2 * 1024 * 1024) {
    die(json_encode(['success' => false, 'error' => 'Arquivo muito grande. O limite é de 2MB.']));
}


// --- Processamento e Armazenamento do Arquivo ---

// Define o diretório de uploads.
$uploadDir = 'qrcodes/';

// Cria o diretório no servidor se ele ainda não existir.
if (!is_dir($uploadDir)) {
    // 0755 são permissões padrão que geralmente funcionam.
    // O 'true' permite a criação de diretórios aninhados.
    if (!mkdir($uploadDir, 0755, true)) {
        die(json_encode(['success' => false, 'error' => 'Falha ao criar o diretório de uploads. Verifique as permissões.']));
    }
}

// Cria um nome de arquivo único para evitar que um arquivo sobrescreva o outro.
$fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
$newFileName = uniqid('qr_', true) . '.' . $fileExtension;
$uploadPath = $uploadDir . $newFileName;

// Move o arquivo da pasta temporária do PHP para o nosso diretório de uploads.
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    
    // --- Atualização do Banco de Dados ---
    // Se o arquivo foi salvo com sucesso, atualiza o caminho no banco.
    try {
        $stmt = $pdo->prepare("UPDATE captura_login SET qrcode_path = ? WHERE id = ?");
        $stmt->execute([$uploadPath, $leadId]);
        
        // Retorna uma mensagem de sucesso para o painel do admin.
        echo json_encode(['success' => true, 'message' => 'QR Code enviado com sucesso!', 'path' => $uploadPath]);

    } catch (PDOException $e) {
        // Se der erro no banco, deleta o arquivo que acabamos de salvar para não deixar lixo no servidor.
        unlink($uploadPath);
        echo json_encode(['success' => false, 'error' => 'Erro ao salvar caminho no banco de dados: ' . $e->getMessage()]);
    }

} else {
    // Se a função move_uploaded_file falhar
    echo json_encode(['success' => false, 'error' => 'Falha ao mover o arquivo para o destino. Verifique as permissões do diretório.']);
}

?>