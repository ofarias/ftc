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
                                <table class="table table-striped table-bordered table-hover" id="dataTables-clientes">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>CLAVE</th>
                                            <th>NOMBRE</th>
                                            <th>RFC</th>
                                            <th>CALLE</th>
											<th>EXTERIOR</th>
                                            <th>SALDO</th>
                                            <th>MONTO X APLICAR</th>
                                            <th>Cargar</th>
                                            <th>Aplicar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 
                                        ?>

                                       <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                       <tr>
                                            <td><?php echo $data->CLAVE?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->RFC;?></td>
                                            <td><?php echo $data->CALLE;?></td>
                                            <td><?php echo $data->NUMEXT;?></td>
                                            <td><?php echo $data->SALDO;?></td>
                                            <td><?php echo $data->SALDOXA;?></td>
                                            <td>
                                            	<form action="index.php" method="post">
                                            	   <input name="cliente" type="hidden" value="<?php echo $data->CLAVE?>" />                                          	
                                            	   <button name="cargarPago" type="submit" value="enviar" class="btn btn-warning">CARGAR </button></td>
                                                   <td>
                                                   <button name="aplicarPago" type="submit" value="enviar" class="btn btn-warning">APLICAR</button>
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
