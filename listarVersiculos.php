<?php
include "verificaLogin.php";
include "conexao.php";

$livro = $_GET['livro'] ?? false;
$capitulo = $_GET['capitulo'] ?? 1;

$sql = "SELECT 
    v.id, v.chapter, v.verse, v.text, b.name AS livro
FROM
    verses v
        INNER JOIN
    books b ON v.book = b.id
	where book = :livro and chapter = :capitulo;";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":livro", $livro);
$stmt->bindParam(":capitulo", $capitulo);
$stmt->execute();
$versiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "select max(chapter) as qtde from verses where book = :livro;";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":livro", $livro);
$stmt->execute();
$capitulos = $stmt->fetch(PDO::FETCH_ASSOC);

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
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
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
            <h2><?php echo $versiculos[0]['livro'] ?>, capítulo <?php echo $capitulo ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php foreach ($versiculos as $versiculo): ?>
                <p><sup><?php echo $versiculo['verse'] ?></sup> <?php echo $versiculo['text'] ?>
                    <a href="#" class="bt_afavoritar" data-versiculo="<?php echo $versiculo['id'] ?>" title="Clique para afavoritar esse versículo">
                        <i class="fa fa-star-o"></i>
                    </a>
                </p>
            <?php endforeach; ?>
        </div>
        <div class="col-md-4">
            <?php for($i = 1; $i <= $capitulos['qtde']; $i++) :?>
            <a href="listarVersiculos.php?livro=<?php echo $livro ?>&capitulo=<?php echo $i ?>"
               class="btn btn-<?php echo $capitulo == $i ? "secondary" : "info" ?>"
            >
                <?php echo $i ?>
            </a>
            <?php endfor; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script>
    window.onload = function() {
        $(".bt_afavoritar").click(function() {
            let id_versiculo = $(this).data("versiculo");
            $.post("favoritarVersiculo.php", {versiculo: id_versiculo}, function (response){

            }, "json");
        })
    }
</script>

</body>

</html>