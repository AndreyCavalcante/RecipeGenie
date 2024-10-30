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
        case 'buscar_por_filtro':
            buscar_por_filtro($connect);
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

    function buscar_por_filtro($connect){
        $id = $connect->real_escape_string($_POST['id']);
        $filtro = $connect->real_escape_string($_POST['filtro']);
        $valor = $connect->real_escape_string($_POST['pesq']);

        $sql = "SELECT * FROM receita WHERE fk_user = $id ";

        if($filtro == "categoria"){

            if($valor != "todas"){
                $sql .= "AND JSON_UNQUOTE(JSON_EXTRACT(receita, '$.categoria')) = '$valor'";
            }

        } else if($filtro == "avaliacao"){

            if ($valor == "maior"){
                $sql .= "ORDER BY avaliacao DESC";
            }else{
                $sql .= "ORDER BY avaliacao ASC";
            }

        }else if($filtro == "tempo"){

            if($valor == 1){
                $sql .= "AND JSON_UNQUOTE(JSON_EXTRACT(receita, '$.tempo_de_preparo')) <= 15";
            } else if($valor == 2){
                $sql .= "AND JSON_UNQUOTE(JSON_EXTRACT(receita, '$.tempo_de_preparo')) BETWEEN 15 AND 30";
            }else if($valor == 3){
                $sql .= "AND JSON_UNQUOTE(JSON_EXTRACT(receita, '$.tempo_de_preparo')) >= 30";
            }
        }else if($filtro == "pesquisa"){
            $sql .= "AND JSON_UNQUOTE(JSON_EXTRACT(receita, '$.nome')) LIKE '%$valor%'"; 
        }

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