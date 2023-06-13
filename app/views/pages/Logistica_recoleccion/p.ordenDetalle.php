<br/>
<style type="text/css">
    * { font-family:verdana;
font-size: 10px;}
</style>
<div>
    <font size="3pxs"><b><p>Proveedor: <?php echo '('.$orden->CVE_PROV.')'.$orden->NOMBRE ?></p></b></font>
    <font size="3pxs" ><p>RFC / Direccion: <font color="blue"><?php echo $orden->RFC.' -->'.$orden->CALLE.', '.$orden->NUMEXT.', '.$orden->COLONIA.', '.$orden->ESTADO.', '.$orden->CP?></font></p></font>
    <font size="3pxs" ><p>Orden de Compra: <font color="red"><?php echo $orden->OC.'</font> Fecha: <font color="red"> '.$orden->FECHA_OC.'</font>  Confirma Pegaso <font color="red"> '.$orden->USUARIO_OC.'</font>  Confirma Proveedor <font color="red"> '.$orden->CONFIRMADO?></font> </p></font>
    <input type="hidden" name="doco" id="oc" value="<?php echo $orden->OC?>">
</div>
    <div class="col-lg-12">
        <div class="panel panel-default">
           <div class="panel-heading">
                    Orden de compra Pegaso.
           </div>
                    <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" class="tabla" >
                                    <thead>
                                        <tr>
                                            <th>Par</th>
                                            <th>Descripcion</th>
                                            <th>Clave <br/>Proveedor</th>
                                            <th>Cantidad</th>
                                            <th>Costo</th>
                                            <th>Descuentos</th>
                                            <th>Subtotal</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i =0;
                                        foreach ($detalle as $data): 
                                        $i += 1 ;
                                        ?>
                                       <tr class="odd gradeX" >
                                            <td><?php echo $data->PARTIDA;?></td>
                                            <td><?php echo $data->DESCRIPCION;?><br/><input type="number" step="any" min="0" max="<?php echo empty($data->STATUS_RECEP)? $data->CANTIDAD:$data->CANT?>" onchange="validar(<?php echo $i?>,this.value, <?php echo $data->CANTIDAD?>)" value="<?php echo empty($data->STATUS_RECEP)? $data->CANTIDAD:$data->CANT ?>" id="recep_<?php echo $i?>"></td>
                                            <td><?php echo $data->CVE_PROD?></td>
                                            <td align="center"><?php echo $data->CANTIDAD;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO,2);?></td>
                                            <td align="right"><?php echo number_format($data->DESC1,2).'<br/>'.number_format($data->DESC2,2).'<br/>'.number_format($data->DESC3,2).'<br/>'.number_format($data->DESCF,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO_TOTAL,2);?></td>
                                            <td align="right"></td>
                                                <input type="hidden" name="par" id='partida_<?php echo $i?>' value="<?php echo $data->PARTIDA?>">
                                                <input type="hidden" name="par" id='prod_<?php echo $i?>' value="<?php echo $data->ART?>">
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <label><input type="button" name="boton" id="boton" value="Finalizar" onclick="finalizar('<?php echo $doco?>')"></label>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function finalizar(oc){
        var oc = document.getElementById('oc').value;
        $.ajax({
            url:'index_log.php',
            type:'POST',
            dataType:'json',
            data:{finalizaoperador:1,oc:oc},
            success:function(data){
                if(data.status == 'ok' ){
                    if(confirm('El resultado de la Orden se procedera como completa')){
                        alert('Mandamos otro ajax');
                    }
                }else if(data.status == 2){
                   alert('La orden ya hasido procesada previamente')
                }
            }
        });   
    }

    function validar(i,num, canto){
        if(num < 0){
            alert('No se permiten valores negativos');
            document.getElementById('recep_'+i).value=canto;
        }else if(num > canto){
            alert('Usted Recibio mas de lo solicitado');
        }else if(num<canto){
             alert('Usted Recibio menos de lo solicitado');
        }
        var doco = document.getElementById('oc').value;
        var partida = document.getElementById('partida_'+i).value;
        var producto = document.getElementById('prod_'+i).value;

        $.ajax({
            url:'index_log.php',
            type:'POST',
            dataType:'json',
            data:{prerecep:1,cantr:num,doco:doco,producto:producto,partida:partida},
            sucess:function(data){
                alert('se valido');
            }
        });
    }
</script>