<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuste do Header</title>
    <style>
        /* Estilo básico para o corpo da página */
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Estilo do cabeçalho */
        .main-header {
            background-color: #ffe600; /* Cor de fundo amarela */
            height: 60px; /* Altura do cabeçalho */
            display: flex; /* Ativa o Flexbox para alinhar itens */
            align-items: center; /* Alinha o logo verticalmente no centro */

            /* --- PONTO DE AJUSTE PRINCIPAL --- */
            /* Altere o valor do padding-left para mover o logo. */
            padding-left: 650px; /* Valor inicial, pode ser alterado */
        }

        /* Estilo da imagem do logo */
        .main-header img {
            height: 37px; /* Altura do logo */
        }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    </body>
</html>