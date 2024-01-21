<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t�tulo</title>
</head>

<body>
<?
require "conexao.php";

	if(@$_GET['acao'] == 'consultar'){
		$codigo = $_GET['codigo'];
		$titulo = $_GET['titulo'];

		$verificaProduto = mysqli_query($conexao_bd, "SELECT * FROM produtos WHERE codigo = '$codigo'");
	
	}
	
		if(@$_GET['acao'] == 'cadastrar'){
			
		$codProduto = $_POST['codProduto'];
		$titulo = $_POST['titulo'];
		$imagem = $_POST['imagem'];
		$estoque = $_POST['estoque'];
		$preco = $_POST['preco'];

		$verificaProduto = mysqli_query($conexao_bd, "INSERT INTO produtos (codigo, titulo, imagem, estoque, preco) VALUES ('$codProduto', '$titulo', '$imagem', '$estoque', '$preco')");
	
	}
	
?>	
</body>
</html>