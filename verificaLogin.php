<?php

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    require "conexao.php";

    $sqlLogin = mysqli_query($conexao_bd, "SELECT * FROM login WHERE login = '$login' AND senha = '$senha'");
    if(mysqli_num_rows($sqlLogin) <= 0){
        $response = false;
    }else{
        $response = true;
    }


    echo json_encode($response);

?>