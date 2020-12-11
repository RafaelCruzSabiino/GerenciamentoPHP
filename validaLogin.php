<?php

session_start();

include 'config.php';

if((isset($_POST['email_usuario'])) && (isset($_POST['senha_usuario']))){

    $email = addslashes($_POST['email_usuario']);
    $senha = addslashes($_POST['senha_usuario']);
    $criptografia = md5($senha);

    $buscarUsuario = "SELECT Id_vendedor, nome_vendedor, email_usuario, senha_usuario, criptografia_usuario, tema_usuario FROM vendedor WHERE email_usuario ='".$email."' AND criptografia_usuario ='".$criptografia."' ";
    $resultBuscarUsuario = $mysqli->query($buscarUsuario) or die(mysqli_error());
    $arrayUsuario = $resultBuscarUsuario->fetch_assoc();

    if(isset($arrayUsuario)){
        $_SESSION['Id_vendedor'] = $arrayUsuario['Id_vendedor'];
        $_SESSION['nome_vendedor'] = $arrayUsuario['nome_vendedor'];
        $_SESSION['email_usuario'] = $arrayUsuario['email_usuario'];
        $_SESSION['senha_usuario'] = $arrayUsuario['senha_usuario'];
        $_SESSION['tema_usuario'] = $arrayUsuario['tema_usuario'];
        header("Location: index.php");
    }else{
        $_SESSION['loginErro'] = "Usuário ou senha Inválido";
        header("Location: login.php");
    }

}else{
    $_SESSION['loginErro'] = "Usuário ou senha inválido";
    header("Location: login.php");
}



?>