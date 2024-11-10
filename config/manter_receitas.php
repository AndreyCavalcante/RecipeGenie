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
        case "delete_receita":
            delete_receita($connect);
            break;
        case "salvar_receita":
            salvar_receita($connect);
            break;
        case 'edit_avaliacao':
            editar_avaliacao($connect);
            break;
        case 'count_receitas';
            count_receitas($connect);
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

    function delete_receita($connect){
        $id = $connect->real_escape_string($_POST['id']);

        $sql = "DELETE FROM receita WHERE id_receita = $id";

        if($connect->query($sql) === true){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
        
    }

    function salvar_receita($connect){
        $id = $connect->real_escape_string($_POST['id']);
        
        if (is_array($_POST['receita'])) {
            $receita = json_encode($_POST['receita'], JSON_UNESCAPED_UNICODE);
        } else {
            $receita = $_POST['receita'];
        }

        $sql = "INSERT INTO receita (receita, avaliacao, fk_user) VALUES ('$receita', 0, $id)";

        if($connect->query($sql) === true){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    function editar_avaliacao($connect){
        $id_receita = $_POST['id_receita'];
        $avaliacao = $_POST['avaliacao'];

        $sql = "UPDATE receita SET avaliacao = $avaliacao WHERE id_receita = $id_receita";

        if ($connect->query($sql) === true){
            echo json_encode(value: true);
        }else{
            echo json_encode(false);
        }
    }

    function count_receitas($connect){
        $id = $_POST['id'];

        $sql = "
            SELECT
                SUM(JSON_CONTAINS(JSON_EXTRACT(receita, '$.categoria'), '\"doce\"')) AS doces,
                SUM(JSON_CONTAINS(JSON_EXTRACT(receita, '$.categoria'), '\"salgado\"')) AS salgadas,
                SUM(JSON_CONTAINS(JSON_EXTRACT(receita, '$.categoria'), '\"fitness\"')) AS fitness,
                count(receita) AS total
            FROM
                receita
            WHERE
                fk_user = $id;
        ";

        $result = $connect->query($sql);

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();

            echo json_encode($row);
        }else{
            echo json_encode(array('error'=>'Nenhuma receita registrada'));
        }
    }