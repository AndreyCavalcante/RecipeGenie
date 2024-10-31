function alerta_temporario(titulo, mensagem, tempo) {

    document.getElementById('modalMessage').innerText = mensagem;
    document.getElementById('exampleModalLabel').innerText = titulo;

    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();

    setTimeout(function() {
        modal.hide();
        document.body.classList.remove('modal-open'); 
        document.querySelector('.modal-backdrop').remove();
    }, tempo);
}

function stars(avaliacao){
    let stars_div = `
        <div class="stars_container">
    `; 

    let cont = 0

    for(let i = 0; i < avaliacao; i++){
        let star = `<span class="star active">&#9733;</span>`

        stars_div += star

        cont++
    }

    for (let j = 0; j < (5 - avaliacao); j++){
        let star = `<span class="star">&#9733;</span>`

        stars_div += star
    }

    stars_div += `</div>`;

    return stars_div

}

function reload_page(){
    window.location.reload();
}

let porcao_inicial = 0;
let porcoes = 0;

function calcular_porcoes(porcoes, quant, old_porcoes) {
    return (quant / old_porcoes) * porcoes;
}

// Função que atualiza a lista de ingredientes e porções
function ingredientes(lista, multi) {
    let div = document.querySelector('.ingre_list');
    let span = document.getElementById('porcoes');

    if (typeof lista === 'string') {
        lista = JSON.parse(lista);
    }

    // Atualizar o número de porções globalmente
    porcoes = porcoes + multi;
    if (porcoes < 1) {
        porcoes = 1; // Limita a no mínimo 1 porção
    }

    let texto = `<ul>`;

    lista.forEach(function(ingrediente) {
        // Calcular a nova quantidade com base nas porções
        let nova_quantidade = calcular_porcoes(porcoes, ingrediente.quant, porcao_inicial); // Suponho que 2 seja a porção original no banco
        let li = `<li>${ingrediente.nome}: ${nova_quantidade.toFixed(1)} ${ingrediente.uni_medida}</li>`;
        texto += li;
    });

    texto += `</ul>`;

    let span_text = `Porções: ${porcoes}`;

    // Atualizar o HTML
    div.innerHTML = texto;
    span.innerText = span_text;
}

function tabela_nutri(tabela){

    let tab = `<table class="table table-striped custom_table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>`
    ;

    tabela.forEach(function(item){
        let td = `
            <tr>
                <td>${item.item}</td>
                <td>${item.quant}</td>
            </tr>
        `;

        tab += td;
    })

    tab += `
            </tbody>
        </table>
    `;

    return tab;
}

function modo_de_preparo(lista){
    let texto = `<ul>`;

    for(let i = 0; i < lista.length; i++){
        let li = `<li>${i+1}: ${lista[i].etapa}</li>`;

        texto += li
    }

    texto += `</ul>`;

    return texto;
}

function visualizar_receita(id){

    let div = document.getElementById('receitas')

    div.innerHTML = `
        <div class="d-flex">
            <p>Carregando... </p><div class='loading'></div>
        </div>
    `;

    $.ajax({
        url:'../config/manter_receitas.php',
        method:'POST',
        data:{'form':'detalhes_receita','id':id},
        dataType:'json',
        success: function(result){
            if('error' in result){
                alerta_temporario('Erro', 'Erro ao tentar mostrar a receita', 3000)
                setTimeout(function(){
                    window.reload()
                }, 3000)
            }else{
                let receita = JSON.parse(result[0].receita);

                let tabela = receita.tab_nutri

                porcoes = receita.porcoes
                porcao_inicial = receita.porcoes

                let receita_view = `
                    <div class="receita">
                        <div class="title_recipe">
                            <div style="display: flex; align-items: center;">
                                <h3>${receita.nome} </h3>
                                ${stars(result[0].avaliacao)}
                            </div>
                            <img class="image_button image_seta" src="../assets/images/seta.png" width="40px" onclick="reload_page()">
                        </div>
                        <div class="info_recipes">
                            <ul>
                                <li>
                                    <span id="porcoes" data-porcoes="${porcoes}"></span>  
                                    <img class="image_button mais_menos" src="../assets/images/mais.png" width="20px" data-ingredientes='${JSON.stringify(receita.ingredientes)}' onclick="ingredientes(this.dataset.ingredientes, 1)">
                                    <img class="image_button mais_menos" src="../assets/images/menos.png" width="20px" data-ingredientes='${JSON.stringify(receita.ingredientes)}' onclick="ingredientes(this.dataset.ingredientes, -1)">
                                </li>
                                <li>Categoria: ${receita.categoria}</li>
                                <li>Tempo de preparo: ${receita.tempo_de_preparo}</li>
                            </ul>
                        </div>
                        <div class="ingredientes">
                            <h4>Ingredientes:</h4>
                            <div class="ingre_list">

                            </div>
                        </div>
                        <div class="modo_de_preparo">
                            <h4>Modo de preparo:</h4>
                            ${modo_de_preparo(receita.modo_preparo)}
                        </div>
                        <div class="tabela_nutricional">
                            <h4>Tabela nutricional</h4>
                            <div>
                                <p>Informação Nutricional (Porção: ${tabela.porcao})</p>
                                ${tabela_nutri(tabela.informacoes)}
                            </div>
                        </div>
                        <button class="button_delete" onclick="delete_receita(${id}, '${receita.nome}')"><img src="../assets/images/lixeira.png"></button>
                    </div>
                `;

                div.innerHTML = receita_view;

                ingredientes(receita.ingredientes, 0)
            }
        },
        error: function(xhr,status,error){
            console.log(xhr.responseText)
            console.log(status)
            console.log(error)
        }
    });
}

function buscar_receitas(id){
    $.ajax({
        url: '../config/manter_receitas.php',
        method: 'POST',
        data: {'form': 'buscar_receitas', 'id': id},
        dataType: 'json',
        success: function(result){
            console.log(result)

            let section = document.getElementById('receitas')

            section.innerHTML = "";

            let texto = ``;

            if('error' in result){
                texto = `<h1>Nenhuma Receita encontrada</h1>`

                section.innerHTML = texto;
            }else{
                result.forEach(function(receitaObj){

                    let receitaDetalhes = JSON.parse(receitaObj.receita)

                    texto += `
                        <div class="col-sm-6">
                            <div class="card card_recipes">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        ${receitaDetalhes.nome}
                                        ${stars(receitaObj.avaliacao)}
                                    </h5>
                                    <p class="card-text">Serve: ${receitaDetalhes.porcoes}<br> Tempo de preparo: ${receitaDetalhes.tempo_de_preparo}</p>
                                    <button class="botao" type="button" onclick="visualizar_receita(${receitaObj.id_receita})">Visualizar receita</button>
                                </div>
                            </div>
                        </div>
                    `;
                })

                section.innerHTML = texto;
            }

        },
        error: function(xhr, status, error){
            console.log(xhr.responseText)
            console.log(status)
            console.log(error)
        }
    });
}

function buscar_filtro(id, filtro, valor, pesq_value){

    if(valor === null || valor === ""){
        if (pesq_value === 1){
            valor = $("#pesquisa_value1").val()
        }else{
            valor = $("#pesquisa_value").val()
        }
    }

    $.ajax({
        url: '../config/manter_receitas.php',
        method: 'POST',
        data: {'form': 'buscar_por_filtro', 'id': id, 'filtro': filtro, 'pesq': valor},
        dataType: 'json',
        success: function(result){
            console.log(result)

            let section = document.getElementById('receitas')

            section.innerHTML = "";

            let texto = ``;

            if('error' in result){
                texto = `<h1>Nenhuma Receita encontrada</h1>`

                section.innerHTML = texto;
            }else{
                result.forEach(function(receitaObj){

                    let receitaDetalhes = JSON.parse(receitaObj.receita)

                    texto += `
                        <div class="col-sm-6">
                            <div class="card card_recipes">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        ${receitaDetalhes.nome}
                                        ${stars(receitaObj.avaliacao)}
                                    </h5>
                                    <p class="card-text">Serve: ${receitaDetalhes.porcoes}<br> Tempo de preparo: ${receitaDetalhes.tempo_de_preparo}</p>
                                    <button class="botao" type="button" onclick="visualizar_receita(${receitaObj.id_receita})">Visualizar receita</button>
                                </div>
                            </div>
                        </div>
                    `;
                })

                section.innerHTML = texto;
            }

        },
        error: function(xhr, status, error){
            console.log(xhr.responseText)
            console.log(status)
            console.log(error)
        }
    });
}

function delete_receita(id, nome){

    let confirm_delete = confirm("Deseja excluir a recita: "+nome)

    if(confirm_delete){
        $.ajax({
            url: "../config/manter_receitas.php",
            method: 'POST',
            data: {'form': 'delete_receita', 'id': id},
            dataType: 'json',
            success: function(result){
    
                if(result){
                    alerta_temporario("Sucesso!", "Receita deletada com sucesso!", 3000)
                    window.reload()
                }else{
                    alerta_temporario('Erro', "Erro ao tentar excluir a receita", 3000)
                }
            },
            error: function(xhr,status,error){
                console.log(xhr.responseText)
                console.log(status)
                console.log(error)
            }
        });
    }else{
        return
    }
}