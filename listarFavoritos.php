<?php
include "verificaLogin.php";
include "conexao.php";

$usuario = $_SESSION['usuario']['id'];
$sql = "SELECT 
   v.text, b.name AS livro, v.chapter, v.verse
FROM
    favoritos f
        INNER JOIN
    verses v ON f.id_versiculo  = v.id
		INNER JOIN 	
	books b ON v.book = b.id
    WHERE f.id_usuario = :usuario;";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":usuario", $usuario);
$stmt->execute();
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Listagem - Biblia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="html/assets/css/styles.min.css">
</head>

<body>
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon">
                <i class="fa fa-book"></i>
            </span>
            <span>Minha bíblia</span>
        </a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
            <span class="visually-hidden">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href=" ">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="listarFavoritos.php">Favoritos</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Minhas anotações</a></li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Testamentos</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="listarLivros.php?testamento=1">Velho Testamentos</a>
                        <a class="dropdown-item" href="listarLivros.php?testamento=2">Novo Testamentos</a>
                        <a class="dropdown-item" href="listarLivros.php">Todos Testamentos</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                        Olá <?php echo $_SESSION["usuario"]["nome"]; ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="sair.php">Sair</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-3">Versiculos Favoritados</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
                <?php foreach($favoritos as $favorito):?>
                <p><?php echo $favorito['text'] . " " . $favorito['livro'] . " " . $favorito['chapter'] . ", " . $favorito['verse'] ?></p>
                <?php endforeach;?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>