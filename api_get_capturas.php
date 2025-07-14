<?php
// api_get_capturas.php

header('Content-Type: application/json');
require 'db.php'; // Conecta e garante que a tabela exista

try {
    // Seleciona todos os dados, ordenando pelos mais recentes primeiro
    $stmt = $pdo->query("SELECT * FROM captura_login ORDER BY id DESC");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($results);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Erro ao buscar dados: ' . $e->getMessage()]);
}
?>