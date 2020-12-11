<?php
 
include 'topo.php';

?>
<h1 class="text-center">Aréa Usuario</h1>
<br>
<div class="container" id="info">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-2" style="padding-top: 70px;">
            <div class="team-member">
                <img class="mx-auto rounded-circle" src="assets/img/default-avatar.png" alt="">
            </div>
        </div> 
        <div class="col-sm-1"></div>
        <div class="col-sm-3"  style="padding-top: 35px;">
            <label>Nome:</label>                
            <input type="text" name="" id="nome" class="form-control" value="<?= $_SESSION['nome_vendedor'] ?>" readonly>     
            <br>       
            <label>E-mail</label>
            <input type="text" name="" id="email" class="form-control" value="<?= $_SESSION['email_usuario'] ?>" readonly>
            <br>       
            <label>Senha Usuario</label>
            <input type="password" name="" id="senha" class="form-control" value="<?= $_SESSION['senha_usuario'] ?>" readonly>
        </div>
        <div class="col-sm-3" style="display: none; padding-top: 35px;" id="temas">  
             <label>Tema</label>           
             <select name="" id="tema" class="form-control">
                 <option value="#">Selecione</option>
                 <option value="blue">Azul</option>
                 <option value="red">Vermelho</option>
                 <option value="purple">Roxo</option>
                 <option value="black">Dark</option>
                 <option value="orange">Laranja</option>
                 <option value="green">Verde</option>
             </select>             
        </div>
    </div> 
    <br>
    <br>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-2">            
            <a data-toggle="modal" href='#cadastrarUser'><button type="button" class="btn btn-danger">+</button></a>          
        </div>
        <div class="col-sm-2" id="bottun1">
            <button type="button" class="btn btn-primary" onclick="usuario(1, <?= $_SESSION['Id_vendedor'] ?>)">Alterar</button>
        </div>
        <div class="col-sm-2" id="bottun2" style="display: none;">
            <button type="button" class="btn btn-danger" onclick="usuario(2, <?= $_SESSION['Id_vendedor'] ?>)">Alterar</button>
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>


<div class="modal fade" id="cadastrarUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title">Cadastrar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container">
                   <div class="row">
                       <div class="col-sm-1"></div>
                       <div class="col-sm-5">
                            <label>Nome:</label>                            
                            <input type="text" name="nome_usuario" id="nome_usuario" class="form-control">                            
                       </div>
                       <div class="col-sm-5">                        
                       </div>
                       <div class="col-sm-1"></div>
                   </div>
                   <br>
                   <div class="row">
                       <div class="col-sm-6">
                            <label>E-mail:</label>                            
                            <input type="text" name="email_usuario" id="email_usuario" class="form-control">                            
                       </div>
                       <div class="col-sm-6">
                            <label>Senha:</label>                            
                            <input type="password" name="senha_usuario" id="senha_usuario" class="form-control">                                                   
                       </div>
                   </div>
                   <br>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                <button type="button" class="btn btn-primary" onclick="usuario(0,0)">Cadastrar</button>
            </div>
        </div>
    </div>
</div>


<script>

    function usuario(ocorrencia, Id_vendedor){
        ocorrencia = ocorrencia;
        Id_vendedor = Id_vendedor;
        nome_usuario = "";
        email_usuario = "";
        senha_usuario = "";
        tema_usuario = "";

        if(ocorrencia == 0){
            nome_usuario = $('#nome_usuario').val();
            email_usuario = $('#email_usuario').val();
            senha_usuario = $('#senha_usuario').val();

            if(nome_usuario == "" || email_usuario == "" || senha_usuario == ""){
                alert('Informe todos os dados!');
                return;
            }

        }else if(ocorrencia == 1){
            $('#bottun1').css({display: "none"});
            $('#bottun2').css({display: "block"});
            $('#temas').css({display: "block"});
            $('#nome').prop("readonly", false);
            $('#email').prop("readonly", false);
            $('#senha').prop("readonly", false);
            return;
        }else if(ocorrencia == 2){
            nome_usuario = $('#nome').val();
            email_usuario = $('#email').val();
            senha_usuario = $('#senha').val();
            tema_usuario = $('#tema').val();

            if(nome_usuario == "" || email_usuario == "" || senha_usuario == "" || tema_usuario == "#"){
                alert('Informe todos os dados!');
                return;
            }
        }

        $.post(
            "usuarioAjax.php",{
                ocorrencia: ocorrencia,
                Id_vendedor: Id_vendedor,
                nome_usuario: nome_usuario,
                email_usuario: email_usuario.toString(),
                senha_usuario: senha_usuario.toString(),
                tema_usuario: tema_usuario
            },function (data){
                if(data != 0 && ocorrencia == 0){
                    alert('Usuario Cadastrado com Sucesso!');
                    location.reload();
                }else if(data != 0 && ocorrencia == 2){
                    alert('Usuario Alterado com Sucesso!');
                    location.reload();
                }else{
                    alert('Erro!');
                }
            }
        );

    }


</script>