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
                                            <th>Factura</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Fecha Cita</th>
                                            <th>Entregar en:</th>
                                            <th>Fecha Fact</th>
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
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                       
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->DOC_ANT;?></td>
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
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />

<div class="row">
    <br />
</div>

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
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i= 0;
                                        foreach ($parfacturas as $data):
                                            $i++;
                                            $color = "style='background-color:FFFFFF;'";
                                            $cant_oc=$data->CANT;
                                            $cant_r= $data->CANT;
                                            $cantval = $data->CANT_VAL;
                                            $cantemp = $cant_r - $cantval;
                                            if($cant_oc=$cant_r){
                                                $color = "style='background-color:green;'";
                                            }else{
                                                $color = "style='background-color:red;'";
                                            }
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->CAMPLIB7;?></td>
                                            <td><?php echo $data->UNI_MED;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>                                    
                                            <td><?php echo $data->REC_FALTANTE;?></td>
                                            <td><?php echo $data->CANT_VAL;?></td>
                                            <form action="index.php" method="post" id="FORM_ACTION_1" onsubmit="return enviar(<?php echo $i;?>)">
                                            <input type="hidden" name="cantval" value = "<?php echo $data->CANT_VAL?>" id="cantval_<?php echo $i;?>"/>
                                            <input name="idcaja" type="hidden" value="<?php echo $idcaja?>"/>
                                            <input name="docf" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="par" type="hidden" value="<?php echo $data->NUM_PAR?>"/>
                                            <input name="canto" type="hidden" value="<?php echo $data->CANT?>" id="canto_<?php echo $i;?>"/>
                                            <input name="idpreoc" type="hidden" value="<?php echo $data->ID_PREOC?>"/>
                                            <input name="art" type="hidden" value="<?php echo $data->CVE_ART?>"/>
                                            <input name="desc" type="hidden" value="<?php echo $data->CAMPLIB7?>"/>
                                            <td>
                                            <input name="cantn" type="number" step="any" min = 0 max="<?php echo $cantemp?>" value="<?php echo $cantemp?>" id="cantn_<?php echo $i;?>" required="required" onchange="validafaltante(this.value, <?php echo $i;?>)" onkeypress="return pulsar(event)"/>
                                            </td>
                                            <td>
                                             <input name="empaque" type ="number" min="1" size = "4" required="required" onkeypress="return pulsar(event)"/>
                                            </td>
                                            <td>
                                                <select class="form-control" name="tipopaq" onkeypress="return pulsar(event)">
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
                                                <input type="submit" name="AsignaEmpaque" value="Preparar" class="btn btn-warning" onclick="ocultar(<?php echo $i?>)" id="btn_<?php echo $i?>"  />
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
<br />
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

    function ocultar(i){
        document.getElementById("btn_"+i).classList.add('hide');
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