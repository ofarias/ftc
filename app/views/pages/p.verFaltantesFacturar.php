<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cajas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Cotizacion</th>
                                            <th>Partida</th>
                                            <th>Cantidad</th>
                                            <th>Cliente</th>
                                            <th>Producto</th> 
                                            <th>Caja</th>
                                            <th>Pendiente <br/> Facturar</th>
                                            <th>Usuario Empaque</th>
                                            <th>Fecha Empaque</th>
                                            <th>Facturas</th>
                                            <th>Remisiones</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($faltantes as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->COTIZACION?></td>
                                            <td><?php echo $data->PARTIDA;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->PRODUCTO;?> <br/> <font color ="blue"><?php echo $data ->DESCRIPCION?></font></td>
                                            <td><?php echo $data->CAJA;?></td>
                                            <td><?php echo $data->PXF;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->FACTURAS;?></td>
                                            <td><?php echo $data->REMISIONES;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
