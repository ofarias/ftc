<br />
<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
                        <div class="panel-heading">
                            Procesos Asignados a Factura
                        </div>
                        <!-- /.panel-heading -->
                        <form action="index.php" method="post">
                        	<input type="hidden" name="compa" value="compa" />
		                        <div class="panel-body">
		                            <div class="table-responsive">
		                                <!--<table class="table table-striped" id="dataTables-aflujo">-->
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
						</div>
				</div>		
		</form>
	</div>