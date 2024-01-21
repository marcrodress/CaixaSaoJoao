<?
require_once "conexao.php";
require_once "gerarCarrinho.php";

$codeCarrinho = geraCarrinho();

$sqlcarrinho = mysqli_query($conexao_bd, "SELECT * FROM carrinho WHERE code = '$codeCarrinho'");

    while($resCarrinho = mysqli_fetch_array($sqlcarrinho)){

        $total = $resCarrinho['total'];
        $pago = $resCarrinho['pago'];
        $aPagar = $resCarrinho['aPagar'];
        $troco = $resCarrinho['troco'];
    }

    $pagamentosEfetuados = 0;
    $sqlPagamentos = mysqli_query($conexao_bd, "SELECT * FROM pagamentoscarrinho WHERE codeCarrinho = '$codeCarrinho'");
        while($resPagamentos = mysqli_fetch_array($sqlPagamentos)){
            $pagamentosEfetuados +=$resPagamentos['valorPago'];
        }

        $pago = $pagamentosEfetuados;
        $aPagar = ($total - $pagamentosEfetuados);

        if($aPagar<=0){
            $aPagar = 0;
        }

        if($pagamentosEfetuados > ($total)){
            $troco = ($pagamentosEfetuados-$total);
        }else{
            $troco = 0;
        }

        mysqli_query($conexao_bd, "UPDATE carrinho SET pago = '$pagamentosEfetuados', aPagar = ' $aPagar', troco = '$troco' WHERE code = '$codeCarrinho'");

        $total = @number_format( $total,2,',','.');
        $pago = @number_format($pago,2,',','.');
        $aPagar = @number_format($aPagar,2,',','.');
        $troco = @number_format($troco,2,',','.');

        echo "

        <div class='row mt-3'>
        <div class='col d-flex justify-content-center;'>
            <h1 style='color:red; font-size:35px; font-weight: bold;'>TOTAL: R$ $total</h1>
        </div>
        </div>

        <div class='row mt-3 d-flex justify-content-center'>
        <h6 style='color:green; font-weight:bold;'>PAGO: R$ $pago | A PAGAR: R$ $aPagar</h6>
        </div>

        <div class='row mt-3 d-flex justify-content-center'>
        <h2 style='color:blue; font-weight: bold;'>TROCO: R$ $troco</h2>
        </div>

        ";

    


?>