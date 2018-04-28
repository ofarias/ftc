<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ruta de Entrega.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Factura / Remision</th>
                                            <th>Dias</th>
                                            <th>Unidad</th>
                                            <th>Logistica</th>
                                            <th>Status</th>
                                            <th>Archivos</th>
                                            <th>Contrarecibo</th>
                                            </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($documentos as $data):  
                                            $i++;
                                            $color = '';
                                            $tipo = '';

                                            if($data->STATUS_RECEPCION == 0 ){
                                                $color = "style='background-color:#FA5858'";
                                                $tipo ='Asignacion de Unidad';
                                            }elseif ($data->STATUS_RECEPCION == 1) {
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'Secuencia';
                                            }elseif($data->STATUS_RECEPCION == 2){
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'Administracion';
                                            }elseif($data->STATUS_RECEPCION == 3){
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'En Bodega';
                                            }elseif($data->STATUS_RECEPCION == 4){
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'En Bodega Cambio de Status';
                                            }elseif ($data->STATUS_RECEPCION == 5){
                                                $color = "style='background-color:#F2F5A9'";
                                                $tipo = 'Procesado';
                                            }elseif($data->STATUS_RECEPCION == 6){
                                                $color = "style='background-color: #CEE3F6'";
                                                $tipo = 'Con Comprobante <br/> Listo para Recepcion';
                                            }elseif ($data->STATUS_RECEPCION == 7){
                                                $color = "style='background-color:#81BEF7'";
                                                $tipo = 'Recibido, Sin Contra Recibo';
                                            }elseif ($data->STATUS_RECEPCION == 8){
                                                $color = "style='background-color:#6699ff'";
                                                $tipo = 'Recibido, Con Contra Recibo';
                                            }elseif ($data->STATUS_RECEPCION == 9){
                                                $color = "style='background-color:#6699ff'";
                                                $tipo = 'Listo para Cobrar';
                                            }elseif ($data->STATUS_RECEPCION == 10){
                                                $color = "style='background-color:#ffb3ff'";
                                                $tipo = 'Vencido';
                                            }elseif ($data->STATUS_RECEPCION == 11){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Cobrado';
                                            }elseif ($data->STATUS_RECEPCION ==22){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Nota de Credito Total';
                                            }elseif ($data->STATUS_RECEPCION ==33){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Nota de credito Parcial';
                                            }elseif ($data->STATUS_RECEPCION ==44){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Refacturado';
                                            }

                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="linea_<?php echo $i?>">
                                            <input type="hidden" name="doc" value="<?php echo $data->DOCUMENTO?>" id ="doc_<?php echo $i?>">
                                            <td align="center"><a href="index.php?action=verHC&idc=<?php echo $data->ID?>" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->ID;?></a></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td align="center"><?php echo $data->FECHA_REV.'<br/>'.$data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td ><?php echo $data->STATUS_LOG?></td>
                                            <td><p id="st_<?php echo $i?>"><?php echo $tipo?></p></td>
                                            <td><?php echo !empty($data->ARCHIVOS)? '<a href="index.php?action=verComprobantesRecibo&idc='.$data->ID.'" target="pop-up" '.'>'.$data->ARCHIVOS.' Archivos</a>':'Sin Archivos'?></td>
                                            <td>
                                                <?php if($tipo2 == 6){?>
                                                <input type="text" maxlength="100" minlength="1" placeholder="Contrarecibo" value="" id="ctrcbo_<?php echo $data->ID?>" onchange="grabaCTRCBO(<?php echo $data->ID?>,<?php echo $i?>, this.value)">
                                                <?php }elseif($tipo2 == 7){?>
                                                <?php echo $data->CONTRARECIBO?>
                                            </td>
                                            <td> 
                                                <input type="button" name="recContra" value="Recibir Contra Recibo" onclick="grabaCTRCBO(<?php echo $data->ID?>, <?php echo $i?>, 'cob<?php echo $data->ID?>')">
                                                <?php }?>
                                            </td>

                                            </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function grabaCTRCBO(idc, i, ctrcbo){
        var doc = document.getElementById('doc_'+i).value;

        if(ctrcbo != 'cob'+idc){
             $mensaje = 'Desea colocar el Contrarecibo: ' + ctrcbo +' del documento:'+ doc;     
        }else{
            $mensaje = 'Desea Recibir el Documento: ' + doc;
        }
       
        if(confirm($mensaje)){
                if(ctrcbo != 'cob'+idc){
                     document.getElementById('ctrcbo_'+idc).readOnly=true;     
                }
                $.ajax({
                    url:"index.php",
                    method:"POST",
                    dataType:"json",
                    data:{grabaCtrCbo:1, idc:idc,doc:doc, info:ctrcbo},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert(data.razon);
                            if(ctrcbo !='cob'+idc){
                                document.getElementById('linea_'+i).style='background-color:#6699ff';
                                document.getElementById('st_'+i).innerHTML='Recibido, Con Contra Recibo';
                            }else{
                                document.getElementById('linea_'+i).style='background-color:#6699ff';
                                document.getElementById('st_'+i).innerHTML='Listo para Cobrar';     
                            }
                        }else{
                            alert(data.razon);
                            document.getElementById('sel_'+i).value='nada';
                        }
                    }
                })    
        }else{
            document.getElementById('ctrcbo_'+idc).value='';
        }
    }


</script>