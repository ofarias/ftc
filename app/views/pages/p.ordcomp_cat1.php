<br /><br />
<?php  
    if(isset($_REQUEST->ok)){
        echo 'Se guardo la orden';
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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>
                                            <th>PEDIDO</th>
                                            <!--<th>PARTIDA</th>-->
                                            <th>FECHA</th>
                                            <th>ARTICULO</th>
                                            <th>DESCRIPCION</th>
											<th>REST</th>
                                            <th>CANTIDAD</th>
                                            <th>COSTO</th>
                                            <th>PROVEEDOR</th>
                                            <th>NOMBRE</th>
                                            <th>TOTAL</th>
                                            <th>DOC ORIGEN</th>
                                            <th>EDITAR</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                       // var_dump($exec); 
                                        $con=1;
                                        foreach ($exec as $data):
                                        $dc=$data->COTIZA; 
                                        $dos=substr($dc, 1);
                                        $doc='O'.$dos;
                                        $totalPartida= $data->CANTI * $data->COSTO;
                                        $color=$data->URGENTE=='U'?"style='background-color:red;'":"";         
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><div id="seleccionHabilitados"><input type="checkbox" value="<?php echo $data->PROVE.'|'.$doc.'|'.$totalPartida.'|'.$data->ID.'|'.$con++.'|'.$doc.'|'.$data->PROD.'|'.$data->COSTO.'|'.$data->CANTI.'|'.$data->REST; ?>" name="seleccion[]" class="Selct" /></div></td>
                                            <td><?php echo $data->COTIZA;?><input type="hidden" name="CVE_DOC" value="<?php echo $data->COTIZA;?>"/></td>
                                            <!-- <td><?php echo $data->PAR;?></td> -->
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
											<td><?php echo $data->REST;?><input type="hidden" name="RESTTXT" id="rest_<?php echo $data->ID;?>" value="<?php echo $data->REST;?>"/></td>
                                            <!--<td><?php echo $data->CANTI;?><input type="hidden" value="<?php echo $data->CANTI;?>" name="cantidad"  id="cantidad_<?php echo $data->ID;?>" /></td>-->
                                            <td><input type="text" value="<?php echo $data->CANTI;?>" name="cantidad"  disabled="disabled" id="cantidad_<?php echo $data->ID;?>" size="5"/></td>
                                            <td><input type="text" value="<?php echo $data->COSTO;?>" name="costoupdate" disabled="disabled" id="costoupdate_<?php echo $data->ID;?>" size="5" /></td>
                                            <td><input type="text" name="prove" id="prove_<?php echo $data->ID;?>" value="<?php echo $data->PROVE;?>" disabled="disabled" size="5"/> <input type="hidden" name="PROVEEDORCUENTA[]" id="PROVEEDORCUENTA" value="<?php echo $data->prove;?>"/><input type="hidden" name="prove2"  value="<?php echo $data->PROVE;?>" /></td>     
                                            <td><?php echo $data->NOM_PROV;?></td>          
                                            <td><?php echo $data->TOTAL;?><input type="hidden" name="TOTALTXT" value="<?php echo $data->TOTAL;?>"/></td>
                                             <td><?php echo $data->DOCORIGEN;?></td>
                                            <td><a href="javascript:activarEditar('<?php echo $data->ID;?>');" style="color:#245269;"><div class="glyphicon glyphicon-pencil" id="lapiz_<?php echo $data->ID;?>"></div><div class="glyphicon glyphicon-floppy-disk" id="disco_<?php echo $data->ID;?>" style="display:none;"></div> </a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <center><!--<input type="button" value="Generar orden de Compra" id="GOC2" name="enviar" class="btn btn-info">-->
                                 <input type="button" value="Generar orden de Compra"  name="enviar" id="GOC" class="btn btn-info"></center>
                                </form>
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
$("#GOC").click(function() {
    if($(".Selct").is(":checked")){
        document.frmOrdCom.submit();
//OpenWarning("Estamos trabajando en esta seccion");
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

    if(band=="display:none"){
        var costo=$("#costoupdate_"+id).val();
        var prove=$("#prove_"+id).val();

        var provcostid=id;
        var cantidad=$("#cantidad_"+id).val();
        var rest=$("#rest_"+id).val();
        var total = cantidad * costo;
        COSTO = costo.replace(/^\s*|\s*$/g, ""); 
        PROVE = prove.replace(/^\s*|\s*$/g, "");
        CANTIDA = cantidad.replace(/^\s*|\s*$/g, "");  
            
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
        if(CANTIDA.length == 0){
            OpenWarning("Capture Cantidad");
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
                    
                    if(res[0]=="existe"){
                            //SE ACTUALIZA EL REGISTRO
                            var nomProvedor=res[1];
                            $.ajax({
                               type: 'GET',
                               url: 'index.php',
                               data: 'action=preocAct&costo='+costo+'&provedor='+prove+'&provcostid='+provcostid+'&total='+total+'&nombreprovedor='+nomProvedor+'&cantidad='+cantidad+'&rest='+rest,   
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