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

const validacoes = {
    'email': false,
    'senha': false,
    'forca_senha': false
}

const passwordInput = document.getElementById('senha')

passwordInput.addEventListener('input', verificar_forca)

function verificar_forca(){

    const password = document.getElementById('senha').value;
    const strengthIndicator = document.getElementById('indicator-password');
    const strengthText = document.getElementById('password-text');

    const strengths = {
        1: 'muito fraca',
        2: 'fraca',
        3: 'moderada',
        4: 'forte',
        5: 'muito forte',
    }

    let score = 0;

    if(password.length >= 8) score++;
    if(password.match(/[a-z]/)) score++;
    if(password.match(/[A-Z]/)) score++;
    if(password.match(/[0-9]/)) score++;
    if(password.match(/[^a-zA-Z0-9]/)) score++;

    switch(score){
        case 1:
            strengthIndicator.style.backgroundColor = 'red';
            break;
        case 2:
            strengthIndicator.style.backgroundColor = '#ff7949'
            break;
        case 3:
            strengthIndicator.style.backgroundColor = '#ffdf51';
            break
        case 4:
            strengthIndicator.style.backgroundColor = '#53aa53';
            break;
        case 5:
            strengthIndicator.style.backgroundColor = 'green';
            break;

    }

    const width = (score / 5) * 100;

    strengthIndicator.style.width = `${width}%`;

    if(password.length > 0){
        strengthText.innerText = `Senha ${strengths[score]}`;
    }else{
        strengthText.innerText = '';
    }

    if(score >= 5){
        validacoes['forca_senha'] = true;
    }else{
        validacoes['forca_senha'] = false;
    }

}

function verificar_email(email){
    const regex = /^[^\s@]{5,}@[^\s@]+\.[^\s@]+$/;

    if(email === ''){
        return false;
    }else{
        return regex.test(email)
    }

}

document.getElementById('email').addEventListener('change', function(){

    let input = document.getElementById('email')
    let smallEmail = document.getElementById('verf_email')
    let email = $('#email').val();

    if(verificar_email(email) === true && email !== ''){

        $.ajax({
            url: '../config/manter_usuarios.php',
            method: 'POST',
            data: {
                'form': 'buscar_email',
                'email': email
            },
            dataType: 'json',
            success: function(result){    
                if (result === true){
                    input.style.borderColor = 'red'
                    validacoes['email'] = false
                    smallEmail.innerText = 'Email já existente'
                    smallEmail.style.color = 'red'
                }else{
                    input.style.borderColor = 'green'
                    validacoes['email'] = true
                    smallEmail.innerText = ''
                }    
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText);
                console.log(status);
                console.log(error)
            }
        })

    }else{
        input.style.borderColor = 'red'
        validacoes['email'] = false;
        smallEmail.innerText = 'Email fora dos padrões'
        smallEmail.style.color = 'red'
    }
})

function verificar_senha(){
    let senhaInput = document.getElementById('senha');
    let confInput = document.getElementById('conf_senha');
    let smallSenha = document.getElementById('small_conf_senha');

    let senha = $('#senha').val();
    let conf_senha = $('#conf_senha').val();

    if (senha === conf_senha && senha !== ''){
        validacoes['senha'] = true
        senhaInput.style.borderColor = 'green'
        confInput.style.borderColor = 'green'
        smallSenha.innerText = ''
        smallSenha.style.color = 'green'
    }else{
        validacoes['senha'] = false
        senhaInput.style.borderColor = 'red'
        confInput.style.borderColor = 'red'
        smallSenha.innerText = 'As senhas não conferem'
        smallSenha.style.color = 'red'
    }
}

$(document).on('submit', '#form_cad', function(e){
    e.preventDefault();

    let nome = $('#nome').val();
    let sobrenome = $('#sobrenome').val();
    let email = $('#email').val();
    let senha = $('#senha').val()

    verificar_email(email);
    verificar_senha()
    verificar_forca(passwordInput);

    if(validacoes['email'] === true && validacoes['senha'] === true && validacoes['forca_senha'] === true){

        loader(true, 'Realizando Cadastro')

        $.ajax({
            url: '../config/manter_usuarios.php',
            method: 'POST',
            data: {'form': 'cadastrar_user', 'nome': nome, 'sobrenome': sobrenome, 'email': email, 'senha': senha},
            dataType: 'json',
            success: function(result){
                loader(false, '')

                if(result){
                    alerta_temporario('Sucesso!', 'Cadastro realizado.', 3000)
                    setTimeout(function(){
                        window.location.href = 'login.php';
                    }, 3000)
                }else{
                    alerta_temporario('Error!', 'Erro ao realizar cadastro. Tente novamente mais tarde', 3000)
                    setTimeout(function(){
                        window.reload();
                    }, 3000)
                }
            },
            error: function(xhr, status, error){
                loader(false, '')
                console.log(xhr.responseText)
                console.log(status)
                console.log(error)
            }
        })
    
    }else if(validacoes['email'] === false){
        alerta_temporario('Erro ao realizar cadastro', 'Verifique seu e-mail!', 3000)
        return
    }else if(validacoes['senha'] === false){
        alerta_temporario('Erro ao realizar cadastro', 'Verifique se as senhas conferem!', 3000)
        return
    }else if(validacoes['forca_senha'] === false){
        alerta_temporario('Erro ao realizar cadastro', 'Verifique a força da senha', 3000)
        return
    }else{
        alerta_temporario('Erro ao realizar cadastro', 'Verifique os dados e tente novamente!', 3000)
        return
    }
})

function teste(){
    loader(true, 'Testando')

    setTimeout(function(){
        loader(false)
        alerta_temporario('Testando', 'teste concluido', 3000)
    }, 3000)
}