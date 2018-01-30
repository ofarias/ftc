<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Solicitudes pendientes de Impresión.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Proveedor</th>
                                            <th>Monto</th>
                                            <th>Usuario</th>
                                            <th>Tipo Solicitud</th>
                                            <th>Fecha Elaboracion</th>
                                            <th>Banco</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($solicitudes as $data): 
                                            
                                            ?>
                                        <tr>
                                            <td><?php echo $data->IDSOL;?></td>
                                            <td><?php echo $data->NOM_PROV;?></td>
                                            <td><?php echo $data->MONTO;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->TIPO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->BANCO?></td>
                                            <form action="index.php" method="post">
                                            <input name="idsol" type="hidden" value="<?php echo $data->IDSOL?>"/>
                                            <td>
                                                <button name="ImpSolicitud" type="submit" value="enviar" class="btn btn-info"> Imprimir <i class="fa fa-print"></i></button></td> 
                                            </form>      
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
