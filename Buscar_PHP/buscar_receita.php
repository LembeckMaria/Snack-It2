<?php
// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php';

// Obtém o termo de busca da URL
$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';

// Verifica se o termo de busca não está vazio
if (empty($searchTerm)) {
    $results = [];
    $message = "Por favor, digite um termo para buscar.";
} else {
    // Prepara o termo de busca para a consulta SQL, adicionando '%' para buscar em qualquer parte do título
    $likeTerm = "%" . $searchTerm . "%";

    // Prepara a consulta SQL usando prepared statements para segurança
    // Seleciona o id, titulo, descricao e foto da tabela receitas
    $stmt = $conn->prepare("SELECT id_receita, titulo, descricao, foto FROM receitas WHERE titulo LIKE ?");
    
    // Verifica se a preparação da query foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da query: " . $conn->error);
    }

    // Liga o parâmetro (s = string)
    $stmt->bind_param("s", $likeTerm); 
    
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
        $message = "Encontradas " . count($results) . " receitas para '" . htmlspecialchars($searchTerm) . "'.";
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
    <title>Resultados da Busca - SnackIt</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/dark-mode.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/23a7e280be.js" crossorigin="anonymous"></script>
    <style>
        /* Estilos básicos para a página de resultados */
        .search-results {
            padding: 50px 0;
            min-height: 60vh;
        }
        .result-card {
            display: flex;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .result-card img {
            width: 200px;
            height: 150px;
            object-fit: cover;
        }
        .result-content {
            padding: 15px;
        }
        .result-content h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <!-- Incluindo o cabeçalho para manter a navegação e o estilo -->
    <header>
        <div class="container">
            <div class="logo">
            </div>
           
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
                        <form action="Buscar_PHP/buscar_receita.php" method="GET" class="search-form">
                          <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                <input type="text" name="query" placeholder="Buscar receitas..." class="search-input">
                    <li><a href="../filmes-series.html">Filmes & Séries</a></li>
                    <li><a href="../veganas.html">Veganas</a></li>
                    <li><a href="../fitness.html">Fitness</a></li>
                    <li><a href="../originais.html">Originais</a></li>
                    <li><a href="../sobre.html"><i class="fa-solid fa-question"></i></a></li>
                    <li><a href="../index.php" class="active"><i class="fa-solid fa-house"></i></a></li>
                    <li><a href="../login.html" class="active"><i class="fa-solid fa-user"></i></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="search-results">
        <div class="container">
            <h2>Resultados da Busca</h2>
            <p><?php echo $message; ?></p>

            <?php if (!empty($results)): ?>
                <div class="results-list">
                    <?php foreach ($results as $receita): ?>
                        <div class="result-card">
                            <!-- A foto da receita está na coluna 'foto'. Assumindo que o caminho é relativo a '../images/' -->
                            <img src="../images/<?php echo htmlspecialchars($receita['foto']); ?>" alt="<?php echo htmlspecialchars($receita['titulo']); ?>">
                            <div class="result-content">
                                <h3><?php echo htmlspecialchars($receita['titulo']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($receita['descricao'], 0, 150)) . '...'; ?></p>
                                <!-- Você precisará de uma página 'receita_detalhe.php' para exibir a receita completa -->
                                <a href="../receita_detalhe.php?id=<?php echo $receita['id_receita']; ?>" class="btn-text">Ver Receita Completa</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Incluindo o rodapé para manter a consistência -->
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
                        <li><a href="../index.php">Início</a></li>
                        <li><a href="../filmes-series.html">Filmes & Séries</a></li>
                        <li><a href="../veganas.html">Veganas</a></li>
                        <li><a href="../fitness.html">Fitness</a></li>
                        <li><a href="../originais.html">Originais</a></li>
                        <li><a href="../sobre.html">Sobre</a></li>
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

    <script src="../js/script.js"></script>
    <script src="../js/dark-mode.js"></script>
</body>
</html>