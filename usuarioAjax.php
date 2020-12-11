<?php

session_start();

include 'config.php';

$ocorrencia = $_POST['ocorrencia'];
$Id_vendedor = $_POST['Id_vendedor'];
$nome_usuario = $_POST['nome_usuario'];
$email_usuario = $_POST['email_usuario'];
$senha_usuario = $_POST['senha_usuario'];
$tema_usuario = $_POST['tema_usuario'];

if($ocorrencia == 0){
    $criptografia = md5($senha_usuario);
    $inserirUsuario = "INSERT INTO vendedor SET
            nome_vendedor = '".$nome_usuario."',
            status_vendedor = 'ativo',
            email_usuario = '".$email_usuario."',
            senha_usuario = '".$senha_usuario."',
            criptografia_usuario = '".$criptografia."' ";
    $resultInserirUsuario = $mysqli->query($inserirUsuario) or die(mysqli_error());

    if($resultInserirUsuario){
        echo 1;
    }else{
        echo $resultInserirUsuario;
    }
}else if($ocorrencia == 2){

    $criptografia = md5($senha_usuario);
    $alterarUser = "UPDATE vendedor SET
            nome_vendedor = '".$nome_usuario."',
            senha_usuario = '".$senha_usuario."',
            criptografia_usuario = '".$criptografia."',
            tema_usuario = '".$tema_usuario."' WHERE Id_vendedor =".$Id_vendedor;
    $resultAlteraUser = $mysqli->query($alterarUser) or die(mysqli_error());
    $_SESSION['nome_vendedor'] = $nome_usuario;
    $_SESSION['senha_usuario'] = $senha_usuario;
    $_SESSION['email_usuario'] = $email_usuario;
    $_SESSION['tema_usuario'] = $tema_usuario;

    if($resultAlteraUser){
        echo 1;
    }else{
        echo $resultAlteraUser;
    }

}
?>
