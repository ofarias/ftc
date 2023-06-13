<br /><br />
<?php  
    if(isset($_REQUEST->ok)){
        echo 'Se guardo la orden:';
    } 
?>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Resultado de Ordenes - Compra
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">
                            <form id="frmOrdCom" name="frmOrdCom" action="index.php" method="POST">
                            <input type="hidden" value="" name="INSRTORCOM"/>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>
                                            <th>Historial</th>
                                            <th>U</th>
                                            <th>PEDIDO</th>
                                            <th>FECHA PEDIDO</th>
                                            <th>FECHA LIBERACION</th>
                                            <th>CLAVE ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UM</th>
                                            <th>CANTIDAD ORIGINAL</th>
                                            <th>FALTANTE</th>
                                            <th>CANTIDAD A SOLICITAR</th>
                                            <th>COSTO BRUTO</th>
                                            <th>IVA</th>
                                            <th>COSTO NETO</th>
                                            <th>CLAVE PROVEEDOR</th>
                                            <th>NOMBRE PROVEEDOR</th>
                                            <th>TOTAL</th> 
                                            <th>TIEMPO DE ENTREGA</th>
                                            <th>EDITAR</th>
                                        </tr>
                                    </thead>   
                                    <tfoot>
                                        <tr>
                                            <th colspan="11" style="text-align:right">Total:</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        $con=1;
                                        foreach ($exec as $data):
                                        $dc=$data->COTIZA; 
                                        $dos=substr($dc, 1);
                                        $doc='O'.$dos;
                                        $totalPartida= $data->CANTI * $data->COSTO;
                                        $color=$data->URGENTE =='U'?"style='background-color:red;'":"";
                                        if($data->LIBERACIONES == 1 ){
                                            $color = "style='background-color:#e6e6ff'";
                                        }elseif ($data->LIBERACIONES == 2){
                                            $color = "style='background-color:#e6ccff'";
                                        }elseif($data->LIBERACIONES == 3){
                                            $color = "style='background-color:#d580ff'";
                                        }elseif ($data->LIBERACIONES > 3) {
                                            $color = "style='background-color:#db4dff', color";
                                        }

                                        ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td>
                                            <div id="seleccionHabilitados">
                                            <input type="checkbox" value="<?php echo $data->PROVE .'|'.$doc.'|'.$totalPartida.'|'.$data->ID .'|'.$con++.'|'.$doc.'|'.$data->PROD .'|'.$data->COSTO .'|'.$data->CANTI .'|'.$data->REST.'|'.$data->FECHAREC; ?>" name="seleccion[]" class="Selct" /></div>
                                            </td>
                                            <td><?php echo $data->LIBERACIONES?></td>
                                            <td><?php echo $data->URGENTE?></td>
                                            <td><?php echo $data->COTIZA;?><input type="hidden" name="CVE_DOC" value="<?php echo $data->COTIZA;?>"/></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->FECHA_AUTO;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data ->REST;?><input type="hidden" name="RESTTXT" id="rest_<?php echo $data->ID;?>" value="<?php echo $data->REST;?>"/></td>

                                            <td><input type="text" value="<?php echo $data->CANTI;?>" name="cantidad"  disabled="disabled" id="cantidad_<?php echo $data->ID;?>" size="5"/></td>
                                             
                                             <td><input type="text" value="<?php echo ($data->COSTO);?>" name="costoupdate" disabled="disabled" id="costoupdate_<?php echo $data->ID;?>" size="5" />
                                            <input type="hidden" value="<?php echo $data->COSTO_MAXIMO?>" name="COSTMAX" id="maximo_<?php echo $data->ID;?>"  />
                                            </td>
                                            <td><?php echo '$ '.number_format($data->COSTO * 0.16,2)?></td>
                                            <td><?php echo '$ '.number_format(($data->COSTO * 1.16),2)?></td>
                                           
                                            
                                            <td style="color:#fff;"><input style="color:#000;" type="text" name="prove" id="prove_<?php echo $data->ID;?>" value="<?php echo $data->PROVE;?>" disabled="disabled" size="5"/> <input type="hidden" name="PROVEEDORCUENTA[]" id="PROVEEDORCUENTA" value="<?php echo $data->PROVE;?>"/><input type="hidden" name="prove2"  value="<?php echo $data->PROVE;?>" /><?php echo $data->PROVE;?></td>  
                                            <td><?php echo $data->NOM_PROV;?></td>          
                                            <td><?php echo number_format(($data->COSTO * 1.16) * $data->CANTI,2 , '.', ',');?></td>
                                            <input type="hidden" name="TOTALTXT" value="<?php echo $data->TOTAL;?>"/>
                                            
                                            <td>
                                            <input type="text" name="tiempoEntrega" class="date" value="<?php echo $data->FECHAREC?>" disabled="disabled" id="fe_<?php echo $data->ID?>" >
                                            </td>
                                            
                                            <td><a href="javascript:activarEditar('<?php echo $data->ID;?>');" style="color:#245269;"><div class="glyphicon glyphicon-pencil" id="lapiz_<?php echo $data->ID;?>"></div><div class="glyphicon glyphicon-floppy-disk" id="disco_<?php echo $data->ID;?>" style="display:none;"></div> </a></td>
                                            <!--<td> 
                                            	<center><a href="index.php?action=nosuministrable&idpedido=<?php echo $data->ID;?>" class="btn btn-warning" role="button">No Suministrable</a></center>
                                            </td>-->
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <center>
                                 <input type="button" value="Generar orden de Compra"  name="enviar" id="GOC" class="btn btn-info" onclick="ocultar()" ></center>
                                </form>
                             <!--   <form name="nosumini" id="nosumini" action="index.php" method="post"></form> -->
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

function ocultar(){
    document.getElementById('GOC').classList.add('hide');
}

$(document).ready(function() {
    $(".date").datepicker({dateFormat: 'dd.mm.yy'});
  } );

$("#GOC").click(function() {
    if($(".Selct").is(":checked")){
        document.frmOrdCom.submit();
    }else{
        OpenWarning("Seleccione al menos una Orden de Compra");
    }
});

$("#marcarTodo").change(function () {
    if ($(this).is(':checked')) {
        $("#seleccionHabilitados input[type=checkbox]").prop('checked', true); 
    } else {
        $("#seleccionHabilitados input[type=checkbox]").prop('checked', false);
    }
});

function activarEditar(id){
    var band=$("#lapiz_"+id).attr("style");
    
    $("#costoupdate_"+id).attr("disabled",false);
    $("#prove_"+id).attr("disabled",false);
    $("#cantidad_"+id).attr("disabled",false);
    $("#lapiz_"+id).attr("style","display:none");
    $("#disco_"+id).attr("style","display:block");
    $("#fe_"+id).attr("disabled",false);

    if(band=="display:none"){
        var costo=$("#costoupdate_"+id).val();
        var prove=$("#prove_"+id).val();
        var provcostid=id;
        var cantidad=$("#cantidad_"+id).val();
        var rest=$("#rest_"+id).val();
        var cmax=$("#maximo_"+id).val();
        var total = cantidad * costo;
        var fe=$("#fe_"+id).val(); /// Fecha de entrega.

        COSTO = costo.replace(/^\s*|\s*$/g, ""); 
        PROVE = prove.replace(/^\s*|\s*$/g, "");
        CANTIDA = cantidad.replace(/^\s*|\s*$/g, "");  
        cmax = (cmax * 1.16) +  (cmax * 1.16 * .05);

        if(parseFloat(cmax) < parseFloat(costo)){
            OpenWarning("Usted intenta comprar a un costo mas alto del permitido, el costo Maximo para este producto es de: $" + cmax);
            costo.focus();
            return false;
        }   
        if(parseFloat(cantidad) > parseFloat(rest)){
             OpenWarning("Cantidad capturada excede el faltante");
             cantidad.focus();
            return false;
        }
        if(parseFloat(cantidad) <= 0){
            OpenWarning("La cantidad no puede ser igual o menor a 0 ");
            cantidad.focus();
            return false;
        }
        if(COSTO.length == 0){
            OpenWarning("Capture Costo");
            costo.focus();
            return false;
        }
        if(PROVE.length == 0){
            OpenWarning("Capture Provedor");
            prove.focus();
            return false;
        }
        if(CANTIDA.length == 0 ){
            OpenWarning("Capture Cantidad mal");
            cantidad.focus();
            return false;
        }
        if(COSTO.length != 0 && PROVE.length != 0 && CANTIDA.length != 0){
            $.ajax({
               type: 'GET',
               url: 'index.php',
               data: 'action=preocVerificaProv&provedorr='+prove,   
               success: function(data){
                    var d=data;
                    var res = d.split("|");
                    //OpenWarning('la fecha enviada es : '+ fe);
                    if(res[0]=="existe"){
                            //SE ACTUALIZA EL REGISTRO
                            var nomProvedor=res[1];
                            $.ajax({
                               type: 'GET',
                               url: 'index.php',
                               data: 'action=preocAct&costo='+costo+'&provedor='+prove+'&provcostid='+provcostid+'&total='+total+'&nombreprovedor='+nomProvedor+'&cantidad='+cantidad+'&rest='+rest+'&fe='+fe,   
                               success: function(data){
                                  if(data=="ok"){
                                        OpenSuccess("El Registro se Actualizo correctamente");
                                  }else{
                                        OpenWarning("No se pudo actualizar, intente mas tarde");
                                  }
                                 
                               }
                            });
                    }else{
                        OpenWarning("Verifica el Proveedor, NO existe");
                        return false;

                    }
                 
                }
            });
            
        }

        $("#costoupdate_"+id).attr("disabled",true);
        $("#prove_"+id).attr("disabled",true);
        $("#cantidad_"+id).attr("disabled",true);
    
        $("#lapiz_"+id).attr("style","display:block");
        $("#disco_"+id).attr("style","display:none");
 
    }
}

function OpenWarning(mensaje) {
                var mensaje = mensaje || "Algo no salió como se esperaba...";
                bootbox.dialog({
                    message: mensaje,
                    title: "<i class=\"fa fa-warning warning\"></i>",
                    className: "modal modal-message modal-warning fade",
                    buttons: {
                        "OK": {
                            className: "btn btn-warning",
                            callback: function () {
                            }
                        }
                    }
                });
}

function OpenSuccess(mensaje) {
                var mensaje = mensaje || "Todo bien...";
                bootbox.dialog({
                    message: mensaje,
                    title: "<i class=\"fa fa-check success\"></i>",
                    className: "modal modal-message modal-success fade",
                    buttons: {
                        "OK": {
                            className: "btn btn-success",
                            callback: function () {
                                 window.location="index.php?action=ordcomp";
                            }
                        }
                    }
                });
}
</script>