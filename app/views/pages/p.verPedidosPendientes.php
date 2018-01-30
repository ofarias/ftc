<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Pedidos pendientes de Facturar.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>CLAVE DEL CLIENTE:</th>
                                            <th>CP</th>
                                            <th>Fehca Pedido</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Factura </th>
                                            <th>Recibidos</th>
                                            <th>Empacados</th>
                                            <th>Preparar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pedidosList as $data): ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                       <tr>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->DOCUMENTO?>"><?php echo $data->DOCUMENTO;?></a></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->SOLICITADA;?></td>
                                            <td><?php echo $data->RECIBIDA;?></td>
                                            <td><?php echo $data->EMPACADO;?></td> 
                                            <td>
                                                <form action="index.php" method="post">
                                                   <input name="doc" type="hidden" value="<?php echo $data->DOCUMENTO?>" />                                           
                                                   <button name="preparamaterial" type="submit" value="enviar" class="btn btn-warning">Preparar <i class="fa fa-th-large"></i></button></td>
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
