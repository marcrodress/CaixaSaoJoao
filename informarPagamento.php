<?

require_once "conexao.php";
require_once "gerarCarrinho.php";


if(@$_GET['p'] == 'situacaoCarrinho'){

$codeCarrinho = geraCarrinho();

$situacaoCarrinho = [];
$total = 0;
$pago = 0;
$aPagar = 0;
$troco = 0;

$sqlCarrinho = mysqli_query($conexao_bd, "SELECT * FROM carrinho WHERE code = '$codeCarrinho'");
    while($resSomaCompras = mysqli_fetch_array($sqlCarrinho)){
        $situacaoCarrinho = array(
            'total' => $resSomaCompras['total'],
            'pago' => $resSomaCompras['pago'],
            'aPagar' => $resSomaCompras['aPagar'],
            'troco' => $resSomaCompras['troco']
        );
    }

    echo json_encode($situacaoCarrinho);

}











if(@$_GET['p'] == 'informarPagamento'){

$opcaoSelecionada = $_POST['opcaoSelecionada'];
$saldo = $_POST['saldo'];

$saldo = str_replace('.','',$saldo);
$saldo = str_replace(',','.',$saldo);


$saldo +=0;

$codeCarrinho = geraCarrinho();

$sqlPagamento = mysqli_query($conexao_bd, "INSERT INTO pagamentoscarrinho 
                            (codeCarrinho, formaPagamento, valorPago) VALUES 
                            ('$codeCarrinho', '$opcaoSelecionada', '$saldo')");

                        
}


?>