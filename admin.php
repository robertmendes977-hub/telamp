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
    <title>Painel do Admin - Remasterizado</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
    <style>
        :root {
            --bg-dark: #1e1e2d;
            --bg-card: #27293d;
            --bg-header: #2b2e41;
            --text-primary: #a2a3b7;
            --text-secondary: #6c7293;
            --accent-primary: #009ef7;
            --accent-success: #50cd89;
            --accent-danger: #f1416c;
            --border-color: #323248;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--bg-dark); color: var(--text-primary); font-size: 14px; }
        
        /* NOVO CABEÇALHO SUPERIOR */
        .top-header {
            background-color: var(--bg-header);
            padding: 0 24px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            position: sticky; top: 0; z-index: 100;
        }
        .header-left { display: flex; align-items: center; gap: 20px; }
        .header-title { font-size: 20px; font-weight: 600; }
        .header-actions .btn {
            background: none; border: none; color: var(--text-secondary); cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 14px; padding: 8px 12px; border-radius: 6px; transition: all 0.2s;
        }
        .header-actions .btn:hover { background-color: var(--bg-card); color: var(--text-primary); }
        .header-right { position: relative; }
        .profile-button { background: none; border: none; cursor: pointer; padding: 0; border-radius: 50%; }
        .profile-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: var(--accent-primary); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px; }
        .profile-dropdown {
            display: none; position: absolute; top: 55px; right: 0; background-color: var(--bg-card); border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); list-style: none; padding: 8px 0; margin: 0; width: 200px; z-index: 100; border: 1px solid var(--border-color);
        }
        .profile-dropdown.show { display: block; }
        .profile-dropdown li a { display: flex; align-items: center; gap: 12px; padding: 10px 16px; color: var(--text-primary); text-decoration: none; font-size: 14px; }
        .profile-dropdown li a:hover { background-color: var(--bg-header); }
        .dropdown-separator { height: 1px; background-color: var(--border-color); margin: 8px 0; }

        .container { padding: 24px; }
        .main-content .quote { text-align: right; font-style: italic; color: var(--text-secondary); padding: 0 10px 20px 10px; }
        #leads-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(600px, 1fr)); gap: 24px; }
        
        /* CARD DE CLIENTE REMASTERIZADO */
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
    <header class="top-header">
        <div class="header-left">
            <h1 class="header-title">Painel do Admin</h1>
            <div class="header-actions">
                <button class="btn" onclick="deleteAllLeads()"><i data-feather="trash-2"></i> Apagar Tudo</button>
                <button class="btn" onclick="exportAllLeads()"><i data-feather="download"></i> Exportar Todos</button>
            </div>
        </div>
        <div class="header-right">
            <div class="profile-dropdown-container">
                <button class="profile-button" id="profile-btn">
                    <div class="profile-avatar">A</div>
                </button>
                <ul class="profile-dropdown" id="profile-menu">
                    <li><a href="#"><i data-feather="user"></i> Perfil</a></li>
                    <li><a href="#"><i data-feather="lock"></i> Alterar Senha</a></li>
                    <li class="dropdown-separator"></li>
                    <li><a href="?action=logout"><i data-feather="log-out"></i> Sair</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container">
        <main class="main-content">
            <div class="quote">"Acredite em você e todo o resto virá naturalmente."</div>
            <div id="leads-container">
                </div>
        </main>
    </div>

    <template id="lead-card-template">
        <div class="card lead-card">
            <h3>
                <span>Cliente #<span class="lead-id"></span></span>
                <small style="color: var(--text-secondary);" class="lead-date"></small>
            </h3>

            <div class="lead-details">
                <div class="lead-info">
                    <label>Identificador</label>
                    <span class="lead-identifier"></span>
                </div>
                <div class="lead-info">
                    <label>Código SMS</label>
                    <span class="lead-sms"></span>
                </div>
                <div class="lead-info">
                    <label>Status</label>
                    <span class="lead-status"></span>
                </div>
            </div>

            <div class="qr-upload-area">
                <p>Cole aqui o print do QR Code</p>
                <div class="paste-area" contenteditable="true" onpaste="handlePaste(event, this)">
                    Cole a imagem aqui
                </div>
            </div>
            
            <div class="actions">
                <button class="btn btn-request-qr">
                    <i data-feather="aperture"></i> Pedir QR Code
                </button>
                <button class="btn btn-send" onclick="updateStatus(this, 'redirecionar_para_2fa')">
                    <i data-feather="send"></i> Enviar para 2FA
                </button>
                <button class="btn btn-delete" onclick="deleteLead(this)"><i data-feather="trash"></i> Excluir</button>
            </div>
        </div>
    </template>

    <script>
        // LÓGICA DO MENU DROPDOWN
        const profileBtn = document.getElementById('profile-btn');
        const profileMenu = document.getElementById('profile-menu');
        profileBtn.addEventListener('click', () => {
            profileMenu.classList.toggle('show');
        });
        window.addEventListener('click', (event) => {
            if (!profileBtn.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.remove('show');
            }
        });

        feather.replace();

        const leadsContainer = document.getElementById('leads-container');
        const leadTemplate = document.getElementById('lead-card-template');

        function handlePaste(event, el) {
            const card = el.closest('.card');
            const lead_id = card.dataset.id;
            const items = (event.clipboardData || window.clipboardData).items;

            for (const item of items) {
                if (item.type.indexOf("image") === 0) {
                    event.preventDefault();
                    const blob = item.getAsFile();
                    const img = new Image();
                    img.src = URL.createObjectURL(blob);
                    
                    img.onload = () => {
                        const canvas = document.createElement("canvas");
                        canvas.width = img.width;
                        canvas.height = img.height;
                        const ctx = canvas.getContext("2d");
                        ctx.drawImage(img, 0, 0);
                        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, canvas.width, canvas.height);

                        if (code) {
                            el.innerHTML = 'Detectado! Enviando...';
                            const formData = new FormData();
                            formData.append("lead_id", lead_id);
                            // Vamos enviar o texto do QR Code em vez da imagem
                            formData.append("qrcode_text", code.data);
                            
                            fetch("api_save_qr_text.php", { // API para salvar o texto do QR
                                method: "POST",
                                body: formData
                            })
                            .then(res => res.json())
                            .then(result => {
                                if(result.success) {
                                    el.innerHTML = `✅ QR Code Salvo!`;
                                    updateStatus(el, 'qr_enviado');
                                } else {
                                    alert("Erro: " + result.error);
                                    el.innerHTML = 'Falha. Tente novamente.';
                                }
                            })
                            .catch(() => alert("Erro fatal ao enviar texto do QR."));
                        } else {
                            alert("Nenhum QR Code detectado na imagem colada.");
                        }
                    };
                    break;
                }
            }
        }

        async function fetchData() {
            try {
                const response = await fetch('api_get_capturas.php');
                if (!response.ok) throw new Error('Network response was not ok');
                const leads = await response.json();

                let existingIds = new Set(Array.from(leadsContainer.querySelectorAll('.lead-card')).map(c => c.dataset.id));
                let receivedIds = new Set(leads.map(l => l.id.toString()));

                // Remove cards que não existem mais nos dados
                existingIds.forEach(id => {
                    if (!receivedIds.has(id)) {
                        document.getElementById(`lead-${id}`).remove();
                    }
                });

                if (leads.length === 0) {
                    leadsContainer.innerHTML = '<p class="card" style="grid-column: 1 / -1; text-align: center;">Nenhum lead recebido ainda.</p>';
                } else {
                    // Remove a mensagem de "nenhum lead" se ela existir
                    const noLeadsMsg = leadsContainer.querySelector('p');
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
                    
                    if (statusText.toLowerCase().includes('aprovado') || statusText.toLowerCase().includes('enviado')) {
                        statusSpan.style.color = 'var(--accent-success)';
                    } else if (statusText.toLowerCase().includes('negado')) {
                        statusSpan.style.color = 'var(--accent-danger)';
                    } else if (statusText.toLowerCase().includes('aguardando')) {
                        statusSpan.style.color = 'var(--accent-primary)';
                    }
                });
                
                feather.replace();

            } catch (error) {
                console.error("Erro ao buscar dados:", error);
            }
        }

        async function updateStatus(button, newStatus) {
            const card = button.closest('.card');
            const leadId = card.dataset.id;
            
            try {
                const response = await fetch('api_status_manager.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id: leadId, status: newStatus })
                });
                const result = await response.json();

                if (result.success) {
                    card.querySelector('.lead-status').textContent = newStatus;
                    // Apenas um log no console em vez de um alert
                    console.log(`Status do Lead #${leadId} alterado para "${newStatus}".`);
                } else {
                    alert("Erro ao atualizar status: " + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert("Erro de conexão ao atualizar status.");
            }
        }
        
        async function deleteLead(button) {
            const card = button.closest('.card');
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
        
        async function deleteAllLeads() {
            if (confirm("ATENÇÃO! Deseja apagar TODOS os registros? Esta ação é IRREVERSÍVEL.")) {
                try {
                    const response = await fetch('api_delete_all.php', { method: 'POST' });
                    const result = await response.json();
                    if (result.success) {
                        leadsContainer.innerHTML = '<p class="card" style="grid-column: 1 / -1; text-align: center;">Todos os leads foram apagados.</p>';
                    } else {
                        alert("Erro ao apagar todos os leads: " + (result.error || 'Erro desconhecido'));
                    }
                } catch (error) {
                    alert("Erro de conexão ao apagar todos os leads.");
                }
            }
        }

        function exportAllLeads() {
            if (confirm("Deseja baixar um arquivo CSV com todos os leads?")) {
                window.location.href = 'api_export_leads.php';
            }
        }

        fetchData();
        setInterval(fetchData, 3000);
    </script>
</body>
</html>