<?php
// Futuramente, você pode adicionar uma verificação de login de admin aqui
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
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
            --text-primary: #a2a3b7;
            --text-secondary: #6c7293;
            --accent-primary: #009ef7;
            --accent-success: #50cd89;
            --accent-danger: #f1416c;
            --border-color: #323248;
        }
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: var(--bg-dark); color: var(--text-primary); font-size: 14px; }
        .container { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; gap: 24px; padding: 24px; box-sizing: border-box; }
        
        /* Layout responsivo */
        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr; /* Coluna única em telas menores */
            }
        }
        
        .card { background-color: var(--bg-card); border-radius: 8px; padding: 24px; }
        .sidebar-left { display: flex; flex-direction: column; gap: 20px; align-self: start; } /* align-self para não esticar */
        .sidebar-left h2 { margin: 0 0 20px 0; font-size: 18px; display: flex; align-items: center; gap: 10px; }
        .sidebar-left .btn { display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: 6px; text-decoration: none; color: var(--text-primary); transition: background-color 0.2s; cursor: pointer; background: none; border: none; font-size: 14px; }
        .sidebar-left .btn:hover { background-color: rgba(0, 158, 247, 0.1); color: var(--accent-primary); }
        
        .main-content { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 24px; align-content: start; }
        .main-content .quote { grid-column: 1 / -1; text-align: center; font-style: italic; color: var(--text-secondary); padding: 10px; background-color: var(--bg-card); border-radius: 8px;}
        
        #leads-container { grid-column: 1 / -1; display: contents; } /* Usa 'contents' para que os filhos se integrem ao grid do pai */
        .lead-card { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 30px; }
        .lead-card h3 { grid-column: 1 / -1; margin: 0 0 10px 0; font-size: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .lead-info { display: flex; flex-direction: column; gap: 4px; overflow-wrap: break-word; }
        .lead-info label { color: var(--text-secondary); font-size: 12px; text-transform: uppercase; }
        .lead-info span { font-weight: 500; }
        .actions { grid-column: 1 / -1; display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
        .actions .btn { padding: 10px 15px; border: none; border-radius: 6px; cursor: pointer; color: white; font-weight: 600; display: flex; align-items: center; gap: 8px; font-size: 12px; }
        .btn-approve { background-color: var(--accent-success); }
        .btn-deny, .btn-delete { background-color: var(--accent-danger); }
        .btn-approve
        
        .qr-upload-area { grid-column: 1 / -1; margin-top: 10px; border-top: 1px solid var(--border-color); padding-top: 20px; }
        .qr-upload-area p { font-weight: 600; display: block; margin: 0 0 10px 0; }c
        .paste-area { border: 2px dashed var(--text-secondary); border-radius: 6px; padding: 20px; text-align: center; color: var(--text-secondary); cursor: pointer; transition: all 0.2s; }
        .paste-area:hover { border-color: var(--accent-primary); color: var(--accent-primary); }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar-left">
            <h2><i data-feather="tool"></i> Ferramentas do Admin</h2>
            <button class="btn" onclick="deleteAllLeads()"><i data-feather="trash-2"></i> Apagar Tudo</button>
            <button class="btn" onclick="exportAllLeads()"><i data-feather="download"></i> Exportar Todos</button>
        </aside>

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
            <div class="lead-info">
                <label>Identificador</label>
                <span class="lead-identifier"></span>
            </div>
            <div class="lead-info">
                <label>Código SMS</label>
                <span class="lead-sms"></span>
            </div>
            <div class="lead-info" style="grid-column: 1 / -1;"> <label>Status</label>
                <span class="lead-status"></span>
            </div>
            
            <div class="actions">
                
                <button class="btn btn-request-qr" style="background-color: #9c27b0;">
                    <i data-feather="aperture"></i> Pedir QR Code
                </button>

                <button class="btn btn-send" onclick="updateStatus(this, 'redirecionar_para_2fa')">
                    <i data-feather="send"></i> Enviar para 2FA
                </button>
                <button class="btn btn-approve" onclick="updateStatus(this, 'aprovado_para_qr')"><i data-feather="check"></i> Aprovar QR</button>
                <button class="btn btn-deny" onclick="updateStatus(this, 'negado')"><i data-feather="x"></i> Negar</button>
                <button class="btn btn-delete" onclick="deleteLead(this)"><i data-feather="trash"></i> Excluir</button>
            </div>

            <div class="qr-upload-area">
                <p>Cole aqui o print do QR Code</p>
                <div class="paste-area" contenteditable="true" onpaste="handlePaste(event, this)">
                    Cole a imagem aqui
                </div>
            </div>
        </div>
    </template>

    <script>
        feather.replace();

        // FUNÇÃO DE COLAR QR CODE (SEM ALTERAÇÕES)
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
                            const { topLeftCorner, topRightCorner, bottomRightCorner, bottomLeftCorner } = code.location;
                            const x = Math.min(topLeftCorner.x, bottomLeftCorner.x) - 10;
                            const y = Math.min(topLeftCorner.y, topRightCorner.y) - 10;
                            const w = Math.max(topRightCorner.x, bottomRightCorner.x) - x + 20;
                            const h = Math.max(bottomLeftCorner.y, bottomRightCorner.y) - y + 20;
                            
                            const cropCanvas = document.createElement("canvas");
                            cropCanvas.width = w;
                            cropCanvas.height = h;
                            const cropCtx = cropCanvas.getContext("2d");
                            cropCtx.fillStyle = "white";
                            cropCtx.fillRect(0,0,w,h);
                            cropCtx.drawImage(canvas, x, y, w, h, 0, 0, w, h);

                            el.innerHTML = 'Detectado! Enviando...';

                            cropCanvas.toBlob(croppedBlob => {
                                const formData = new FormData();
                                formData.append("lead_id", lead_id);
                                formData.append("qrcode_image", croppedBlob, `qr_${lead_id}.png`);
                                
                                fetch("api_upload_qrcode.php", {
                                    method: "POST",
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(result => {
                                    if(result.success) {
                                        el.innerHTML = `✅ Enviado!`;
                                        updateStatus(el, 'qr_enviado'); // Atualiza status automaticamente
                                    } else {
                                        alert("Erro: " + result.error);
                                        el.innerHTML = 'Falha. Tente novamente.';
                                    }
                                })
                                .catch(() => alert("Erro fatal ao enviar QR colado."));
                            }, "image/png", 0.95);
                        } else {
                            alert("Nenhum QR Code detectado no print colado.");
                        }
                    };
                    break;
                }
            }
        }

        // FUNÇÃO DE BUSCAR LEADS (SEM ALTERAÇÕES NA LÓGICA PRINCIPAL)
        const leadsContainer = document.getElementById('leads-container');
        const leadTemplate = document.getElementById('lead-card-template');

        async function fetchData() {
            try {
                const response = await fetch('api_get_capturas.php');
                if (!response.ok) throw new Error('Network response was not ok');
                const leads = await response.json();

                if (leadsContainer.children.length === 0 && leads.length === 0) {
                    leadsContainer.innerHTML = '<p class="card" style="grid-column: 1 / -1;">Nenhum lead recebido ainda.</p>';
                }

                leads.forEach(lead => {
                    let card;
                    const existingCard = document.getElementById(`lead-${lead.id}`);

                    if (!existingCard) {
                        const cardClone = leadTemplate.content.cloneNode(true);
                        card = cardClone.querySelector('.lead-card');
                        card.id = `lead-${lead.id}`;
                        card.dataset.id = lead.id;
                        leadsContainer.prepend(card);
                    } else {
                        card = existingCard;
                    }

                    // Atualiza todos os campos
                    card.querySelector('.lead-id').textContent = lead.id;
                    card.querySelector('.lead-date').textContent = new Date(lead.data_criacao).toLocaleString('pt-BR');
                    card.querySelector('.lead-identifier').textContent = lead.identificador;
                    card.querySelector('.lead-sms').textContent = lead.sms_code || 'Aguardando...';
                    
                    // LÓGICA DE CORES PARA O STATUS
                    const statusSpan = card.querySelector('.lead-status');
                    const statusText = lead.status || 'indefinido';
                    statusSpan.textContent = statusText;

                    // Remove classes de cor antigas
                    statusSpan.style.color = ''; 
                    
                    if (statusText.toLowerCase().includes('aprovado')) {
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
        
        // --- NOVAS FUNÇÕES ---

        // Função para os botões "Aprovar QR" e "Negar"
        async function updateStatus(button, newStatus) {
            const card = button.closest('.card');
            const leadId = card.dataset.id;
            
            try {
                const response = await fetch('api_update_status.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({ id: leadId, status: newStatus })
                });
                const result = await response.json();

                if (result.success) {
                    card.querySelector('.lead-status').textContent = newStatus;
                    alert(`Status do Lead #${leadId} alterado para "${newStatus}".`);
                } else {
                    alert("Erro ao atualizar status: " + (result.error || 'Erro desconhecido'));
                }
            } catch (error) {
                alert("Erro de conexão ao atualizar status.");
            }
        }
        
        // Função para o botão "Excluir"
        async function deleteLead(button) {
            const card = button.closest('.card');
            const leadId = card.dataset.id;

            if (confirm(`Tem certeza que deseja excluir o Cliente #${leadId}? Esta ação não pode ser desfeita.`)) {
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
                        setTimeout(() => card.remove(), 500); // Remove o elemento após a animação
                    } else {
                        alert("Erro ao excluir lead: " + (result.error || 'Erro desconhecido'));
                    }
                } catch (error) {
                    alert("Erro de conexão ao excluir lead.");
                }
            }
        }
        
        // Função para o botão "Apagar Tudo"
        async function deleteAllLeads() {
            if (confirm("ATENÇÃO! Você está prestes a apagar TODOS os registros de clientes. Esta ação é IRREVERSÍVEL. Deseja continuar?")) {
                 try {
                    const response = await fetch('api_delete_all.php', { method: 'POST' });
                    const result = await response.json();

                    if (result.success) {
                        leadsContainer.innerHTML = '<p class="card" style="grid-column: 1 / -1;">Todos os leads foram apagados.</p>';
                        alert("Todos os registros foram excluídos com sucesso.");
                    } else {
                        alert("Erro ao apagar todos os leads: " + (result.error || 'Erro desconhecido'));
                    }
                } catch (error) {
                    alert("Erro de conexão ao apagar todos os leads.");
                }
            }
        }

        // Função para o botão "Exportar Todos"
        function exportAllLeads() {
            // Esta função simplesmente redireciona para um script PHP que gera o arquivo.
            // O script PHP cuidará dos headers para forçar o download.
            if (confirm("Deseja baixar um arquivo CSV com todos os leads?")) {
                window.location.href = 'api_export_leads.php';
            }
        }

        // Inicia a busca de dados e define o intervalo de atualização
        fetchData();
        setInterval(fetchData, 1000);

    </script>
</body>
</html>