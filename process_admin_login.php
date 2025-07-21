<?php
session_start();

// --- DEFINA SUAS CREDENCIAIS AQUI ---
// Em uma aplicação real, isso viria de um banco de dados.
$correct_username = 'admin';
// IMPORTANTE: NUNCA armazene senhas em texto puro. Gere um hash.
// Para gerar o hash, use o script gerador no final desta resposta.
$correct_password_hash = '$2y$12$YjXucVlTKA4gA4Lau2ONXeBzd8IaFsVC.a0cbL5pt664A7AK0fdke'; // Senha de exemplo: 'senha123'

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verifica o usuário e a senha usando password_verify()
    if ($username === $correct_username && password_verify($password, $correct_password_hash)) {
        // Se as credenciais estiverem corretas, marca o usuário como logado na sessão
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        // Se estiverem erradas, redireciona de volta para o login com uma mensagem de erro
        header('Location: admin_login.php?error=1');
        exit;
    }
} else {
    // Se alguém tentar acessar este arquivo diretamente, redireciona para o login
    header('Location: admin_login.php');
    exit;
}
?>