<!DOCTYPE html>
<html lang="pt-BR" translate="no">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RecipeGenie - Cadastre-se</title>

        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

        <link rel="stylesheet" href="../assets/css/global.css">
        <link rel="stylesheet" href="../assets/css/style_cad.css">

        <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
    </head>
    <body>
        <header class="container-fluid nav-container">
            <div class="nav-container">
                <nav class="navbar navbar-expand-lg nav-edit">
                    <div class="container-fluid">
                        <a class="navbar-brand font-edit" href="../index.php">
                            <img src="../assets/images/favicon.png" width="40px" alt="Recipe Genie">
                            Recipe Genie
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                
                            </ul>
                            <div class="d-flex horizontal-edit" role="search">
                                <a class="nav-btn" href="login.php">
                                    <input type="button" value="Entrar">
                                </a>
                                <a class="nav-btn" href="#">
                                    <input type="button" value="Cadastre-se">
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
            
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

        </header>

        <main class="container-fluid">
            <div class="row-space"></div>
            <div class="row justify-content-center text-center">
                <h1>Cadastre-se</h1>
            </div>
            <div class="row justify-content-center">

                <div class="col-lg-12 d-flex justify-content-center">
                    <section class="section-form section_cad">
                        <div class="image-container d-flex justify-content-center text-center">
                            <div class="image">
                                <img src="../assets/images/logo.png" alt="">
                            </div>
                        </div>
                        <div>
                            <form id="form_cad">
                                <div class="input_container">
                                    <label for="nome">Nome:</label><br>
                                    <input type="text" name="nome" id="nome" placeholder=" Insira eu nome" required>
                                </div>
                                <div class="input_container">
                                    <label for="sobrenome">Sobrenome:</label><br>
                                    <input type="text" name="sobrenome" id="sobrenome" placeholder=" Insira seu sobrenome" required>
                                </div>
                                <div class="input_container">
                                    <label for="email">E-mail:</label><br>
                                    <input type="email" name="email" id="email" placeholder=" Insira seu email" required><br>
                                    <small class="small_validation" id="verf_email"></small>
                                </div>
                                <div class="input_container">
                                    <label for="senha">Senha:</label><br>
                                    <input type="password" name="senha" id="senha" placeholder=" Criar senha" onchange="verificar_senha()" required><br>
                                    <div class="bar-password">
                                        <p id="indicator-password" class="indicator-password"></p>
                                    </div>
                                    <div class="div-text-password"><small id="password-text"></small></div>
                                    <div class="dica"><small id="tip">Sua senha deve conter letras maiusculas e minusculas, números e caracteres especiais</small></div>
                                    <small class="small_validation" id="small_conf_senha"></small>
                                </div>
                                <div class="input_container">
                                    <label for="conf_senha">Confirmar senha:</label><br>
                                    <input type="password" name="conf_senha" id="conf_senha" placeholder=" Confirmar senha" onchange="verificar_senha()" required>
                                </div>
                                <div class="input_container justify-content-center text-center">
                                    <button class="botao submit_button" type="submit">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </main>

        <footer class="container-fluid footer">

        </footer>
    
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/jquery-3.7.1.min.js"></script>

        <script src="../assets/js/script_cad.js"></script>
    </body>
</html>