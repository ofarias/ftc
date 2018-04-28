<div class="row">
	<br />
</div>

<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recepciones 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                        	<th>Orden de Compra</th>
                                            <th>Recepcion</th>
                                            <th>Proveedor</th>
                                            <th>Unidad</th>
                                            <th>Operador</th>
                                            <th>Fecha Recoleccion</th>
                                            <th>Estado Recoleccion</th>
                                            <th>Estado de la Recepcion</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($recep as $data): 

                                            $statusrec = $data->ENLAZADO;
                                            $statuslog = $data->STATUS_LOG;

                                            if($statusrec == 'T'){
                                                $statusrec = 'Total';
                                            }elseif($statusrec == 'P'){
                                                $statusrec = 'Parcial';
                                            }else{
                                                $statusrec = 'Otro';
                                            }

                                            if ($statuslog == $statusrec){
                                                $color = "style='background-color:FFFFFF;'";
                                            }else{
                                                $color = "style='background-color:orange;'";
                                            }                        
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                       
                                            <td><?php echo $data->OC;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $statusrec;?></td>
                                             
                                        </tr>
                                        
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

<div class="row">
    <br />
</div>

<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Productos recibidos.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Recepcion</th>
                                            <th>Partida</th>
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad OC</th>
                                            <th>Cantidad Recibida</th>
                                            <th>Monto</th>
                                            <th>PXR</th>
                                            <th>Cant Recibida</th>
                                            <th>Costo x Producto</th>
                                            <th>Descuento 1</th>
                                            <th>Descuento 2</th>
                                            <th>Descuento 3</th>
                                            <th>Sub Total</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Recibido?</th>
                                            <th>Recibido?</th>
                                            <th>Cambiar Cantidad</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($parRecep as $data): 
                                            $color = "style='background-color:FFFFFF;'";

                                            $cant_oc=$data->CANT_OC;
                                            $cant_r= $data->CANT;

                                            if($cant_oc=$cant_r){
                                                $color = "style='background-color:green;'";
                                            }else{
                                                $color = "style='background-color:red;'";
                                            }


                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->UNI_ALT;?></td>
                                            <td><?php echo $data->CANT_OC;?></td>
                                            <td><?php echo $data->CANT;?></td>                                       
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->PXR_OC;?></td>
                                            <td><?php echo $statusrec;?></td>
                                            <form action="index.php" method="post" id="productosrecibidos">
                                            <input name="docr" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="par" type="hidden" value="<?php echo $data->NUM_PAR?>"/>
                                            <input name="cantorig" type="hidden" value="<?php echo $data->CANT?>"/>
                                            <input name="costoorig" type="hidden" value="<?php echo $data->COST?>"/>
                                            <input name="idpreoc" type="hidden" value="<?php echo $data->ID_PREOC?>"/>
                                            <input name="doco" type="hidden" value="<?php echo $data->DOCO?>"/>
                                            <input name="tot_partida" id="tot_partida" class="tot_partida" type="hidden" value="<?php echo $data->TOT_PARTIDA;?>"/>
                                            <td>
                                            <input name="cantn" type="text" value="<?php echo $data->CANT?>" required = "required"/>
                                            </td>
                                            <td><input type="number" name="desc1" id="desc1" class="desc1" value="0" min="0" max="100"/></td>
                                            <td><input type="number" name="desc2" id="desc2" class="desc2" value="0" min="0" max="100"/></td>
                                            <td><input type="number" name="desc3" id="desc3" class="desc3" value="0" min="0" max="100"/></td>
                                            <td><input type="number" name="subtotal_" id="subtotal" class="subtotal "value="<?php echo $data->TOT_PARTIDA;?>" readonly></td>
                                            <td><input type="text" name="iva" id="iva" class="ivatotal" value="0" readonly /></td>
                                            <td><input type="text" name="total" id="total" class="total" value="0" readonly /></td>
                                            <td>
                                            <input name="coston" type = "text" value="<?php echo $data->COST?>" required ="required"/>
                                            <td>
                                                <button name="ValParOk" type="submit" value="enviar" class="btn btn-warning"><i class="fa fa-check"></i></button>
                                            </td> 
                                            <td>
                                                <button name="ValParNo" type="submit" value="enviar" class="btn btn-warning"><i class="fa fa-close"></i></button>
                                            </td>
                                            </form>      
                                        </tr>

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
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Productos No Recibido o Recibidos en Otras Recepciones.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Recepcion</th>
                                            <th>Partida</th>
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad OC</th>
                                        
                                            <th>Monto</th>
                                            <th>PXR</th>
                                            <th>Estatus</th>

                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($parNoRecep as $data): 
                                            $color = "style='background-color:FFFFFF;'";


                                            $pxr = $data->PXR;
                                            if($pxr > 0){
                                                $color = "style='background-color:red;'";
                                            }else{
                                                $color = "style='background-color:green;'";
                                            }


                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->UNI_ALT;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                        
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->PXR_OC;?></td>
                                            <td><?php echo $statusrec;?></td>
                                            <form action="index.php" method="post">
                                            <input name="docr" type="hidden" value="<?php echo $data->CVE_DOC?>"/>
                                            <input name="par" type="hidden" value="<?php echo $data->NUM_PAR?>"/>
                                    
                                            </form>      
                                        </tr>
                                        
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

<script>
	window.addEventListener('load',CalculaMontosPR,false);
	window.addEventListener('keypress',CalculaMontosPR,false);
	function CalculaMontosPR(){
		
		var total = document.getElementsByClassName("total");
		var subtotal = document.getElementsByClassName("tot_partida");
		var desc1 = document.getElementsByClassName("desc1");
		var desc2 = document.getElementsByClassName("desc2");
		var desc3 = document.getElementsByClassName("desc3");
		var ivatotal = document.getElementsByClassName("ivatotal");
		for(var i = 0; i <= total.length; i++){
			var impuesto = 16.00;
			var iva = 0;
			var descuentos = [desc1[i].value,desc2[i].value,desc3[i].value,impuesto];
			var tot = subtotal[i].value;
			for (var f = 0;f < 4; f++){
				if(f < 3){
						tot = tot - (tot * (descuentos[f]/100));	
					}else{
						iva = tot * (descuentos[f]/100);
						tot = tot + (tot * (descuentos[f]/100));
					}
					ivatotal[i].value = iva.toFixed(2);
					total[i].value = tot.toFixed(2);		
			}
		}
	}
</script>