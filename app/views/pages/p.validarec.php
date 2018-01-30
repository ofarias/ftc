<div class="row">
<style type="text/css">
    h1 {color:red}
    h1 {text-shadow: 2px 2px #FFFF00;}
</style>

    <br />
        <h1> Se Realiza la Validación <?php echo $foliovalidacion?> </h1>
</div>
<br />

<?php if($recep)
{
    ?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recepciones 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>Orden de Compra</th>
                                            <th>Recepcion</th>
                                            <th>Proveedor</th>
                                            <th>Unidad</th>
                                            <th>Operador</th>
                                            <th>Fecha Recoleccion</th>
                                            <th>Estado Recoleccion</th>
                                            <th>Estado de la Recepcion</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $ordcomp;
                                        foreach ($recep as $data): 
                                            
                                            $statusrec = $data->ENLAZADO;
                                            $statuslog = $data->STATUS_LOG;

                                            if($statusrec == 'T'){
                                                $statusrec = 'Total';
                                            }elseif($statusrec == 'P'){
                                                $statusrec = 'Parcial';
                                            }else{
                                                $statusrec = 'Otro';
                                            }

                                            if ($statuslog == $statusrec){
                                                $color = "style='background-color:FFFFFF;'";
                                            }else{
                                                $color = "style='background-color:orange;'";
                                            }                        
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->OC;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $statusrec;?></td>
                                             
                                        </tr>
                                        
                                        <?php $ordcomp = $data->OC; endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />
<?php 
}else{
?>
<h1>
    Se Valida Una OC Fallida.
</h1>
<?php 
}
?>

<?php if($parRecep)
{
    ?>
<div class="row">
    <br />
</div>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Productos recibidos.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>OC</th>
                                            <th>Par</th>
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Ord</th>
                                            <th>Rec</th>
                                            <th>Monto</th>
                                            <th>PXR</th>
                                            <th>Rec</th>
                                            <th>Cant</th>
                                            <th>CxU</th>
                                            <th>Desc1</th>
                                            <th>Desc2</th>
                                            <th>Desc3</th>
                                            <th>SubTot</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>                                   
                                    <tfoot>
                                        <tr>
                                            <th colspan="14">Totales</th>
                                            <th id="total_descuentos"></th>
                                            <th id="total_subtotal"></th>
                                            <th id="total_iva"></th>
                                            <th id="total_total"></th>
                                            <th colspan="2"></th>                                   
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        $i =0;
                                        foreach ($parRecep as $data): 
                                            $i++;
                                            $color = "style='background-color:FFFFFF;'";
                                            $cant_oc=$data->CANT_OC;
                                            $cant_r= $data->CANT;
                                            if($cant_oc=$cant_r){
                                                $color = "style='background-color:green;'";
                                            }else{
                                                $color = "style='background-color:red;'";
                                            }
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->UNI_ALT;?></td>
                                            <td><?php echo $data->CANT_OC;?></td>
                                            <td><?php echo $data->CANT;?></td>                                       
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->PXR_OC;?></td>
                                            <td><?php echo $data->DOCO;?></td>
                                            <!--<td><?php echo $statusrec;?></td>-->
                                            <form action="index.php" method="post" id="FORM_ACTION_1" onsubmit="return enviar(<?php echo $i;?>)">
                                            <input name="doco" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="fechadoco" type="hidden" value="<?php echo $data->FECHA_DOCO;?>"/>
                                            <input name="descripcion" type="hidden" value = "<?php echo $data->DESCR?>"/>
                                            <input name="cveart" type="hidden" value ="<?php echo $data->CVE_ART?>" />
                                            <input name="par" type="hidden" value="<?php echo $data->NUM_PAR?>"/>
                                            <input name="cantorig" type="hidden" value="<?php echo $data->CANT_OC?>" id="cantorig_<?php echo $i;?>"/>
                                            <input name="costoorig" type="hidden" value="<?php echo $data->COST?>"/>
                                            <input name="idpreoc" type="hidden" value="<?php echo $data->ID_PREOC?>"/>
                                            <input name="docr" type="hidden" value="<?php echo $data->DOCO?>"/>
                                            <input name="ordcomp" type="hidden" value="<?php echo $ordcomp;?>"/>
                                            <input name="tot_partida" id="tot_partida" class="tot_partida" type="hidden" value="<?php echo $data->TOT_PARTIDA;?>"/>
                                            <input type="hidden" name="pxr_oc" value="<?php echo $data->PXR_OC;?>" id="pxr_<?php echo $i;?>"/>
                                            <td><input name="cantn" type="text" size="4" value="<?php echo $data->PXR?>" id="cantn_<?php echo $i;?>" required = "required" onkeyup="validaCantidadTotal(this, <?php echo $data->PXR_OC?>)"/></td>
                                            <td><input name="coston" type ="text" size = "4" value = "<?php echo $data->COST;?>"/></td>
                                            <td><input type="text" size="3" name="desc1" id="desc1" class="desc1" value="0" min="0" max="100"/></td>
                                            <td><input type="text" size="3" name="desc2" id="desc2" class="desc2" value="0" min="0" max="100"/></td>
                                            <td><input type="text" size="3" name="desc3" id="desc3" class="desc3" value="0" min="0" max="100" size="4"/></td>
                                            <td><input type="text" size="3" name="subtotal_" id="subtotal" class="subtotal "value="<?php echo $data->TOT_PARTIDA;?>" readonly></td>
                                            <td><input type="text" size="3" name="iva" id="iva" class="ivatotal" value="0" readonly /></td>
                                            <td><input type="text" size="3" name="total" id="total" class="total" value="0" readonly /></td>
                                            <input type="hidden" name="fval" value="<?php echo $foliovalidacion?>" />
                                            <td>

                                            <button name="ValParOk" 
                                                    type="submit" 
                                                    value="<?php echo $data->ID_PREOC?>" 
                                                    class="btn btn-warning" 
                                                    id="val_<?php echo $data->ID_PREOC?>" 
                                                    onclick="ocultar(val_<?php echo $data->ID_PREOC?>.value)"
                                            >
                                                    <i class="fa fa-check"   ></i></button>
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
<?php 
}else{ 
?>

<label> NO SE ENCONTRARON PARTIDAS PENDIENTES DE VALIDAR, FAVOR DE REVISAR LA INFORMACION...</label>
<?php }
?>
<br />
<br />

<?php 
if(!empty($parNoRecep))
{?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Productos No Recibido o Recibidos en Otras Recepciones.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>OC</th>
                                            <th>Recepcion</th>
                                            <th>Partida</th>
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad OC</th>
                                            <th>Cantidad Valida</th>
                                            <th>Monto Compra</th>
                                            <th>Saldo</th>
                                            <th>PXR</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead> 
                                    <tfoot>
                                        <th colspan="11"></th>
                                        <th><button type="submit" form="productosrecibidos" name="ImpRecepVal" class ="btn btn-info" formtarget="_blank">Imprimir <i class="fa fa-print"></i></button></th>
                                    </tfoot>                                 
                                  <tbody>
                                        <?php 
                                        foreach ($parNoRecep as $data): 
                                            $color = "style='background-color:FFFFFF;'";
                                            $pxr = $data->PXR;
                                            if($pxr > 0){
                                                $color = "style='background-color:red;'";
                                            }else{
                                                $color = "style='background-color:green;'";
                                            }
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->DOC_SIG;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->UNI_ALT;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->CANT_REC?></td>
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->SALDO;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->STATUS_REC;?></td>
                                            <form action="index.php" method="post" id="productosrecibidos">
                                            <input name="docr" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="par" type="hidden" value="<?php echo $data->NUM_PAR?>"/>
                                            </form>      
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
<?php 
}
?>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">
    window.addEventListener('load',CalculaMontosPR,false);
    window.addEventListener('keypress',CalculaMontosPR,false);


    function ocultar(a){
        //alert('El renglon es ' + a);
        document.getElementById('val_' + a).classList.add('hide');

    }

    function validaCantidadTotal(me, valor){
        if (me.value != '' && me.value > valor ){
             me.focus();
            alert("La cantidad no debe ser Mayor que la Pendiente por Recibir (PXR): "+valor);
        }
    }

    function enviar(iterador){
        var form = document.getElementById("FORM_ACTION_1");
        var campo = pasrseFloat(document.getElementById("cantn_"+iterador).value);
        var otro = document.getElementById("cantorig_"+iterador).value;
        var pxr = parseFloat(document.getElementById("pxr_"+iterador).value);
        if(campo > pxr){
            alert("No puede validar mas de la cantidad Pendiente !!!!!");
            return false;
        } else {
            form.submit();
        }
    }

    function CalculaMontosPR(){
        var total = document.getElementsByClassName("total");
                var sub_total = document.getElementsByClassName("subtotal");
        var subtotal = document.getElementsByClassName("tot_partida");
        var desc1 = document.getElementsByClassName("desc1");
        var desc2 = document.getElementsByClassName("desc2");
        var desc3 = document.getElementsByClassName("desc3");
        var ivatotal = document.getElementsByClassName("ivatotal");
                var total_descuento = document.getElementById("total_descuentos");
                var total_subtotal = document.getElementById("total_subtotal");
                var total_iva = document.getElementById("total_iva");
                var total_total = document.getElementById("total_total");

                var tot_desc = 0;
                var tot_subtot = 0;
                var tot_iva = 0;
                var tot_tot = 0;
        for(var i = 0; i <= total.length; i++){
            var impuesto = 16.00;
            var iva = 0;
            var descuentos = [desc1[i].value,desc2[i].value,desc3[i].value,impuesto];
            var tot = subtotal[i].value;
                        tot_subtot += Number(sub_total[i].value);
                        
                        
            for (var f = 0;f < 4; f++){
                if(f < 3){
                                                tot_desc += (tot * (descuentos[f])/100);
                        tot = tot - (tot * (descuentos[f]/100));    
                    }else{
                        iva = tot * (descuentos[f]/100);
                        tot = tot + (tot * (descuentos[f]/100));
                    }
                                        tot_iva += Number(iva);
                    ivatotal[i].value = iva.toFixed(2);
                    total[i].value = tot.toFixed(2);        
            }
                        tot_tot += Number(total[i].value);
                                        total_descuento.innerHTML = "$" + tot_desc.toFixed(2);
                                        total_subtotal.innerHTML = "$" + tot_subtot.toFixed(2);
                                        total_iva.innerHTML = "$" + tot_iva.toFixed(2);
                                        total_total.innerHTML = "$" + tot_tot.toFixed(2);
        }
    }
</script>