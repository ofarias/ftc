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
                                            <th>Pedido u OC </th>
                                            <th>Cliente o Proveedor</th>
                                            <th>Estado Logistica:</th>
                                            <th>Unidad</th>
                                            <th>Operador</th>
                                            <th></th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Preparar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($ruta as $data): ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                       <tr>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->DOCUMENTO?>"><?php echo $data->DOCUMENTO;?></a></td>
                                            <td><?php echo $data->FECHA;?></td>
                                            <td><?php echo $data->STATUSLOG;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td>
                                                <form action="index.php" method="post">
                                                   <input name="doc" type="hidden" value="<?php echo $data->COTIZA?>" />                                           
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Revision de rutas.
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
                                            <th>Entregar en:</th>
                                            <th>CP</th>
											<th>Fehca Factura</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Preparar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($facturas as $data): ?>
                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                       <tr>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
											<td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td>
                                            	<form action="index.php" method="post">
                                            	   <input name="doc" type="hidden" value="<?php echo $data->CVE_DOC?>" />                                          	
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
