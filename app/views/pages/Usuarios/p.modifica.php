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
			<input type="text" name="usuario1" class="form-control" placeholder="<?php echo $data->USER_LOGIN;?>" value="<?php echo $data->USER_LOGIN?>" required="required" readonly/>
			<label for="contrasena">Cambiar Contraseña: </label>
			<input type="password" name="contrasena1" class="form-control" required="required" maxlength="15" minlength="6" value="<?php echo $data->USER_PASS?>" />			
			<label for="email">Cambiar Correo Electronico: </label>
			<input type="email" name="email1" class="form-control" value="<?php echo $data->USER_EMAIL;?>" required="required" />
			<label for="rol">Rol Actual: </label>
			<label for="rol"><font color="blue"><?php echo $data->NOMROL;?></font></label><br />
			<input type="hidden" value="<?php echo $data->USER_ROL?>" id="lb">
			<label for="rol">Cambiar Rol: </label>
			<select name="rol" class="form-control" id="sel" onChange="verifica(this.value)">
				<option value="<?php echo $data->USER_ROL?>">Selecciona Rol</option>
				<?php foreach($roles as $r){?>
					<option value="<?php echo 'r_'.$r->IDR?>"><?php echo $r->DESCRIPCION?></option>
				<?php }?>
			</select>			
			<label for="rol">Estado Actual: </label>
			<label for="rol"><font color="blue"><?php echo $data->USER_STATUS;?></font></label><br />
			<label for="">Cambiar Estado:</label>
			<select name="estatus" class="form-control"  >
				<option value="<?php echo $data->USER_STATUS?>">Selecciona Estatus</option>
				<option value="alta">Alta</option>
				<option value="baja">Baja</option>
			</select>
			<br />
			<button type="submit" class="btn btn-success">Modificar</button>
			<input type="hidden" value="<?php echo $_SESSION['user']->USER_ROL?>" id="rola">
			<a href="index.php?action=ausers" class="btn btn-warning">Cancelar</a>
		</form>
		<?php endforeach; ?>
	</div>
</div>
<script type="text/javascript">
	function verifica(idr){
		var rola = document.getElementById('rola').value
		var rolo = document.getElementById('lb').value
		if(rola != 'administrador' && idr == 'r_11'){
			alert('Lo siento!!!! Solo los Administradores, pueden dar de alta administradores....')
			document.getElementById('sel').value=rolo
		}
	}

</script>