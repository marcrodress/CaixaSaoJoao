<?
require_once "conexao.php";
require_once "gerarCaixa.php";

$valorSangria = $_GET['valorSangria'];
$login = $_GET['login'];

$valorSangria = str_replace('.','', $valorSangria);
$valorSangria = str_replace(',','.', $valorSangria);

$valorSangria +=0;


$codeCaixa = retornaCaixa($login);

$codeSangria = rand()*(date("s")*date("s")+date("d"));

$sqlSangria = mysqli_query($conexao_bd, "INSERT INTO sangria 
                            (codeSangria, caixa, operador, data, valor) VALUES 
                            ('$codeSangria', '$codeCaixa', '$login', '$dataCompleta', '$valorSangria')");
echo json_encode($codeSangria)
?>