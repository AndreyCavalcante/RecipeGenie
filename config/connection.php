<?php

    $server = 'localhost';
    $user = 'root';
    $senha = '';
    $db_name = 'recipe_genie';

    $connect = new mysqli($server, $user, $senha, $db_name);

    if ($connect->connect_error){
        Die('Deu ruim malandro');
    }