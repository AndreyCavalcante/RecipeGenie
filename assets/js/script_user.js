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

function buscar_dados_user(id){
    $.ajax({
        url: '../config/manter_receitas.php',
        method: 'POST',
        data: {'form':'count_receitas', 'id':id},
        dataType: 'json',
        success: function(result){

            let div = document.getElementById('tabela_dados');

            if('error' in result){
                div.innerHTML += `<h4>${result.error}</h4>`;
            }else{
                let tabela = `
                    <table class="table table-striped-columns edit-table" id="tabela_user" style="color: #0c0628;">
                        <tr>
                            <th>Salgadas</th>
                            <th>Doces</th>
                            <th>Fitness</th>
                            <th>Total</th>
                        </tr>
                        <tr>
                            <td>${result.doces}</td>
                            <td>${result.salgadas}</td>
                            <td>${result.fitness}</td>
                            <td>${result.total}</td>
                        </tr>
                    </table>
                `;

                div.innerHTML += tabela;
            }
        },
        error: function(xhr, status, error){
            console.log(xhr.responseText)
            console.log(status)
            console.log(error)
        }
    });
}

function form_editar(id, nome, sobrenome, email){
    let div = document.getElementById('receitas');

    let form = `
        <div class="form-container">
            <form id="form_editar_user">
                <div class="input_container">
                    <input type="hidden" id="id_user" value="${id}">
                    <label for="email">Nome:</label><br>
                    <input type="text" name="nome_user" id="nome_user" value="${nome}" required><br>
                </div>
                <div class="input_container">
                    <label for="email">Sobrenome:</label><br>
                    <input type="text" name="sobrenome_user" id="sobrenome_user" value="${sobrenome}" required><br>
                </div>
                <div class="input_container">
                    <label for="senha">Email:</label><br>
                    <input type="email" name="email_user" id="email_user" value="${email}" required>
                </div>
                <div class="input_container text-center">
                    <button type="submit" class="botao submit_button" style="margin: 3px;">Editar</button>
                </div>
                <div class="input_container text-center">
                    <button type="button" class="botao submit_button" onclick="editar_senha(${id})" style="margin: 3px;">Editar Senha</button>
                </div>
            </form>
        </div>
    `;

    div.innerHTML = form;
}

function editar_senha(id){
    let div = document.getElementById('receitas');

    let form = `
        <form id="form_editar_senha">
            <div class="input_container">
                <input type="hidden" id="id_user" value="${id}">
                <label for="email">Senha Atual:</label><br>
                <input type="password" name="senha_atual" id="senha_atual" placeholder="Digite sua senha atual" required><br>
            </div>
            <div class="input_container">
                <label for="senha">Nova Senha:</label><br>
                <input type="password" name="senha" id="senha" placeholder=" Criar nova senha" oninput="verificar_forca()" onchange="verificar_senha()" required><br>
                <div class="bar-password">
                    <p id="indicator-password" class="indicator-password"></p>
                </div>
                <div class="div-text-password"><small id="password-text"></small></div>
                <div class="dica"><small id="tip">Sua senha deve conter letras maiusculas e minusculas, números e caracteres especiais</small></div>
                <small class="small_validation" id="small_conf_senha"></small>
            </div>
            <div class="input_container" style="margin-bottom: 10px;">
                <label for="conf_senha">Confirmar nova senha:</label><br>
                <input type="password" name="conf_senha" id="conf_senha" placeholder=" Confirmar nova senha" onchange="verificar_senha()" required>
            </div>
            <div class="input_container text-center">
                <button type="submit" class="botao submit_button" style="margin: 3px;">Editar</button>
            </div>
        </form>
    `;

    div.innerHTML = form;
}

const validacoes = {
    'email': false,
    'senha': false,
    'forca_senha': false
}

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

$(document).on('submit', '#form_editar_user', function(e){
    e.preventDefault();

    let id = $('#id_user').val();
    let nome = $('#nome_user').val();
    let sobre = $('#sobrenome_user').val();
    let email = $('#email_user').val();

    verificar_email(email);

    if(validacoes['email'] === true){
        $.ajax({
            url: '../config/manter_usuarios.php',
            method: 'POST',
            data: {'form': 'alterar_user', 'id':id, 'nome': nome, 'sobre': sobre, 'email':email},
            dataType: 'json',
            success: function(result){
                loader(false);

                if(result){
                    alerta_temporario('Sucesso!', 'Dado(s) alterado(s) com sucesso!', 3000)
                    window.location.reload()
                }else{
                    alerta_temporario('Erro!', 'Erro ao tentar alterar seu(s) dado(s), tente novamente mais tarde', 3000)
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText)
                console.log(status)
                console.log(error)
            }
        });
    }
});

$(document).on('submit', '#form_editar_senha', function(e){
    e.preventDefault();

    let id = $('#id_user').val();
    let senha_atual = $('#senha_atual').val();
    let senha_nova = $('#senha').val();

    verificar_forca();
    verificar_senha();

    loader(true, "Alterando senha");
    if(validacoes['senha'] === true && validacoes['forca_senha'] === true){
        
        $.ajax({
            url: '../config/manter_usuarios.php',
            method: 'POST',
            data: {'form': 'alterar_senha', 'id':id, 'senha_atual': senha_atual, 'senha_nova': senha_nova},
            dataType: 'json',
            success: function(result){
                loader(false);

                if('sucesso' in result){
                    alerta_temporario('Sucesso!', 'Senha alterada com sucesso!', 3000)
                    window.location.href = '../config/logout.php';
                }else{
                    alerta_temporario('Erro!', result.error, 3000)
                }
            },
            error: function(xhr, status, error){
                console.log(xhr.responseText)
                console.log(status)
                console.log(error)
            }
        });

    }else if(validacoes['senha'] === false){
        loader(false);
        alerta_temporario('Erro ao tentar atualizar senha', 'Verifique se as senhas conferem', 3000);
    }else if(validacoes['forca_senha'] === false){
        loader(false)
        alerta_temporario('Erro ao tentar atualizar senha', 'Verifique a força da senha e tente novamente', 3000);
    }
});