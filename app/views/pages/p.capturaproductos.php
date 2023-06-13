<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal">
        <div class="panel panel-default">
                <div class="panel panel-heading">
                        <h3>Alta de productos</h3>
                </div>
        <br />
        <div class="panel panel-body">

                        <form action="index.php" method="post">
                                <div class="form-group">
                                        <label for="clave" class="col-lg-2 control-label">Clave: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="clave" placeholder="Clave" required = "required"/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="descripcion" class="col-lg-2 control-label">Descripcion: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="descripcion" placeholder="Descripción"  required = "required"/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="marca1" class="col-lg-2 control-label">Marca Principal: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="marca1" placeholder="Marca 1" required = "required" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="categoria" class="col-lg-2 control-label">Categoria: </label>
                                        <div class="col-lg-10">
                                                <select class="form-control" name="categoria" required="required">
                                    <option>--Elige Categoria--</option>
                                    <option value="Electrico">Electrico</option>
                                    <option value="Plomeria">Plomeria</option>
                                    <option value="Ferreteria">Ferreteria</option>
                                    <option value="Jarceria">Jarceria y Seguridad</option>
                                    <option value="Material">Material de Construccion y Pinturas</option>
                                    <option value="Fijacion">Fijacion</option>
                                    <option value="Cintas y Adhesivos">Cintas y Adhesivos</option>
                                    <option value="Cerrajeria">Cerrajeria y Herrajes</option>
                                    <option value="Herramientas">Herramientas Manual y Electrica</option>
                                    <option value="Aceros">Aceros y Perfiles</option>
                                    <option value="Soldaduras">Soldaduras</option>
                        </select><br>
                        </div>
                    </div>
                                <!--<input type="text" class="form-control" name="categoria" placeholder ="Categoria" required = "required" /><br>-->
                                <div class="form-group">
                                        <label for="unidadcompra" class="col-lg-2 control-label">Unidad de compra: </label><br/>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="unidadcompra" placeholder ="Piezas" value="Piezas" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="factorventa" class="col-lg-2 control-label">Factor de compra: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="factorcompra" placeholder ="1" value="1" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="unidadventa" class="col-lg-2 control-label">Unidad de venta: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="unidadventa" placeholder="Piezas" value="Piezas" required="required"/><br/>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="factorventa" class="col-lg-2 control-label">Factor de venta: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="factorventa" placeholder ="1" value="1" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="Codigo prov1" class="col-lg-2 control-label">Codigo proveedor Base: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" id="prov1" name="prov1" placeholder ="Codigo proveedor1" required = "required" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="codigo_prov1" class="col-lg-2 control-label">Codigo Producto Proveedor Base: </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="codigo_prov1" placeholder ="Codigo producto proveedor1" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="costo_prov1" class="col-lg-2 control-label">Precio de Lista proveedor Base: </label>
                                        <div class="col-lg-10">	
                                                <input type="number" step="any" class="form-control" name="costo_prov1" id="costo_prov" value="0.00" min="0.00" required="required" onChange="CostoTotal(this.value,desc1.value,desc2.value,desc3.value,desc4.value,iva);"/><br>
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label for="iva" class="col-lg-2 control-label">IVA (Si el producto tiene IVA incluido, seleccionar la casilla): </label>
                                                <div class="col-lg-10">	
                                                        <input type="checkbox" class="form-control" id="iva" name="ivacheck" placeholder ="IVA" value = "0.00" onChange="CostoTotal(costo_prov.value,desc1.value,desc2.value,desc3.value,desc4.value,this);"/><br>
                                                </div>
                                </div>
                <!--		<div class="col-lg-6">  -->
                                <div class="form-group">	
                                        <label for="desc1" class="col-lg-2 control-label">% Descuento 1: </label>
                                        <div class="col-lg-10">		
                                                <input type="number" step="any" class="form-control" name="desc1" id="desc1" value="0.00" placeholder ="Descuento 1" min="0" max="100"  onChange="CostoTotal(costo_prov.value,this.value,desc2.value,desc3.value,desc4.value,iva);"/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="desc2"  class="col-lg-2 control-label">% Descuento 2: </label>
                                        <div class="col-lg-10">		
                                                <input type="number" step="any" class="form-control" name="desc2" id="desc2" value="0.00" placeholder ="Descuento 2" min="0" max="100" onChange="CostoTotal(costo_prov.value,desc1.value,this.value,desc3.value,desc4.value,iva);"/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="desc3" class="col-lg-2 control-label">% Descuento 3: </label>
                                        <div class="col-lg-10">	
                                                <input type="number" step="any" class="form-control" name="desc3" id="desc3" value="0.00" placeholder ="Descuento 3" min="0" max="100" onChange="CostoTotal(costo_prov.value,desc1.value,desc2.value,this.value,desc4.value,iva);"/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="desc4" class="col-lg-2 control-label">% Descuento 4: </label>
                                        <div class="col-lg-10">		
                                                <input type="number" step="any" class="form-control" name="desc4" id="desc4" value ="0.00" placeholder ="Descuento 4" min="0" max="100" onChange="CostoTotal(costo_prov.value,desc1.value,desc2.value,desc3.value,this.value,iva);"/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="desc5" class="col-lg-2 control-label">% Descuento Financiero (no afecta el costo): </label>
                                        <div class="col-lg-10">		
                                                <input type="number" step="any" class="form-control" name="desc5" value = "0.00" placeholder ="Descuento Financiero" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="impuesto" class="col-lg-2 control-label">Impuesto total:</label>
                                        <div class="col-lg-10">		
                                                <input type="number" step="any" class="form-control" name="impuesto" id="impuesto" value = "0.00" placehorlder="Total impuesto" readonly/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="costo_total" class="col-lg-2 control-label">Costo: </label>
                                        <div class="col-lg-10">		
                                                <input type="text" class="form-control" name="costo_total" id="costo_total"  min="0" placeholder ="Costo Final" readonly/><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="prov2" class="col-lg-2 control-label">Codigo proveedor Alterno (opcional): </label>
                                        <div class="col-lg-10">
                                                <input type="text" class="form-control" name="prov2" placeholder ="Codigo proveedor2" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="codigo_prov2" class="col-lg-2 control-label">Codigo Producto Proveedor Alterno (opcional): </label>
                                        <div class="col-lg-10">	
                                                <input type="text" class="form-control" name="codigo_prov2" placeholder ="Codigo producto proveedor2" /><br>
                                        </div>
                                </div>
                                <div class="form-group">
                                        <label for="costo_prov2" class="col-lg-2 control-label">Costo Producto Proveedor Alterno (opcional): </label>
                                        <div class="col-lg-10">		
                                                <input type="number" step="any" class="form-control" name="costo_prov2"  min="0" value="0.00" /><br>
                                        </div>
                                </div>

                                <!--<label for="codigo_clie">Codigo de Producto para el Cliente (opcional): </label>
                                <input type="text" class="form-control" name="codigo_clie" placeholder ="Codigo cliente" /><br>-->
                                <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                                <button name="altaproductos" type="submit" value="enviar" class="btn btn-warning">Guardar <i class="fa fa-floppy-o"></i></button>
                                        </div>
                                </div>
                        </form>
        <!--	</div> -->
        </div>
        </div>
    </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	function CostoTotal(costo_prov,desc1,desc2,desc3,desc4,ivacheck){
		var checkbox = ivacheck;
		var impuesto = 16.00;
		var costoProveedor = costo_prov;
		var descuentos = [desc1,desc2,desc3,desc4,impuesto];
		var total = costoProveedor;
		
		for(var f = 0; f < 5; f++){
			if(f < 4){
				total = total - (total * (descuentos[f]/100));
			}else{
				if(iva.checked == false){
					total = total + (total * (descuentos[f]/100));
					document.getElementById("impuesto").value=total - (total / (1 + (descuentos[4]/100)));
					}else{
						document.getElementById("impuesto").value=total - (total / (1.16));
					  	} 
				}
		}
		
		document.getElementById("costo_total").value=total.toFixed(2);
		document.getElementBtId("costo_prov").value=costoProveedor.toFixed(2);
	}

    	$("#prov1").autocomplete({
		source: "index.php?proveedor=1",
		minLength: 2,
		select: function(event, ui){
			}
		})
 </script>
