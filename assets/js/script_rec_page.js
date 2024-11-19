let receita_global = "";

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

function reload_page(){
    window.location.reload();
}

function changeEmoji() {
    const emojis = ["🍕","🍟", "🌭", "🍿", "🍰", "🥪","🍨", "🥞", "🍱", "🍫", "🍹", "☕", "🦞","🍜", "🥗", "🥕", "🍩", "🍵", "🥟", "🍖", "🥑", "🍎", "🍳", "🍡", "🥧"];
    let index = 0;

    const loadingEmoji = document.getElementById("loader_modal_rec");

    setInterval(() => {
        loadingEmoji.innerText = emojis[index];
        index = (index + 1) % emojis.length;
    }, 500);
}

function loader(value, title = ''){
    document.getElementById('modalMessage').innerHTML = `   
        <div class="d-flex loading_recipes">
            <p>Carregando... </p><div id="loader_modal_rec"></div>
        </div>
    `;

    document.getElementById('exampleModalLabel').innerText = title;

    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    
    if(value === true){
        modal.show();
        changeEmoji();
        
    }else if(value === false){
        modal.hide();
        document.body.classList.remove('modal-open');

        let modal_remove = document.getElementById('exampleModal');
        modal_remove.classList.remove('show');

        document.querySelector('.modal-backdrop').remove();
    }
}

function teste_modal(){
    loader(true, "Testando")
}

function renderizarIngredientes(ingredientes) {
    let texto = "<ul>";
    ingredientes.forEach(ingrediente => {
        texto += `<li>${ingrediente.quant} ${ingrediente.uni_medida} de ${ingrediente.nome}</li>`;
    });
    texto += "</ul>";
    return texto;
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

function modo_de_preparo(lista) {
    let texto = "<ul>";

    for (let i = 0; i < lista.length; i++) {
        let li = `<li>${i + 1}: ${lista[i].etapa}</li>`;
        texto += li;
    }

    texto += "</ul>";

    return texto;
}

function exibir_receitas(result) {

    console.log(result);
    if (!result || !Array.isArray(result.receita) || result.receita.length === 0) {
        console.error("Estrutura de `result` inesperada ou vazia.");
        return;
    }

    let receita = result.receita[0];
    let div = document.getElementById('receitas');
    let tabela = receita.tab_nutri;
    let porcoes = receita.porcoes;

    let receita_view = `
        <div class="receita">
            <div class="title_recipe">
                <div style="display: flex; align-items: center;">
                    <h3>${receita.nome}</h3>
                </div>
                <img class="image_button image_seta" src="../assets/images/seta.png" width="40px" onclick="reload_page()">
            </div>
            <div class="info_recipes">
                <ul>
                    <li>
                        <span id="porcoes" data-porcoes="${porcoes}">Porções: ${porcoes}</span>  
                    </li>
                    <li>Categoria: ${receita.categoria}</li>
                    <li>Tempo de preparo: ${receita.tempo_de_preparo}</li>
                </ul>
            </div>
            <div class="ingredientes">
                <h4>Ingredientes:</h4>
                <div class="ingre_list">
                    ${renderizarIngredientes(receita.ingredientes)}
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
            <div class="botao_salvar_receita">
                <button class="botao submit_button" onclick="salvar_receita()">Salvar Receita</button>
            </div>
        </div>
    `;

    div.innerHTML = receita_view;
}


$(document).on('submit', '#form_gerar_receitas', function(e){
    e.preventDefault();

    let ingre_values = $('#ingredientes_value').val();

    let ingre_list = ingre_values.split(",");

    let ingredientes = [];
    
    ingre_list.forEach(ingrediente => {
        ingredientes.push(ingrediente.trim())
    });

    loader(true, 'Gerando receita...')

    $.ajax({
        url: '../config/gerar_receitas.php',
        method: 'post',
        data: {"lista": ingredientes},
        dataType: 'json',
        success: function(result){
            loader(false, 'Sucesso')

            if('error' in result){
                alerta_temporario('Erro', "Erro ao gerar a receita", 3000);
            }else{
                exibir_receitas(result);
                receita_global = result.receita;
                console.log(receita_global);
            }
        },
        error: function(xhr, status, error){
            loader(false, "Erro")
            console.log("Erro: "+status+error)
        }
    });

    
});

$(document).on('submit', '#form_gerar_nome', function(e){
    e.preventDefault();

    let ingre_values = $('#ingredientes_value').val();

    let ingre_list = ingre_values.split(",");

    let ingredientes = [];
    
    ingre_list.forEach(ingrediente => {
        ingredientes.push(ingrediente.trim())
    });

    loader(true, 'Gerando receita...')

    $.ajax({
        url: '../config/gerar_receitas.php',
        method: 'post',
        data: {"lista": ingredientes},
        dataType: 'json',
        success: function(result){
            loader(false, 'Sucesso')

            if('error' in result){
                alerta_temporario('Erro', "Erro ao gerar a receita", 3000);
            }else{
                exibir_receitas(result);
                receita_global = result.receita;
                console.log(receita_global);
            }
        },
        error: function(xhr, status, error){
            loader(false, "Erro")
            console.log("Erro: "+status+error)
        }
    });

    
});

function salvar_receita(){
    let id = $('#id_user').val();

    $.ajax({
        url: "../config/manter_receitas.php",
        method: 'POST',
        data: {'form': 'salvar_receita', "id": id, "receita":receita_global[0]},
        dataType: 'json',
        success: function(result){
            if(result){
                alerta_temporario('Sucesso!', "A receita foi salva com sucesso!", 3000);
                setTimeout(function(){
                    window.location.href = '../pages/minhas_receitas.php';
                },3000);
            }else{
                alerta_temporario('Erro!', 'Ocorreu um erro inesperado ao tentar salvar a receita');
            }
        },
        error: function(xhr, status, error){
            console.log(xhr.responseText)
            console.log(status)
            console.log(error)
        }
    });
}