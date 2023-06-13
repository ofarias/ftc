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
                                            <th>Fecha Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Factura / Remision</th>
                                            <th>Dias</th>
                                            <th>Unidad</th>
                                            <th>Logistica</th>
                                            <th>Statust</th>
                                            
                                            </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($documentos as $data):  
                                        $i++;
                                            $ubicacion='';
                                            if($data->STATUS_RECEPCION == 1){
                                                $ubicacion = 'Asignacion de Unidad';
                                            }elseif($data->STATUS_RECEPCION == 2){
                                                $ubicacion = 'Secuencia';
                                            }elseif($data->STATUS_RECEPCION == 3){
                                                $ubicacion = 'Administracion';
                                            }elseif($data->STATUS_RECEPCION == 4){
                                                $ubicacion = 'Cierre de Ruta';
                                            }else{
                                                $ubicacion = 'Sin Procesar';
                                            }
                                        ?>
                                       <tr class="odd gradeX"  id="linea_<?php echo $i?>">
                                            <td><?php echo $data->ID.'<br/>'.$data->STATUS;?></td>
                                            <td><font color="red"><b><?php echo $data->FECHA_CREACION?></b></font></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG?></td>
                                            <td><?php echo $ubicacion?></td>
                                         
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