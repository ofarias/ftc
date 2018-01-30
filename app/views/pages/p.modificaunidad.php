<div class="row">
	<div class="col-lg-12">
		<h2>Modifica Unidad</h2>
	</div>
	<br /><br />
	<div class="col-lg-6">
		<?php foreach ($munidad as $data): ?>
		<form action="index.php" method="post" class="form-group">
			<label for="usuario">Numero: </label>
			<input type="text" name="numero" class="form-control" value="<?php echo $data->NUMERO;?>" required="required" />
			<label for="contrasena">Marca: </label>
			<input type="text" name="marca" class="form-control" value="<?php echo $data->MARCA;?>" required="required" />
			<label for="modelo">Modelo: </label>
			<input type="text" name="modelo" class="form-control" value="<?php echo $data->MODELO;?>" required="required" />
			<label for="placas">Placas: </label>
			<input type="text" name="placas" class="form-control" value="<?php echo $data->PLACAS;?>" required="required" />	
			<label for="operador">Operador: </label>
			<input type="text" name="operador" class="form-control" value="<?php echo $data->OPERADOR;?>" required="required" />
			<label for="tipo">Tipo: </label>
			<input type="text" name="tipo" class="form-control" value="<?php echo $data->TIPO;?>" required="required" />
			<label for="tipo2">Tipo 2: </label>
			<input type="text" name="tipo2" class="form-control" value="<?php echo $data->TIPO2;?>" required="required" />
			<label for="coordindor">Coordinador: </label>
			<input type="number" name="coordinador" class="form-control" value="<?php echo $data->COORDINADOR;?>" required="required" />
			<br />
			<input type="hidden" name="idu", value="<?php echo $data->IDU;?>"></input>
			<button type="submit" name="actualizaUnidades" class="btn btn-success">Actualizar!</button>
		</form>
	</div>
		<?php endforeach;?>
	</div>
</div>