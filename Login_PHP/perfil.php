<?php
session_start();


// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - SnackIt</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dark-mode.css">
    <link rel="stylesheet" href="../css/notificacoes.css">
    <link rel="stylesheet" href="perfil.css">

    <!-- Google Fonts e Ícones -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/23a7e280be.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../includes/flash_messages.php'; ?>
    
    <header>
        <div class="container">
            <div class="logo">
                <img src="../images/logo_snack_it.png" alt="">
            </div>
            <nav>
                <button class="mobile-menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="menu">
                    <li><a href="../filmes-series.php">Filmes & Séries</a></li>
                    <li><a href="../veganas.php">Veganas</a></li>
                    <li><a href="../fitness.php">Fitness</a></li>
                    <li><a href="../originais.php">Originais</a></li>
                    <li><a href="../sobre.php"><i class="fa-solid fa-question"></i></a></li>
                    <li><a href="../index.php"><i class="fa-solid fa-house"></i></a></li>
                    <li><a href="perfil.php" class="active"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="perfil-container">

        <!-- Topo rosa (mantido o estilo do perfil.css) -->
        <div class="perfil-header">
            <div class="foto-wrapper">
                <?php if (!empty($user['foto_perfil'])): ?>
                    <img src="../images/<?php echo htmlspecialchars($user['foto_perfil']); ?>" alt="Foto de perfil" class="foto-perfil">
                <?php else: ?>
                    <img src="../images/default.png" alt="Foto padrão" class="foto-perfil">
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
                            <img src="../images/<?php echo htmlspecialchars($rec['foto']); ?>" alt="<?php echo htmlspecialchars($rec['titulo']); ?>">
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

    <!-- Scripts -->
    <script src="../js/notificacoes.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/dark-mode.js"></script>
</body>
</html>
