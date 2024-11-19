<?php

    session_start();

    if((!isset($_SESSION['email']) === TRUE) || (!isset($_SESSION['id_user']) === TRUE)){
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
        <title>RecipeGenie - Gerar receita</title>

        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/style_minhas_receitas.css">
        <link rel="stylesheet" href="../assets/css/style_receita.css">

        <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    </head>
    <body class="container-fluid">
        <input type="hidden" name="id_user" id="id_user" value="<?php echo $id_user?>">
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
                        <form action="../config/logout.php">
                            <a class="nav-btn sidebar-nav-btn">
                                <input type="submit" value="Sair" style="margin-top: 3px; margin-right: 10px; width: 100px;">
                            </a>
                        </form>
                    </ul>
                    <!-- NavBar Vertical expandida-->
                    <ul class="navbar-nav d-lg-none nav-vertical-edit">
                        <div class="side-bar-container receitas_page">
                            <a href="../pages/usuario.php" class="nav-btn sidebar-nav-btn">
                                <input type="button" value="Meu perfil ⬈">
                            </a>
                            <a href="../pages/minhas_receitas.php" class="nav-btn sidebar-nav-btn">
                                <input type="button" value="Minhas receitas ⬈">
                            </a>
                            <form action="../config/logout.php">
                                <a class="nav-btn sidebar-nav-btn">
                                    <input type="submit" value="Sair" style="margin-top: 3px;">
                                </a>
                            </form>

                            <div class="footer-nav-expand">
                                <div class="left-section">
                                    <a href="#">Sobre Nós</a>
                                    <a href="#">Feedback</a>
                                    <span class="copyright">© 2024 RecipeGenie</span>
                                </div>
                                <h1 class="h1">RecipeGenie</h1>
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
                            <a href="../pages/usuario.php" class="nav-btn sidebar-nav-btn">
                                <input type="button" value="Meu perfil ⬈">
                            </a>
                            <a href="../pages/minhas_receitas.php" class="nav-btn sidebar-nav-btn">
                                <input type="button" value="Minhas receitas ⬈">
                            </a>
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
                    <section class="section_gerar_receita section-container" id="receitas">
                        <div class="container_input">
                            <div class="container_inpur_rec">
                                <h2>Gerar receitas</h2>
                                <p id="msg_rec">Crie uma receita com os ingredientes disponíveis em casa</p>
                            </div>
                            <div id="receita_ingredientes">
                                <form id="form_gerar_receitas">
                                    <div class="container_input_rec input_rec">
                                        <input
                                            type="text" name="ingredientes_values"
                                            id="ingredientes_value"
                                            placeholder=" "
                                            required
                                            data-bs-container="body"
                                            data-bs-toggle="popover"
                                            data-bs-placement="bottom"
                                            data-bs-trigger="focus"
                                            data-bs-content='Separe seus ingredientes com ","'
                                        >
                                        <label for="ingredientes_value">Ingredientes</label>
                                    </div>
                                    <div class="container_input_rec"></div>
                                    <div class="container_input_rec">
                                        <input class="botao submit_button submit_form_rec" type="submit" id="submit_form_rec" value="Gerar receita">
                                    </div>
                                </form>
                                <a style="cursor: pointer;" onclick="mudar_form(1)">Deseja gerar receita por nome?</a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        
        <script src="../assets/js/jquery-3.7.1.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/script_rec_page.js"></script>
        <script>
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
        </script>
    </body>
</html>