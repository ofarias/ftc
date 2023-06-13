<br/>
<div class="row">
    <div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">
		<h3>Asignar Responsable de Marca</h3>
	</div>
<br />
<div class="panel panel-body">


		<form action="index.php" method="post">
			<?php foreach($categoria as $data):
			
			?>
			<input type="hidden" name="idmxc" value="<?php echo $data->ID?>">
			<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Categoria: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="150" name="nombreCategoria" readonly="readonly" value = "<?php echo $data->NOMBRE_CATEGORIA?>"/>
				</div>
			</div>

			<div class="form-group">
				<label for="descripcion" class="col-lg-2 control-label">Abreviatura: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="20" name="abreviatura" required="required" value="<?php echo $data->ABREVIATURA?>"  readonly="readonly"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label"> Marca: </label>
				<div class="col-lg-10">
					<input type="text" name="marca" value="<?php echo $data->CLAVE_MARCA?>">
				</div>
			</div>
			<div class="form-group">
				<label for="marca1" class="col-lg-2 control-label">Responsable: </label>
				<div class="col-lg-10">
					<select name ="responsable" required="required">
						<option value ="">SELECCIONE UN RESPONSABLE</option>
						<?php foreach ($usuarios as $key): ?>
							<option value ="<?php echo $key->NOMBRE ?>"> <?php echo $key->NOMBRE?></option>>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="form-group">
    			<div class="col-lg-offset-2 col-lg-10">
					<button name="editarMXC" type="submit" value="enviar" class="btn btn-warning"> Guardar <i class="fa fa-floppy-o"></i></button>
				</div>
			</div>
		<?php endforeach; ?>
		</form>
	</div>
</div>
</div>
    </div>
</div>

