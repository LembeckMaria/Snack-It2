<?php
session_start();
include __DIR__ . "/../Login_PHP/conexao.php";

header('Content-Type: application/json');

if (!isset($_SESSION['id_usuario'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'msg' => 'Você precisa estar logado.']);
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$data = json_decode(file_get_contents("php://input"), true);

$id_receita = $data['id_receita'] ?? 0;
$favoritado = $data['favoritado'] ?? 0;

if ($favoritado == 1) {
    $sql = "INSERT IGNORE INTO favoritas (id_usuario, id_receita)
            VALUES ($id_usuario, $id_receita)";
    $conn->query($sql);
    $mensagem = 'Receita favoritada com sucesso';
} else {
    $sql = "DELETE FROM favoritas 
            WHERE id_usuario = $id_usuario AND id_receita = $id_receita";
    $conn->query($sql);
    $mensagem = 'Receita removida dos favoritos';
}

echo json_encode(['ok' => true, 'favoritado' => $favoritado, 'mensagem' => $mensagem]);
