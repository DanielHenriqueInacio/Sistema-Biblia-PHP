<?php

try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=sistema_biblia",
        "root",
        ""
    );
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}