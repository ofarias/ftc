<div class="container">
	<div class="row">
		<button id="openeAP" class="btn btn-warning">Nuevo Proceso <i class="fa fa-plus-circle"></i></button>
	</div>
	<br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Modifica Usuarios
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                           <th>Factura</th>
                                           <th>CVE_CLPV</th>
                                           <th>Importe</th>
                                           <th>ID de Proceso</th>
                                           <th>Estatus</th>
                                           <th>Modificar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($asignados as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo "$ " . number_format($data->IMPORTE, 2, '.', ',');?></td>
                                            <td><?php echo $data->ID_SEG;?></td>
                                            <td><?php echo $data->STATUS_FACT == 'a' ? 'Asignado' : 'Otro';?></td>
                                            <td><center><a href="#" class="btn btn-warning" role="button"><p><i class="fa fa-pencil-square-o"></i></p></a></center></td>
                                            <!--<td><p><i class="fa fa-chevron-right"></i></p></td> --> 
                                            <!--<td><center><a href="index.php?action=modificaproceso&e=<?php echo $data->CVE_DOC?>" class="btn btn-warning" role="button"><p><i class="fa fa-pencil-square-o"></i></p></a></center></td>-->
                                            <!--<td><center><a style="text-decoration: none" href="index.php?action=modifica&e=<?php echo $data->USER_EMAIL;?>"><p><i class="fa fa-chevron-right"></i></p></a></center></td>-->                                           
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
</div>

<!--Menu desplegable-->
<div id="dialogAP" title="Nuevo Proceso">
<div class="row">
	<!--<div class="col-lg-12">
		<h2>Formulario para Alta de Nuevo Usuario</h2>
	</div>-->
	
<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
                        <div class="panel-heading">
                            Seleccionar Componentes a Asignar
                        </div>
                        <!-- /.panel-heading -->
                        <form action="index.php" method="post">
                        	<!--<input type="hidden" name="compa" value="compa" />-->
		                        <div class="panel-body">
		                            <div class="table-responsive">
		                                <!--<table class="table table-striped" id="dataTables-aflujo">-->
		                                <table class="table" id="dataTables-aflujo">
		                                    <thead>
		                                        <tr>
		                                           <th>Nombre de Componente</th>
		                                           <th>Asignar</th>
		                                        </tr>
		                                    </thead>                                   
		                                  <tbody>                                  	
											<!--Se muestran los componentes creados, solo los id y nombre-->
											<?php foreach ($exec as $data): ?>
												<tr class="odd gradeX">
													<td><label for="nombre"><?php echo $data->SEG_NOMBRE;?></label></td>
													<!--<td><input type="text" name="nombre" value="<?php echo $data->SEG_NOMBRE;?>" readonly/></td>-->
													<td><center><input name="id[]" value="<?php echo $data->ID;?>" type="checkbox" /></center></td>
												</tr>
											  <?php endforeach; ?>									  
											  </tbody>
		                                </table>
		                            </div>
		                            <!-- /.table-responsive -->
					          </div>		
						</div>
				</div>
		<div class="col-md-6">
			<div class="form-group">
			<label for="Nombre">Nombre: </label>
			<input class="form-control" type="text" name="nombreflujo" /><!--nombre flujo es el nombre clave a recibir en el index-->
			</div>
			<div class="form-group">
			<label for="Descripcion">Descripción: </label>
			<input class="form-control" type="text" name="desc" />
			</div>
			<button type="submit" class="btn btn-warning">Asignar Componentes </button>
		</div>
		</form>
	</div>
</div>
</div>
</div>