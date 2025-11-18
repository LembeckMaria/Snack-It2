<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel do Usuário</title>
</head>
<body>
  <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1>
  <p>Você está logado com o e-mail: <?php echo $_SESSION['email']; ?></p>

  <a href="logout.php">Sair</a>
</body>
</html>
