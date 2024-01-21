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


        $data = [
            'total' => $total,
            'pago' => $pago,
            'aPagar' => $aPagar,
            'troco' => $troco
        ];
    
        $json = json_encode($data);

        echo $json;




?>