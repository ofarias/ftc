
	<div class="row">
		<button id="openera" class="btn btn-warning">Asignar Nuevo <i class="fa fa-plus-circle"></i></button>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
                        <div class="panel-heading">
                            Procesos Asignados a Factura
                        </div>
                        <form action="index.php" method="post">
                        	<input type="hidden" name="compa" value="compa" />
		                        <div class="panel-body">
		                            <div class="table-responsive">
		                                <table class="table table-striped" id="dataTables-aflujo">
		                                    <thead>
		                                        <tr>
		                                           <th>Factura</th>
		                                           <th>Clave CLPV</th>
		                                           <!--<th>Estatus Factura</th>-->
		                                           <th>ID Seguimiento</th>
		                                           <th>Estatus</th>
		                                        </tr>
		                                    </thead>                             
		                                  <tbody>                                  	
											<!--Se muestran los componentes creados, solo los id y nombre-->
											<?php foreach ($exec as $data): ?>
												<tr class="odd gradeX">
													<td><?php echo $data->CVE_DOC;?></td>
													<td><?php echo $data->CVE_CLPV;?></td>
													<!--<td><center><?php echo $data->STATUS;?></center></td>-->
													<td><?php echo $data->ID_SEG;?></td>
													<td><?php echo $data->STATUS_FACT == 'a' ? 'Asignado' : 'Otro';?></td>
													<!--<td><center>
														<select name="asigna">
															<?php foreach($options as $option) :?>
																<option value="<?php echo $option->ID; ?>"><?php echo $option->NOMBRE;?></option>
															<?php endforeach;?>
														</select>
														</center>
												</td>-->
													<!--<td><a style="text-decoration: none; color: #444444;" href="index.php?action=<?php echo $option->ID; ?>" >Asignar <i class="fa fa-chevron-right"></i></a></td>-->
													</tr>
											  <?php endforeach; ?>									  
											  </tbody>
		                                </table>
		                            </div>
		                            <!-- /.table-responsive -->
					          </div>
					        </form>  		
						</div>
				</div>		
	</div>



<!--Fancy Box con opcion de asignar nuevo-->
<div id="dialoga" title="Asignar Proceso a Factura">
  <form action="index.php" method="post">
	<!--<input type="text" name="nombre" placeholder="Colocar Nombre Componente" /><br />-->
	<select name="factura[]">
		<?php reset($facturas); foreach($facturas as $factura) :?>
			<option value="<?php echo $factura->CVE_DOC; ?>"><?php echo $factura->CVE_DOC;?></option>
		<?php endforeach;?>
	</select>
	<select name="compo[]">
		<?php reset($componentes); foreach($componentes as $comp) :?>
			<option value="<?php echo $comp->ID; ?>"><?php echo $comp->NOMBRE . '-' . $comp->DESCRIPCION;?></option>
		<?php endforeach;?>
	</select>
	<!--<input type="text" name="duracion" placeholder="Duracion en Horas" /><br />-->
	<input type="hidden"  name="asignacomposconfact" /><br /><br />
	<button type="submit" class="btn btn-warning" >Agregar</button>
  </form>
</div>
