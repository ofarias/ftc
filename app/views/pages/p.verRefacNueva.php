<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Solicitudes de Productos de Ventas.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Partida</th>
                                            <th>Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad <br/> <font color="red">Pendiente</font> <br/><font color="blue">Omitido</font> </th>
                                            <th>Precio</th>
                                            <th>Descuento </th>
                                            <th>Total Partida</th>
                                            <th>Quitar / Poner</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($refactura as $data):
                                            $i++;
                                            if(empty($data->CANT_VAL)){
                                                $cantval= 0;    
                                            }else{
                                                $cantval = $data->CANT_VAL;
                                            }
                                            ?>
                                        <tr id="<?php echo $i?>">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->NOMBRE?></td>
                                            <td><?php echo $data->CANT;?> <br/> <font color="red"><?php echo $data->PXS?></font> &nbsp;/&nbsp; <font color="blue"><strong><?php echo empty($data->CANT_VAL)? 0:$data->CANT_VAL?></strong></font></td>
                                            <td align="right"><?php echo '$ '.number_format($data->PREC,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->DESC1,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->TOT_PARTIDA,2);?></td>
                                            <td>
                                                <?php if($cantval == 0 and $data->PXS == 0){?>
                                                <label><font color="green">Facturado</font></label>
                                                <?php }elseif($cantval == 0 and $data->PXS > 0){?>
                                                <input name="quit" type="button" value="Quitar" onclick="quitar(<?php echo $i?>, '<?php echo $data->CVE_DOC?>',<?php echo $data->NUM_PAR?>)" id="boton_<?php echo $i?>" class="btn btn-danger">
                                                <?php }elseif($cantval > 0 ){?>
                                                <input name="quit" type="button" value="Reingresar" onclick="quitar(<?php echo $i?>, '<?php echo $data->CVE_DOC?>',<?php echo $data->NUM_PAR?>)" id="boton_<?php echo $i?>" class="btn btn-success">
                                                <?php }?>
                                            </td>
                                                 
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

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">


function quitar(i, docref, partida){

    if(confirm('Desea quitar la Partida de la refacturacion?' )){
        $.ajax({
        url:'index.php',
        dataType:'json',
        method:'POST',
        data:{quitarPartidaRef:1,docref:docref,partida:partida}, 
        success:function(data){
            alert(data.mensaje);
                }
        });    
    }
        document.getElementById('boton_'+i).classList.add('hide');      
        renglon = document.getElementById(i);
        renglon.style.background="red";  
}
    


</script>
