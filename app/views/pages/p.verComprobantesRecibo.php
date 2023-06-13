<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Historial de Cambios de los Documentos.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Caja</th>
                                            <th>Documento</th>
                                            <th>Usuario</th>
                                            <th>Fecha</th>
                                            <th>Archivo</th>
                                            <th>Status</th>
                                            </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        foreach ($comprobantes as $data):  
                                        $i++;

                                        ?>
                                       <tr class="odd gradeX" id="linea_<?php echo $i?>">
                                            <td><?php echo $data->IDCAJA;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><a href="/ComprobantesRecibo/<?php echo $data->ARCHIVO;?>" download="/ComprobantesRecibo/<?php echo $data->ARCHIVO;?>"> <?php echo $data->ARCHIVO;?></a></td>
                                            <td><?php echo $data->STATUS?></td>
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