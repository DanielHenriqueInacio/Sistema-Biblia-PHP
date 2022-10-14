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

