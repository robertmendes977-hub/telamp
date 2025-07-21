<?php
// Coloque a senha que você quer usar aqui dentro das aspas
$minhaSenhaSecreta = '102030';

// Este comando gera o hash seguro
$hashSeguro = password_hash($minhaSenhaSecreta, PASSWORD_DEFAULT);

// Exibe o hash na tela
echo "Seu hash de senha seguro é:<br><br>";
echo $hashSeguro;
?>