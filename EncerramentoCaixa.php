<?

require_once "conexao.php";
require_once "gerarCaixa.php";

$saldoEmcaixa = $_GET['saldoEmCaixa'];
$login = $_GET['login'];

$saldoEmcaixa = str_replace('.','',$saldoEmcaixa);
$saldoEmcaixa = str_replace(',','.',$saldoEmcaixa);


$saldoEmcaixa+=0;

$codeCaixa = retornaCaixa($login);

$sqlAtualizaCaixa = mysqli_query($conexao_bd, "UPDATE caixa SET saldoFinal = '$saldoEmcaixa' WHERE codeCaixa = '$codeCaixa'");


?>