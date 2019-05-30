<div class="row">
	<br />
</div>
<div class="row">
	<div class="col-md-6">
		<form action="index.php" method="post">
		  <div class="form-group">
		    <input type="text" name="ped" class="form-control" id="pedido" placeholder="Numero de Pedido">
		  </div>
		  <button type="submit" id="pedido" class="btn btn-default">Buscar</button>
		  </form>
	</div>
</div>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pedidos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                        	<th>ID</th>
                                            <th>Pedido</th>
                                            <th>Estatus</th>
                                            <th>Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad Pedido</th>
                                            <th>Cant <br/>Ordenada</th>
                                            <th>Cant <br/>Recibida</th>
                                            <th>Cant <br/>Empacado</th>
                                            <th>Cant <br/>Remisionado</th>
                                            <th>Cant <br/>Facturado</th>
                                            <th>Cant <br/>Devuelto</th>
                                            <th>Fecha Rechazo</th>
                                            <th>Motivo Rechazo</th>
                                            <th>Remision</th>
                                            <th>Fecha</th>
                                            <th>Factura</th>
                                            <th>Fecha</th>
                                            <th>Ruta Entrega</th>
                                            <th>Unidad</th>
                                            <th>Fecha Ruta</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($exec as $data): 
                                            $color=$data->ORDENADO;
                                            $color2=$data->RECEPCION;
                                            if ($color == '0'){
                                               $color="style='background-color:yellow;'";             
                                            }elseif($color2=='0'){
                                            $color="style='background-color:#FFBF00;'";
                                            } 
                                            $fecha= '';
                                            if($data->STATUS == 'RE'){
                                                $s='Rechazado';
                                                $fecha=$data->FECHA_RECHAZO;
                                                $color= "style='background-color:#9BA9AE;'";
                                            }elseif ($data->STATUS == 'P'){
                                                $s='Pendiente en Liberacion ';
                                            }elseif ($data->STATUS == 'N'){
                                                $s='Suministros';
                                                $fecha= $data->FECHA_AUTO;
                                            }elseif($data->STATUS == 'C'){
                                                $s='Cancelado';    
                                            }elseif($data->STATUS == 'J'){
                                                $s = 'Compras (Cambio Proveedor)';
                                            }elseif(($data->STATUS == 'B' or $data->STATUS == 'R') and $data->REC_FALTANTE > 0){
                                                $s='Ordenado';
                                            }elseif ($data->STATUS == 'B' and $data->REC_FALTANTE <= 0) {
                                                $s='Completo';
                                            }elseif ($data->STATUS == 'S') {
                                                $statusID = 'No Suministrables';
                                            }else{
                                              $statusID = 'Error Reportar a Sistenas';  
                                            }
                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><a href="index.php?action=historiaIDPREOC&id=<?php echo $data->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->ID;?></a></td>
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $s;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->ORDENADO;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->EMPACADO;?></td>
                                            <td><?php echo $data->REMISIONADO;?></td>
                                            <td><?php echo $data->FACTURADO;?></td>
                                            <td><?php echo $data->DEVUELTO;?></td>
                                            <td><?php echo $fecha;?></td>
                                            <td><?php echo $data->MOTIVO_RECHAZO;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->FECHA_REM;?></td>
                                            <td><?php echo $data->FACTS."<br/>".$data->FACTURAS;?></td>
                                            <td><?php echo $data->FECHA_FAC;?></td>        
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
