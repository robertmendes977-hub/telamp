<?php
session_start();
// Se o admin já estiver logado, redireciona para o painel principal
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Painel do Admin</title>
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --bg-dark: #1e1e2d;
            --bg-card: #27293d;
            --text-primary: #a2a3b7;
            --text-secondary: #6c7293;
            --accent-primary: #009ef7;
            --accent-danger: #f1416c;
            --border-color: #323248;
        }
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background-color: var(--bg-card);
            border-radius: 8px;
            padding: 40px;
            width: 100%;
            max-width: 380px;
            box-sizing: border-box;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            background-color: var(--bg-dark);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--accent-primary);
        }
        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 6px;
            background-color: var(--accent-primary);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 24px;
            transition: background-color 0.2s;
        }
        .btn-submit:hover {
            background-color: #008bdb;
        }
        .error-message {
            background-color: rgba(241, 65, 108, 0.1);
            color: var(--accent-danger);
            border: 1px solid var(--accent-danger);
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h2><i data-feather="log-in"></i> Painel do Admin</h2>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">Usuário ou senha inválidos.</div>
        <?php endif; ?>

        <form action="process_admin_login.php" method="POST">
            <div class="form-group">
                <label for="username">Usuário</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">Entrar</button>
        </form>
    </div>
    <script>
      feather.replace();
    </script>
</body>
</html>