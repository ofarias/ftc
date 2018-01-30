<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Marcas Activas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCajasAlmacen">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Cajas Pegaso</th>
                                            <th>Clave Pedido  </th>
                                            <th>Vendedor </th>
                                            <th>Partidas </th>
                                            <th>Estado </th>
                                            <th>Fecha Creacion Pedido</th>
                                            <th>Fecha Liberacion <br/> Creacion de Caja Almacen</th>
                                            <th>Maestro</th>
                                            <th>Ver Cotizacion</th>
                                            <th>Abrir Caja</th>
                                            <th>Ver Pedido Cliente</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($cajas as $data): 
                                            $color = '';
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?> >
                                            <td><?php echo empty($data->CAJA_PEGASO)? $data->IDCA:$data->CAJA_PEGASO ?></td>
                                            <td><?php echo $data->PEDIDO;?> </td>
                                            <td><?php echo $data->VENDEDOR;?> </td>
                                            <td><?php echo $data->NUM_PROD;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->FECHA_VENTAS;?></td>
                                            <td><?php echo $data->FECHA_LIBERACION?></td>
                                            <td><?php echo $data->MAESTRO?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="idca" value="<?php echo $data->IDCA;?>"/>
                                            <input type="hidden" name="idp" value="<?php echo $data->PEDIDO;?>">
                                            <input type="hidden" name="folio" value="<?php echo $data->COTIZACION?>" />
                                            <input type="hidden" name="urgente" value="<?php echo $data->URGENTE?>" />
                                            <td>
                                                <button name="verPedido" type="submit" value="enviar" class="btn btn-success"> Ver Pedido</button>
                                            </td>
                                            <td>
                                                <a href="index.php?action=verCajaAlmacen&pedido=<?php echo $data->PEDIDO?>" target="popup" onclick="window.open(this.href, this.target, 'width=1800,height=820'); return false;" class="btn btn-info"> Ver Caja </a><br/>
                                                <button> Cerrar Caja</button>
                                             </td> 
                                             </form>
                                             <td>
                                                <font color='blue'><a href="/PedidosVentas/<?php echo substr($data->NOMBRE_ARCHIVO,30, 176)?>" download="/PedidosVentas/<?php echo substr($data->NOMBRE_ARCHIVO,30, 176)?>"><?php echo substr($data->NOMBRE_ARCHIVO,30, 176)?> </a></font>
                                             </td>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>
