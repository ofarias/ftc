<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ver Recepcion de Ordenes de compra.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Recepcion</th>
                                            <th>Orden</th>
                                            <th>Fecha</th>
                                            <th>Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad OC</th>
                                            <th>Cantidad Recibida</th>
                                            <th>Faltante</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $e=0;
                                        foreach ($recepcion as $data):
                                            $e++;
                                            ?>
                                        <tr id="ln<?php echo $e?>">
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->ORDEN;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD?></td>
                                            <td><?php echo $data->CANTIDAD_OC;?></td>
                                            <td><?php echo $data->CANTIDAD_REC;?></td>
                                            <td><?php echo $data->CANTIDAD_OC - $data->CANTIDAD_REC;?></td>
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

