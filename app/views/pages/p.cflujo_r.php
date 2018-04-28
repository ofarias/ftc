<div class="container">
	<div class="row">
		<h2>Asigna Componentes</h2>
	</div>
	<div class="row">
		<div class="alert-success"><center><h2>Componentes Asignados correctamente</h2></center></div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
                        <div class="panel-heading">
                            Seleccionar Componentes a Asignar
                        </div>
                        <!-- /.panel-heading -->
                        <form action="index.php" method="post">
                        	<input type="hidden" name="compa" value="compa" />
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
			<input class="form-control" type="text" name="nombreflujo" />
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