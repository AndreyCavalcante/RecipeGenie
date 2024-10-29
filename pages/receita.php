<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/style_user.css">

    <style>
        body{
            display: flex;
            justify-content: center;
            padding: 50px;
        }

        .div_container{
            width: 50%;
        }

        .section_recipes{
            padding: 50px;
        }

        .title_recipe{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .title_recipe button{
            height: 20px;
        }

        .info_recipes ul, .ingredientes ul, .modo_de_preparo ul{
            list-style: none;
        }
    </style>
</head>
<body>
    <div class="div_container">
        <section class="section_recipes">
            <div class="receita">
                <div class="title_recipe">
                    <h1>Nome Receita</h1>
                    <button>voltar</button>
                </div>
                <div class="info_recipes">
                    <ul>
                        <li>Categoria: Salgado</li>
                        <li>Proções: 2 pessoas</li>
                        <li>Tempo de preparo: 20 minutos</li>
                    </ul>
                </div>
                <div class="ingredientes">
                    <h3>Ingredientes:</h3>
                    <ul>
                        <li>a</li>
                        <li>b</li>
                        <li>c</li>
                    </ul>
                </div>
                <div class="modo_de_preparo">
                    <h3>Modo de preparo:</h3>
                    <ul>
                        <li>Etapa 1: </li>
                        <li>Etapa 2: </li>
                        <li>Etapa 3: </li>
                        <li>Etapa 4: </li>
                    </ul>
                </div>
                <div class="tabela_nutricional">
                    <h3>Tabela nutricional:</h3>
                    <table border="1">
                        <caption>Informação Nutricional (Porção: 100g)</caption>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Valor energético</td>
                                <td>170 kcal</td>
                            </tr>
                            <tr>
                                <td>Carboidratos</td>
                                <td>28g</td>
                            </tr>
                            <tr>
                                <td>Açucares totais</td>
                                <td>20g</td>
                            </tr>
                            <tr>
                                <td>Açucares adicionados</td>
                                <td>20g</td>
                            </tr>
                            <tr>
                                <td>Proteínas</td>
                                <td>3g</td>
                            </tr>
                            <tr>
                                <td>Gorduras totais</td>
                                <td>6g</td>
                            </tr>
                            <tr>
                                <td>Gorduras saturadas</td>
                                <td>4g</td>
                            </tr>
                            <tr>
                                <td>Gorduras trans</td>
                                <td>0g</td>
                            </tr>
                            <tr>
                                <td>Fibra alimentar</td>
                                <td>1g</td>
                            </tr>
                            <tr>
                                <td>Sódio</td>
                                <td>40mg</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</body>
</html>