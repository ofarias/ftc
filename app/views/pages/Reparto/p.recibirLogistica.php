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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-RecibirLogistica">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Factura / Remision</th>
                                            <th>Dias</th>
                                            <th>Unidad</th>
                                            <th>Finaliza Logistica</th>
                                            <th>Cambiar Status</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($rutas as $data):  
                                        $i++;
                                        $unidad = $data->IDU;
                                        $color = '';
                                        if(!empty($data->ORIGINAL)){
                                            $color = "style='background-color: #fcf3cf'";
                                        }elseif ($data->STATUS_RECEPCION == 3) {
                                            $color = "style='background-color:#b3ffd9'";
                                        }   
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="linea_<?php echo $i?>">
                                            <td><?php echo $i?></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <?php if($tipo == 1){?>
                                                <td>
                                                    <form action="index.php" method="post">
                                                    <input name="idcaja" type="hidden" value="<?php echo $data->ID?>" id="caja_<?php echo $i?>"/>
                                                    <input name="clie" type="hidden" value="<?php echo $data->NOMBRE?>"/>
                                                    <input name="secuencia" type="number" value="<?php echo $data->SECUENCIA?>" onchange="asignar(<?php echo $i?>, this.value)" id="sec_<?php echo $i?>"/>
                                                    <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>"/>
                                                    <input name="idu" type="hidden" value="<?php echo $data->IDU?>" />
                                                    <input name="fecha" type="hidden" value="<?php echo $data->FECHA?>"/> 
                                                    <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                                    </form>
                                                </td>
                                            <?php }elseif($tipo == 2){?>
                                                    <td>
                                                        <input name="idcaja2" type="hidden" value="<?php echo $data->ID?>" id="caja2_<?php echo $i?>"/>
                                                        <select name="fin"  onchange="finalizar(this.value, <?php echo $i?>)" id="sel_<?php echo $i?>">
                                                            <option value ="<?php echo (empty($data->STATUS_LOG) or $data->STATUS_LOG == 'admon')? 'nada':"$data->STATUS_LOG"?>">
                                                                <?php echo (empty($data->STATUS_LOG) OR $data->STATUS_LOG == 'admon')? "-- Seleccionar --":"$data->STATUS_LOG" ?></option> 
                                                            <option value="entregado"> Entregado</option>
                                                            <option value="reenrutar">Reenrutar</option>
                                                            <option value="NC">Nota de Credito</option>
                                                            <option value="Refacturar"> Refacturar / Cobranza</option>
                                                            <option value="RefacReen"> Refacturar / Reenvio</option>
                                                        </select>
                                                    </td>
                                            <?php }elseif ($tipo==3) { ?>
                                                 <td>   
                                                        <input name="idcaja2" type="hidden" value="<?php echo $data->ID?>" id="caja2_<?php echo $i?>"/>
                                                        <input type="hidden" name="status" id="statusA_<?php echo $i?>" value="<?php echo $data->STATUS_LOG?>">
                                                        <font color="RED" ><b><?php echo (empty($data->ORIGINAL))? $data->STATUS_LOG:$data->ORIGINAL?></b></font>
                                                    </td>
                                                    <td>
                                                         <font color="blue"><select name="fin"  onchange="finalizar(this.value, <?php echo $i?>)" id="sel_<?php echo $i?>">
                                                            <option value ="<?php echo (empty($data->STATUS_LOG) or $data->STATUS_LOG == 'admon')? 'nada':"$data->STATUS_LOG"?>">
                                                                <?php echo (empty($data->STATUS_LOG) OR $data->STATUS_LOG == 'admon')? "-- Seleccionar --":"$data->STATUS_LOG" ?></option> 
                                                            <option value="entregado"> Entregado</option>
                                                            <option value="reenrutar">Reenrutar</option>
                                                            <option value="NC">Nota de Credito</option>
                                                            <option value="Refacturar"> Refacturar / Cobranza</option>
                                                            <option value="RefacReen"> Refacturar / Reenvio</option>
                                                        </select>
                                                    </font>
                                                    </td>
                                            <?php }?>  
                                            </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
                <div class = "panel-footer">
                    <div class="text-right">
                        <form action="index.php" method="post">
                            <input type="hidden" name="unidad" value="<?php echo $unidad?>"/>
                            <input type="hidden" name="tipo" value="<?php echo $tipo?>">
                            <button type="input" name="ImprimirSecuenciaEntrega" class="btn btn-primary">Recibir e Imprimir <i class="fa fa-print" aria-hidden="true"></i></button>
                        </form>
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
                    data:{finRutaLog:3,fin,idcaja:caja},
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