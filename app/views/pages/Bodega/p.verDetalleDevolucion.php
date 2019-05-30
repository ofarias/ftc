<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ver recepcion de devoluciones.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>Folio <br/><font color="red"> Caja</font></th>
                                            <th>Cotizacion /  Factura </th>
                                            <th><font color ="blue">Cantidad</font><br/><font color ="red">Devuelto</font></th>
                                            <th>Descripcion</th>
                                            <th>Usuario</th>
                                            <th>Fecha Ultima Devolucion </th>
                                            <th>Motivo Devolucion </th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        $i=0;
                                        foreach ($detalle as $data):
                                            $archivo = 'DEVOLUCION_'.$data->FOLIO_DEV;
                                            $i++;
                                        ?>
                                        <tr id="<?php echo $i?>">
                                            <td><?php echo $data->FOLIO_DEV.'<br/><font color="red">'.$data->IDCAJA.'</font>';?></td>
                                            <td align="center"><?php echo $data->DOCUMENTO.'<font color="red"> / '.$data->DOCUMENTO_VENTA.'</font>'?></td>
                                            <td><?php echo '<font color="blue">'.$data->CANTIDAD.'</font><br/><font color="red">'.$data->DEVUELTO.'</font>';?></td>
                                            <td><?php echo $data->DESCRIPCION ;?></td>
                                            <td><?php echo $data->USUARIO_DEV;?></td>
                                            <td><?php echo $data->FECHA_ULTIMA_DEV?></td>
                                            <td><?php echo $data->MOTIVO;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
    </div>
<br />

