<?

 require "conexao.php";
 $saldoEmcaixa = $_POST['saldoEmcaixa'];

 $sqlAtualizaCaixa = mysqli_query($conexao_bd, "UPDATE caixa SET saldoFinal = '$saldoEmcaixa'");


?>