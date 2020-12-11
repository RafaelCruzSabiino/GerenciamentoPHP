<?php

include 'topo.php';

$buscarProduto2 = "SELECT nome_produto, Id_produto FROM produtos WHERE status_produto = 'ativado' GROUP BY nome_produto ORDER BY nome_produto ASC";
$resultBuscarProduto2 = $mysqli->query($buscarProduto2);

$buscarVendedor = "SELECT Id_vendedor, nome_vendedor FROM vendedor WHERE status_vendedor= 'ativado' ";
$resultBuscarVendedor = $mysqli->query($buscarVendedor);

$buscarSubVenda = "SELECT c.nome_cliente, p.nome_produto, p.Id_produto, n.nome_vendedor, v.quantidade_venda, v.valor_venda, v.Id_sub_venda, v.Id_cliente FROM sub_venda v 
INNER JOIN clientes c ON v.Id_cliente = c.Id_cliente
INNER JOIN produtos p On v.Id_produto = p.Id_produto
INNER JOIN vendedor n ON v.Id_vendedor = n.Id_vendedor";
$resultbuscarSubVenda = $mysqli->query($buscarSubVenda);
$resultbuscarSubVenda2 = $mysqli->query($buscarSubVenda);
$verificacao = $resultbuscarSubVenda2->fetch_array();

$valor_total = 0;
?>

<input type="hidden" name="" id="verificacao" class="form-control" value="<?= $verificacao['Id_sub_venda'] ?>">

<div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Pedido de Venda</h2>
        </div>
      </div>
      <br>
      <div class="row">
          <div class="col-sm-2"> 
              <label><b>Cod. Cliente:</b></label>             
              <input type="number" name="cod_cliente" id="Id_cliente3" class="form-control" value="<?= $verificacao['Id_cliente'] ?>" min="0" onchange="inserirVenda(6,0,0)">             
          </div>
          <div class="col-sm-3">
               <label><a data-toggle="modal" href='#verificarCod' style="color: black;">Nome Cliente:</a></label>               
               <input type="text" name="" id="nome_cliente" class="form-control" value="<?= $verificacao['nome_cliente'] ?>" onchange="inserirVenda(7,0,0)">               
          </div>
          <div id="returnInfor"></div>
          <div class="col-sm-2"> 
              <label><b>Cod. Produto:</b></label>             
              <input type="number" name="Id_produto3" id="Id_produto3" class="form-control"  min="0" onchange="consultarPro(1)">             
          </div>
          <div class="col-sm-3">
              <label id="labelProduto"><b>Produto:</b></label>             
              <input type="text" name="" id="nome_produto3" class="form-control" onchange="consultarPro(0)">              
          </div>
          <div class="col-sm-2">
              <label id="labelQuantidade"><b>Quant.:</b></label>            
              <input type="number" name="quantidade_venda" id="quantidade_venda" class="form-control" value="0" min="0" max="5">                        
          </div>
      </div>
      <br>
      <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-2">
              <label id="labelTipo"><b>Tipo:</b></label>              
              <select name="tipo_venda" id="tipo_venda" class="form-control">
                  <option value="consumo">Consumo</option>
                  <option value="revenda">Revenda</option>
              </select>                                     
          </div>
               <div id="returnEstoque"></div>
          <div class="col-sm-2"> 
              <br>             
              <center><button type="button" class="btn btn-danger" id="botao" onclick="inserirVenda(1, 0, 0)">+</button></center>                              
          </div>
          <div class="col-sm-4"></div>
      </div>
      <br>
      <br>
</div>
<div class="container" id="sub_venda">
    <div class="row"> 
    <div class="col-sm-12">  
    <div class="table-responsive">
        <table class="table table-hover" id="tableVenda">
            <thead>
            <tr>
                <th>Vendedor</th>
                <th>Cliente:</th>
                <th>Produto:</th>
                <th>Quantidade:</th>
                <th>Valor Total:</th>
            </tr>
            </thead>
            <tbody>
            <?php while($arraySubVenda = $resultbuscarSubVenda->fetch_array()) { $valor_total += $arraySubVenda['valor_venda'] ?>
            <tr ondblclick="inserirVenda(3, <?= $arraySubVenda['Id_sub_venda'] ?>, <?= $arraySubVenda['Id_produto'] ?>)">
                <td><?= utf8_encode($arraySubVenda['nome_vendedor']) ?></td>
                <td><?= utf8_encode($arraySubVenda['nome_cliente']) ?></td>
                <td><?= utf8_encode($arraySubVenda['nome_produto']) ?></td>
                <td style="color: green;"><?= $arraySubVenda['quantidade_venda'] ?></td>
                <td style="color: blue;">R$ <?= $arraySubVenda['valor_venda'] ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>    
    </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-2">
            <label>Valor Total</label>        
            <input type="text" name="valor_total" id="valor_total" class="form-control" style="color: red;" value="R$ <?= $valor_total ?>" readonly>        
        </div>
        <div class="col-sm-2">
            <label>Status Venda</label>        
            <select name="status_venda" id="status_venda" class="form-control" onchange="inserirVenda(15,0,0)">
                <option value="#">Selecione</option>
                <option value="pago">Pago</option>
                <option value="pagar">À Pagar</option>
            </select>        
        </div>
        <div class="col-sm-2">      
            <br>        
            <center><button type="button" class="btn btn-success" id="botaoConcluir" style="display: none;" onclick="inserirVenda(4, 0, 0)">Concluir</button></center>           
        </div>
        <div class="col-sm-3"></div>
    </div>
    <br>
    <br>
</div>

  <div class="modal fade" id="verificarCod">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Cliente:</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>          
        </div>
        <div class="modal-body">
              <div class="container">
                <div class="row">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-8">
                      <label>Nome do Cliente:</label>                       
                      <input type="text" name="clientes" id="clientes_id" class="form-control" onchange="consultarCod(0)">                    
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <br>
                    <div id="returnCod">
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
        </div>
      </div>
    </div>
  </div>

  
  


<script>
      $(document).ready( function () {
        $('#tableVenda').DataTable( {        
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                download: 'open'
                
            }
        ]
        
    });
        if($('#verificacao').val() == ""){
            $('#sub_venda').css({display: "none"});
        }

      } );


function inserirVenda(ocorrencia, Id_venda, Id_produto){

ocorrencia = ocorrencia;
Id_venda = Id_venda;
Id_cliente = $('#Id_cliente3').val();
quantidade_venda = parseInt($('#quantidade_venda').val());
tipo_venda = $('#tipo_venda').val();
nome_cliente = $('#nome_cliente').val();
status_venda = "";
estoque = 0;


if(ocorrencia == 0){
    return;
}

if(ocorrencia == 15){
    $('#botaoConcluir').css({display: "block"});
    return;
}

if(ocorrencia == 6){
    if(Id_cliente == ""){
        location.reload();
        return;
    }
}


if(ocorrencia == 1){
    estoque = $('#estoque_produto').val();
    
    if(nome_cliente == "" || Id_cliente == "" || $('#Id_produto3').val() == "#" || quantidade_venda == ""){
        alert('Insira todos os dados!');
        return;
    }

    if(quantidade_venda > estoque){
        confirm = confirm('Essa quantidade é maior que o Estoque da Mercadoria, Deseja Realmente Realizar a Venda?');
        if(confirm == false){
            location.reload();
            return;
        }
    }

}

if(ocorrencia == 3){
    confirm = confirm('Deseja Realmente Excluir o Item?');
    if(confirm == false){
        location.reload();
        return;
    }
    Id_produto = Id_produto;
}else{
    Id_produto = $('#Id_produto3').val();
}

if(ocorrencia == 4){
    status_venda = $('#status_venda').val();

    if(status_venda == "#"){
        alert('Inserir Status da Venda');
        return;
    }
}

$.post(
    "inserirVendaAjax.php",{
        ocorrencia: ocorrencia,
        Id_cliente: Id_cliente,
        Id_produto: Id_produto,
        quantidade_venda: quantidade_venda,
        Id_venda: Id_venda,
        status_venda: status_venda,
        tipo_venda: tipo_venda.toString(),
        nome_cliente: nome_cliente
    },function (data){
        if(ocorrencia == 5){
           $('#returnEstoque').html(data);
        }
        else if(ocorrencia == 1){
            alert('Pre-venda Realizada com Sucesso!');
            location.reload();
        }else if(ocorrencia == 3){
            alert('Pre-venda Excluida com Sucesso!');
            location.reload();
        }else if(ocorrencia == 4){
            alert('Venda Efetivado com Sucesso!');
            location.reload();
        }else if(ocorrencia == 6){
            $('#returnInfor').html(data);
            document.getElementById('nome_cliente').value = $('#nome_clientes').val();
            $('#Id_produto3').focus();
        }else if(ocorrencia == 7){
            $('#returnInfor').html(data);
            document.getElementById('nome_cliente').value = $('#nome_clientes').val();     
            document.getElementById('Id_cliente3').value = $('#Id_clientes').val();
            $('#Id_produto3').focus();
        }else{
            alert('Erro');
        }
    }
);

}



    function consultarCod(ocorrencia){

ocorrencia = ocorrencia;

clientes = $('#clientes_id').val();

$.post(
  "consulClienteAjax.php",{
      ocorrencia: ocorrencia,
    clientes: clientes.toString()
  },function (data){
    if(data != 0){
      $('#returnCod').html(data);          

    }else{
       alert('Erro');
    }
  }
);
}

    function consultarPro(ocorrencia){

ocorrencia = ocorrencia;
if(ocorrencia == 0){
    nome_produto = $('#nome_produto3').val();
    Id_produto = "";
}else{
    Id_produto = $('#Id_produto3').val();
    nome_produto = "";
}
$.post(
  "consulProdutoAjax.php",{
      ocorrencia: ocorrencia,
      Id_produto: Id_produto,
    nome_produto: nome_produto.toString(),
  },function (data){
    if(data != 0){
      $('#returnCod').html(data);
      $('#Id_produto3').val($('#Id_produto10').val());         
      $('#nome_produto3').val($('#nome_produto10').val());   
    }else{
       alert('Erro');
    }
  }
);
}


</script>