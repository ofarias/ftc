

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Revision de rutas.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>Orden de Compra</th>
                                            <th>Proveedor</th>
                                            <th>Estado</th>
                                            <th>CP</th>
											<th>Fecha Orden</th>
                                            <th>PAGO TESORERIA</th>
                                            <th>FECHA PAGO</th>
                                            <th>Dias Transcurridos</th>
                                            <th>Unidad</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($unidades as $data):  
                                        ?>
                                       <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADOPROV;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
											<td><?php echo $data->PAGO_TES;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                           
                                            
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
</div>