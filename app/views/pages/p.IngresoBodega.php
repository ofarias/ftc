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

<?php if(gettype($suministros) == 'array'){ ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                El producto es requerido en las siguientes cotizaciones:<br/>
                Cantidad ingresada: <?php echo $cant?> &nbsp; &nbsp; disponible: <font color="black"><input type="text" size="8" name="disponible" id="disp" value="<?php echo $cant?>" readonly></font>
            </div>
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="">
                        <thead>
                            <tr>     
                                <th>Cotizacion</th>
                                <th>Cliente</th>
                                <th>Ordenado </th>
                                <th>Faltante de Recibir </th>
                                <th>Proveedor Predeterminado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 

                        	$i = 0;
                        	foreach($suministros as $data):
                        	$i++;
                        ?>
                            <tr>
                                <td><?php echo $data->COTIZA?></td>
                                <td><?php echo '('.$data->CLIEN.')'.$data->NOM_CLI?> </td>
                                <td><?php echo $data->ORDENADO?></td>
                                <td><?php echo $data->REC_FALTANTE ?></td>
                                <td><?php echo '('.$data->PROVE.')'.$data->NOM_PROV ;?></td>
                                <td><!--<a href="index.php?action=asignarMatBodega&idib=<?php echo $ingresar?>&idpreoc=<?php echo $data->ID?>&cant=<?php echo $data->REC_FALTANTE?>" onclick="asignar()" class="btn btn-success" >Asignar</a>-->
                                	<input type="button" name="asignar" onclick="asignar(<?php echo $i?>)" class="btn btn-success" value="Asignar" id="boton_<?php echo $i?>">
                                	<input type="hidden" name="restante" value="<?php echo $data->REC_FALTANTE?>" id="faltante_<?php echo $i?>">
                                	<input type="hidden" name="idingreso" value="<?php echo $ingresar?>" id="idi_<?php echo $i?>">
                                	<input type="hidden" name="idpreoc" value="<?php echo $data->ID?>" id="preoc_<?php echo $i?>">
                                </td>
                            			
                            </tr>
                        <?php endforeach?>
                        <input type="hidden" name="itera" value="<?php echo $i?>" id="iterador">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } else{ ?>
<?php } ?>


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
     function asignar(i){
     	if(confirm('Asignar el producto a la solicitud?')){
     		alert('Si');
     		document.getElementById('boton_'+i).classList.add('hide');
     		var faltante = parseFloat(document.getElementById('faltante_'+i).value);
     		var restante = parseFloat(document.getElementById('disp').value);
     		var iding = document.getElementById('idi_'+i).value;
     		var idpreoc = document.getElementById('preoc_'+i).value;
     		var asignado = parseFloat(document.getElementById('faltante_'+i).value);
     		document.getElementById('disp').value= restante - faltante;
     		var it = parseFloat(document.getElementById('iterador').value);
			alert('Faltante: '+ faltante + ' , restante: ' + restante + ' iterador '+ it);

			if((restante - faltante)  >= 0){
				$.ajax({
	     			type:'POST',
	     			url:'index.php',
	     			dataType:'json',
	     			data:{asignar:1, idpreoc:idpreoc, asig:asignado, idi:iding},
	     			success: function(data){

	     				if(data.status == "ok"){
	     					alert('Se creo una asignacion desde Bodega al material, debera de recibir la mercancia para finalizar el proceso.');
	     				
	     				}else{
	     					alert('Ocurrio un error o el producto ya fue asignado desde otro equipo.');
	     					for (var s = 1 ; s <= it; s++) {
	     						document.getElementById('boton_'+s).classList.add('hide');
	     					}
	     				}
	     			},
	     			error: function(data){
	     				alert('Ocurrio un error');
	     			}
	     		});
	     		if((restante - faltante == 0)){
	     			for (var s = 1 ; s <= it; s++) {
	     				document.getElementById('boton_'+s).classList.add('hide');
	     			}
	     		}	
			}else if((restante - faltante) < 0){
				if(confirm('Solo se puede asignar' + restante)){
					$.ajax({
		     			type:'POST',
		     			url:'index.php',
		     			dataType:'json',
		     			data:{asignar:1, idpreoc:idpreoc, asig:restante, idi:iding},
		     			success: function(data){
		     				if(data.status == "ok"){
	     						alert('Se creo una asignacion desde Bodega al material, debera de recibir la mercancia para finalizar el proceso.');
	     					}else{
		     					alert('Ocurrio un error o el producto ya fue asignado desde otro equipo.');
		     					for (var s = 1 ; s <= it; s++) {
		     						document.getElementById('boton_'+s).classList.add('hide');
	     						}
	     					}
		     			},
		     			error: function(data){
		     				alert('Ocurrio un error');
		     			}
	     			});
	     			for (var s = 1 ; s <= it; s++) {
	     				document.getElementById('boton_'+s).classList.add('hide');
	     			}
	     		}
			}
     		
     	}else{
     		alert('No');
     	}
     }


</script>