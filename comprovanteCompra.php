<?

    require_once "conexao.php";
    require_once "gerarCarrinho.php";

    $codeCarrinho = geraCarrinho();

    $total = 0;
    $pago = 0;
    $troco = 0;

    $sqlProdutosCarrinho = mysqli_query($conexao_bd, "SELECT * FROM produtoscarrinho WHERE codeCarrinho = '$codeCarrinho'");
    if(mysqli_num_rows($sqlProdutosCarrinho) <=0){
        echo "<script>window.alert('Não existe produtos adicionados para finalizar!');window.close();</script>";
    }else{

        $sqlVerificaCarrinho = mysqli_query($conexao_bd, "SELECT * FROM carrinho WHERE code = '$codeCarrinho'");
            while($resVerificaCarrinho = mysqli_fetch_array($sqlVerificaCarrinho)){
               
                $total = $resVerificaCarrinho['total'];
                $pago = $resVerificaCarrinho['pago'];
                $troco = $resVerificaCarrinho['troco'];
            }

            if($total>$pago){

                echo "<script>window.alert('A compra ainda não paga totalmente, efetue o pagamneto!');window.close();</script>";

            }else{

              require "gerarCaixa.php";
              $login = $_GET['login'];
              $caixa = retornaCaixa($login);
               
              mysqli_query($conexao_bd, "UPDATE carrinho SET status = 'Fechado', caixa = '$caixa' WHERE code = '$codeCarrinho'");
              mysqli_query($conexao_bd, "UPDATE pagamentoscarrinho SET caixa = '$caixa' WHERE codeCarrinho = '$codeCarrinho'");
              mysqli_query($conexao_bd, "UPDATE produtoscarrinho SET caixa = '$caixa' WHERE codeCarrinho = '$codeCarrinho'");

                    $total = number_format($total,2,',','.');
                    $pago = number_format($pago,2,',','.');
                    $troco = number_format($troco,2,',','.');

                        echo "
                        <table class='table table-bordered' width='386' border='2'>
                            <tr>
                              <th width='66' bgcolor='#999999' scope='col'>QUANT.</th>
                              <th width='233' bgcolor='#999999' scope='col'>DESCRIÇÃO</th>
                              <th width='65' bgcolor='#999999' scope='col'>VALOR</th>
                            </tr>
                        ";

                        while($resProdutosCarrinho = mysqli_fetch_array($sqlProdutosCarrinho)){

                            $produto = $resProdutosCarrinho['produto'];
                            $quantidade = strtoupper($resProdutosCarrinho['quantidade']);
                            $valorUnitario = number_format($resProdutosCarrinho['valorUnitario'],2,',','.');
                            $valorTotal = number_format($resProdutosCarrinho['valorTotal'],2,',','.');
                            
                            $sqlProduto = mysqli_query($conexao_bd, "SELECT * FROM produtos WHERE codigo = '$produto'");
                                while($resProduto = mysqli_fetch_array($sqlProduto)){
                                    $titulo = strtoupper($resProduto['titulo']);
                                }
                        echo "
                            <tr>
                              <td align='center'>$quantidade</td>
                              <td>$titulo - R$ $valorUnitario</td>
                              <td align='center'>R$ $valorTotal</td>
                            </tr>
                            ";
                        }
                        echo "
                            <tr>
                              <td height='30' align='center' colspan='3'><strong>VALOR TOTAL: </strong>R$ $total</td>
                            </tr>
                            <tr>
                              <td colspan='2' bgcolor='#999999'><strong>FORMA DE PAGAMENTO</strong></td>
                              <td bgcolor='#999999'><strong>VALOR</strong></td>
                            </tr>
                       ";
                        
                        $sqlPagamentos = mysqli_query($conexao_bd, "SELECT * FROM pagamentoscarrinho WHERE codeCarrinho = '$codeCarrinho'");
                        while($resPagamentos = mysqli_fetch_array($sqlPagamentos)){
                            $formaPagamento = $resPagamentos['formaPagamento'];
                            $valorPago = number_format($resPagamentos['valorPago'],2,',','.');
                        
                        echo "
                            <tr>
                              <td colspan='2'>$formaPagamento</td>
                              <td>R$ $valorPago</td>
                            </tr>
                        ";
                        }
                        
                        echo "
                            <tr>
                              <td colspan='3' align='center'><strong>TROCO:</strong> R$ $troco</td>
                            </tr>
                            <tr>
                              <td colspan='3' align='center'><strong>

                                BOM ARRAIÁ!

                              <br>OBRIGADO E VOLTE SEMPRE!</strong></td>
                            </tr>
                        </table> 
                
                ";


                

            }





    }



    

?>