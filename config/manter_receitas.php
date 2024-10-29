<?php
    header('Content-type: application/json');

    include 'connection.php';

    global $connect;

    $form = $_POST['form'];

    switch($form){
        case 'buscar_receitas':
            buscar_receitas($connect);
            break;
        case 'detalhes_receita':
            detalhes_receita($connect);
            break;
        default:
            break;
    }

    function buscar_receitas($connect){
        $id = $connect->real_escape_string($_POST['id']);

        $sql = "SELECT * FROM receita WHERE fk_user = $id";

        $result = $connect->query($sql);

        if($result->num_rows > 0){

            $recipes = array();

            while($row = $result->fetch_assoc()){
                $recipes[] = $row;
            }

            echo json_encode($recipes);
        }else{
            echo json_encode(array('error' => 'Nenhuma receita encontrada'));
        }

        $connect->close();
    }

    function detalhes_receita($connect){
        $id = $connect->real_escape_string($_POST['id']);

        $sql = "SELECT * FROM receita WHERE id_receita = $id";

        $result = $connect->query($sql);

        if($result->num_rows > 0){

            $recipes = array();

            while($row = $result->fetch_assoc()){
                $recipes[] = $row;
            }

            echo json_encode($recipes);
        }else{
            echo json_encode(array('error' => 'Nenhuma receita encontrada'));
        }

        $connect->close();
    }
