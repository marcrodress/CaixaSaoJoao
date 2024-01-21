<?

function retornaCaixa($login){
    
    include "conexao.php";
    
    $sqlCaixa = mysqli_query($conexao_bd, "SELECT * FROM caixa WHERE status = 'Aberto' AND operador = '$login'");
    if(mysqli_num_rows($sqlCaixa) <=0){
        
        $codeCaixa = rand()*5+(522*date("s"));

        return $codeCaixa;

    }else{
        while($resCaixa = mysqli_fetch_array($sqlCaixa)){
            return $resCaixa['codeCaixa'];
        }
    }

}

?>