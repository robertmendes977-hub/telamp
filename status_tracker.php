<?php
/**
 * Atualiza o status do lead no banco de dados com base na página atual.
 *
 * @param string $status A mensagem de status a ser salva.
 */
function update_user_status($status) {
    if (empty($status)) {
        return;
    }

    $cookie_id = $_COOKIE['identificador_cliente'] ?? null;
    if (!$cookie_id) {
        return;
    }

    // Caminho ajustado para o db.php na raiz do projeto.
    require_once __DIR__ . '/db.php';

    if (isset($pdo)) {
        try {
            $sql = "UPDATE captura_login SET status = ? WHERE id = (
                        SELECT id FROM captura_login
                        WHERE session_id = ?
                        ORDER BY id DESC
                        LIMIT 1
                    )";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$status, $cookie_id]);
        } catch (PDOException $e) {
            error_log('Erro ao atualizar status do usuário: ' . $e->getMessage());
        }
    }
}
?>