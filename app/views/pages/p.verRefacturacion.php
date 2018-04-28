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
                                            <th>Unidad</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($exec as $data):  
                                        $i++;
                                        if(!empty($data->FACTURA)){
                                            $documento = $data->FACTURA;    
                                        }else{
                                            $documento = $data->REMISION;
                                        }
                                        ?>
                                       <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $documento;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->FECHA_U_LOGISTICA?></td>
                                            <td><a href="index.php?action=buscaFacturaNC&opcion=1&docf=<?php echo $documento?>" class="btn btn-success">Procesar</a></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                 </div>
            </div>           
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function asignar(i, sec){
        var caja = document.getElementById("caja_"+i).value;
        $.ajax({
            url:"index.php",
            method:"POST",
            dataType:"json",
            data:{aSec:1,uni:"",clie:"",idu:"",sec:sec, docf:"",idcaja:caja},
            success:function(data){
                if(data.status == 'ok'){
                    document.getElementById('sec_'+i).value=sec;
                }else{
                    document.getElementById('sec_'+i).value='';
                }
                
            }
        })
    }
    
    function finalizar(fin, i){
        var caja = document.getElementById("caja2_"+i).value;
       // alert('Caja '+ caja + ' fin ' + fin);
        $.ajax({
            url:"index.php",
            method:"POST",
            dataType:"json",
            data:{finRutaLog:1,fin:fin,idcaja:caja},
            success:function(data){
                if(data.status == 'ok'){
                    
                }else{
                    alert(data.mensaje);
                    document.getElementById('sel_'+i).value='nada';
                }
                
            }
        })
    }

</script>