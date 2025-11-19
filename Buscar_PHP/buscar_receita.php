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

// Obtém o termo de busca da URL
$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';

// Verifica se o termo de busca não está vazio
if (empty($searchTerm)) {
    $results = [];
    $message = "Por favor, digite um termo para buscar.";
} else {
    // Prepara o termo de busca para a consulta SQL, adicionando '%' para buscar em qualquer parte do título ou descrição
    $likeTerm = "%" . $searchTerm . "%";

    // Prepara a consulta SQL usando prepared statements para segurança
    // Busca tanto no título quanto na descrição
    $stmt = $conn->prepare("SELECT id_receita, titulo, descricao, foto FROM receitas WHERE titulo LIKE ? OR descricao LIKE ?");
    
    // Verifica se a preparação da query foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Liga os parâmetros (s = string)
    $stmt->bind_param("ss", $likeTerm, $likeTerm); 
    
    // Executa a consulta
    $stmt->execute();
    
    // Obtém o resultado
    $result = $stmt->get_result();

    // Armazena os resultados em um array
    $results = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
        $message = "Encontradas " . count($results) . " receita(s) para '" . htmlspecialchars($searchTerm) . "'.";
    } else {
        $message = "Nenhuma receita encontrada para '" . htmlspecialchars($searchTerm) . "'.";
    }

    // Fecha o statement
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dark-mode.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/23a7e280be.js" crossorigin="anonymous"></script>
    <style>
        /* Estilos para a página de resultados */
        .search-results {
            padding: 50px 0;
            min-height: 60vh;
        }
        
        .search-results h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        .search-message {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: var(--text-color);
        }
        
        .results-list {
            display: grid;
            gap: 25px;
        }
        
        .result-card {
            display: flex;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .result-card img {
            width: 250px;
            height: 180px;
            object-fit: cover;
            flex-shrink: 0;
        }
        
        .result-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
        }
        
        .result-content h3 {
            margin: 0 0 10px 0;
            font-size: 1.5rem;
            color: var(--primary-color);
        }
        
        .result-content p {
            margin: 0 0 15px 0;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .btn-ver-receita {
            display: inline-block;
            padding: 10px 20px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
            align-self: flex-start;
        }
        
        .btn-ver-receita:hover {
            background: var(--secondary-color);
        }
        
        .no-results {
            text-align: center;
            padding: 50px 20px;
        }
        
        .no-results i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .result-card {
                flex-direction: column;
            }
            
            .result-card img {
                width: 100%;
                height: 200px;
            }
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
                        <input type="text" name="query" placeholder="Buscar receitas..." class="search-input" value="<?php echo htmlspecialchars($searchTerm); ?>">
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

    <section class="search-results">
        <div class="container">
            <h2>Resultados da Busca</h2>
            <p class="search-message"><?php echo $message; ?></p>

            <?php if (!empty($results)): ?>
                <div class="results-list">
                    <?php foreach ($results as $receita): ?>
                        <div class="result-card">
                            <?php if (!empty($receita['foto'])): ?>
                                <img src="imgs/<?php echo htmlspecialchars($receita['foto']); ?>" alt="<?php echo htmlspecialchars($receita['titulo']); ?>">
                            <?php else: ?>
                                <img src="images/placeholder.jpg" alt="Sem imagem">
                            <?php endif; ?>
                            <div class="result-content">
                                <div>
                                    <h3><?php echo htmlspecialchars($receita['titulo']); ?></h3>
                                    <p><?php echo htmlspecialchars(substr($receita['descricao'], 0, 200)) . (strlen($receita['descricao']) > 200 ? '...' : ''); ?></p>
                                </div>
                                <a href="receita_detalhe.php?id=<?php echo $receita['id_receita']; ?>" class="btn-ver-receita">Ver Receita Completa</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif (!empty($searchTerm)): ?>
                <div class="no-results">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h3>Nenhuma receita encontrada</h3>
                    <p>Tente usar outros termos de busca ou explore nossas categorias.</p>
                </div>
            <?php endif; ?>
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