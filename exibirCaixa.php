<?

    require_once "conexao.php";
    require_once "gerarCarrinho.php";

    $codeCarrinho = geraCarrinho();

    $produtosCarrinho = array();

    $sqlListaCarrrinho = mysqli_query($conexao_bd, "SELECT * FROM produtoscarrinho WHERE codeCarrinho = '$codeCarrinho'");
    if(mysqli_num_rows($sqlListaCarrrinho) <= 0){
        return 0;
    }else{
        while($res_carrinho = mysqli_fetch_array($sqlListaCarrrinho)){

            $produto = $res_carrinho['produto'];
            $quantidade = $res_carrinho['quantidade'];
            $valorUnitario = number_format($res_carrinho['valorUnitario'],2,',','.');
            $valorTotal = number_format($res_carrinho['valorTotal'],2,',','.');

                $sqlProduto = mysqli_query($conexao_bd, "SELECT * FROM produtos WHERE codigo = '$produto'");
                while($resProduto = mysqli_fetch_array($sqlProduto)){
                    
                    $imagem = $resProduto['imagem'];
                    $titulo = $resProduto['titulo'];

                }

            array_push($produtosCarrinho, array(

                'imagem' => $imagem,
                'titulo' => $titulo,
                'valorUnitario' => $valorUnitario,
                'quantidade' => $quantidade,
                'valorTotal' => $valorTotal

            ));


            echo "
                <div class='row mt-2 mb-1'>
                    <div class='col-1'>
                        <img src='$imagem' style='border-radius:20px;' width='70' height='70'>
                    </div>
                    <div class='col'>
                        <div class='row'>
                            <h5 style='margin-left: 20px;'>COD. $produto: $titulo</h5>
                        </div>
                        <div style='margin-top: -8px; margin-left: 10px;' class='row'>
                            <h6 style='font-size: 12px;'>VALOR UNITÁRIO: R$ $valorUnitario</h6>
                        </div>
                        <div style='margin-top: -10px; margin-left: 10px;' class='row'>
                            <h6 style='font-size: 12px;'>QUANT.: $quantidade | VALOR TOTAL: R$ $valorTotal</h6>
                        </div>
                    </div>
                </div>
                ";

        }



        

    }


   


?>