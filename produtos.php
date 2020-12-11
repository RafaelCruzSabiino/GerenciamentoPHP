<?php

include 'topo.php';

$buscarProduto = "SELECT nome_produto, Id_produto, preco_produto, preco_varejo_produto, entrada_produto, quantidade_produto, status_produto, estoque_produto FROM produtos WHERE status_produto = 'ativado'";
$resultBuscarProduto = $mysqli->query($buscarProduto) or die(mysqli_error());

?>
<h1 class="text-center">Produtos</h1>
<br>
<br>
<div class="container" id="antes">
    <div class="row">
       <div class="col-sm-4"></div>
       <div class="col-sm-4"><center>
       <a data-toggle="modal" href='#CadastrarProdutos'><button type="button" class="btn btn-primary" style="width: 100%;">Incluir</button></a>
       </center></div>
       <div class="col-sm-4"></div>
    </div>
    <br>
    <br>
    <div class="row">
    <div class="col-sm-12">
    <div class="table-responsive">
    <table class="display" id="table_id">
        <thead>
            <tr>
                <th>Nome:</th>
                <th>Preço:</th>
                <th>Revenda:</th>
                <th>Compra:</th>
                <th>Vendidos:</th>
                <th>Status:</th>
                <th>Estoque:</th>
            </tr>
        </thead>
        <tbody>
            <?php while($arrayProduto = $resultBuscarProduto->fetch_array()) { ?>
            <tr>
                <td  onclick="consultarProduto(2, <?= $arrayProduto['Id_produto'] ?>)"><?= utf8_encode($arrayProduto['nome_produto']) ?></td>
                <td style="color: blue;">R$ <?= $arrayProduto['preco_produto'] ?></td>
                <td style="color: blue;">R$ <?= $arrayProduto['preco_varejo_produto'] ?></td>
                <td style="color: red;">R$ <?= $arrayProduto['entrada_produto'] ?></td>
                <td style="color: green;"><?= $arrayProduto['quantidade_produto'] ?></td>
                <td><?= $arrayProduto['status_produto'] ?></td>
                <td style="color: purple;"><?= $arrayProduto['estoque_produto'] ?></td>
            </tr>   
            <?php } ?>
        </tbody>
    </table>
    </div>
    </div>
    </div>
</div>

<div class="container" style="display: none;" id="depois">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><center>
        <button type="button" class="btn btn-primary" onclick="consultarProduto(4, 0)">Voltar</button>
        </center></div>
        <div class="col-sm-4"></div>
    </div>
    <br>
    <br>
    <div id="infoProduto"></div>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4"><center>
        <button type="button" class="btn btn-danger" onclick="consultarProduto(1, <?= $arrayProduto['Id_produto'] ?>)">Excluir</button>
        </center></div>
        <div class="col-sm-4"><center>
        <button type="button" class="btn btn-primary" onclick="consultarProduto(3, 0)">Alterar</button>
        </center></div></div>
    </div>
    <br>
    <br>
</div>



<div class="modal fade" id="CadastrarProdutos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Inserir Produto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
            <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <label><b>Nome:</b></label>            
            <input type="text" name="nome_produto" id="nome_produto" class="form-control" placeholder="Nome Produto">            
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <label><b>Descrição:</b></label>            
            <textarea name="descricao_produto" id="descricao_produto" class="form-control" rows="3" placeholder="Inserir Descrição"></textarea>            
        </div>
        <div class="col-sm-2"></div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-4">
            <label><b>Preço:</b></label>            
            <input type="text" name="preco_produto" id="preco_produto" class="form-control" value="0"  onkeyup="varejo()">            
        </div>
        <div class="col-sm-4">
        <label><b>Preço Varejo:</b></label>            
            <input type="text" name="preco_varejo_produto" id="preco_varejo_produto" class="form-control">
        </div>
        <div class="col-sm-2"></div>
    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                <button type="button" class="btn btn-primary" onclick="cadProduto()">Inserir</button>
            </div>
        </div>
    </div>
</div>



<script>
      $(document).ready( function () {
        $('#table_id').DataTable({        
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                download: 'open'
                
            }
        ]
        
    });
      } );

      function cadProduto(){

            nome_produto = $('#nome_produto').val();
            descricao_produto = $('#descricao_produto').val();
            preco_produto = parseFloat($('#preco_produto').val());
            preco_varejo_produto = parseFloat($('#preco_varejo_produto').val());

            if(nome_produto == "" || preco_produto == 0){
                alert('Informar os Dados!');
                return;
            }

            if(descricao_produto == ""){
                descricao_produto = 'Sem Obs';
            }

            $.post(
                "inserirProdutoAjax.php",{
                nome_produto: nome_produto.toString(),
                descricao_produto: descricao_produto.toString(),
                preco_produto: preco_produto,
                preco_varejo_produto: preco_varejo_produto

                },function (data){
                    if(data != 0){
                        alert('Produto Inserido Com Sucesso!');
                        location.reload();
                    }else{
                        alert('Erro');
                    }
                }
            );


        }



function varejo(){
     preco = $('#preco_produto').val();
     document.getElementById('preco_varejo_produto').value = preco;  
}


function consultarProduto(ocorrencia, Id_produto){
        ocorrencia = ocorrencia;
        nome_produto = "";
        descricao_produto = "";
        preco_produto = 0;
        preco_varejo_produto = "";
        entrada_produto = "";
    
        if(ocorrencia == 1){
            confirm = confirm('Deseja Realmente Desativar/Ativar esse Produto?')
            if(confirm == false){
                location.reload();
                return;
            }
            Id_produto = $('#Id_produtos').val();

        }else if(ocorrencia == 3){
            confirm = confirm('Deseja Realmente Alterar o Produto?');
            if(confirm == false){
                location.reload();
                return;
            }
            Id_produto = $('#Id_produtos').val();
            nome_produto = $('#nome_produto').val();
            descricao_produto = $('#descricao_produto').val();
            preco_produto = parseFloat($('#preco_produto').val());
            preco_varejo_produto = parseFloat($('#preco_varejo_produto').val());
            entrada_produto = parseFloat($('#entrada_produto').val());
            
        }else if(ocorrencia == 4){
            location.reload();
            return;
        }else{
            Id_produto = Id_produto;
        }

        $.post(
            "buscarProdutoAjax.php",{
                ocorrencia: ocorrencia,
                Id_produto: Id_produto,
                nome_produto: nome_produto.toString(),
                descricao_produto: descricao_produto.toString(),
                preco_produto: preco_produto,
                preco_varejo_produto: preco_varejo_produto,
                entrada_produto: entrada_produto
            },function (data){
                if(ocorrencia == 1){
                    alert('Produto Desativado/Ativado com Sucesso!');
                    location.reload();
                }else if(ocorrencia == 2){
                    $('#antes').css({display: "none"});
                    $('#depois').css({display: "block"});
                    $('#infoProduto').html(data);
                }else if(ocorrencia == 3){
                    alert('Produto Alterado Com Sucesso!');
                    location.reload();
                }else{
                    alert('Erro');
                }
            }
        );

    }


</script>