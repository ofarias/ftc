<div class="container">
	<div class="row">
		<button id="openeU" class="btn btn-warning">Nuevo Usuario <i class="fa fa-plus-circle"></i></button>
	</div>
	<br />
	<div class="row">
		<div class="alert alert-warning"><h3>Usuario Agregado/Modificado correctamente</h3></div>
	</div>
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
                                           <th>Usuario</th>
                                           <th>Email</th>
                                           <th>Estatus</th>
                                           <th>Rol</th>
                                           <th>Letra</th>
                                           <th>Modificar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($exec as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->USER_LOGIN;?></td>
                                            <td><?php echo $data->USER_EMAIL;?></td>
                                            <td><?php echo $data->USER_STATUS;?></td>
                                            <td><?php echo $data->USER_ROL;?></td>
                                            <td><?php echo $data->LETRA;?></td>
                                            <!--<td><p><i class="fa fa-chevron-right"></i></p></td> --> 
                                            <td><center><a href="index.php?action=modifica&e=<?php echo $data->USER_EMAIL?>" class="btn btn-warning" role="button"><p><i class="fa fa-pencil-square-o"></i></p></a></center></td>
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

<!--Fancy Box para nuevo usuarios-->
<div id="dialogU" title="Nuevo Usuario">
<div class="row">
	<div class="col-lg-12">
		<h2>Formulario para Alta de Nuevo Usuario</h2>
	</div>
	<br /><br /><br /><br />
	<div class="col-lg-6">
		<form action="index.php" method="post" class="form-group">
			<label for="usuario">Usuario: </label>
			<input type="text" name="usuario" class="form-control" required="required" />
			<label for="contrasena">Contraseña: </label>
			<input type="password" name="contrasena" class="form-control" required="required" />
			<label for="email">Correo Electronico: </label>
			<input type="email" name="email" class="form-control" required="required" />
			<label for="rol">Tipo de Rol: </label>
			<select name="rol[]" class="form-control">
				<option value="">Selecciona Rol</option>
				<option value="administracion">Administración</option>
				<option value="usuario">Usuario</option>
				<option value="ventas">Ventas</option>
				<option value="compras">Compras</option>
				<option value="recepcion">Recepcion</option>
			</select>
			<br />
			<button type="submit" class="btn btn-success">Alta</button>
		</form>
	</div>
</div>
</div>
