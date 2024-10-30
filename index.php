<!DOCTYPE html>
<html lang="pt-BR" translate="no">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RecipeGenie</title>

        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/style_index.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
        <style>
            footer {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
                background-color: #f4f4f4;
                border-top: 1px solid #ccc;
                }

                .left-section {
                display: flex;
                gap: 20px;
                }

                .left-section a {
                text-decoration: none;
                color: #000;
                font-size: 14px;
                }

                .left-section a:hover {
                text-decoration: underline;
                }

                .copyright {
                font-size: 14px;
                color: #666;
                }

                .h1 {
                font-size: 24px;
                color: #333;
                }
        </style>
    </head>
    <body>
        <header class="container-fluid nav-container">
            <div class="nav-container">
                <nav class="navbar navbar-expand-lg nav-edit">
                    <div class="container-fluid">
                        <a class="navbar-brand font-edit" href="#">
                            <img src="assets/images/favicon.png" width="40px" alt="Recipe Genie">
                            Recipe Genie
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link" href="#ia_title">Saiba mais</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Suporte</a>
                                </li>
                            </ul>
                            <div class="d-flex" role="search">
                                <a class="nav-btn" href="pages/login.php">
                                    <input type="button" value="Entrar">
                                </a>
                                <a class="nav-btn" href="pages/cadastro.php">
                                    <input type="button" value="Cadastre-se">
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="container-fluid">
            <div class="row-space"></div>
            <div class="row">
                <div class="col-12 col-lg-1"></div>

                <div class="col-12 col-lg-5 centro">
                    <h1 class="texto">
                        Crie pratos incríveis em segundos com nosso gerador de receitas!                    
                    </h1>
                    <p>
                        Descubra receitas deliciosas em segundos e transforme seus ingredientes
                        em pratos incríveis com o <strong>Recipe Genie  </strong>
                        <a href="pages/login.php">
                            <button class="botao">Comece já ⬈</button>
                        </a>
                    </p>
                </div>

                <div class="col-12 col-lg-5">
                    <img class="logo_index" src="assets/images/logo.png" width="450px" alt="">
                </div>

                <div class="col-12 col-lg-1"></div>
            </div>
            <div class="row-space-B"></div>
            <div class="row">
                <div class="col-lg-2"></div>

                <div class="col-lg-4 justify-content-center text-center">
                    <img src="assets/images/openai_api.png" width="200px" alt="">
                </div>
                <div class="col-lg-4">
                    <h1 id="ia_title" class="ia-title">Receitas Geradas por <strong>Inteligência Artificial</strong></h1>
                    <div class="functions-list">
                        <p>
                            <img src="assets/images/openai_api_icon.png" width="16" alt="">
                            Crie receitas com os ingredientes disponíveis em casa
                        </p>
                        <p>
                            <img src="assets/images/icone_chapeu.png" width="16" alt="">
                            Evite o desperdício criando receitas deliciosas
                        </p>
                        <p>
                            <img src="assets/images/icone_receitas.png" width="16" alt="">
                            Salve suas receitas para ver onde e quando quiser
                        </p>
                    </div>
                </div>

                <div class="col-lg-2"></div>
            </div>
            <div class="row-space"></div>
        </main>
        <footer>
            <div class="left-section">
                <a href="#">Sobre Nós</a>
                <a href="#">Feedback</a>
                <span class="copyright">© 2024 RecipeGenie</span>
            </div>
            <h1 class="h1">RecipeGenie</h1>
        </footer>

        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.navbar-toggler').click(function() {
                    $('#navbarSupportedContent').collapse('toggle');
                });
            });
        </script>
    </body>
</html>