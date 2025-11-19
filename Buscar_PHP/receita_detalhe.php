<?php
// Inclui o arquivo de conexão com o banco de dados
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "snackit";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Obtém o ID da receita da URL
$id_receita = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_receita <= 0) {
    header("Location: index.html");
    exit();
}

// Busca os dados da receita
$stmt = $conn->prepare("SELECT id_receita, titulo, descricao, preparo, foto FROM receitas WHERE id_receita = ?");
$stmt->bind_param("i", $id_receita);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: index.html");
    exit();
}

$receita = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($receita['titulo']); ?> - SnackIt</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dark-mode.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/23a7e280be.js" crossorigin="anonymous"></script>
    <style>
        .recipe-detail {
            padding: 50px 0;
            min-height: 60vh;
        }
        
        .recipe-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .recipe-header h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .recipe-image {
            width: 100%;
            max-width: 800px;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
            margin: 0 auto 30px;
            display: block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .recipe-content {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .recipe-section {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .recipe-section h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 15px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
        }
        
        .recipe-section p {
            line-height: 1.8;
            color: var(--text-color);
            font-size: 1.1rem;
        }
        
        .back-button {
            display: inline-block;
            padding: 12px 25px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 30px;
            transition: background 0.3s ease;
        }
        
        .back-button:hover {
            background: var(--secondary-color);
        }
        
        .back-button i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="imgs/logo_snack_it.png" alt="SnackIt Logo">
            </div>
            <nav>
                <button class="mobile-menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="menu">
                    <form action="buscar.php" method="GET" class="search-form">
                        <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <input type="text" name="query" placeholder="Buscar receitas..." class="search-input">
                    </form>
                    <li><a href="filmes-series.html">Filmes & Séries</a></li>
                    <li><a href="veganas.html">Veganas</a></li>
                    <li><a href="fitness.html">Fitness</a></li>
                    <li><a href="originais.html">Originais</a></li>
                    <li><a href="sobre.html"><i class="fa-solid fa-question"></i></a></li>
                    <li><a href="index.html"><i class="fa-solid fa-house"></i></a></li>
                    <li><a href="login.html"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="recipe-detail">
        <div class="container">
            <a href="javascript:history.back()" class="back-button">
                <i class="fa-solid fa-arrow-left"></i> Voltar
            </a>
            
            <div class="recipe-header">
                <h1><?php echo htmlspecialchars($receita['titulo']); ?></h1>
            </div>
            
            <?php if (!empty($receita['foto'])): ?>
                <img src="imgs/<?php echo htmlspecialchars($receita['foto']); ?>" alt="<?php echo htmlspecialchars($receita['titulo']); ?>" class="recipe-image">
            <?php endif; ?>
            
            <div class="recipe-content">
                <?php if (!empty($receita['descricao'])): ?>
                    <div class="recipe-section">
                        <h2><i class="fa-solid fa-info-circle"></i> Descrição</h2>
                        <p><?php echo nl2br(htmlspecialchars($receita['descricao'])); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($receita['preparo'])): ?>
                    <div class="recipe-section">
                        <h2><i class="fa-solid fa-utensils"></i> Modo de Preparo</h2>
                        <p><?php echo nl2br(htmlspecialchars($receita['preparo'])); ?></p>
                    </div>
                <?php else: ?>
                    <div class="recipe-section">
                        <h2><i class="fa-solid fa-utensils"></i> Modo de Preparo</h2>
                        <p>Informações de preparo em breve!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>SnackIt</h2>
                    <p>Receitas especiais para todos os gostos</p>
                </div>
                <div class="footer-links">
                    <h3>Links Rápidos</h3>
                    <ul>
                        <li><a href="index.html">Início</a></li>
                        <li><a href="filmes-series.html">Filmes & Séries</a></li>
                        <li><a href="veganas.html">Veganas</a></li>
                        <li><a href="fitness.html">Fitness</a></li>
                        <li><a href="originais.html">Originais</a></li>
                        <li><a href="sobre.html">Sobre</a></li>
                    </ul>
                </div>
                <div class="footer-social">
                    <h3>Redes Sociais</h3>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 SnackIt. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/dark-mode.js"></script>
</body>
</html>