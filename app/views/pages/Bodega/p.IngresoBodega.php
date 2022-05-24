<br />
<div class="row">
	<h3>Ingreso de Productos a la Bodega</h3>
</div>
<br />
<div class="row">
	<div class="col-lg-6">
		<form action="index.php" method="post">
			<input type="text" class="form-control" name='descripcion' id='descripcion' value='' class="text" maxlength="90" style="width: 100%" placeholder="Se puede buscar por SKU, Descripcion, Numero de Parte...." /><br/>
			<input type="text" class="form-control" name="cant" placeholder="Cantidad" required="required" /><br/>
			<input type="text" class="form-control" name="marca" placeholder="Marca"  /><br/>
			<input type="text" class="form-control" name="proveedor" placeholder="Proveedor" /> <br/>
			<!--<input type="number" step="any" class="form-control" name="costo" placeholder="Costo" value = '0'/> <br/> -->
			<select name="unidad" class="form-control" required="required" />
			<option value = ""> Unidad de Medida</option> 
			<?php foreach ($um as $key):{
			}?>
				<option value="<?php echo $key->DESCRIPCION?>"><?php echo $key->DESCRIPCION ?></option>
			<?php endforeach ?>
			</select>
			<br/>
			<button type="submit" class="alert alert-warning" name="IngresarBodega" value = "enviar"> Agregar</button>
		</form>
	</div>
</div>

<div id="cuerpo">
    
</div>

</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

    $("#descripcion").autocomplete({
        source: "index.v.php?descAuto=1",
        minLength: 3,
        select: function(event, ui){
        }
    })

   


</script>