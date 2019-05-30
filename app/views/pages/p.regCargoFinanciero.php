<br/>
<div class="row">
    <div class="container-fluid">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3>Captura de Cargo Financiero.</h3>
                      <input type="hidden" name="mensaje" value="<?php echo $mensaje?>" id="mensaje">
                </div>
                <br />
                <div class="panel panel-body">
                    <form action="index.php" method="post" id="formgasto">
                        <div class="form-group">
                            <label for="banco" class="col-lg-2 control-label">Banco: </label>
                            <div class="col-lg-10">
                                <select class="form-control" id="banco" name="banco" required = "required" ><br/>
                                    <option>--Selecciona un banco--</option>
                                    <?php foreach ($cuentaBancarias as $data): ?>
                                        <option value="<?php echo $data->ID; ?>"><?php echo $data->BANCO; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="monto" class="col-lg-2 control-label">Monto: </label>
                            <div class="col-lg-10">
                                   <input type="number" step="any" name="monto" required="required" >                                  
                           </div>
                        </div>
                        <div class="form-group">
                            <label for="fecha" class="col-lg-2 control-label">Fecha de Estado de Cuenta </label>
                            <div class="col-lg-10">
                                <input type="text" name="fecha" required="required" id = "fecha" />
                            </div>
                        </div>
                       <!-- <div>
                            <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Nombre del cliente" />
                            <div id="clienteList"></div>
                        </div>-->
                        <button name="guardaCargoFinanciero" type = "submit" value = "enviar" class="btn button-warning"> Guardar</button>
                    </form>       
                    </div>
            </div>
        </div>
    </div>
</div>
<label>Ver Historico: &nbsp;&nbsp;&nbsp;</label>Si <input type="radio" name="historico" value="si" onchange="verHistorico(this.value)">
&nbsp;&nbsp;&nbsp; No<input type="radio" name="historico" value="no" onchange="verHistorico(this.value)">
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Cargos Financieros pendientes de aplicar;
            </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Banco / Cuenta</th>
                                            <th>Fecha de Cargo</th>
                                            <th>Importe</th>
                                            <th>Saldo</th>
                                            <th>Aplicar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($cf as $data):
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->BANCO;?> / <?php echo $data->CUENTA?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>  
                                            <form action = "index.php" method = "post">
                                                <input type="hidden" value ="<?php echo $data->ID?>" name = "idcf" />
                                                <input type="hidden" name="rfc" value ="<?php echo $data->RFC?>" />
                                                <input type="hidden" name="banco" value="<?php echo $data->BANCO?>" />
                                                <input type="hidden" name="cuenta" value="<?php echo $data->CUENTA?>" />
                                                <td>
                                                   <button name="asociarCF" value="a" type="submit" class="btn btn-warning"> Asociar</button><br/>
                                                   <button name="asociarCF" value="c" type="submit" class="btn btn-danger" onclick="alerta()">Cancelar</button>
                                                </td>   
                                            </form>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>
<br/>
<br>

<div id="historico" class="row hidden" >
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Cargos Financieros pendientes de aplicar;
            </div>
                    <div class="panel-body">
                            <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Banco / Cuenta</th>
                                            <th>Fecha de Cargo</th>
                                            <th>Importe</th>
                                            <th>Saldo</th>
                                            <th>Aplicar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($cfh as $data):
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->BANCO;?> / <?php echo $data->CUENTA?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>  
                                            <form action = "index.php" method = "post">
                                                <input type="hidden" value ="<?php echo $data->ID?>" name = "idcf" />
                                                <input type="hidden" name="rfc" value ="<?php echo $data->RFC?>" />
                                                <input type="hidden" name="banco" value="<?php echo $data->BANCO?>" />
                                                <input type="hidden" name="cuenta" value="<?php echo $data->CUENTA?>" />
                                                <td>
                                                   <button name="asociarCF" value="a" type="submit" class="btn btn-warning"> Asociar</button><br/>
                                                   <button name="asociarCF" value="c" type="submit" class="btn btn-danger" onclick="alerta()">Cancelar</button>
                                                </td>   
                                            </form>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>
<br />
<!--Modified by GDELEON 3/Ago/2016-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
        
    function verHistorico(t){
        alert('ver Historico')
        if(t == 'si'){
            document.getElementById('historico').classList.remove('hidden')    
        }else if(t == 'no'){
            document.getElementById('historico').classList.add('hidden')    
        }
    }

    function alerta(){
        alert('Se cancela el cargo financiero.');
        location.reload(true)
    }

   $(function() {
    $("#fecha").datepicker({dateFormat:'dd.mm.yy'});
    var mensaje = document.getElementById('mensaje').value;
    if(mensaje != ''){
        alert(mensaje);
    }
  } );

      /* $(document).ready(function(){
        $("#cliente").keyup(function(){
            var query = $(this).val();
                if(query != '')
                {
                    $.ajax({
                        url:"p.ajaxtest.php",
                        method:"POST",
                        data:{query:query},
                        success:function(data)
                        {
                            $('#clienteList').fadeIn();
                            $('#clienteList').html.(data);
                        }
                    });
                }
        });
    });*/

</script>