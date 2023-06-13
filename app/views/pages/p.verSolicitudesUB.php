<br /><br />
<div class="<?php (empty($exec)) ? hide : nohide;?>"  >
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Solicitudes de Utilidad Baja.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-clientes">
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
                                            <th>Autorizar</th>
                                            <th>Negar Autorizacion</th>
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
                                             <button name="AutorizarUB" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Autorizar</button>
                                             </td> 
                                             <td>
                                             <button name="RechazoUB" type="submit" value="enviar" class="btn btn-warning"> Negar </button>
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
</div>
