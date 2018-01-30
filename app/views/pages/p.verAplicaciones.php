<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default"> 
            <div class="panel-heading">
            Aplicaciones.
            </div>
  <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No.Aplicacion</th>
                                            <th>Clave</th>
                                            <th>CLIENTE</th>
                                            <th>Fecha Aplicacion</th>
                                            <th>Documento</th>
                                            <th>Importe</th>
                                            <th>Saldo Documento</th>
                                            <th>Monto Aplicado</th>
                                            <th>Saldo Pago</th>
                                            <th>Usuario</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($aplicaciones as $data):
                                    
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLAVE?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo '$ '.$data->IMPORTE?></td>
                                            <td><?php echo '$ '.$data->SALDO_DOC;?></td>
                                            <td><?php echo '$ '.$data->MONTO_APLICADO;?></td>
                                            <td><?php echo '$ '.$data->SALDO_PAGO?></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <form action="index.php" method="post">
                                            <td>
                                                <input type="hidden" name="ida" value ="<?php echo $data->ID?>">
                                                <button type="submit" value="enviar" name="impAplicacion" class="btn btn-warning"> Imprimir </button>
                                            </td>     
                                            </form>
                                        </tr>
                                        
                                        <?php endforeach; ?>
                            
                                 </tbody>
                                </table>
                            </div>
                    </div>
                    </div>
    </div>
</div>


