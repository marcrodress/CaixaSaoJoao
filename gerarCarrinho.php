<?php
function geraCarrinho(){

    require "conexao.php";

    $sqlBuscaCarrinho = mysqli_query($conexao_bd, "SELECT * FROM carrinho WHERE status = 'Aberto'");
    if(mysqli_num_rows($sqlBuscaCarrinho) <=0){

        $codeCarrinho = rand()*5+(522*date("s"));

        mysqli_query($conexao_bd, "INSERT INTO carrinho 
        (status, caixa, code, total, pago, aPagar, troco, data, dataCompleta) VALUES 
        ('Aberto', '', '$codeCarrinho', '', '', '', '', '$data', '$dataCompleta')");

        return $codeCarrinho;

    }else{

        while($res = mysqli_fetch_array($sqlBuscaCarrinho)){

            return $res['code'];

        }


    }



}

?>