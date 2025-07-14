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
            gap: 80px; /* Aumentando o espaço entre as colunas */
            flex-grow: 1;
        }
        
        /* Coluna da Esquerda */
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

        .user-identifier-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background-color: #ededed;
            border-radius: 6px;
            padding: 12px;
            margin-top: 32px;
        }

        .user-identifier-box span {
            font-size: 14px;
            font-weight: 500;
            color: #333;
        }

        .user-identifier-box a {
            font-size: 14px;
            color: #3483fa;
            text-decoration: none;
            margin-left: auto; /* Empurra o link para a direita */
        }
        .user-identifier-box a:hover { text-decoration: underline; }

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
            padding: 16px 0; /* Padding vertical, sem padding horizontal */
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

        .verification-option .icon-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e3edff;
            display: flex;
            align-items: center;
            justify-content: center;
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
            margin-left: auto; /* Empurra a seta para a direita */
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
        
        <div class="left-column">
            <span class="session-start-label">INÍCIO DE SESSÃO</span>
            <h1 class="main-title">Escolha um método de verificação para iniciar sessão</h1>
            
            <div class="user-identifier-box">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                
                <?php
                    // Em uma aplicação real, o CPF viria da sessão ou do banco de dados
                    $cpf_identificador = "CPF 288.114.198-67"; 
                ?>
                <span><?php echo htmlspecialchars($cpf_identificador); ?></span>
                
                <a href="/index.php">Trocar conta</a>
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