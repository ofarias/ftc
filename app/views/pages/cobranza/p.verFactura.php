<style type="text/css">
input[type=number] {
   width: 50px;
}
input[type=text]{
    width: 100px;
}

</style>
    
<?php foreach ($factura as $key) {
    $mp = $key->METODO_PAGO;
    $fp = $key->FORMADEPAGOSAT;
    $uso = $key->USO_CFDI;
    $cliente = $key->CLIENTE;
    $nombre = $key->NOMBRE_CLIENTE;
    $uuid =$key->UUID;
    $documento = $key->DOCUMENTO;
    $status = (empty($key->UUID)? 'OK':'Timbrada');
}
?>
<br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                  Detalle de la Factura. <font size="4pxs"><?php echo $documento?></font>
                    <?php if($status == 'Timbrada'){?>
                    <h3><?php echo $status.' UUID: '.$uuid; ?></h3>
                    <font size="8pxs" color="red">No se pueden modificar facturas timbradas, favor de revisar la informacion.</font>
                    <?php } ?>
            </div>
            <div class="panel-body">
                 <div class="table-responsive">                            
                        <table class="table table-bordered" >
                            <thead>

                                <tr>
                                    Cliente: <input type="text" name="cliente" value="<?php echo $cliente?>" id="cveclie" >&nbsp;&nbsp;<?php echo $nombre?>
                                    <br/>
                                    <br/>
                                    Uso: <input type="text" name="uso" value="<?php echo $uso?>" id="suso"> &nbsp;&nbsp;Metodo de Pago <input type="text" name="mp" value="<?php echo $mp?>" id="smp">&nbsp;&nbsp;Forma de Pago: <input type="text" name="fp" value="<?php echo $fp?>" id="sfp">
                                    <br/>
                                    -
                                </tr>
                                <tr>
                                <th>Factura</th>
                                <th>Ln</th>
                                <th>Descripcion</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                                <th>Clave SAT</th>
                                <th>Unidad SAT</th>
                                <th>Revisado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0;
                                  $i =0;
                                  $subtotal = 0;
                                  $subTotal = 0;
                                  $descTotal = 0;
                                  $iva = 0;
                            foreach($factura as $doc):
                                $i++;
                                $id=substr($doc->CVE_ART, 3);
                                $a='<select name="unisat" class="unisat"  prod="'.$doc->CVE_ART.'" idp="'.$id.'" orig="'.$doc->UNIDAD_SAT.'" id="ln_'.$id.'">
                                                <option value="a">'.$doc->UNIDAD_SAT.'</option>
                                                <option value="H87">Pieza "H87" </option>
                                                <option value="ACT">Actividad "ACT"</option>
                                                <option value="MTR">Metro "MTR"</option>
                                                <option value="STL">Litro estandar "STL"</option>
                                                <option value="LTR">Litro "LTR"</option>
                                                <option value="EA">Elemento "EA"</option>
                                                </select>';
                                $color="";
                                $cantidad = $doc->CANT;
                                $precio = $doc->PREC;
                                $desc1 = $doc->DESC1;
                                $subtotal = ($cantidad * $precio) - $desc1;
                                $subTotal += $subtotal;
                                $descTotal += $desc1;
                                $iva += ($subtotal*.16);
                                $total += $subtotal - $descTotal + $iva

                            ?>
                                    <tr class="odd gradeX" <?php echo $color?> id="ln_<?php echo $i?>" > 
                                        <td><?php echo $doc->CVE_DOC?></td>
                                        <td><?php echo  $doc->NUM_PAR?></td>
                                        <td><?php echo $doc->NOMBRE?></td>                                    
                                        <td><?php echo $doc->CVE_ART;?></td>
                                        
                                        <td><?php echo $doc->CANT?><br/>
                                            <input type="number" name="cant" id="c_<?php echo $doc->NUM_PAR?>" step="any" lnc="<?php echo $doc->NUM_PAR?>" prod="<?php echo $doc->CVE_ART?>" class="cantidad" <?php echo (empty($doc->UUID))? '':'readonly'?> ></td>
                                        
                                        <td><?php echo $doc->PREC?><br/>
                                            <input type="number" name="prec" id="p_<?php echo $doc->NUM_PAR?>" step="any" lnc="<?php echo $doc->NUM_PAR?>" prod="<?php echo $doc->CVE_ART?>" def="<?php echo $doc->PREC?>" class="precio"  <?php echo (empty($doc->UUID))? '':'readonly'?>></td>
                                        
                                        <td><?php echo $doc->DESC1?><br/>
                                            <input type="number" name="desc" id="d_<?php echo $doc->NUM_PAR?>" step="any" lnc="<?php echo $doc->NUM_PAR?>" prod="<?php echo $doc->CVE_ART?>" def="<?php echo $doc->DESC1?>" class="descuento"  <?php echo (empty($doc->UUID))? '':'readonly'?>></td>
                                        
                                        <td align="right" id="sub_<?php echo $i?>"  width="100"><?php echo '$ '.number_format($subtotal,2)?>
                                            <br/><label id="subtotal_<?php echo $doc->NUM_PAR?>"  <?php echo (empty($doc->UUID))? '':'readonly'?>></label>
                                        </td>
                                        <td><input type="text" name="cvesat" value="<?php echo $doc->CVE_SAT;?>"  class="cvesat1" 
                                        value="<?php echo $doc->CVE_ART;?>" prod="<?php echo $doc->CVE_ART?>" idp="<?php echo $id?>" orig="<?php echo $data->CVE_SAT?>" id="ln_<?php echo $id?>"  <?php echo (empty($doc->UUID))? '':'readonly'?>></td>
                                        <td><?php echo $a?></td>
                                        <td><input type="checkbox" name="revision" id="<?php echo $i?>" value="<?php echo $i?>" onclick="marcar(this.value)"  <?php echo (empty($doc->UUID))? '':'readonly'?>></td>
                                    </tr> 
                            <?php endforeach;?>
                        </tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>SubTotal por Cobrar: </b></td>
                                        <td align="right"><font size="3pxs" color="blue"><b><?php echo '$ '.number_format($subTotal,2)?></font></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>Descuento : </b></td>
                                        <td align="right"><font size="3pxs" color="blue"><b><?php echo '$ '.number_format($descTotal,2)?></font></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>IVA: </b></td>
                                        <td align="right"><font size="3pxs" color="blue"><b><?php echo '$ '.number_format($iva,2)?></font></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total: </b></td>
                                        <td align="right"><font size="3pxs" color="blue"><b><?php echo '$ '.number_format($total,2)?></font></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                    </table>
                    <?php if($status=='OK'){?>
                    <a class="btn btn-info actualizar" > Actualizar </a>
                    <a class="btn btn-success timbrar">Timbrar</a> <input type="checkbox" name="prueba" id="test"> Prueba?
                    <?php }else{?>
                        <font size="8pxs" color="red">No se pueden modificar facturas timbradas, favor de revisar la informacion.</font>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

    var docf = "<?php echo $docf?>";
    $(".actualizar").click(function(){
        $(".cantidad").each(function(){
            var par = $(this).attr('lnc');
            var nprecio = document.getElementById("p_"+par).value;
            var ncantidad = document.getElementById("c_"+par).value;
            var ndescuento = document.getElementById("d_"+par).value;
            var mp = document.getElementById("smp").value;
            var fp = document.getElementById("sfp").value;
            var uso = document.getElementById("suso").value;
            var clie = document.getElementById("cveclie").value;
            //alert("cant" + ncantidad + " precio " + nprecio + "descuento" + ndescuento);
            $.ajax({
                url:'index.v.php',
                type:'post',
                dataType:'json',
                data:{actPartida:docf, par, nprecio, ncantidad, ndescuento, mp, fp, uso, clie},
                success:function(data){
                    if(data.status=='OK'){
                        if(confirm(data.mensaje)){
                             location.reload();     
                        }     
                    }else{
                        //location.reload();
                    } 
                },
                error:function(data){
                    alert('algo salio mal y no se pudo actualiza');
                    location.reload();
                }
            })
        })
    })


    $(".timbrar").click(function(){
        var tipo = document.getElementById('test');
        if(tipo.checked){
            var tipo ='t';
        }else{
            var tipo ='p';
        }
        if(confirm("Ya revisaste los datos fiscales, el nombre del cliente y los montos son los correctos?")){
            $.ajax({
                url:'index.php',
                type:'post',
                dataType:'json',
                data:{generaJson:1, docf, caja:tipo},
                success:function(){
                    alert('Revise si se timbro la factura por favor');
                }
            })
        }
    })

    $(".cantidad").change(function(){
        var par = $(this).attr('lnc');
        var prod = $(this).attr('prod');
        var cantidad = $(this).val();
        var nprecio = document.getElementById("p_"+par).value;
        var precio = document.getElementById("p_"+par).getAttribute('def');
        var ndescuento = document.getElementById("d_"+par).value;
        var descuento = document.getElementById("d_"+par).getAttribute('def');
        if(nprecio == null || nprecio ==""){
        }else{
            precio = nprecio;
        }   
        if(ndescuento == null|| ndescuento == ""){
        }else{
            descuento = ndescuento;
        }
        var ns = (cantidad * precio) - descuento;
        document.getElementById('subtotal_' + par).innerHTML="<font color='red'>"+ns+"</font>";
        //alert ('Precio default'+ precio + 'Nuevo Precio' + nprecio);
    })

    $(".precio").change(function(){
        var par = $(this).attr('lnc');
        var prod = $(this).attr('prod');
        var precio = $(this).val();
        var ncantidad = document.getElementById("c_"+par).value;
        var cantidad = document.getElementById("c_"+par).getAttribute('def');
        var ndescuento = document.getElementById("d_"+par).value;
        var descuento = document.getElementById("d_"+par).getAttribute('def');
        if(ncantidad == null || ncantidad ==""){
        }else{
            cantidad = ncantidad;
        }   
        if(ndescuento == null|| ndescuento == ""){
        }else{
            descuento = ndescuento;
        }
        var ns = (cantidad * precio) - descuento;
        document.getElementById('subtotal_' + par).innerHTML="<font color='red'>"+ns+"</font>";
        //alert ('Precio default'+ precio + 'Nuevo Precio' + nprecio);
    })

    $(".descuento").change(function(){
        var par = $(this).attr('lnc');
        var prod = $(this).attr('prod');
        var descuento = $(this).val();
        var nprecio = document.getElementById("p_"+par).value;
        var precio = document.getElementById("p_"+par).getAttribute('def');
        var ncantidad = document.getElementById("c_"+par).value;
        var cantidad = document.getElementById("c_"+par).getAttribute('def');
        if(nprecio == null || nprecio ==""){
        }else{
            precio = nprecio;
        }   
        if(ncantidad == null|| ncantidad == ""){
        }else{
            cantidad = ncantidad;
        }
        var ns = (cantidad * precio) - descuento;
        document.getElementById('subtotal_' + par).innerHTML="<font color='red'>"+ns+"</font>";
        //alert ('Precio default'+ precio + 'Nuevo Precio' + nprecio);
    })


    function marcar(ln){
        var renglon = document.getElementById("ln_"+ln);
        var chek = document.getElementById(ln);
        if(chek.checked){
            renglon.style.background="#99ccff";         
        }else{
            renglon.style.background="white";
        }
    }

    $(".cvesat1").autocomplete({
            source: "index.php?cvesat=1",
            minLength: 3,
            select: function(event, ui){
            }
        })

    $("select.unisat").change(function(){
            var nuni = $(this).val();
            var prod = $(this).attr('prod');
            var nvacve = '';
            var idpreoc = $(this).attr('idp');
            var cveact = $(this).attr('orig');
            if(nuni == 'a'){
                alert('Seleccione un valor');        
            }else{
                $.ajax({
                    url:'index.php',
                    type:'POST',
                    dataType:'json',
                    data:{gcvesat:prod,cvesat:nvacve,idpreoc:idpreoc,nuni:nuni,tipo:'uni'},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert('Se actualizo el producto, ahora ya se puede facturar');
                            location.reload(true)
                        }else{
                            alert(data.mensaje);
                            document.getElementById('ln_'+idpreoc).value=cveact;
                        }
                    }
                });
            }
        })

    $("input.cvesat1").change(function(){
            var nuni = '';
            var prod = $(this).attr('prod');
            var nvacve = $(this).val();
            var idpreoc = $(this).attr('idp');
            var cveact = $(this).attr('orig');
            if(confirm('Desea asignar el codigo del SAT: '+ nvacve +', al producto: ' + prod)){   
                $.ajax({
                    url:'index.php',
                    type:'POST',
                    dataType:'json',
                    data:{gcvesat:prod,cvesat:nvacve,idpreoc:idpreoc, nuni:nuni, tipo:'cve'},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert('Se actualizo el producto, ahora ya se puede facturar');
                            location.reload(true)
                        }else{
                            alert(data.mensaje);
                            document.getElementById('ln_'+idpreoc).value=cveact;
                        }
                    }
                });
            }else{
                document.getElementById('ln_'+idpreoc).value='';
            }
    })


</script>
