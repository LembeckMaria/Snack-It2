<?php
session_start();
session_destroy();
// Define a mensagem de sucesso antes de destruir a sessão
$_SESSION['mensagem_sucesso'] = "Você saiu da sua conta com sucesso!";

// Redireciona para a página de login
header("Location: ../login.php");
exit();

