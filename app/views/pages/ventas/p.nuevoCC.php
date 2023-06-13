<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Maestros   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Sucursales</th>
                                            <th>Cartera Revision</th>
                                            <th>Cartera Cobranza</th>
                                            <th>Centros de Compras</th>
                                            <th>Total CC</th>
                                            <th></th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($maestro as $data): 
                                        	$idm = $data->ID;
                                        ?>
                                        <tr class="odd gradeX" >
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->SUCURSALES;?></td>
                                            <td><?php echo $data->CARTERA;?></td>
                                            <td><?php echo $data->CARTERA_REVISION;?></td>
                                            <td><?php echo $data->CCS?></td>
                                            <td><?php echo $data->TOTCCS?></td>
                                            <td></td>
                                            <td>
                                            <form action="index.php" method="post">
                                                <input type="hidden" name="idm" value="<?php echo $data->ID?>" >
                                                <input type="hidden" name="cvem" value="<?php echo $data->CLAVE?>">
                                                <button name="editarMaestro" value="enviar" type="submit" class="btn btn-info"> Editar </button>
                                            </td>
                                            <td>
                                                <button type="submit" value="enviar" name="verCCC" class="btn btn-success"> CCC </button>
                                            </td>
                                             
                                        </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br />

<br/>
<div class="row">
    <div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">
		<h3>Alta de Centro de Costos</h3>
	</div>
<br />

<div class="panel panel-body">
		<form action="index.php" method="post">

		<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Nombre : </label>
				<div class="col-lg-10">
					<input type="text" maxlength="60" name="nombre" placeholder="Nombre del Centro de Compra" value="" class=" form form-control" required="required">
				</div>
		</div>
		<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Contacto : </label>
				<div class="col-lg-10">
					<input type="text" maxlength="60" name="contacto" placeholder="Persona de contacto" value="" class=" form form-control" required="required">
				</div>
		</div>
		<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Telefono : </label>
				<div class="col-lg-10">
					<input type="text" maxlength="60" name="telefono" placeholder="Telefono del Contacto" value="" class=" form form-control" required="required">
				</div>

		</div>
		<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Presupuesto: </label>
				<div class="col-lg-10">
					<input type="number" step="10000" name="presup" min="0" placeholder="Presupuesto Mensual" value="" class=" form form-control" required="required">
				</div>
		</div>

		<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Asociar individual : </label>
				<div class="col-lg-10">
					<select name = "cliente" required="required" >
						<option value = "">Seleccionar cliente Individual </option>
						<<?php foreach ($individuales as $key): ?>
							<option value= "<?php echo $key->CLAVE?>"><?php echo $key->NOMBRE?></option>
						<?php endforeach ?>	
					</select>
				</div>
		</div>


			<div class="form-group">
    			<div class="col-lg-offset-2 col-lg-10">
    				<input type="hidden" name="cvem" value ="<?php echo $cvem?>">
    				<input type="hidden" name="idm" value="<?php echo $idm?>">
					<button name="creaCC" type="submit" value="enviar" class="btn btn-warning"> Guardar <i class="fa fa-floppy-o"></i></button>
				</div>
			</div>
		</form>

	</div>
</div>
</div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
function CostoTotal(costo_prov,desc1,desc2,desc3,desc4,desc5){
		//var checkbox = iva;
		var impuesto = 16.00;
		var costoProveedor = costo_prov;
		var descuentos = [desc1,desc2,desc3,desc4,impuesto];
		var total = costoProveedor;

		for(var f = 0; f < 5; f++){
			if(f < 4){
				total = total - (total * (descuentos[f]/100));
			}else{
				document.getElementById("impuesto").value=(total * (1.16) - total); 
			}
		}
		var totalsi = total * 1.16;
		var descf = desc5;
		var totaloc = totalsi;

		if(desc5 > 0){
			var desc5 = desc5 / 100;
			totaloc = (total-(total * desc5))*1.16;
		}
		// costo sin IVA.
		document.getElementById("costo_oc").value=totaloc.toFixed(2);
		document.getElementById("costo_t").value=totalsi.toFixed(2);
		document.getElementById("costo_total").value=total.toFixed(2);
		document.getElementBtId("costo_prov").value=costoProveedor.toFixed(2);
	}

	$("#prov1").autocomplete({
		source: "index.v.php?proveedor=1",
		minLength: 2,
		select: function(event, ui){
		}
	})

	/*

	$("#prov1").autocomplete({
		source: "index.php?proveedor=1",
		minLength: 2,
		select: function(event, ui){
			}
		})

	$('input.nospace').keydown(function(e){ 
	 alert (e.keyCode);
	 if(e.keyCode == 32){ return fa
*/
</script>