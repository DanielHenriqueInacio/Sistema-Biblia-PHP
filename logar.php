<?php

include "conexao.php";
include "funcoes.php";

$email = $_POST['email'] ?? false;
$senha = $_POST['password'] ?? false;

if (!$email || !$senha) {
    flashMsg("warning", "Informe Email e Senha!", "login.php");
}

$sql = "select * from usuarios where email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":email", $email);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($senha, $usuario["senha"])) {
    unset($usuario["senha"]);
    $_SESSION["usuario"] = $usuario;
    header("location: index.php");
} else {
    flashMsg("danger", "Email e/ou Senha inválidos!", "login.php");
}