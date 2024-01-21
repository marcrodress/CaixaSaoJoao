<?

require_once "conexao.php";

$operador = $_GET['login'];

$sqlCaixa = mysqli_query($conexao_bd, "SELECT * FROM caixa WHERE status = 'Aberto' AND operador = '$operador'");
if(mysqli_num_rows($sqlCaixa) <=0){
    echo json_encode("Erro");
}else{
    echo json_encode("Sucesso");
}

?>