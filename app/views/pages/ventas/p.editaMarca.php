<br/>
<div class="row">
    <div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">
		<h3>Alta de Marca</h3>
	</div>
<br />
<div class="panel panel-body">
		<form action="index.v.php" method="post">

		<?php foreach ($marca as $data):?>
			<input type="hidden" name="idm" value = "<?php echo $data->ID?>">
			<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Clave / Nombre: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="20" name="nombreMarca" readonly="readonly" value="<?php echo $data->CLAVE_MARCA?>" />
				</div>
			</div>

			<div class="form-group">
				<label for="descripcion" class="col-lg-2 control-label">NOMBRE COMERCIAL: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="50" name="nombreComercial" placeholder="Nombre Comercial" value="<?php echo $data->NOMBRE_COMERCIAL?>" /><br>
				</div>
			</div>
			<div class="form-group">
				<label for="marca1" class="col-lg-2 control-label">Razon Social: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="50" name="razonSocial" placeholder="Razon Social" value="<?php echo $data->RAZON_SOCIAL?>" >
				</div>
			</div>

			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Direccion de la planta: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="100" name="direccion" placeholder="Direccion de la planta" value="<?php echo $data->DIRECCION?>" >
				</div>
			</div>


			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Telefono: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="10" name="telefono" placeholder="Telofono" value="<?php echo $data->TELEFONO?>" >
				</div>
			</div>

			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Contacto: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="50" name="contacto" placeholder="Contacto" value="<?php echo $data->CONTACTO?>" >
				</div>
			</div>


			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Estatus: </label>
				<div class="col-lg-10">
					<select name="status">
						<option value="<?php echo $data->STATUS?>" > <?php echo $data->STATUS?> </option>
						<option value = "A"> Activo </option>
						<option value = "B"> Baja </option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Periodo de Revision: </label>
				<div class="col-lg-10">
					<select name="periodo">
						<option value = "7"> Semanal </option>
						<option value = "15"> Quincenal </option>
						<option value = "30"> Mensual </option>
						<option value = "60"> Bimestral </option>
						<option value = "180"> Semestral </option> 
						<option value = "365"> Anual </option>
						<option value = "999"> Sin Revision</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Periodo de Revision: </label>
				<div class="col-lg-10">
					<select name="dia">
						<option value = "Lunes"> Lunes </option>
						<option value = "Martes"> Martes </option>
						<option value = "Miercoles"> Miercoles </option>
						<option value = "Jueves"> Jueves </option>
						<option value = "Viernes"> Viernes </option> 
					</select>
				</div>
			</div>
			<div class="form-group">
    			<div class="col-lg-offset-2 col-lg-10">
					<button name="editarMarca" type="submit" value="enviar" class="btn btn-warning"> Editar <i class="fa fa-floppy-o"></i></button>
				</div>
			</div>
			<?php endforeach ?>

		</form>
	</div>
</div>
</div>
    </div>
</div>

