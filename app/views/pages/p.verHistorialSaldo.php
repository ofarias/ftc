<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           De los saldos liberados del Proveedor <?php echo $prov?>
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
                                            <th>Fecha de Orden</th>
                                            <th>Partida </th>
                                            <th>Cantidad</th>
                                            <th>Producto</th>
                                            <th>Costo en Ordenes </th>
                                            <th>Total Cancelado</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Usuario Libera</th>
                                            <th>Fecha de Liberacion</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($detallesaldo as $data):
                                        ?>
                                       <tr>
                                            <td>
                                                 <?php echo $data->OC;?>
                                            </td>
                                            <td align="center"><?php echo $data->FECHA_OC;?></td>
                                            <td align="center"><?php echo $data->PARTIDA_OC?></td>
                                            <td align="center"><?php echo $data->CANTIDAD;?></td>
                                            <td align="center"><?php echo '('.$data->PROVEEDOR.') '.$data->NOMBRE_PROVEEDOR;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COST,2) ;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COST*$data->CANTIDAD,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format(($data->CANTIDAD * $data->COST) * .16,2)?></td>
                                            <td align="right"><font color="red"><?php echo '$ '.number_format(($data->CANTIDAD * $data->COST)*1.16,2)?></font></td>
                                            <td><?php echo $data->USUARIO?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                        
                                        </tr>
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
    </div>
</div>
