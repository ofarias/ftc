<br/>
<div class="row">
    <div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">
		<h3>Alta de Categoria</h3>
	</div>
<br />
<div class="panel panel-body">
		<form action="index.v.php" method="post">
			<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Categoria: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="150" name="nombreCategoria" required="required"/>
				</div>
			</div>

			<div class="form-group">
				<label for="descripcion" class="col-lg-2 control-label">Abreviatura: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="20" name="abreviatura" required="required"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="marca1" class="col-lg-2 control-label">Responsable: </label>
				<div class="col-lg-10">
					<select name ="responsable">
						<option value ="Sin Responsable">Seleccione el Responsable</option>
						<?php foreach ($usuarios as $key): ?>
							<option value ="<?php echo $key->NOMBRE ?>"> <?php echo $key->NOMBRE?></option>>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Estatus: </label>
				<div class="col-lg-10">
					<select name = "status">
						<option value = "P">SELECCIONE STATUS</option>
						<option value = "A"> Alta </option>
						<option value = "B"> Baja </option>
					</select>
				</div>
			</div>

			<div class="form-group">
    			<div class="col-lg-offset-2 col-lg-10">
					<button name="altaCategoria" type="submit" value="enviar" class="btn btn-warning"> Guardar <i class="fa fa-floppy-o"></i></button>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
    </div>
</div>

