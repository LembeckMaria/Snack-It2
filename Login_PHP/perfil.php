<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexão com o banco
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "SnackIt";

$conn = new mysqli($servidor, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id_usuario = $_SESSION['id_usuario'];

// Pega dados do usuário
$sqlUser = "SELECT nome_usuario, email, foto_perfil FROM login WHERE id_usuario = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $id_usuario);
$stmtUser->execute();
$user = $stmtUser->get_result()->fetch_assoc();

// Pega receitas favoritas do usuário
$sqlFav = "
    SELECT r.id_receita, r.titulo, r.foto 
    FROM favoritas f 
    JOIN receitas r ON f.id_receita = r.id_receita 
    WHERE f.id_usuario = ?";

$stmtFav = $conn->prepare($sqlFav);
$stmtFav->bind_param("i", $id_usuario);
$stmtFav->execute();
$favoritas = $stmtFav->get_result();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil - SnackIt</title>
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
    <div class="perfil-container">

        <!-- Topo amarelo -->
        <div class="perfil-header">
            <div class="foto-wrapper">
                <?php if (!empty($user['foto_perfil'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($user['foto_perfil']); ?>" alt="Foto de perfil" class="foto-perfil">
                <?php else: ?>
                    <img src="uploads/default.png" alt="Foto padrão" class="foto-perfil">
                <?php endif; ?>
            </div>
            <p>Seu cantinho de receitas favoritas 🍴</p>
        </div>

        <!-- Conteúdo branco -->
        <div class="perfil-body">
            <h2>Bem-vindo(a), <?php echo htmlspecialchars($user['nome_usuario']); ?></h2>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

            <h3>Receitas Favoritas</h3>
            <div class="grid-receitas">
                <?php if ($favoritas->num_rows > 0): ?>
                    <?php while ($rec = $favoritas->fetch_assoc()): ?>
                        <div class="receita">
                            <img src="uploads/<?php echo htmlspecialchars($rec['foto']); ?>" alt="<?php echo htmlspecialchars($rec['titulo']); ?>">
                            <p><?php echo htmlspecialchars($rec['titulo']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nenhuma receita favoritada ainda.</p>
                <?php endif; ?>
            </div>

            <!-- Botões -->
            <div class="acoes">
                <a href="editar_perfil.php" class="btn editar">Editar Perfil</a>
                <a href="logout.php" class="btn sair">Sair</a>
            </div>
        </div>
    </div>
</body>
</html>
