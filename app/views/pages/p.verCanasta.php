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
                        <?php echo 'Usuario: '.$user.'<br/>Gerente: '.$gerencia?>
                           <div class="panel-body">
                            <div class="table-responsive">
                            <form id="frmOrdCom" name="frmOrdCom" action="index.php" method="POST">
                            <input type="hidden" value="" name="preOrdenDeCompra"/> <!-- Asi se llama en el Index -->
                                <table class="table table-striped table-bordered table-hover" width="100%" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>
                                           
                                            <th>PEDIDO</th>
                                            <th>FECHA <br/>PEDIDO</th>
                                            <th>FECHA <br/> LIBERACION</th>
                                            <th>CLAVE <br/>ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UM</th>
                                            <th>CANT <br/> ORIG</th>
                                            <th>FALTA</th>
                                            <th>CANTIDAD A <br/> SOLICITAR</th>
                                            <th>COSTO</th>
                                            <th>NOMBRE PROVEEDOR
                                                <?php if($user =='Gerencia de Compras' or $gerencia == 'Si'){?>
                                                    <br/> <font color="red">Responsable</font>
                                                <?php }?></th>
                                            <th>TOTAL</th> 

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
                                            <th colspan="11" style="text-align:right"> </th>
                                            <th>   </th>
                                            <th> Descuento: </th>
                                            <th> <div id="Descuento_check">0.00</div></th>
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
                                            $TOTAL = ($data->CANTI * $data->COSTO_ART);
                                            $DESCUENTO = ($data->DESC1A + $data->DESC2A + $data->DESC3A) * $data->CANTI;
                                            $color="";         
                                            $res = '';
                                            $ca=0;
                                            foreach ($historial as $key) {
                                                if($key->IDPREOC == $data->ID){
                                                    $texto = 'Proveedor original ('.$key->CVE_PROV_ORIG.')'.$key->NOMBRE_PROV_ORIG.', provedor nuevo: ('.$key->CVE_NUEVO_PROV.')'.$key->NOMBRE_NUEVO_PROV.' Fecha Cambio:'.$key->FECHA_CAMBIA.'--->';
                                                    $res = $res.$texto;
                                                    $ca = $ca+1;
                                                }
                                            }

                                            if ($ca == 1){
                                                $color = "style='background-color:#d6eaf8'";
                                            }elseif($ca == 2 ){
                                                $color = "style= 'background-color:#7fb3d5'";
                                            }elseif ($ca ==3) {
                                                $color = "style= 'background-color:#2874a6'";
                                            }elseif($ca >= 4){
                                                $color = "style= 'background-color: #af7ac5'";
                                            }
                                        ?>
                                        <tr class="odd gradeX" <?php echo $color;?> title="<?php echo $res?>">
                                            <td><div id="seleccionHabilitados">
                                                <input type='checkbox' value="<?php echo $idprov .'|'.$data->ID .'|'.$data->PROD .'|'.$data->COSTO_ART .'|'.$data->CANTI .'|'.$data->REST.'|'.$data->COTIZA.'|'.$DESCUENTO;?>" name="seleccion[]" class="Selct" monto="<?php echo ($TOTAL * 1.16)?>" desc1="<?php echo $DESCUENTO?>"
                                                    <?php echo $data->COSTO_ART <= 0? 'onclick="sinCosto(this.id)"':''?> 
                                                    id="id_<?php echo $data->ID?>"    
                                                    
                                                /></div>
                                                </td>
                                       
                                            <td><?php echo $data->COTIZA;?><input type="hidden" name="CVE_DOC" value="<?php echo $data->COTIZA;?>"/></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->FECHA_AUTO;?></td>
                                            <td onClick="test1()" ><?php echo $data->PROD;?> </td>
                                            <td><?php echo $data->NOMPROD;?> <br/> <font color = "#1c2833" size ="2">
                                                Precio Lista: <?php echo '$ '.number_format($data->COSTO_ART,2)?>
                                                Desc1: <?PHP echo '$ '.number_format($data->DESC1A,2)?>
                                                Desc2: <?PHP echo '$ '.number_format($data->DESC2A,2)?>
                                                Desc3:<?PHP echo '$ '.number_format($data->DESC3A,2)?>  </font size ="2"> <br/> <font color="blue">
                                                subTotal <?php echo '$ '.number_format($data->COSTO_ART,2)?> 
                                                IVA <?php echo '$ '.number_format($data->IMPUESTO,2)?> 
                                                Total <?php echo '$ '.number_format($data->COSTO_T,2)?></font></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data ->REST;?>  <input type="hidden" name="rest" id="rest_<?php echo $data->ID;?>" value="<?php echo $data->REST;?>"/></td>
                                            <input type="hidden" name="idpreoc" id="preoc_<?php echo $data->ID?>" value='<?php echo $data->ID?>'>
                                            <td>
                                            <input type="text" step="any" min="0" value="<?php echo $data->CANTI;?>" name="cantidad"  id="cantidad_<?php echo $data->ID;?>" size="5" onChange="validaCant(this.value, rest_<?php echo $data->ID;?>.value, preoc_<?php echo $data->ID?>.value, prove_<?php echo $data->ID;?>.value )" />
                                            </td>
                                            <td><input type="text" value="<?php echo $data->COSTO_ART;?>" name="costoupdate" disabled="disabled" id="costoupdate_<?php echo $data->ID;?>" size="5" />
                                            <input type="hidden" value="<?php echo $data->COSTO_ART?>" name="COSTMAX" id="maximo_<?php echo $data->ID;?>"  />
                                            </td>
                                            <input type="hidden" name="prove" id="prove_<?php echo $data->ID;?>" value="<?php echo $data->PROVE;?>" />   
                                            <td><?php echo $data->NOMBRE;?>
                                                <?php if($user =='Gerencia de Compras' or $gerencia == 'Si'){?>
                                                    <br/> <font color="red"> <?php echo $data->RESPONSABLE?></font>
                                                <?php }?>
                                            </td>         
                                            <td> <?php echo number_format($TOTAL,2 , '.', ',');?></td>
                                            <td>
                                                <?php if($user == 'Gerencia de Compras' or $gerencia == 'G'){ ?>
                                                    <input type="button" name="cambiarProv" value="Cambiar Proveedor" onclick="aviso()">
                                                <?php }else{ ?>
                                                    <input type="button" name="cambiarProv" value="Cambiar Proveedor" onclick="cambiaProv(<?php echo $data->ID?>, '<?php echo htmlentities($data->NOMPROD)?>', <?php echo $data->CANTI?>)" >
                                                <?php }?>
                                            </td>

                                        </tr>

                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <center>
                                <br/>
                                <?php if($user == 'Gerencia de Compras' or $gerencia == 'G'){?>
                                <?php }else{?>
                                 <input type="button" value="Generar Pre Orden de Compra"  name="enviar" id="GOC" class="btn btn-info" onclick="ocultar()"></center>
                                <?php } ?>
                                </form>
                             <!--   <form name="nosumini" id="nosumini" action="index.php" method="post"></form> -->
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<form action="index.php" method="post" id="formCP">
     <input type="hidden" name="ida" value="" id="idpreoc">
     <input type="hidden" name="cant" value="" id="cant">
     <input type="hidden" name="origen" value="suministros">
     <input type="hidden" name="prov" value="">
     <input type="hidden" name="tipo" value="">
     <input type="hidden" name="cambiarProv" value="">
</form>


<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">


    function aviso(){
        alert('El gerente no puede realizar cambios, favor de revisarlos con el responsable.');
    }

    function cambiaProv(id, prod, canti){
        var confirmacion = confirm('Se solicitara el cambio de proveedor a Costos del producto: ' + prod );
        if (confirmacion == true){
            document.getElementById('idpreoc').value=id;
            document.getElementById('cant').value=canti;
            var formulario = document.getElementById('formCP');
            formulario.submit();           
        }
    }

function sinCosto(idsel){
    alert("EL PRODUCTO NO TIENE COSTO, FAVOR DE SOLICITAR A COSTOS. GRACIAS");
    document.getElementById(idsel).checked="";
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
    var desc1 = parseFloat("0");
    $("input[type=checkbox]").on("click", function(){
        var monto = $(this).attr("monto");
        var des1 = $(this).attr("desc1");
        monto = parseFloat(monto);        
        des1 = parseFloat(des1);
        if(this.checked){
            tot+=monto;
            desc1+=des1;
          } else {
            tot-=monto;
            desc1-=des1;
        }
        d = parseFloat(desc1).toFixed(2);
        t = parseFloat(tot).toFixed(2);
        st = parseFloat(t / 1.16).toFixed(2);
        std = st - d;
        iva  = parseFloat(std * .16).toFixed(2);
        t2= parseFloat(std * 1.16).toFixed(2);
        $("#subtotal_check").text(st);
        $("#Descuento_check").text(d);
        $("#iva_check").text(iva);
        $("#totales_check").text(t2);

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