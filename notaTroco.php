<?     
require_once "conexao.php";


if(@$_GET['p'] == 'emitir'){

    $operador = $_GET['operador'];
    $valorTroco = $_GET['valorTroco'];

    $valorTroco = str_replace('.','',$valorTroco);
    $valorTroco = str_replace(',','.',$valorTroco);
    $valorTroco+=0;

    $codigoNota = rand()*((date("s")*date("s"))+date("s"));

    require "gerarCaixa.php";
    $caixa = retornaCaixa($_GET['operador']);

    $sqlNota = mysqli_query($conexao_bd, "INSERT INTO notapagamento 
                                        (data, codigoNota, caixaEmissao, operador, status, valor, operadorResgate, caixaResgate) VALUES 
                                        ('$dataCompleta', '$codigoNota', '$caixa', '$operador', 'Aguarda', '$valorTroco', '', '')");

        echo json_encode($codigoNota);
}


if(@$_GET['p'] == 'resgate'){

require "gerarCaixa.php";
$operador = $_GET['operador'];
$caixa = retornaCaixa($operador);
$notaResgate = $_GET['notaResgate'];

$sqlResgate = mysqli_query($conexao_bd, "SELECT * FROM notapagamento WHERE codigoNota = '$notaResgate' AND status = 'Aguarda'");
if(mysqli_num_rows($sqlResgate) <=0){
    echo "<script>alert('ERRO: O código da nota de troco está incorreto ou já foi resgatado!');</script>";
}else{
    mysqli_query($conexao_bd, "UPDATE notapagamento SET status = 'Resgatado', operadorResgate = '$operador', caixaResgate = '$caixa' WHERE codigoNota = '$notaResgate'");
    echo "<script>alert('SUCESSO: Nota de troco foi registrado com sucesso!');</script>";
}

}





if(@$_GET['p'] == 'exibirNota'){

    $nota = $_GET['nota'];
    $login = $_GET['login'];
    $valor = 0;
    $operador = 0;
      
    $sqlNota = mysqli_query($conexao_bd, "SELECT * FROM notapagamento WHERE codigoNota = '$nota'");
        while($resNota = mysqli_fetch_array($sqlNota)){
            $valor = number_format(($resNota['valor']),2,',','.');
        }
    
    $sqlOperador = mysqli_query($conexao_bd, "SELECT * FROM login WHERE login = '$login'");
        while($resOperador = mysqli_fetch_array($sqlOperador)){
            $operador = strtoupper($resOperador['nome']);
    }
        

    echo "
           <table class='table table-bordered' width='345'>                
             <tr>
             <td><strong>OPERADOR:</strong> $operador</td>
             </tr>
             <tr>
             <td><strong>VALOR DA NOTA:</strong> R$ $valor</td>
             </tr>
             <tr>
             <td><strong>CÓDIGO DA NOTA:</strong> $nota</td>
             </tr>
             <tr>
             <td align='center'><br><br><br>
             
             <em>APRESENTE ESTA NOTA PARA RESGATE DO VALOR!</em>
             <br><br>
             BOM ARRAIÁ!
             
             
             </td>
             </tr>
            </table>
        ";


}
?>