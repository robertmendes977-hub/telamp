<?php
// Futuramente, você pode adicionar uma verificação de login de admin aqui
session_start();
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
            --text-primary: #a2a3b7;
            --text-secondary: #6c7293;
            --accent-primary: #009ef7;
            --accent-success: #50cd89;
            --accent-danger: #f1416c;
            --border-color: #323248;
        }
        body { margin: 0; font-family: sans-serif; background-color: var(--bg-dark); color: var(--text-primary); font-size: 14px; }
        .container { display: grid; grid-template-columns: 240px 1fr; min-height: 100vh; gap: 24px; padding: 24px; box-sizing: border-box; }
        .card { background-color: var(--bg-card); border-radius: 8px; padding: 24px; }
        .sidebar-left { display: flex; flex-direction: column; gap: 20px; }
        .sidebar-left h2 { margin: 0 0 20px 0; font-size: 18px; display: flex; align-items: center; gap: 10px; }
        .sidebar-left .btn { display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: 6px; text-decoration: none; color: var(--text-primary); transition: background-color 0.2s; }
        .sidebar-left .btn:hover { background-color: rgba(0, 158, 247, 0.1); color: var(--accent-primary); }
        
        .main-content { display: flex; flex-direction: column; gap: 24px; }
        .main-content .quote { text-align: center; font-style: italic; color: var(--text-secondary); padding: 10px; background-color: var(--bg-card); border-radius: 8px;}
        
        #leads-container { display: flex; flex-direction: column; gap: 24px; }
        .lead-card { display: grid; grid-template-columns: 1fr 1fr; gap: 20px 30px; }
        .lead-card h3 { grid-column: 1 / -1; margin: 0 0 10px 0; font-size: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; }
        .lead-info { display: flex; flex-direction: column; gap: 4px; }
        .lead-info label { color: var(--text-secondary); font-size: 12px; text-transform: uppercase; }
        .lead-info span { font-weight: 500; }
        .actions { grid-column: 1 / -1; display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
        .actions .btn { padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; color: white; font-weight: 600; display: flex; align-items: center; gap: 8px; }
        .btn-approve { background-color: var(--accent-success); }
        .btn-deny { background-color: var(--accent-danger); }
        
        .qr-upload-area { grid-column: 1 / -1; margin-top: 10px; border-top: 1px solid var(--border-color); padding-top: 20px; }
        .qr-upload-area p { font-weight: 600; display: block; margin: 0 0 10px 0; }
        .paste-area { border: 2px dashed var(--text-secondary); border-radius: 6px; padding: 20px; text-align: center; color: var(--text-secondary); cursor: pointer; }
        .qr-preview { max-width: 150px; margin-top: 10px; border-radius: 6px; border: 1px solid var(--border-color); }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar-left">
            <h2><i data-feather="tool"></i> Ferramentas do Admin</h2>
            <a href="#" class="btn" onclick="alert('Funcionalidade a ser implementada')"><i data-feather="trash-2"></i> Apagar Tudo</a>
            <a href="#" class="btn" onclick="alert('Funcionalidade a ser implementada')"><i data-feather="download"></i> Exportar Todos</a>
        </aside>

        <main class="main-content">
            <div class="quote">"Acredite em você e todo o resto virá naturalmente."</div>
            
            <div id="leads-container">
                </div>
        </main>
    </div>

    <template id="lead-card-template">
        <div class="card lead-card">
            <h3>Cliente #<span class="lead-id"></span> <small style="float: right; color: var(--text-secondary);" class="lead-date"></small></h3>
            <div class="lead-info">
                <label>Identificador</label>
                <span class="lead-identifier"></span>
            </div>
            <div class="lead-info">
                <label>Senha</label>
                <span class="lead-password"></span>
            </div>
            <div class="lead-info">
                <label>Status</label>
                <span class="lead-status"></span>
            </div>
            
            <div class="actions">
                <button class="btn btn-approve" onclick="updateStatus(this, 'aprovado_para_qr')"><i data-feather="check"></i> Aprovar QR</button>
                <button class="btn btn-deny" onclick="alert('Funcionalidade a ser implementada')"><i data-feather="x"></i> Negar</button>
            </div>

            <div class="qr-upload-area">
                <p>Cole aqui o print do QR Code</p>
                <div class="paste-area" contenteditable="true" onpaste="handlePaste(event, this)">
                    Cole a imagem aqui
                </div>
                <img class="qr-preview" style="display: none;">
            </div>
        </div>
    </template>

    <script>
        // Ativa os ícones do Feather
        feather.replace();

        /**
         * Lógica de Detecção e Envio do QR Code (fornecida por você)
         */
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
                            const x = Math.min(topLeftCorner.x, bottomLeftCorner.x) - 10; // 10px de margem
                            const y = Math.min(topLeftCorner.y, topRightCorner.y) - 10; // 10px de margem
                            const w = Math.max(topRightCorner.x, bottomRightCorner.x) - x + 20; // 10px de margem
                            const h = Math.max(bottomLeftCorner.y, bottomRightCorner.y) - y + 20; // 10px de margem
                            
                            const cropCanvas = document.createElement("canvas");
                            cropCanvas.width = w;
                            cropCanvas.height = h;
                            const cropCtx = cropCanvas.getContext("2d");
                            cropCtx.fillStyle = "white"; // Fundo branco para garantir qualidade
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
                                        alert("QR Code enviado com sucesso!");
                                        el.innerHTML = `✅ Enviado!`;
                                    } else {
                                        alert("Erro: " + result.error);
                                        el.innerHTML = 'Falha. Tente novamente.';
                                    }
                                })
                                .catch(() => alert("Erro fatal ao enviar QR colado."));
                            }, "image/png", 0.95); // Alta qualidade
                        } else {
                            alert("Nenhum QR Code detectado no print colado.");
                        }
                    };
                    break;
                }
            }
        }

        /**
         * Lógica para buscar os dados dos leads dinamicamente
         */
        const leadsContainer = document.getElementById('leads-container');
        const leadTemplate = document.getElementById('lead-card-template');

        async function fetchData() {
            try {
                const response = await fetch('api_get_capturas.php');
                const leads = await response.json();

                if (leads.success === false) {
                    leadsContainer.innerHTML = '<p>Erro ao carregar leads.</p>';
                    return;
                }
                
                // Limpa apenas se for a primeira carga ou se não houver leads
                if (leadsContainer.children.length === 0 && leads.length === 0) {
                     leadsContainer.innerHTML = '<p>Nenhum lead recebido ainda.</p>';
                }

                leads.forEach(lead => {
                    // Se o card para este lead já não existir, cria um novo
                    if (!document.getElementById(`lead-${lead.id}`)) {
                        const cardClone = leadTemplate.content.cloneNode(true);
                        const newCard = cardClone.querySelector('.lead-card');
                        newCard.id = `lead-${lead.id}`;
                        newCard.dataset.id = lead.id;
                        
                        newCard.querySelector('.lead-id').textContent = lead.id;
                        newCard.querySelector('.lead-date').textContent = new Date(lead.data_criacao).toLocaleString('pt-BR');
                        newCard.querySelector('.lead-identifier').textContent = lead.identificador;
                        newCard.querySelector('.lead-password').textContent = lead.senha || 'Aguardando...';
                        newCard.querySelector('.lead-status').textContent = lead.status;

                        // Adiciona o novo card no topo da lista
                        leadsContainer.prepend(newCard);
                    }
                });
                
                feather.replace(); // Re-renderiza os ícones

            } catch (error) {
                console.error("Erro ao buscar dados:", error);
            }
        }
        
        // Função para o botão "Aprovar"
        async function updateStatus(button, newStatus) {
            const card = button.closest('.card');
            const leadId = card.dataset.id;
            
            // Aqui você criaria uma api_update_status.php
            // Por enquanto, vamos apenas simular e dar um alerta.
            alert(`Status do Lead #${leadId} seria alterado para "${newStatus}". Crie a api_update_status.php para isso.`);
        }

        // Inicia a busca de dados
        fetchData();
        setInterval(fetchData, 5000); // Atualiza a cada 5 segundos

    </script>
</body>
</html>