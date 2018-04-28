<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Factura Datos del Cliente 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Fecha Cita</th>
                                            <th>Entregar en:</th>
                                            <th>Fecha Pedido</th>
                                            <th>Dias </th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($facturas as $data): 

                                            $statusrec = $data->ENLAZADO;
                                            if($statusrec == 'T'){
                                                $statusrec = 'Total';
                                            }elseif($statusrec == 'P'){
                                                $statusrec = 'Parcial';
                                            }else{
                                                $statusrec = 'Otro';
                                            }
                                            $color = "style='background-color:orange;'";      
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><?php echo $idcaja?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td><?php echo $data->DAT_ENVIO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->DIAS;?></td>                                            
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

<div class="row">
    <br />
</div>

<?php if(count($parfacturas) > 0){?>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Preparar Materiales.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Clave</th>
                                            <th>Partida</th>                                         
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Cant Rec</th>
                                            <th>Faltante</th>
                                            <th>Enpacado</th>
                                            <th>Cant a Empacar</th>
                                            <th>Numero Empaque</th>
                                            <th>Tipo</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i= 0;
                                        foreach ($parfacturas as $data):
                                            $i++;
                                            $color = "style='background-color:FFFFFF;'";
                                            $color2 = '';
                                               
                                                $empacar = $data->RECEPCION - $data->EMPACADO;
                                            ?>
                                       <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->PAR;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->RECEPCION;?></td> 
                                            <td><?php echo $data->REC_FALTANTE?>                                   
                                            <td><?php echo $data->EMPACADO;?></td>
                                            <input type="hidden" name="idpreo" value ="<?php echo $data->ID?>" id="idpre<?php echo $i?>">
                                            <td align="center">
                                            <font size="2.5px" <?php echo $color2?>><b><?php echo $empacar?></b>
                                            <!--<input name="cantn" type="number" step="any" min = 0 max="<?php echo $cantemp?>" value="<?php echo $cantemp?>" id="cantn_<?php echo $i;?>" required="required" onchange="validafaltante(this.value, <?php echo $i;?>)" onkeypress="return pulsar(event)"/>-->
                                            </td>
                                            <td>
                                             <input name="empaque" type ="number" min="1" size = "4" required="required" id="emp_<?php echo $i?>"/>
                                            </td>
                                            <td>
                                                <select class="form-control" name="tipopaq" id="sel_<?php echo $i?>">
                                                    <option value="CAJA">Caja</option>
                                                    <option value="BOLSA">Bolsa</option>
                                                    <option value="BULTO">Bulto</option>
                                                    <option value="COSTAL">Costal</option>
                                                    <option value="CONTENEDOR">Contenedor</option>
                                                    <option value="PAQUETE">Paquete</option>
                                                    <option value="ROLLO">Rollo</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="button" name="AsignaEmpaque" value="Preparar" class="btn btn-warning" onclick="ocultar(<?php echo $i?>)" id="btn_<?php echo $i?>"  />
                                            </td> 
                                                 
                                        </tr>

                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<?php }else{?>
    <label> <font size ="8">No existen mas materiales pendientes de emabalar</font></label>
    <br/>
    <br/>
<?php }?>

<?php if($asignados > 0){?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <font size="4"> Materiales en la Caja <?php echo $idcaja?>.</font>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Clave</th>
                                            <th>Partida</th>                                         
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Cant Rec</th>
                                            <th>Faltante</th>
                                            <th>Enpacado</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i= 0;
                                        foreach ($asignados as $data):
                                            $i++;
                                      ?>
                                       <tr class="odd gradeX">
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><?php echo $data->PARTIDA;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->RECEPCION;?></td> 
                                            <td><?php echo $data->REC_FALTANTE?>                                   
                                            <td><?php echo $data->EMPACADO;?></td>    
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>

<?php }?>
<form action="index.php" method="POST" id="formPrepara">
    <input type="hidden" name="idpreoc" value="" id="formidpreoc">
    <input type="hidden" name="noemp" value="" id="NoEmp">
    <input type="hidden" name="tipoemp" value="" id=TipoEmp>
    <input type="hidden" name="idcaja" value="<?php echo $idcaja?>">
    <input type="hidden" name="docf" value="<?php echo $docf?>">
    <input type="hidden" name="AsignaEmpaque" value="">
</form>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

    function ocultar(i){
        var numeroEmp = document.getElementById('emp_'+i).value;    
        if(numeroEmp == ''){
            alert('Debe de capturar un empaque...');
        }else{
            var tipoemp = document.getElementById("sel_"+i).value;
            var idpreoc = document.getElementById("idpre"+i).value; 
            document.getElementById("btn_"+i).classList.add('hide');
            document.getElementById("NoEmp").value=numeroEmp;
            document.getElementById("formidpreoc").value=idpreoc;
            document.getElementById("TipoEmp").value=tipoemp;

            var form = document.getElementById('formPrepara');
                form.submit();
                
        } 
        //document.getElementById('btnPago').classList.add('hide');
    }

    function pulsar(e) { 
  tecla = (document.all) ? e.keyCode :e.which; 
  return (tecla!=13); 
} 

    function validafaltante(val, iterador){ 
        var nueva = document.getElementById("cantn_"+iterador).value;
        var validada = document.getElementById("cantval_"+iterador).value;
        var original = document.getElementById("canto_"+iterador).value; 
        var pendiente = original - validada; 
        if (nueva > pendiente){
            alert("La cantidad es mayor a la necesaria para empacar, favor de revisarlo.");
        }
    }  

     function enviar(iterador){
        var form = document.getElementById("FORM_ACTION_1");
        var nueva = document.getElementById("cantn_"+iterador).value;
        var validada = document.getElementById("cantval_"+iterador).value;
        var original = document.getElementById("canto_"+iterador).value; 
        /// Calcular el valor de 
        //var pxr = document.getElementById("pxr_"+iterador).value;
        /// 6 - 0 = 6
        // 10> 6 
        var pendiente = original - validada;
        if(nueva > pendiente){
            alert("No puede validar mas de la cantidad Pendiente !!!!!");
            return false;
        }else {
            form.submit();
        }
    }
</script>