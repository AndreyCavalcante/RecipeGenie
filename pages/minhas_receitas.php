<?php

    session_start();

    if((!isset($_SESSION['email']) === TRUE) and (!isset($_SESSION['senha']) === TRUE)){
        session_unset();
        session_destroy();
        echo "
            <script>
                window.location.href = 'login.php';
            </script>
        ";
    }

    $id_user = $_SESSION['id_user'];
    $nome = $_SESSION['nome'];
    $sobrenome = $_SESSION['sobrenome'];
    $email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RecipeGenie - Receitas</title>

        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/style_user.css">

        <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    </head>
    <body class="container-fluid" onload="buscar_receitas(<?php echo $id_user?>)">

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalMessage"></div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg nav-edit fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand logo" href="#">
                    <img src="../assets/images/favicon.png" width="40px" alt="">
                    Recipe Genie
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse  horizontal-edit" id="navbarNav">
                    <!-- NavBar horizontal -->
                    <ul class="navbar-nav ms-auto d-none d-lg-flex">
                        <form>
                            <div class="input_container side-bar-pesq">
                                <input type="text" name="pesquisa_value" id="pesquisa_value" placeholder="Pesquisar por nome">
                                <button type="button" onclick="buscar_filtro(<?php echo $id_user?>, 'pesquisa', '', 0)"><img src="../assets/images/pesq.png" width="25px" alt=""></button>
                            </div>
                        </form>
                    </ul>
                    <!-- NavBar Vertical expandida-->
                    <ul class="navbar-nav d-lg-none nav-vertical-edit">
                        <div class="side-bar-container">
                            <button class="btn botao sidebar-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <span class="btn-text">Categorias</span>
                                <img class="btn-icon" src="../assets/images/seta_baixo.png" width="20px" alt="">
                            </button>
                            <div class="collapse collapse-edit" id="collapseExample">
                                <div class="card card-body filtro-card">
                                    <input type="button" value="Todas" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'todas', 0)">
                                    <input type="button" value="Salgados" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'salgado', 0)">
                                    <input type="button" value="Doces" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'doce', 0)">
                                    <input type="button" value="Fitness" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'fitness', 0)">
                                </div>
                            </div>
                            <button class="btn botao sidebar-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
                                <span class="btn-text">Tempo de preparo</span>
                                <img class="btn-icon" src="../assets/images/seta_baixo.png" width="20px" alt="">
                            </button>
                            <div class="collapse collapse-edit" id="collapseExample1">
                                <div class="card card-body filtro-card">
                                    <input type="button" value="-15 minutos" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'tempo', 1, 0)">
                                    <input type="button" value="15 - 30 minutos" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'tempo', 2, 0)">
                                    <input type="button" value="+30m minutos" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'tempo', 3, 0)">
                                </div>
                            </div>
                            <button class="btn botao sidebar-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                                <span class="btn-text">Avaliação</span>
                                <img class="btn-icon" src="../assets/images/seta_baixo.png" alt="">
                            </button>
                            <div class="collapse collapse-edit" id="collapseExample2">
                                <div class="card card-body filtro-card">
                                    <input type="button" value="Maior" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'avaliacao', 'maior', 0)">
                                    <input type="button" value="Menor" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'avaliacao', 'menor', 0)">
                                </div>
                            </div>
                            <hr>
                            <a href="receita.php" class="nav-btn sidebar-nav-btn">
                                <input type="button" value="Gerar Receita ⬈">
                            </ah>
                            <form action="../config/logout.php">
                                <a class="nav-btn sidebar-nav-btn">
                                    <input type="submit" value="Sair" style="margin-top: 3px;">
                                </a>
                            </form>
                            <hr>
                            <form>
                                <div class="input_container side-bar-pesq">
                                    <input type="text" name="pesquisa_value1" id="pesquisa_value1" placeholder="Pesquisar por nome">
                                    <button type="button" onclick="buscar_filtro(<?php echo $id_user?>, 'pesquisa', '', 1)"><img src="../assets/images/pesq.png" width="25px" alt=""></button>
                                </div>
                            </form>
                            <div class="footer-nav-expand">
                                <div class="left-section">
                                    <a href="#">Sobre Nós</a>
                                    <a href="#">Feedback</a>
                                    <span class="copyright">© 2024 RecipeGenie</span>
                                </div>
                                <div class="nome_footer">
                                    <h1 class="h1">RecipeGenie</h1>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <div class="sidebar">
                        <ul class="side-list">
                        <button class="btn botao sidebar-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <span class="btn-text">Categorias</span>
                                <img class="btn-icon" src="../assets/images/seta_baixo.png" width="20px" alt="">
                            </button>
                            <div class="collapse collapse-edit" id="collapseExample">
                                <div class="card card-body filtro-card">
                                    <input type="button" value="Todas" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'todas', 0)">
                                    <input type="button" value="Salgados" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'salgado', 0)">
                                    <input type="button" value="Doces" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'doce', 0)">
                                    <input type="button" value="Fitness" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'categoria', 'fitness', 0)">
                                </div>
                            </div>
                            <button class="btn botao sidebar-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
                                <span class="btn-text">Tempo de preparo</span>
                                <img class="btn-icon" src="../assets/images/seta_baixo.png" width="20px" alt="">
                            </button>
                            <div class="collapse collapse-edit" id="collapseExample1">
                                <div class="card card-body filtro-card">
                                    <input type="button" value="-15 minutos" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'tempo', 1, 0)">
                                    <input type="button" value="15 - 30 minutos" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'tempo', 2, 0)">
                                    <input type="button" value="+30m minutos" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'tempo', 3, 0)">
                                </div>
                            </div>
                            <button class="btn botao sidebar-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                                <span class="btn-text">Avaliação</span>
                                <img class="btn-icon" src="../assets/images/seta_baixo.png" alt="">
                            </button>
                            <div class="collapse collapse-edit" id="collapseExample2">
                                <div class="card card-body filtro-card">
                                    <input type="button" value="Maior" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'avaliacao', 'maior', 0)">
                                    <input type="button" value="Menor" class="collapse_button" onclick="buscar_filtro(<?php echo $id_user?>, 'avaliacao', 'menor', 0)">
                                </div>
                            </div>
                            <hr>
                            <a href="receita.php" class="nav-btn sidebar-nav-btn">
                                <input type="button" value="Gerar Receita ⬈">
                            </a>
                            <form action="../config/logout.php">
                                <a class="nav-btn sidebar-nav-btn">
                                    <input type="submit" value="Sair" style="margin-top: 3px;">
                                </a>
                            </form>
                            <div class="footer-nav">
                                <div class="left-section">
                                    <a href="#">Sobre Nós</a>
                                    <a href="#">Feedback</a>
                                    <span class="copyright">© 2024 RecipeGenie</span>
                                </div>
                                <h1 class="h1">RecipeGenie</h1>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 main-container">
                    <div class="container_title">
                        <h3>Minhas receitas</h3>
                    </div>
                    <section class="section-container" id="receitas">
                        
                    </section>
                </div>
            </div>
        </div>

        <script src="../assets/js/jquery-3.7.1.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/script_user.js"></script>
    </body>
</html>