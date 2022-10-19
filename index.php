<?php
include "conexao.php";
include "verificaLogin.php";
include "funcoes.php";


$busca = $_GET['busca'] ?? false;

$sql = "SELECT 
   v.id as id_versiculo, v.text, b.name AS livro, v.chapter, v.verse, b.id as livro_id
FROM
    favoritos f
        RIGHT JOIN
    verses v ON f.id_versiculo = v.id
		LEFT JOIN 	
	books b ON v.book = b.id
    WHERE v.text LIKE :busca;";


$stmt = $conn->prepare($sql);
$str = "%" . $busca . "%";
$stmt->bindParam(":busca", $str);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Biblia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="html/assets/css/styles.min.css">
</head>

<body>
<nav class="navbar navbar-dark navbar-expand-md bg-dark py-3">
    <div class="container"><a class="navbar-brand d-flex align-items-center" href="#"><span
                    class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><i
                        class="fa fa-book"></i></span><span>Minha bíblia</span></a>
        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5"><span
                    class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-5">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="listarFavoritos.php">Favoritos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Minhas anotações</a>
                </li>
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

<div class="container py-4 py-xl-5">
    <div class="row mb-5">
        <div class="col-md-8 col-xl-6 text-center mx-auto">
            <form class="d-flex" method="get" action="index.php">
                <input value="<?php echo !$busca ? "" : $busca?>" name="busca" id="busca" class="border rounded form-control" type="text" autofocus="" placeholder="Busque aqui ...">
                <button class="btn btn-primary border rounded float-end" id="bt_busca" type="button">Buscar</button>
            </form>
        </div>
    </div>

    <!-- So vai aparecer quando houver busca -->
    <?php if ($busca): ?>
        <div class="row mb-5">
            <div class="col-md-8 col-xl-6 mx-auto">
                <?php
                // Se $resultado for 0 (usar a funcao count()), mostrar mensagem de "Nenum versiculo foi encontrado com o termo <tal>"
                // Senao, vai pro foreach
                foreach($resultados as $resultado):?>
                    <p>
                        <?php echo $resultado['text'] . " <strong>" . $resultado['livro'] . " " . $resultado['chapter'] . ", " . $resultado['verse'] . "</strong>" ?>
                        <a href="/listarVersiculos.php?livro=<?php echo $resultado['livro_id'] ?>&capitulo=<?php echo $resultado['chapter'] ?>" class="btn btn-info btn-sm">
                            <i class="fa fa-plus"></i>
                        </a>
                    </p>

                <?php endforeach;?>

                </p>
            </div>
        </div>


    <?php endif; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script type="text/javascript">
    window.onload = function() {
        $("#bt_busca").click(function(){
            let busca = $("#busca").val();
            if (busca === "") {
                alert("Precisa informar um termo para busca!")
            } else {
                window.location = `/index.php?busca=${busca}`;
            }
        })
    }
</script>
</body>

</html>