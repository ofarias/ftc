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
                            <input type="hidden" value="" name="preOrdenDeCompra"/> <!-- Asi se llama en el Index -->
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>
                                            <th>U</th>
                                            <th>PEDIDO</th>
                                            <th>FECHA PEDIDO</th>
                                            <th>FECHA LIBERACION</th>
                                            <th>CLAVE ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UM</th>
                                            <th>CANT <br/> ORIG</th>
                                            <th>FALTANTE</th>
                                            <th>CANTIDAD A SOLICITAR</th>
                                            <th>COSTO</th>
                                            <!--
                                            <th>CLAVE PROVEEDOR</th>
                                            -->
                                            <th>NOMBRE PROVEEDOR</th>
                                            <th>TOTAL</th> 
                                            <!--
                                            <th>EDITAR</th>
                                            -->
                                            <th>MODIFICAR ESTADO</th>
                                        </tr>
                                    </thead>   
                                    <tfoot>
                                        <tr>
                                            <th colspan="11" style="text-align:right"> </th>
                                            <th>   </th>
                                            <th> SubTotal: </th>
                                            <th> <div id="subtotal_check">0.00</div></th>
                                        </tr>
                                        <tr>
                                            <th colspan="11" style="text-align:right">  </th>
                                            <th>   </th>
                                            <th> IVA : </th>
                                            <th>  <div id="iva_check">0.00</div> </th>
                                        </tr>
                                        <tr>
                                            <th colspan="11" style="text-align:right">  </th>
                                            <th>   </th>
                                            <th> TOTAL : </th>
                                            <th>  <div id="totales_check">0.00</div> </th>
                                        </tr>
                                    </tfoot>
                                  <tbody>
                                        <?php
                                        $con=1;
                                        foreach ($exec as $data):
                                        //$dc=$data->COTIZA; 
                                        //$dos=substr($dc, 1);
                                        //$doc='O'.$dos;
                                        //$totalPartida= $data->CANTI * $data->COSTO;
                                            $TOTAL = ($data->CANTI * $data->COSTO);
                                            
                                        $color=$data->URGENTE =='U'?"style='background-color:red;'":"";         
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><div id="seleccionHabilitados">
                                                
                                                <input type='checkbox' value="<?php echo $idprov .'|'.$data->ID .'|'.$data->PROD .'|'.$data->COSTO .'|'.$data->CANTI .'|'.$data->REST.'|'.$data->COTIZA; ?>" name="seleccion[]" class="Selct" monto="<?php echo ($TOTAL * 1.16)?>" 
                                                    <?php echo $data->COSTO <= 0? 'onclick="sinCosto()"':''?>

                                                    
                                                /></div>

                                                </td>
                                            <td><?php echo $data->URGENTE?></td>
                                            <td><?php echo $data->COTIZA;?><input type="hidden" name="CVE_DOC" value="<?php echo $data->COTIZA;?>"/></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->FECHA_AUTO;?></td>
                                            <td onClick="test1()" ><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data ->REST;?>  <input type="hidden" name="rest" id="rest_<?php echo $data->ID;?>" value="<?php echo $data->REST;?>"/></td>
                                            <input type="hidden" name="idpreoc" id="preoc_<?php echo $data->ID?>" value='<?php echo $data->ID?>'>
                                            <td>
                                                <input type="number" step="any" min="0" value="<?php echo $data->CANTI;?>" name="cantidad"  id="cantidad_<?php echo $data->ID;?>" size="5" 
                                            onChange="validaCant(this.value, rest_<?php echo $data->ID;?>.value, preoc_<?php echo $data->ID?>.value, prove_<?php echo $data->ID;?>.value )" /></td>

                                            <td><input type="text" value="<?php echo $data->COSTO;?>" name="costoupdate" disabled="disabled" id="costoupdate_<?php echo $data->ID;?>" size="5" />
                                            <input type="hidden" value="<?php echo $data->COSTO_MAXIMO?>" name="COSTMAX" id="maximo_<?php echo $data->ID;?>"  />
                                            </td>
                                            <!--   Cambio de proveedor
                                            <td style="color:#fff;">-->
                                            <input type="hidden" name="prove" id="prove_<?php echo $data->ID;?>" value="<?php echo $data->PROVE;?>" />   
                                            <td><?php echo $data->NOMBRE;?></td>         
                                            <td> <?php echo number_format($TOTAL,2 , '.', ',');?></td>
                                            <!--<input type="hidden" name="TOTALTXT" value="<?php echo $data->TOTAL;?>"/> -->
                                            <!-- Edicion 
                                            <td><a href="javascript:activarEditar('<?php echo $data->ID;?>');" style="color:#245269;"><div class="glyphicon glyphicon-pencil" id="lapiz_<?php echo $data->ID;?>"></div><div class="glyphicon glyphicon-floppy-disk" id="disco_<?php echo $data->ID;?>" style="display:none;"></div> </a></td>
                                            -->
                                            <!--
                                            <td> 
                                            	<center><a href="index.php?action=nosuministrable&idpedido=<?php echo $data->ID;?>" class="btn btn-warning" role="button">No Suministrable</a></center>
                                            </td>
                                            -->
                                            <form action="index.php" method="post" id="name">
                                                <input type="hidden" name="ida" value="Articulo">
                                                <input type="hidden" name="cotiza" value="cotizacion">
                                            <td>
                                                <button name="cambiarProv" type="submit" value="enviar" form="name"  >Cambiar Proveedor</button>
                                            </td>
                                            </form>

                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <center>
                                <br/>
                                 <input type="button" value="Generar orden de Compra"  name="enviar" id="GOC" class="btn btn-info" onclick="ocultar()"></center>
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

function sinCosto(){
    alert("EL PRODUCTO NO TIENE COSTO, FAVOR DE SOLICITAR A COSTOS. GRACIAS");

}

function ocultar(){
    document.getElementById('GOC').classList.add('hide');
}

$("#GOC").click(function() {
    if($(".Selct").is(":checked")){
        document.frmOrdCom.submit();
//OpenWarning("Estamos trabajando en esta seccion");
    }else{
        OpenWarning("Seleccione al menos una Partida");
    }
});

$("#marcarTodo").change(function () {
    if ($(this).is(':checked')) {
        $("#seleccionHabilitados input[type=checkbox]").prop('checked', true); 

    } else {
        $("#seleccionHabilitados input[type=checkbox]").prop('checked', false);
    }
});

    var tot = parseFloat("0");
    var seleccionados = parseInt("0");  
    $("input[type=checkbox]").on("click", function(){

       
        var monto = $(this).attr("monto");
        //monto = monto.replace("$", "");
        //monto = monto.replace(",", "");     
        monto = parseFloat(monto);        
        if(this.checked){
           
            tot+=monto;
          
          } else {
            tot-=monto;
        }
        //alert("Total: "+total);
        t = parseFloat(tot).toFixed(2);
        $("#totales_check").text(t);
        st = parseFloat(t / 1.16).toFixed(2);
        $("#subtotal_check").text(st);
        iva  = parseFloat(t-(t /1.16)).toFixed(2);
        $("#iva_check").text(iva)
        seleccionados = $("input:checked").length;
        $("#seleccion_cr").val(seleccionados);
        $("#total").val(tot); 
    });





function validaCant(a,b,c,d){
    //alert('Esta Cambiando:' + this + 'por'+ rest);
    var cantn = parseFloat(a);
    var cantm = parseFloat(b);
    alert('Nueva Cantidad: ' + cantn + ' Cantidad Maxima: '+ cantm + 'preoc valor' + c + ' Clave proveedor:' + d);
    
    if(cantn > cantm ){
        document.getElementById("cantidad_"+c).value=cantm;
        OpenWarning("Cantidad capturada excede el faltante");
        document.getElementById("cantidad_"+c).focus();
        return false;
    }else{

         $.ajax({
            type: 'GET',
            url: 'index.php',
            data: 'action=actualizaCanti&cantnu='+a+'&idpreoc='+c+'&idprov='+d,   
            success: function(data){
                    if(data=="ok"){
                                        OpenSuccess("Se cambio la cantidad, por seguridad la cantidad restante  se pasara a la gerencia de compra hasta realizar la Orden de compra actual....",d);
                                  }else{
                                        OpenWarning("No se pudo actualizar, intente mas tarde");
                                  } 
                               }
        });
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

function OpenSuccess(mensaje,d) {
                var mensaje = mensaje || "Todo bien...";
                bootbox.dialog({
                    message: mensaje,
                    title: "<i class=\"fa fa-check success\"></i>",
                    className: "modal modal-message modal-success fade",
                    buttons: {
                        "OK": {
                            className: "btn btn-success",
                            callback: function () {
                                 window.location="index.php?action=verCanasta&idprov=" + d;
                            }
                        }
                    }
                });
}
</script>