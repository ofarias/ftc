<br />
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">
		<h3>Modificar preorden de compra</h3>
	</div>
<div class="panel panel-body">
		<?php 
			foreach($exec AS $data){

			}
		?>
		<form action="index.php" method="post">
			<div class ="form-group">
				<label for="motivo" class="col-lg-1 control-label">Motivo de cancelación: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="motivo" maxlength="255" placeholder="Escriba los motivos de la cancelación. " required/>	
					</div>
			</div>
			<input type="hidden" name="idpreorden" value="<?php echo $data->ID;?>"/>
			<input type="hidden" name="cotizacion" value="<?php echo $data->COTIZA;?>"/>
			<input type="hidden" name="partida" value="<?php echo $data->PAR; ?>"/>
  			<div class="form-group">
    				<div class="col-sm-offset-1 col-sm-10">
      				<button name="cancelapreorden" type="submit" value="enviar" class="btn btn-warning">Guardar <i class="fa fa-floppy-o"></i></button>
   			 </div>
		</form>
	</div>
</div>
</div>
