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
		<p>
			<?php echo "Cotización: ". $data->COTIZA ." Partida: ". $data->PAR ." ID: ". $data->ID;?>
		</p>
		<form action="index.php" method="post">
			<div class ="form-group">
				<label for="producto" class="col-sm-1 control-label">Producto: </label>
				 <div class="col-sm-8">
					<input type="text" class="form-control" name="producto" id="producto" value="<?php echo $data->PROD." : ". $data->NOMPROD;?>" required = "required" readonly/> 
				 </div>
			</div>
			<div class ="form-group">
				<label for="costo" class="col-sm-1 control-label">Costo: </label>
					<div class="col-sm-8">
						<input type="number" step="any" class="form-control" name="costo" min="0" value="<?php echo $data->COSTO;?>" required/>
					</div>
			</div>
			<div class ="form-group">
				<label for="precio" class="col-sm-1 control-label">Precio: </label>
					<div class="col-sm-8">
						<input type="number" step="any" class="form-control" name="precio" value="<?php echo $data->PRECIO;?>" min="0" readonly/>
					</div>
			</div>			
			<div class ="form-group">
				<label for="marca" class="col-sm-1 control-label">Marca: </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="marca" placeholder="Marca" value="<?php echo $data->MARCA;?> " required/>
					</div>
			</div>	
			<div class ="form-group">
				<label for="proveedor" class="col-sm-1 control-label">Proveedor: </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="proveedor" id="proveedor" value = "<?php echo $data->PROVE ." : ". $data->NOM_PROV; ?>" required/>	
					</div>
			</div>
			<div class ="form-group">
				<label for="motivo" class="col-sm-1 control-label">Motivo: </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="motivo" placeholder="Escriba los motivos del cambio..." required/>	
					</div>
			</div>
			<input type="hidden" name="idpreorden" value="<?php echo $data->ID;?>"/>
			<input type="hidden" name="cotizacion" value="<?php echo $data->COTIZA;?>"/>
			<input type="hidden" name="partida" value="<?php echo $data->PAR; ?>"/>
  			<div class="form-group">
    				<div class="col-sm-offset-1 col-sm-10">
      				<button name="formmodificapreorden" type="submit" value="enviar" class="btn btn-warning">Guardar <i class="fa fa-floppy-o"></i></button>
   			 </div>
		</form>
	</div>
</div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	
	$("#proveedor").autocomplete({
		source: "index.php?proveedor=1",
		minLength: 2,
		select: function(event, ui){
		}
	})
	
	$("#producto").autocomplete({
		source: "index.php?producto=1",
		minLength: 2,
		select: function(event, ui){
		}		
	})
	
</script>