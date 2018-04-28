

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
<!--
                                            <td>
                                            	<form action="index.php" method="post">
                                            	<input name="docu" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                            	<select name="unidad" required="required">
                                            		<option value="">--Selecciona Unidad--</option>
                                            	//<?php foreach($unidad as $u){
                                            	//	echo '<option value="'.$u->NUMERO.'">"'.$u->NUMERO.'"</option>';
                                            	} ?>
                                            	</select>
                                            </td>  
-->
                                            <td>                                            	
                                            	<button name="asignaruta" type="submit" value="enviar" class="btn btn-warning">Asignar <i class="fa fa-floppy-o"></i></button></td>
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