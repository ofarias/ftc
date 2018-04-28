<div class="row">
	<div class="col-lg-12">
		<h2>Modifica Usuario</h2>
	</div>
	<br /><br /><br /><br />
	<div class="col-lg-6">
		<?php foreach ($exec as $data): ?>
		<form action="index.php" method="post" class="form-group">
			<input type="hidden" name="actualizausr" value="actualizausr" />
			<input type="hidden" name="mail" value="<?php echo $data->USER_EMAIL; ?>" />
			<label for="usuario">Cambiar Usuario: </label>
			<input type="text" name="usuario1" class="form-control" placeholder="<?php echo $data->USER_LOGIN;?>" required="required" />
			<label for="contrasena">Cambiar Contraseña: </label>
			<input type="password" name="contrasena1" class="form-control" placeholder="*********" required="required" />
			<label for="email">Cambiar Correo Electronico: </label>
			<input type="email" name="email1" class="form-control" placeholder="<?php echo $data->USER_EMAIL;?>" required="required" />
			<label for="rol">Rol Actual</label>
			<label for="rol">"<?php echo $data->USER_ROL;?>"</label><br />
			<label for="rol">Nuevo Rol: </label>
			<select name="rol1[]" class="form-control">
				<option value="">Selecciona Rol</option>
				<option value="administracion">Administración</option>
				<option value="usuario">Usuario</option>
			</select>			
			<label for="">Estatus</label>
			<select name="estatus[]" class="form-control">
				<option value="">Selecciona Estatus</option>
				<option value="alta">Alta</option>
				<option value="baja">Baja</option>
			</select>
			<br />
			<button type="submit" class="btn btn-success">Modificar</button>
			<a href="index.php?action=ausers" class="btn btn-warning">Cancelar</a>
		</form>
		<?php endforeach; ?>
	</div>
</div>