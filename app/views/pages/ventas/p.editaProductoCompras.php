<br/>
<div class="row">
    <div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
	<div class="panel panel-heading">

	<?php foreach ($producto as $data){
		if($data->COTIZACION ==0){
			$texto = 'EDITAR PRODUCTO';
		}else{
			$texto = 'Solicitud de Alta de Productos desde Ventas';
		}
		}?>
		<h3><?php echo $texto;?></h3>
	
	</div>
<br />
<div class="panel panel-body">

		<?php foreach ($producto as $data): ?>
			
		<form action="index.php" method="post">
			<input type="hidden" name="cotizacion" value="<?php echo $cotizacion?>">
			<input type="hidden" name="cliente" value="<?php echo $cliente?>">
			<input type="hidden" name="ids" value="<?php echo $data->ID;?>"/>
                        <!-- Control para activar e inactivar producto -->
                        <!-- Fin del control para inactivar producto -->

			<div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Vendedor que Solicita:</label>
				<div class="col-lg-10">
					<label><?php echo $data->VENDEDOR?></label>
				</div>
			</div>            

            <div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Clave : </label>
				<div class="col-lg-10">
					<input type="text" maxlength="20" class="form-control" name="clave" placeholder="Clave del Articulo" value="<?php echo $data->CLAVE_PROD?>" <?php echo ($data->STATUS == 'A')? 'readonly="readonly"':''?>>
				</div>
			</div>

            <div class="form-group">
				<label for="categoria" class="col-lg-2 control-label">Categoria: </label>
				<div class="col-lg-10">
					<select name="categoria" class="form-control">
						<option value="<?php echo $data->CATEGORIA?>"><?php echo $data->CATEGORIA?></option>
						<?php foreach ($categorias as $key): ?>
							<option value="<?php echo $key->NOMBRE_CATEGORIA?>"> <?php echo $key->NOMBRE_CATEGORIA?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

            <div class="form-group">
				<label for="linea" class="col-lg-2 control-label">Linea: </label>
				<div class="col-lg-10">
					<select name="linea" class="form-control">
						<option value="<?php echo $data->LINEA?>"> <?php echo $data->LINEA?> </option>
						<?php foreach ($lineas as $key): ?>
							<option value="<?php echo $key->NOMBRE_LINEA?>"> <?php echo $key->NOMBRE_LINEA?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="descripcion" class="col-lg-2 control-label">Descripcion Compuesta: <br/> Generico + Calificativo + Marca </label>
				<div class="col-lg-10">
					<input type="text" class="form-control" name="descripcion" required = "required" value = "<?php echo $data->GENERICO.' - '.$data->CALIFICATIVO.' - '.$data->MARCA;?>" <?php echo ($data->STATUS =='A')? 'readonly="readonly"':''?> /><br>
				</div>
			</div>
			<div class="form-group">
				<label for="marca1" class="col-lg-2 control-label" >Marca: </label>
				<div class="col-lg-10">
					<select name="marca" class="form-control">
						<option value="<?php echo $data->MARCA?>"><?php echo $data->MARCA?></option>
						<?php foreach ($marcas as $key): ?>
							<option value="<?php echo $key->CLAVE_MARCA?>"><?php echo $key->NOMBRE_COMERCIAL?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
		<div class="form-group">
				<label for="generico" class="col-lg-2 control-label">Generico: </label>
				<div class="col-lg-10">
				<input type="text" maxlength="100" class="form-control" name="generico" value="<?php echo $data->GENERICO?>" /><br>
				</div>
			</div>
			<div class="form-group">
				<label for="sinonimos" class="col-lg-2 control-label">Sinonimos: </label>
				<div class="col-lg-10">
					<input type="text" maxlength="150" class="form-control" name="sinonimos" placeholder="sinonimos" value="<?php echo $data->SINONIMO?>"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="calificativo" class="col-lg-2 control-label">Calificativo: </label>
				<div class="col-lg-10">
					<input type="text" maxlength="200" class="form-control" name="calificativo" placeholder="Calificativos del producto"  value="<?php echo $data->CALIFICATIVO?>"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="medidas" class="col-lg-2 control-label">Medidas: </label>
				<div class="col-lg-10">
					<input type="text" maxlength="20" class="form-control" name="medidas" placeholder="medidas" value="<?php echo $data->MEDIDAS?>"/><br>
				</div>
			</div>
			<!--<label for="marca2">Marca Opcional: </label>
			<input type="text" class="form-control" name="marca2" placeholder="Marca 2" /><br>-->     	 
			<!--<input type="text" class="form-control" name="categoria" placeholder ="Categoria" required = "required" /><br>-->
			<div class="form-group">
				<label for="unidadmedida" class="col-lg-2 control-label">Unidad de Medida: </label><br/>
				<div class="col-lg-10">
						<select name="unidadmedida">
							<option value="<?php echo $data->UM?>"><?php echo $data->UM?></option>
							<?php foreach ($um as $key): ?>
								<option value="<?php echo $key->UM ?>"><?php echo $key->DESCRIPCION ?></option>	
							<?php endforeach ?>
						</select>
			    </div>
			</div> 
			<div class="form-group">
				<label for="empaque" class="col-lg-2 control-label">Se vende por empaque: </label>
				<div class="col-lg-10">
					<select name="empaque">
						<option value='2'><?php echo ($data->EMPAQUE == 0 or $data->EMPAQUE == 2)? "No":"Si" ?></option>
						<option value='0'>No</option>
						<option value='1'>Si</option>
					</select>	
				</div>
			</div>
			
			<div class="form-group">
				<label for="Codigo prov1" class="col-lg-2 control-label">Codigo Proveedor Principal: </label>
				<div class="col-lg-10">			
					<input type="text" class="form-control" id="prov1" name="prov1" placeholder ="Codigo proveedor1" value="<?php echo $data->CLAVE_DISTRIBUIDOR?>"/><br>	
				</div>
			</div>
			<div class="form-group">
				<label for="codigo_prov1" class="col-lg-2 control-label">Codigo Producto Proveedor Base: </label>
					<div class="col-lg-10">
						<input type="text" class="form-control" name="codigo_prov1" placeholder ="Codigo producto proveedor1" value="<?php echo $data->CLAVE_FABRICANTE?>"/><br>
					</div>
			</div>

			 <div class="form-group">
                <label for="Codigo prov1" class="col-lg-2 control-label">Codigo Fabricante: </label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="sku" placeholder ="Codigo Fabricante" value="<?php echo $data->SKU?>"/><br>
                    </div>
            </div>

			<div class="form-group">
				<label for="costo_prov1" class="col-lg-2 control-label">Precio de Lista Proveedor Principal: </label>
				<div class="col-lg-10">	
					<input type="number" step="any" class="form-control" name="costo_prov1" id="costo_prov" min="0.00" value="<?php echo $data->PRECIO?>" onChange="CostoTotal(this.value,desc1.value,desc2.value,desc3.value,desc4.value, desc5.value);"/><br>
				</div>
			</div>

		<!--	<div class="form-group">
				<label for="iva" class="col-lg-2 control-label">IVA (Si el producto tiene IVA incluido, seleccionar la casilla): </label>
					<div class="col-lg-10">	
						<input type="checkbox" class="form-control" id="iva" name="iva" placeholder ="IVA" checked value="si" onChange="CostoTotal(costo_prov.value,desc1.value,desc2.value,desc3.value,desc4.value,this);"/><br>
				</div>
			</div> -->
			<div class="form-group">	
				<label for="desc1" class="col-lg-2 control-label">% Descuento 1: </label>
				<div class="col-lg-10">	
					<input type="number" step="any" class="form-control" name="desc1" id="desc1" placeholder ="Descuento 1" min="0" max="100"
					value="<?php echo ($data->DESC1 == 0)? '':$data->DESC1 ?>" onChange="CostoTotal(costo_prov.value,this.value,desc2.value,desc3.value,desc4.value, desc5.value);"/>
					<label style="font-weight: bold"> Para descontar el IVA capture 13.79</label>
				</div>
			</div>
			<div class="form-group">
				<label for="desc2"  class="col-lg-2 control-label">% Descuento 2: </label>
				<div class="col-lg-10">	
					<input type="number" step="any" class="form-control" name="desc2" id="desc2" placeholder ="Descuento 2" 
					value="<?php echo ($data->DESC2 == 0)? '':$data->DESC2 ?>"  min="0" max="100" 
					onChange="CostoTotal(costo_prov.value,desc1.value,this.value,desc3.value,desc4.value, desc5.value);"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="desc3" class="col-lg-2 control-label">% Descuento 3: </label>
				<div class="col-lg-10">	
					<input type="number" step="any" class="form-control" name="desc3" id="desc3" placeholder ="Descuento 3" min="0" max="100" value="<?php echo ($data->DESC3 == 0)? '':$data->DESC3?>" onChange="CostoTotal(costo_prov.value,desc1.value,desc2.value,this.value,desc4.value, desc5.value);"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="desc4" class="col-lg-2 control-label">% Descuento 4: </label>
				<div class="col-lg-10">		
					<input type="number" step="any" class="form-control" name="desc4" id="desc4" placeholder ="Descuento 4" min="0" max="100" value="<?php echo ($data->DESC4 == 0)? '':$data->DESC4 ?>" onChange="CostoTotal(costo_prov.value,desc1.value,desc2.value,desc3.value, this.value, desc5.value);"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="desc5" class="col-lg-2 control-label">% Descuento Financiero (no afecta el costo): </label>
				<div class="col-lg-10">	
					<input type="number" step="any" class="form-control" name="desc5" id="desc5" placeholder ="Descuento Financiero" min="0" max="100" 
					value="<?php echo ($data->DESCF == 0)? '':$data->DESCF ?>"  
					onChange="CostoTotal(costo_prov.value,desc1.value,desc2.value,desc3.value,desc4.value, this.value);"/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="costo_total" class="col-lg-2 control-label">Costo sin IVA: </label> 
				<div class="col-lg-10">	
					<input type="text" class="form-control" name="costo_total" id="costo_total" min="0" value="<?php echo ($data->COSTO == 0)? '':$data->COSTO ?>" placeholder ="Costo Final" readonly/><br>
				</div>
			</div>
			<div class="form-group">
				<label for="impuesto" class="col-lg-2 control-label">Impuesto total:</label>
				<div class="col-lg-10">	
					<input type="number" step="any" class="form-control" name="impuesto" id="impuesto" placehorlder="Total impuesto" value="<?php echo ($data->IMPUESTO == 0)? '':$data->IMPUESTO ?>" readonly/><br>
				</div>
			</div>

			<div class="form-group">
				<label for="costo_total" class="col-lg-2 control-label">Costo Total:</label> 
				<div class="col-lg-10">	
					<input type="text" class="form-control" name="costo_t" id="costo_t" min="0" value="<?php echo ($data->COSTO_T == 0)? '':$data->COSTO_T ?>" placeholder ="Costo Total" readonly/><br>
				</div>
			</div>

			<div class="form-group">
				<label for="costo_total" class="col-lg-2 control-label">Costo de Orden de compra:</label> 
				<div class="col-lg-10">	
					<input type="text" class="form-control" name="costo_oc" id="costo_oc" min="0" value="<?php echo ($data->COSTO_OC == 0)? '':$data->COSTO_OC ?>" placeholder ="Costo Oden de Compra" readonly/><br>
				</div>
			</div>

			<div class="form-group">
    			<div class="col-lg-offset-2 col-lg-10">
					<button name="guardaFTCART" type="submit" value="enviar" class="btn btn-warning"> Guardar <i class="fa fa-floppy-o"></i></button>
				</div>
			</div>
		</form>
		<?php endforeach ?>
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
	 if(e.keyCode == 32){ return false; } 
	});*/

</script>