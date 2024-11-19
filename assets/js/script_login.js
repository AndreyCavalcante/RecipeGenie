function alerta_temporario(titulo, mensagem, tempo) {

    document.getElementById('modalMessage').innerText = mensagem;
    document.getElementById('exampleModalLabel').innerText = titulo;

    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();

    setTimeout(function() {
        modal.hide();
        document.body.classList.remove('modal-open');
        let modal_remove = document.getElementById('exampleModal');
        modal_remove.classList.remove('show');
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

document.getElementById('email').addEventListener('change', function(){
    let emailInput = document.getElementById('email')
    let smallEmail = document.getElementById('small_email')
    
    let email = $('#email').val();

    $.ajax({
        url: '../config/manter_usuarios.php',
        method: 'POST',
        data: {'form': 'buscar_email', 'email': email},
        dataType: 'json',
        success: function(result){
            if (result === true){
                emailInput.style.borderColor = 'green'
                smallEmail.innerText = ''
            }else{
                emailInput.style.borderColor = 'red'
                smallEmail.innerText = 'Email não encontrado'
                smallEmail.style.color = 'red'
            }       
        },
        error: function(xhr, status, error){
            console.log(xhr.responseText)
            console.log(status)
            console.log(error)
        }
    });
})

$(document).on('submit', '#form_login', function(e){

    e.preventDefault();

    let email = $('#email').val();
    let senha = $('#senha').val();

    loader(true, 'Login')

    $.ajax({
        url: '../config/manter_usuarios.php',
        method: 'POST',
        data: {'form': 'login', 'email': email, 'senha': senha},
        dataType: 'json',
        success: function(result){

            loader(false)

            if(result === true){
                window.location.href = '../pages/minhas_receitas.php';
            }else{
                alerta_temporario('Erro', 'Não foi possível realizar o login, tente novamente!', 3000)
            }
        },
        error: function(xhr, status, error){
            console.log(xhr.responseText)
            console.log(status)
            console.log(error)
        }
    });
});