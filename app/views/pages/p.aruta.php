<br /><br />
<div class="row">
        <?php if(!empty($recibedoc)){
            if($recibedoc == true){
                $alerta = "alert alert-success";
                $mensaje = "Documentos asignados correctamente.";
                }else{
                $alerta = "alert alert-error";
                $mensaje = "Los documentos no se pudieron asignar.";                    
                }
            }else{
                $alerta = "";
                $mensaje = "";
            } 
    ?>
<div class="<?php echo $alerta;?>"><center><h2><?php echo $mensaje;?></h2></center></div>
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
                                            <th>Fecha OC</th>
                                            <th>Fecha Pago</th>
                                            <th>Monto del Pago</th>
                                            <th>Tipo de Pago</th>
                                            <th>Dias de Atraso</th>
                                            <th>Documentos</th>
                                            <th>Recibir Documentos</th>
                                            <th>Seleccionar Unidad</th>
                                            <th>Vueltas</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 

                                            $color = $data->DIAS;
                                            $urgencia = $data->URGENCIA;
                                            if ($urgencia == 'U'){
                                                $color = "style='background-color: red;'";
                                            }elseif ($color <= 1 ){
                                               $color="style='background-color: white;'";             
                                            }elseif($color == 3 ){
                                               $color="style='background-color:#FFBF00;'";
                                            }elseif ($color > 3 and $color < 7 ){
                                            $color="style='background-color:#81DAF5;'";
                                            }elseif ($color >= 7 ){
                                            $color="style='background-color:red;'";
                                            }
                                            $var= $data->DOCS;
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADOPROV;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
											<td><?php echo $data->PAGO_TES;?></td>
                                            <td><?php echo $data->TP_TES;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->DOCS;?></td>

                                            <form action="index.php" method="post">
                                            <td>
                                            <input type="hidden" name="docf" value="">
                                            <input type="hidden" name="docr" value="">
                                            <button name="docs" type="submit" value="A" class="btn btn-warning" <?php echo ($var == 'No' or $var =='N') ? "" : "disabled";?>>Recibir<i class="fa fa-floppy-o"></i></button>
                                            </td> 
                                            <!--<td><?php echo ($data->DOCS == 'S') ? "":"disable";?>>-->
                                            <td>
                                            	<input name="docu" type="hidden" value="<?php echo $data->CVE_DOC?>" />
                                                <input name="edo" type="hidden" value="<?php echo $data->ESTADOPROV?>" />
                                            	<select name="unidad" <?php echo ($var == 'No') ? "":"required" ;?>>
                                            		<option value="">--Selecciona Unidad--</option>
                                            	<?php foreach($unidad as $u){
                                            		echo '<option value="'.$u->NUMERO.'">"'.$u->NUMERO.'"</option>';
                                            	} ?>
                                            	</select>
                                            </td> 
                                            <td><?php echo $data->VUELTAS;?></td>                                           
                                            <td>                            

                                            	<button name="asignaruta" type="submit" value="enviar" class="btn btn-warning" <?php echo ($var == 'No' )? "disabled":"";?>>Asignar <i class="fa fa-floppy-o"></i></button>
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
</div>

