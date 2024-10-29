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
        <title>Teste</title>

        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/style_user.css">
    </head>
    <body class="container-fluid" onload="buscar_receitas(<?php echo $id_user?>)">
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
                            <div>
                                <input type="text" name="" id="">
                                <input type="submit" value="">
                                <select name="" id=""></select>
                            </div>
                        </form>
                    </ul>
                    <!-- NavBar Vertical expandida-->
                    <ul class="navbar-nav d-lg-none nav-vertical-edit">
                        <button class="btn botao sidebar-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Categorias ᐯ
                        </button>
                        <div class="collapse collapse-edit" id="collapseExample">
                            <div class="card card-body filtro-card">
                                <input type="button" value="Salgados" class="collapse_button">
                                <input type="button" value="Doces" class="collapse_button">
                                <input type="button" value="Fitness" class="collapse_button">
                            </div>
                        </div>
                        <hr>
                        <a class="nav-btn">
                            <input type="button" value="Gerar Receita ⬈">
                        </a>
                        <form action="../config/logout.php">
                            <a class="nav-btn">
                                <input type="submit" value="Sair" style="margin-top: 3px;">
                            </a>
                        </form>
                        <hr>
                        <form>
                            <div>
                                <input type="text" name="" id="">
                                <input type="submit" value="">
                                <select name="" id="">
                                    
                                </select>
                            </div>
                        </form>
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
                                Categorias ᐯ
                            </button>
                            <div class="collapse collapse-edit" id="collapseExample">
                                <div class="card card-body filtro-card">
                                    <input type="button" value="Salgados" class="collapse_button">
                                    <input type="button" value="Doces" class="collapse_button">
                                    <input type="button" value="Fitness" class="collapse_button">
                                </div>
                            </div>
                            <hr>
                            <a class="nav-btn">
                                <input type="button" value="Gerar Receita ⬈">
                            </a>
                            <form action="../config/logout.php">
                                <a class="nav-btn">
                                    <input type="submit" value="Sair" style="margin-top: 3px;">
                                </a>
                            </form>
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