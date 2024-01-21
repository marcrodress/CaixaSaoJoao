<?

    require_once "conexao.php";
    require_once "gerarCarrinho.php";

    $sangria = $_GET['sangria'];
    $login = $_GET['login'];
   
        $sqlSangria = mysqli_query($conexao_bd, "SELECT * FROM sangria WHERE codeSangria = '$sangria'");
            while($resSangria = mysqli_fetch_array($sqlSangria)){
               
                $valor = number_format($resSangria['valor'],2,',','.');
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
                            <td><strong>VALOR DA SANGRIA:</strong> R$ $valor</td>
                            </tr>
                            <tr>
                            <td><strong>CÓDIGO DA SANGRIA:</strong> $sangria</td>
                            </tr>
                            <tr>
                            <td align='center'><br><br><br>
                            <p>__________________________________<br>
                            <em>Assinatura do responsável</em></td>
                            </tr>
                        </table>
                        ";

                       

                

            





    



    

?>