<?
require "conexao.php";

$codProduto = $_POST['codProduto'];
$titulo = $_POST['titulo'];
$imagem = $_POST['imagem'];
$estoque = $_POST['estoque'];
$preco = $_POST['preco'];

if($preco <1000){
    $preco = str_replace(',','.',$preco);
}

$preco+=0;


$sqlVerificaProduto = mysqli_query($conexao_bd, "SELECT * FROM produtos WHERE codigo = '$codProduto'");
if(mysqli_num_rows($sqlVerificaProduto) <=0){
    
    mysqli_query($conexao_bd, "INSERT INTO produtos 
        (codigo, titulo, imagem, estoque, preco) VALUES 
        ('$codProduto', '$titulo', '$imagem', '$estoque', '$preco')");

    echo "<script>alert('Produto cadastrado com sucesso!');</script>";

}else{
    echo "<script>alert('Produto já cadastrado!');</script>";
}

?>