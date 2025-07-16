<?php
// Define o tipo de resposta como JSON
header('Content-Type: application/json');
require 'db.php'; // Inclui a conexão com o banco

try {
    // TRUNCATE TABLE é mais rápido que DELETE e reseta o auto-incremento do ID
    $pdo->exec("TRUNCATE TABLE captura_login RESTART IDENTITY");
    
    // Se não houver exceção, a operação foi um sucesso
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Em caso de erro no banco, retorna uma mensagem
    http_response_code(500); // Erro de servidor
    echo json_encode(['success' => false, 'error' => 'Erro ao limpar a tabela no banco de dados.']);
}
?>