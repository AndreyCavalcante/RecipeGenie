<?php
    header('Content-type: application/json');

    session_start();

    include 'connection.php';

    global $connect;

    $form = $_POST['form'];

    switch($form){
        case 'login':
            login($connect);
            break;
        case 'cadastrar_user':
            cadastrar_user($connect);
            break;
        case 'buscar_email':
            buscar_email($connect);
            break;
        case 'alterar_user':
            alterar_user($connect);
            break;
        case 'alterar_senha':
            alterar_senha($connect);
            break;
        default:
            break;
    }

    function login($connect){

        $email = $connect->real_escape_string($_POST['email']);
        $senha = $connect->real_escape_string($_POST['senha']);

        $stmt = "SELECT * FROM usuarios WHERE email = '$email'";

        $result = $connect->query($stmt);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            if(password_verify($senha, $row["senha"])){

                //var_dump($row);

                $_SESSION["id_user"] = $row["id_user"];
                $_SESSION["nome"] = $row["nome_user"];
                $_SESSION["sobrenome"] = $row["sobrenome_user"];
                $_SESSION["email"] = $row["email"];

                echo json_encode(true);
            }else{
                session_unset();
                session_destroy();

                echo json_encode(false);
            }
        }else{
            session_destroy();
            session_unset();

            echo json_encode(false);
        }
    }

    function cadastrar_user($connect){
        $nome = $connect->real_escape_string($_POST['nome']);
        $sobrenome = $connect->real_escape_string($_POST['sobrenome']);
        $email = $connect->real_escape_string($_POST['email']);
        $senha = $connect->real_escape_string($_POST['senha']);

        $criptografia = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $connect->prepare("INSERT INTO usuarios (nome_user, sobrenome_user, email, senha) VALUES(?,?,?,?)");

        if($stmt === false){
            echo json_encode(false);
        }

        $stmt->bind_param("ssss", $nome, $sobrenome, $email, $criptografia);

        if($stmt->execute()){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }

        $stmt->close();
        $connect->close();
    }

    function buscar_email($connect){
        $email = $connect->real_escape_string($_POST['email']);

        $sql = "SELECT id_user FROM usuarios WHERE email = '$email'";

        $result = $connect->query($sql);

        if($result->num_rows > 0){
            $status = true;
        }else {
            $status = false;
        }

        echo json_encode($status);
    }

    function alterar_user($connect){
        $id = $connect->real_escape_string($_POST['id']);
        $nome = $connect->real_escape_string($_POST['nome']);
        $sobre = $connect->real_escape_string($_POST['sobre']);
        $email = $connect->real_escape_string($_POST['email']);

        $sql = "UPDATE 
                    usuarios 
                SET 
                    nome_user = '$nome', 
                    sobrenome_user = '$sobre',
                    email = '$email'
                WHERE
                    id_user = $id
        ";

        if($connect->query($sql) === true){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    function alterar_senha($connect){
        $id = $connect->real_escape_string($_POST['id']);
        $senha_atual = $connect->real_escape_string($_POST['senha_atual']);
        $senha_nova = $connect->real_escape_string($_POST['senha_nova']);

        $sql = "SELECT senha FROM usuarios WHERE id_user = $id";

        $result = $connect->query($sql);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            if (password_verify($senha_atual, $row['senha'])){
                
                $senha_hash = password_hash($senha_nova, PASSWORD_DEFAULT);

                $sql = "UPDATE 
                            usuarios
                        SET
                            senha = '$senha_hash'
                        WHERE
                            id_user = $id
                ";

                if($connect->query($sql) === true){
                    echo json_encode(array('sucesso'=>'Senha alterada com secesso!'));
                }else{
                    echo json_encode(array('error'=>'Erro ao alterar a senha'));
                }

            }else{
                echo json_encode(array('error'=>'Senha atual não existente'));
            }
        }else{
            echo json_encode(array('error'=>'Nenhum peril encontrado'));
        }
    }