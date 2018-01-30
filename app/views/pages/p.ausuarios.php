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
			</select>
			<label for="letra">Letra: </label>
			<input type="text" name="letra" class="form-control" required="required">
			<br />
			<button type="submit" class="btn btn-success">Alta</button>
		</form>
	</div>
</div>