<?php
// Conexão com o banco
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "SnackIt";

// Conectando ao banco
$conn = new mysqli($servidor, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebendo dados do formulário
$nome_usuario = trim($_POST['nome_usuario']);
$senha_usuario = $_POST['senha'];

// Criptografando a senha
$senha_hash = password_hash($senha_usuario, PASSWORD_DEFAULT);

// Inserindo no banco de dados usando prepared statement
$stmt = $conn->prepare("INSERT INTO login (nome_usuario, senha) VALUES (?, ?)");
$stmt->bind_param("ss", $nome_usuario, $senha_hash);

if ($stmt->execute()) {
    echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = '../login.html';</script>";
} else {
    echo "Erro ao cadastrar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
