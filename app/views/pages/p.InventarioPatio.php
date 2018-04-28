

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Inventatio patio.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc1">
                                    <thead>
                                        <tr>
                                            <th>LIBERACION <br/> FECHA LIBERACION</th>
                                            <th>FECHA PEDIDO</th>
                                            <th>PEDIDO</th>
                                            <th>PARTIDA</th>
                                            <th>CLAVE <br/> ESTADO</th>
                                            <th>NOMBRE</th>
                                            <th>UM</th>
                                            <th>CANTIDAD PEDIDO</th>
                                            <th>RECEPCION</th>
                                            <th>EMPACADO</th>
                                            <th>FACTURADO</th>
                                            <th>REMISIONADO</th>
                                            <th>FACTURAS</th>
                                            <th>FECHA</th>
                                            <th>REMISIONES</th>
                                            <th>FECHA</th>
                                            <th>STATUS LOGISTICA</th>
                                            <th>EN PATIO</th>
                                            <th>PRESUPUESTO COMPRA</th>
                                            <th>COSTO REAL</th>
                                            <th>DIFERENCIA</th>
                                            <th>PRESUPUESTO VENTA</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $totalCosto = 0;
                                        foreach ($invempaque as $data): 
                                            $color = '';
                                            if($data->STATUS == 'N'){
                                                $status = 'En suministros';
                                                $color="style='background-color:#A9F5A9;'";    
                                            }elseif (strtoupper($data->STATUS)  == 'B') {
                                                $status  = 'Ordenado';
                                                $color="style='background-color:#A9E2F3;'";
                                            }elseif ($data->STATUS == 'X') {
                                                $status = 'En Preorden';
                                                $color="style='background-color:#CECEF6;'";
                                            }elseif ($data->STATUS == 'J' or $data->STATUS == 'P') {
                                                $status = 'Compras (Cambio Proveedor)';
                                                $color="style='background-color:#F5D0A9;'";
                                            }elseif (strtoupper($data->STATUS) == 'S') {
                                                $status = 'No Suministrables';
                                                $color="style='background-color:#F78181;'";
                                            }elseif ($data->STATUS == 'C') {
                                                $status = 'Cancelado';
                                                $color="style='background-color:#F78181;'";
                                            }

                                            $totalCosto = $totalCosto + ($data->COSTO_REAL * $data->BODEGA);


                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?> >
                                            <td><?php echo $data->CAJA_PEGASO.'<br/>'.$data->FECHA_LIBERACION;?></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->COTIZA;?></a></td>
                                            <td><?php echo $data->PAR.' ->'.$data->STATUS ;?></td>
                                            <td><?php echo $data->PROD.' (<b>'.$data->ID.'</b>)'.'<br/>'.$status;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><font color = "red"><big><b><?php echo $data->EMPACADO;?></b></big></font></td>
                                            <td><?php echo $data->FACTURADO;?></td>
                                            <td><?php echo $data->REMISIONADO;?></td>
                                            <td><?php echo $data->FACTURAS;?></td>
                                            <td><?php echo $data->FFAC;?></td>
                                            <td><?php echo $data->REMISIONES;?></td>
                                            <td><?php echo $data->FREM;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><font color ="blue"><big><b> <?php echo $data->BODEGA;?></b></big> </font></td>
                                            <td align="right"><?php echo '$ '.number_format($data->PPTO_COMPRA,2);?></td>
                                            <td align="right"> <font color="blue"><?php echo '$ '.number_format($data->COSTO_REAL,2)?></font></td>
                                            <td align="right"><?php echo '$ '.number_format($data->DIFERENCIA,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->PPTO_VENTA,2)?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <label><font size="15px"> <b>Costo Total del Inventario:</b> </font> <font color="red" size="13px"><?php echo '$ '.number_format($totalCosto,2)?></font> <font size="8px"> (Sin IVA) </font></label>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                </div>
        </div>
    </div>
</div>
