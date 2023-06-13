<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Cotizaciones con Utilidad Baja.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Cotizacion</th>
                                            <th>Cliente</th>
                                            <th>Fecha Cotizacion</th>
                                            <th>Clave</th>
                                            <th>Partida</th>
                                            <th>Cantidad</th>
                                            <th>Producto</th>
                                            <th>Precio Venta</th>
                                            <th>Costo Total</th>
                                            <th>Utilidad Calculada</th>
                                            <th>Solicitar Autotizacion</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->CLAVE_PROD?></td>
                                            <td><?php echo $data->NUM_PART;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->PRODUCTO;?></td>
                                            <td><?php echo $data->PRECIOVENTA;?></td>
                                            <td><?php echo $data->COSTO;?></td>
                                            <td><?php echo $data->UTILIDADCALCULADA;?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="cotizacion" value="<?php echo $data->CVE_DOC;?>" />
                                            <input type="hidden" name="partida" value="<?php echo $data->NUM_PART?>" />
                                            <td>
                                             <button name="solAutoUB" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Solicitar Autorizacion</button>
                                             </td> 
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
