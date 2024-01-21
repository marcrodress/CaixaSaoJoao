<?

require_once "conexao.php";
require_once "gerarCaixa.php";

$valor = $_GET['valor'];
$login = $_GET['login'];

$valor = str_replace('.', '',$valor);
$valor = str_replace(',', '.',$valor);

$codeCaixa = retornaCaixa($login);

$sqlCaixa = mysqli_query($conexao_bd, "SELECT * FROM caixa WHERE codeCaixa = '$codeCaixa' AND operador = '$login'");
if(mysqli_num_rows($sqlCaixa) <=0){
    
    mysqli_query($conexao_bd, "INSERT INTO caixa (status, operador, codeCaixa, saldoInicial, saldoFinal) VALUES ('Aberto', '$login', '$codeCaixa', '$valor', '')");
    
}

echo json_encode("ok");

?>