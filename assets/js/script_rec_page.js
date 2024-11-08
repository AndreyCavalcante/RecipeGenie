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

function loader(value, title = ''){
    document.getElementById('modalMessage').innerHTML = `
        <div class="d-flex">
            <p>Carregando... </p><div class='loading'></div>
        </div>
    `;

    document.getElementById('exampleModalLabel').innerText = title;

    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    
    if(value){
        modal.show();
    }else{
        modal.hide();
        document.body.classList.remove('modal-open'); 
        document.querySelector('.modal-backdrop').remove();
    }
}

$(document).on('submit', '#form_gerar_receitas', function(e){
    e.preventDefault();

    let ingre_values = $('#ingredientes_value').val();

    let ingre_list = ingre_values.split(",");

    let ingredientes = [];
    
    ingre_list.forEach(ingrediente => {
        ingredientes.push(ingrediente.trim())
    });

    console.log(ingredientes)

    
});