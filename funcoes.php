<?php
require_once "conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function flashMsg($id, $msg = null, $destino = null)
{
    if (is_null($msg)) {
        echo temFlashMsg($id) ? "<div class='alert alert-$id'>{$_SESSION['flashMsg'][$id]}</div>" : "";
        unset($_SESSION['flashMsg'][$id]);
    } else {
        $_SESSION['flashMsg'][$id] = $msg;
    }
    if(!is_null($destino)){
        header("location: $destino");
    }
}

function temFlashMsg($id)
{
    return isset($_SESSION['flashMsg'][$id]) ? true : false;
}

function listarLivros($conn, $testamento) {
    $sql = "SELECT  
    b.id, b.name AS livro, t.name AS testamento
FROM
    books b
        INNER JOIN
    testament t ON b.testament = t.id";

    if (!$testamento) {
        $query = $conn->query($sql);
        $livros = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {

        $sql .= " where t.id = :testamento";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":testamento", $testamento);
        $stmt->execute();
        $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $livros;
}

