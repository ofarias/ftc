<br />
<div class="row">
	<div id="creado" class="alert alert-success"><center><h2>Unidad Guardada Correctamente</h2></center></div>
</div>
<div class="row">
	<h3>Formulario para alta de Unidades</h3>
</div>
<br />
<div class="row">
	<div class="col-lg-6">
		<form action="index.php" method="post">
			<input type="text" class="form-control" name="numero" placeholder="Numero" /><br />
			<input type="text" class="form-control" name="marca" placeholder="Marca" /><br />
			<input type="text" class="form-control" name="modelo" placeholder="Modelo" /><br />
			<input type="text" class="form-control" name="placas" placeholder="Placas" /><br />
			<input type="text" class="form-control" name="operador" placeholder="operador" /><br />
			<input type="submit" class="alert alert-warning" name="altaunidadf" value="Dar de Alta!" >
		</form>
	</div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
	var delay = 2500; //delay
		setTimeout(function()
		{ $('#creado').hide(); }, delay);
</script>
