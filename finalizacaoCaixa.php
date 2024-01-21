<link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<? if(@$_GET['p'] == 'detalhesTotal'){

require_once "conexao.php";
require_once "gerarCaixa.php";

$login = $_GET['login'];
$codeCaixa = retornaCaixa($login);

$operador = 0;
$sqlOperador = mysqli_query($conexao_bd, "SELECT * FROM login WHERE login = '$login'");
  while($res = mysqli_fetch_array($sqlOperador)){
      $operador = strtoupper($res['nome']);
  }


  $saldoInicial = 0;
  $saldoFinal = 0;
  $informacaoFinal = 0;

  $sqlCaixa = mysqli_query($conexao_bd, "SELECT * FROM caixa WHERE operador = '$login' AND codeCaixa = '$codeCaixa'");
  while($resCaixa = mysqli_fetch_array($sqlCaixa)){
    $saldoInicial = $resCaixa['saldoInicial'];
    $saldoFinal = $resCaixa['saldoFinal'];
  }

    $sangria = 0;

 $sqlSangria = mysqli_query($conexao_bd, "SELECT * FROM sangria WHERE operador = '$login' AND caixa = '$codeCaixa'");
  while($resSangria = mysqli_fetch_array($sqlSangria)){
    $sangria +=$resSangria['valor'];
  }

  

echo "

<table class='table table-bordered'>
    <tr>
      <td colspan='4' align='center' bgcolor='#FFFFFF'>
      <h4>E.E.F. DEPUTADO LEORNE BELÉM</h4>
      <h5>RELATÓRIO FINAL DE CAIXA</h5>
      <h6>".date("d/m/Y H:i:s")."</h6>
      
      
      
      </td>
    </tr>
    <tr>
      <td colspan='3' align='center' bgcolor='#FFFFFF'><strong>OPERADOR: </strong>$operador</td>
    </tr>
    <tr>
      <td colspan='3' align='center' bgcolor='#CCCCCC'><strong>CAIXA INICIAL INFORMADO: </strong>R$ ".number_format($saldoInicial,2,',','.')."</td>
    </tr>
    <tr>
      <th width='55' bgcolor='#CCCCCC' scope='col'>QUANT.</th>
      <th width='221' bgcolor='#CCCCCC' scope='col'>PRODUTO/SERVIÇO</th>
      <th width='94' bgcolor='#CCCCCC' scope='col'>VALOR</th>
    </tr>

";

$faturamento = 0;

$sqldetalhesTotal = mysqli_query($conexao_bd, "SELECT * FROM produtos");
    while($resTotal = mysqli_fetch_array($sqldetalhesTotal)){
        $produto = $resTotal['codigo'];
        $titulo = strtoupper($resTotal['titulo']);

        $quantidadeVentidade = 0;
        $valorTotalVendido = 0;
        
        $sqlProdutosCarrinho = mysqli_query($conexao_bd, "SELECT * FROM produtoscarrinho WHERE produto = '$produto' AND caixa = '$codeCaixa'");
            while($resProdutoCarrinho = mysqli_fetch_array($sqlProdutosCarrinho)){
                $quantidadeVentidade+=$resProdutoCarrinho['quantidade'];
                $valorTotalVendido+=$resProdutoCarrinho['valorTotal'];
            }

            $faturamento += $valorTotalVendido;
            $valorTotalVendido = number_format($valorTotalVendido,2,',','.');
            $faturamento = number_format($faturamento,2,',','.');

            echo "    
            <tr>
            <td>$quantidadeVentidade</td>
            <td>$titulo</td>
            <td>R$ $valorTotalVendido</td>
            </tr>
              
        ";

    }


    $notasemitidas = 0;
    $notasresgatada = 0;

    $sqlEmitidas = mysqli_query($conexao_bd, "SELECT * FROM notapagamento WHERE caixaEmissao = '$codeCaixa' AND status = 'Aguarda'");
      while($resEmitidas = mysqli_fetch_array($sqlEmitidas)){
          $notasemitidas +=$resEmitidas['valor'];
      }

    $sqlResgatadas = mysqli_query($conexao_bd, "SELECT * FROM notapagamento WHERE caixaResgate = '$codeCaixa' AND status = 'Resgatado'");
      while($Resgatadas = mysqli_fetch_array($sqlResgatadas)){
          $notasresgatada +=$resEmitidas['valor'];
      }


    
    $dinheiro = 0;
    $credito = 0;
    $debito = 0;
    $pix = 0;
    $interno = 0;
    $outros = 0;

    $sqlPagqmentos = mysqli_query($conexao_bd, "SELECT * FROM pagamentoscarrinho WHERE caixa = '$codeCaixa'");
        while($resPagamentos = mysqli_fetch_array($sqlPagqmentos)){
            if($resPagamentos['formaPagamento'] == 'DINHEIRO'){
                $dinheiro +=$resPagamentos['valorPago'];
            }elseif($resPagamentos['formaPagamento'] == 'CREDITO'){
                $credito +=$resPagamentos['valorPago'];
            }elseif($resPagamentos['formaPagamento'] == 'DEBITO'){
                $debito +=$resPagamentos['valorPago'];
            }elseif($resPagamentos['formaPagamento'] == 'PIX'){
                $pix +=$resPagamentos['valorPago'];
            }elseif($resPagamentos['formaPagamento'] == 'INTERNO'){
                $interno +=$resPagamentos['valorPago'];
            }elseif($resPagamentos['formaPagamento'] == 'OUTROS'){
                $outros +=$resPagamentos['valorPago'];
            }
        }
    
    $troco = 0;
    $sqltroco = mysqli_query($conexao_bd, "SELECT * FROM carrinho WHERE caixa = '$codeCaixa'");
        while($resTroco = mysqli_fetch_array($sqltroco)){
          $troco+=$resTroco['troco'];
        }
        $dinheiro -= $troco;

        
        $valorSangria = number_format($sangria,2,',','.');
        $saldoFinalCaixaDinheiroAtualiza = (($saldoInicial+$dinheiro+$notasemitidas)-($sangria+$notasresgatada+$saldoFinal));
        $saldoFinalCaixaDinheiro = number_format($saldoFinalCaixaDinheiroAtualiza,2,',','.');
        

        $dinheiro = number_format($dinheiro,2,',','.');
        $credito = number_format($credito,2,',','.');
        $debito = number_format($debito,2,',','.');
        $pix = number_format($pix,2,',','.');
        $interno = number_format($interno,2,',','.');
        $outros = number_format($outros,2,',','.');

echo "

<tr>
            <td align='center' colspan='3'><strong>FATURAMENTO:</strong> R$ $faturamento<hr></td>
            </tr>  
<tr>
      <td colspan='2' bgcolor='#999999'><strong>FORMA DE PAGAMENTO</strong></td>
      <td bgcolor='#999999'><strong>VALOR</strong></td>
    </tr>
    <tr>
      <td colspan='2'>DINHEIRO</td>
      <td>R$ $dinheiro</td>
    </tr>
    <tr>
      <td colspan='2'>CARTÃO DE CRÉDITO</td>
      <td>R$ $credito</td>
    </tr>
    <tr>
      <td colspan='2'>CARTÃO DE DÉBITO</td>
      <td>R$ $debito</td>
    </tr>
    <tr>
      <td colspan='2'>PIX/TRANSFERÊNCIA</td>
      <td>R$ $pix</td>
    </tr>
    <tr>
      <td colspan='2'>INTERNO</td>
      <td>R$ $interno</td>
    </tr>
    <tr>
      <td colspan='2'>OUTROS</td>
      <td>R$ $outros</td>
    </tr>
    <tr>
      <td colspan='3' align='center' bgcolor='#CCCCCC'><strong>SANGRIA REALIZADA: </strong>R$ $valorSangria</td>
    </tr>
    <tr>
      <td colspan='3' align='center'><strong>CAIXA FINAL INFORMADO: </strong>R$ ".number_format($saldoFinal,2,',','.')."</td>
    </tr>
    <tr>
      <td colspan='3' align='center'><strong>NOTAS DE TROCO EMITIDA: </strong>R$ ".number_format($notasemitidas,2,',','.')."</td>
    </tr>
    <tr>
      <td colspan='3' align='center'><strong>NOTAS DE TROCO RESGATADA: </strong>R$ ".number_format($notasresgatada,2,',','.')."</td>
    </tr>
    <tr>
      <td colspan='3' align='center' bgcolor='#CCCCCC'><strong>SALDO FINAL: </strong>R$ $saldoFinalCaixaDinheiro</td>
    </tr>
</table>    
";

//mysqli_query($conexao_bd, "UPDATE caixa SET status = 'Fechado', saldoFinal = '$saldoFinalCaixaDinheiroAtualiza' WHERE codeCaixa = '$codeCaixa'");

}?>