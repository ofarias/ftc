<div class="row">
	<br />
</div>

<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recepciones 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                        	<th>Orden de Compra</th>
                                            <th>Recepcion</th>
                                            <th>Proveedor</th>
                                            <th>Unidad</th>
                                            <th>Operador</th>
                                            <th>Fecha Recoleccion</th>
                                            <th>Estado Recoleccion</th>
                                            <th>Fecha Recepcion</th>
                                            <th>Estado de la Recepcion</th>
                                            <th>Fallar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($fallidas as $data): 

                                            $statusrec = $data->ENLAZADO;
                                            $statuslog = $data->STATUS_LOG;

                                            if($statusrec == 'T'){
                                                $statusrec = 'Total';
                                            }elseif($statusrec == 'P'){
                                                $statusrec = 'Parcial';
                                            }else{
                                                $statusrec = 'Otro';
                                            }

                                            if ($statuslog == $statusrec){
                                                $color = "style='background-color:FFFFFF;'";
                                            }else{
                                                $color = "style='background-color:orange;'";
                                            }                        
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $statusrec;?></td>
                                            <form action="index.php" method="post">
                                            <input name="docr" type="hidden" value="<?php echo $data->RECEPCION?>"/>
                                            <input name="doco" type= "hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <td>
                                                <button name="fallarOC" type="submit" value="enviar" <?php echo (empty($data->RECEPCION))? '':'disabled'; ?> class="btn btn-warning">Fallar Orden de Compra <i class="fa fa-close"></i></button></td> 
                                            </form>      
                                        </tr>
                                        
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
			          </div>
			</div>
		</div>
</div>
<br />