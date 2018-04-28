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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-foliofacturas">
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
                                            <th>Statust</th>
                                            <th>Archivos</th>
                                            <?php if($rol == 'cxcc'){?>
                                            <th>Adjunto</th>
                                            <?php }?>
                                            </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($dias as $data):  
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
                                           
                                            <td align="center"><a href="index.php?action=verHC&idc=<?php echo $data->ID?>" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->ID;?></a></td> 
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?><br/><?php echo (empty($data->FACTNC2))? '':"$data->FACTNC2<br/>" ?><?php echo ($data->DOCUMENTO == $data->HISTORIAL)? '':$data->HISTORIAL?>  </td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG?></td>
                                            <td><?php echo $tipo?></td>
                                            <td><?php echo !empty($data->ARCHIVOS)? '<a href="index.php?action=verComprobantesRecibo&idc='.$data->ID.'" target="pop-up" '.'>'.$data->ARCHIVOS.' Archivos</a>':'Sin Archivos'?></td>
                                            <?php if($rol == 'cxcc'){?>
                                            <td>
                                                <input type="button" name="cara" value="Subir Archivos" onclick="caratula('<?php echo $data->CLAVE?>',<?php echo $data->ID?>, '<?php echo $data->DOCUMENTO?>', '<?php echo $dia.','.$mes.','.$anio?>' )">
                                            </td>
                                            <?php }?>
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


    function caratula(cl, idc, doc, fecha){
        $.ajax({
            url:'index.php',
            type:'POST',
            dataType:'json',
            data:{caratula:1, cl:cl, idc:idc, fecha:fecha},
            success:function(data){
                if(data.status =='ok'){
                     window.location.href ='index.php?action=caratula&cl='+cl+'&idc='+idc+'&doc='+doc+'&fecha='+fecha+'&tipo=2';
                }else{
                    alert('El cliente no tiene caratula');
                }
            }
        })
    }
    
    function finalizar(fin, i){
        var caja = document.getElementById("caja2_"+i).value;
        var statusA = document.getElementById("statusA_"+i).value;
        if(statusA != fin){
            if(confirm('Desea Cambiar el status de la Caja '+ caja + ' Status Actual: ' + statusA + ' Nuevo Status: '+ fin)){
                $.ajax({
                    url:"index.php",
                    method:"POST",
                    dataType:"json",
                    data:{finRutaLog:3,fin:fin,idcaja:caja},
                    success:function(data){
                        if(data.status == 'ok'){
                            document.getElementById('linea_'+i).style='background-color:#fcf3cf';
                        }else{
                            alert(data.mensaje);
                            document.getElementById('sel_'+i).value='nada';
                        }
                        
                    }
                })
            }    
        }
    }


</script>