<?php
// Inclui o arquivo de conexão com o banco de dados
// O caminho é relativo a este arquivo, que está na raiz do projeto
include 'Login_PHP/conexao.php';

// Obtém o ID da receita da URL
$receita_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$receita = null;
$message = "";

if ($receita_id > 0) {
    // Prepara a consulta SQL para buscar a receita pelo ID
    $stmt = $conn->prepare("SELECT * FROM receitas WHERE id_receita = ?");
    
    if ($stmt === false) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Liga o parâmetro (i = integer)
    $stmt->bind_param("i", $receita_id); 
    
    // Executa a consulta
    $stmt->execute();
    
    // Obtém o resultado
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $receita = $result->fetch_assoc();
    } else {
        $message = "Receita não encontrada.";
    }

    // Fecha o statement
    $stmt->close();
} else {
    $message = "ID de receita inválido.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $receita ? htmlspecialchars($receita['titulo']) : 'Receita Não Encontrada'; ?> - SnackIt</title>
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
        .recipe-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .recipe-content h1 {
            margin-top: 0;
            color: #333; /* Ajuste a cor conforme seu CSS */
        }
        .recipe-content p {
            line-height: 1.6;
        }
        .recipe-content h2 {
            border-bottom: 2px solid #eee;
            padding-bottom: 5px;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <?php 
    include 'includes/head.php';
    ?>
    <header>
        <div class="container">
            <div class="logo">
            </div>
          
            <div class="logo">
                <img src="images/logo_snack_it.png" alt="">
            </div>
            <nav>
                <button class="mobile-menu-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="menu">
                  
              
            </form>
                <form action="Buscar_PHP/buscar_receita.php" method="GET" class="search-form">
                          <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                <input type="text" name="query" placeholder="Buscar receitas..." class="search-input">
                    <li><a href="filmes-series.html">Filmes & Séries</a></li>
                    <li><a href="veganas.html">Veganas</a></li>
                    <li><a href="fitness.html">Fitness</a></li>
                    <li><a href="originais.html">Originais</a></li>
                    <li><a href="sobre.html"><i class="fa-solid fa-question"></i></a></li>
                    <li><a href="index.php" class="active"><i class="fa-solid fa-house"></i></a></li>
                    <li><a href="login.html" class="active"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="recipe-detail">
        <div class="container">
            <?php if ($receita): ?>
                <div class="recipe-content">
                    <h1><?php echo htmlspecialchars($receita['titulo']); ?></h1>
                    <img src="images/<?php echo htmlspecialchars($receita['foto']); ?>" alt="<?php echo htmlspecialchars($receita['titulo']); ?>">
                    
                    <h2>Descrição</h2>
                    <p><?php echo nl2br(htmlspecialchars($receita['descricao'])); ?></p>
                    
                    <h2>Modo de Preparo</h2>
                    <p><?php echo nl2br(htmlspecialchars($receita['preparo'])); ?></p>
                    
                    <!-- Aqui você pode adicionar a lógica para buscar e exibir os ingredientes da tabela receita_ingredientes e ingredientes -->
                    <!-- Por simplicidade, vou deixar apenas o esqueleto principal -->
                    
                </div>
            <?php else: ?>
                <h1><?php echo $message; ?></h1>
                <p>Volte para a <a href="index.php">página inicial</a> ou tente uma nova busca.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Rodapé (copiado de index.php para consistência) -->
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
                        <li><a href="index.php">Início</a></li>
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