<br/>
<div class="row">
    <div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">
		<h3>Solicitud</h3>
	</div>
<br />
<div class="panel panel-body">
		<form action="index.php" method="post">
		<?php foreach ($ftcart as $data):?>
			<input type="hidden" name="ids" value = "<?php echo $data->ID?>">
			<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Vendedor: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="20" name="vendedor" readonly="readonly" value="<?php echo $data->VENDEDOR?>" readonly="readonly"/>
				</div>
			</div>

			<div class="form-group">
				<label for="descripcion" class="col-lg-2 control-label">Descripcion: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="50" name="descripcion" placeholder="Nombre Comercial" value="<?php echo $data->GENERICO?>" readonly="readonly"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="marca1" class="col-lg-2 control-label">Marca: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="50" name="marca" placeholder="Razon Social" value="<?php echo $data->MARCA?>" readonly="readonly" >
				</div>
			</div>

			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Categoria: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="100" name="categoria" placeholder="Direccion de la planta" value="<?php echo $data->CATEGORIA?>" readonly="readonly" >
				</div>
			</div>


			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Paquete: </label>
				<?php if($data->EMPAQUE == 2){
						$emp = 'Si';
					}else{
						$emp = 'No';
						}?>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="10" name="paquete" placeholder="Telofono" value="<?php echo $emp?>" readonly="readonly" >
				</div>
			</div>

			<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Motivo de Rechazo: </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" maxlength="150" name="motivo" placeholder="Motivo de Rechazo" required="required" id="mot">
				</div>
			</div>
			<div class="form-group">
    			<div class="col-lg-offset-2 col-lg-10">
					<button name="rechazaSol" type="submit" value="enviar" class="btn btn-danger"  id="btn"> Rechazar <i class="fa fa-floppy-o"></i></button>
				</div>
			</div>
			<?php endforeach ?>
		</form>
	</div>
</div>
</div>
    </div>
</div>
