<?
    require "conexao.php";
    include_once "gerarCarrinho.php";

    if(@$_GET['acao'] == 'adicionarAoCarinnho'){
        
        $codProduto = $_GET['codProduto'];
        $quantidade = $_GET['quantidade'];

        $total = 0;

        $sqlBuscaProduto = mysqli_query($conexao_bd, "SELECT * FROM produtos WHERE codigo = '$codProduto'");
        if(mysqli_num_rows($sqlBuscaProduto) <=0){
            echo "<script>alert('Produto não encontrado!');</script>";
        }else{

            $codeCarrinho = geraCarrinho();

            while($resProduto = mysqli_fetch_array($sqlBuscaProduto)){
                $valorUnitario = $resProduto['preco'];
            }

            $sqlBuscarCarrinho = mysqli_query($conexao_bd, "SELECT * FROM produtoscarrinho WHERE codeCarrinho = '$codeCarrinho' AND produto = '$codProduto'");
            if(mysqli_num_rows($sqlBuscarCarrinho) <= 0){
                
                mysqli_query($conexao_bd, "INSERT INTO produtoscarrinho (codeCarrinho, produto, quantidade, valorUnitario, valorTotal) VALUES 
                ('$codeCarrinho', '$codProduto', '$quantidade', '$valorUnitario', '".($valorUnitario*$quantidade)."')");

                    $total += ($valorUnitario*$quantidade);
                
            }else{
                while($resProdutosCarrinho = mysqli_fetch_array($sqlBuscarCarrinho)){
                    
                    $quantidade += $resProdutosCarrinho['quantidade'];

                    if($_GET['quantidade'] <=0){
                        mysqli_query($conexao_bd, "DELETE FROM produtoscarrinho WHERE codeCarrinho = '$codeCarrinho' AND produto = '$codProduto'");
                    }
                    
                    mysqli_query($conexao_bd, "UPDATE produtoscarrinho SET quantidade = '$quantidade', valorUnitario = '$valorUnitario', valorTotal = '".($valorUnitario*$quantidade)."' WHERE codeCarrinho = '$codeCarrinho' AND produto = '$codProduto'");
                    
                    $total += ($valorUnitario*$quantidade);

                }
            }

            $valorTotal = 0;
            $sqlSomaCarrinho = mysqli_query($conexao_bd, "SELECT * FROM produtoscarrinho WHERE codeCarrinho = '$codeCarrinho'");
             while($resSomaCarrinho = mysqli_fetch_array($sqlSomaCarrinho)){
                $valorTotal +=$resSomaCarrinho['valorTotal'];
             }

            
            mysqli_query($conexao_bd, "UPDATE carrinho SET total = '$valorTotal' WHERE code = '$codeCarrinho'");
            echo "<script>window.location='';</script>";
        }

    }

?>