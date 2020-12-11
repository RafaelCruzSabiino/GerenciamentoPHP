<?php

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$nome_produto = $_POST['nome_produto'];
$Id_produto = $_POST['Id_produto'];

if($ocorrencia == 0 || $ocorrencia == 1){

if($ocorrencia == 1){
    $selectProduto = "SELECT Id_produto, nome_produto FROM produtos WHERE Id_produto =".$Id_produto;
}else{
    $selectProduto = "SELECT Id_produto, nome_produto FROM produtos WHERE nome_produto LIKE '%".$nome_produto."%'";
}
    $resultSelectProduto = $mysqli->query($selectProduto) or die(mysqli_error());
    $arrayproduto = $resultSelectProduto->fetch_array();
?>

<input type="hidden" name="" id="Id_produto10" class="form-control" value="<?= $arrayproduto['Id_produto'] ?>">
<input type="hidden" name="" id="nome_produto10" class="form-control" value="<?= $arrayproduto['nome_produto'] ?>">

<?php
}
?>
