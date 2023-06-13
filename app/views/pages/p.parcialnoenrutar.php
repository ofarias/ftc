

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
                                            <th>Orden</th>
                                            <th>Proveedor</th>
                                            <th>Estado</th>
                                            <th>CP</th>
											<th>Fecha Orden</th>
                                            <th>PAGO TESORERIA</th>
                                            <th>FECHA PAGO</th>
                                            <th>Dias Transcurridos</th>
                                            <th>Unidad</th>
                                            <th>Secuencia</th>
                                            <th>Fecha</th>
                                            <th>Estado Actual</th>
                                            <th>Motivo</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($fallido as $data):  
											$PNR = $data->STATUS_LOG;
											if($PNR == 'PNR'){
												$PNR = 'Parcial No Enrutar';
											}
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
                                            <td><?php echo $data->SECUENCIA;?></td>
                                            <td><?php echo $data->HOY;?></td>
                                            <td><?php echo $PNR;?></td>
                                            <td>
                                            	<form action="index.php" method="post">
                                            	<input name="doc" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                            	<input name="secuencia" type="hidden" value="<?php echo $data->SECUENCIA?>"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>" />
                                                <input name="idf" type="hidden" value="<?php echo $data->IDU?>"/>
                                                <input name="motivo" type="text" required="required"/>
                                                                          
                                            </td>                                           
                                           <td>                                             
                                                <button name="finalizaRuta" type="submit" value="enviar" class="btn btn-warning">Finaliza Ruta  <i class="fa fa-car"></i></button></td>
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