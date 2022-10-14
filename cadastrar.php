<?php

include "conexao.php";
include "funcoes.php";

$nome = $_POST["name"] ?? false;
$email = $_POST["email"] ?? false;
$senha = $_POST["password"] ?? false;

if (!$nome || !$email || !$senha) {
    flashMsg("warning", "Todos os Campos são obrigatórios!", "registre.php");
} else {
    $token = md5(uniqid());
    $senha = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "insert into usuarios (nome, email, senha, token) values (:nome, :email, :senha, :token)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":senha", $senha);
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    flashMsg("success", "Seu usuario foi criado com sucesso!", "login.php");
}