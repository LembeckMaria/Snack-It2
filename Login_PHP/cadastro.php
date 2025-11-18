<?php
session_start();
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "SnackIt";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senhaHash = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Upload da foto
    $foto = "default.png";
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . "_" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    $sql = "INSERT INTO login (nome_usuario, senha, foto_perfil) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $senhaHash, $foto);

    if ($stmt->execute()) {
        $_SESSION['id_usuario'] = $stmt->insert_id; 
        header("Location: login.php ");
        exit;
    } else {
        echo "Erro: " . $stmt->error;
    }
}
?>
