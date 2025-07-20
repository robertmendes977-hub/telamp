<?php
// Define que a resposta será em formato JSON
header('Content-Type: application/json');

// Inclui o seu arquivo de conexão com o banco de dados
require_once __DIR__ . '/db.php';

// --- PASSO 1: VALIDAÇÃO DOS DADOS RECEBIDOS ---
// Verifica se o ID do lead e o texto do QR Code foram enviados via POST
if (!isset($_POST['lead_id']) || !isset($_POST['qrcode_text'])) {
    echo json_encode(['success' => false, 'error' => 'Dados incompletos. ID do lead ou texto do QR Code não recebido.']);
    exit;
}

// Armazena os dados em variáveis
$lead_id = $_POST['lead_id'];
$qrcode_text = $_POST['qrcode_text'];

// Valida se o texto do QR Code não está vazio
if (empty($qrcode_text)) {
    echo json_encode(['success' => false, 'error' => 'O texto do QR Code não pode estar vazio.']);
    exit;
}

// --- PASSO 2: ATUALIZAÇÃO DO BANCO DE DADOS ---
try {
    // Prepara o comando SQL para atualizar a tabela 'captura_login'.
    // Ele vai inserir o texto do QR na coluna 'qrcode_text' e também atualizar o status.
    // Lembre-se que você precisa ter a coluna 'qrcode_text' na sua tabela.
    $sql = "UPDATE captura_login SET qrcode_text = ?, status = 'qr_enviado' WHERE id = ?";
    
    // Prepara a query para execução segura (evita SQL Injection)
    $stmt = $pdo->prepare($sql);
    
    // Executa a query, passando os valores recebidos
    if ($stmt->execute([$qrcode_text, $lead_id])) {
        // Se a execução for bem-sucedida, retorna uma resposta de sucesso
        echo json_encode(['success' => true, 'message' => 'Texto do QR Code salvo com sucesso.']);
    } else {
        // Se houver uma falha na execução (ex: lead_id não existe)
        echo json_encode(['success' => false, 'error' => 'Falha ao atualizar o registro no banco de dados.']);
    }

} catch (PDOException $e) {
    // Se ocorrer um erro na conexão ou na preparação da query
    http_response_code(500); // Código de Erro Interno do Servidor
    // Em produção, é melhor registrar o erro em um log do que mostrá-lo ao usuário.
    echo json_encode(['success' => false, 'error' => 'Erro de banco de dados: ' . $e->getMessage()]);
}
?>