<?php
include "verificaLogin.php";
include "conexao.php";

$versiculo = $_POST['versiculo'] ?? false;
$usuario = $_SESSION['usuario']['id'];

$sql = "insert into favoritos (id_usuario, id_versiculo) values (:usuario, :versiculo)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":usuario", $usuario);
$stmt->bindParam(":versiculo", $versiculo);
$stmt->execute();

header("Content-Type: application/json");

echo json_encode(["status" => "success"]);