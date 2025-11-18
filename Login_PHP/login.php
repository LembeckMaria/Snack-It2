<?php
session_start();
require_once "conexao.php";

// Verifica se os dados foram enviados corretamente
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Normaliza o nome de usuário
    $usuario = trim(strtolower($_POST['nome_usuario']));
    $senha = $_POST['senha'];

    // Prepara a consulta usando prepared statements
    $stmt = $conn->prepare("SELECT id_usuario, nome_usuario, senha FROM login WHERE LOWER(nome_usuario) = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se encontrou o usuário
    if ($result->num_rows > 0) {
        $dados = $result->fetch_assoc();

        // Verifica se a senha está correta
        if (password_verify($senha, $dados['senha'])) {
            // Login bem-sucedido -> padroniza sessão
            $_SESSION['id_usuario'] = $dados['id_usuario'];
            $_SESSION['nome_usuario'] = $dados['nome_usuario'];
            
            header("Location: ../index.html ");
            exit();
        } else {
            echo "<script>alert('Senha incorreta.'); window.location.href='../login.html';</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado.'); window.location.href='../login.html';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Se tentar acessar o login.php sem usar POST
    header("Location: ../login.html");
    exit();
}
?>
