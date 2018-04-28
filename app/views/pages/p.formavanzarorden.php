<br/>
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
        	 <div class="panel-heading">
             	<h4>Orden</h4> 
             </div>
             <div class="panel-body">
             	<div class="table-responsive">
                	<table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                    	<thead>
                        	<th>Orden</th>
                           	<th>Proveedor</th>
                       		<th>Fecha elaboración</th>
                            <th>Importe</th>
                            <th>Status</th>
                            <th>Dias</th>
                    	</thead>                                   
                        <tbody>
                        <?php 
                        	foreach ($orden as $data): 
                        	$statusorden = $data->STATUS; 
                        	if($statusorden == 'O') $statusorden = 'Original';
                            	elseif($statusorden == 'C') $statusorden = 'Cancelada';
                                		else $statusorden = 'Emitida';?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->PROVEEDOR;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->IMPORTE;?> </td>
                                            <td><?php echo $statusorden;?></td>
                                            <td><?php echo $data->DIAS;?></td>  
                                        </tr>
                         <?php endforeach; ?>
                         </tbody>
                	</table>
            	</div>
                            <!-- /.table-responsive -->
			</div>
		</div>
		<br>
		<div class="panel panel-default">
        	 <div class="panel-heading">
             	<h4>Partidas Orden de compra</h4> 
             </div>
             <div class="panel-body">
             	<div class="table-responsive">
                	<table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                    	<thead>
                        	<th>Preorden</th>
                        	<th>Clave producto</th>
                        	<th>Descripción</th>
                        	<th>Cantidad</th>
                        	<th>PxR</th>
                        	<th>Total partida</th>
                        	<th>Fecha de recepcón</th>
                        	<th>Avanzar</th>
                    	</thead>                                   
                        <tbody>
                        <?php foreach ($partorden as $partida): ?>
                        	<tr class="odd gradeX">
								<td><?php echo $partida->ID_PREOC;?></td>
								<td><?php echo $partida->CVE_ART;?></td>
								<td><?php echo $partida->DESCR;?></td>
								<td><?php echo $partida->CANT;?></td>
								<td><?php echo $partida->PXR;?></td>
								<td><?php echo $partida->TOT_PARTIDA;?></td>
								<td><?php echo $partida->FECHA_DOC_RECEP;?></td>
								<td>
									<form action="index.php" method="post">
										<input type="hidden" name="idpreoc" value="<?php echo $partida->ID_PREOC;?>"/>
										<input type="hidden" name="partida" value="<?php echo $partida->NUM_PAR;?>"/>
										<input type="hidden" name="idorden" value="<?php echo $partida->CVE_DOC;?>"/>
										<button name="avanzaroc" type="submit" value="enviar" class="btn btn-warning">Avanzar <i class="fa fa-angle-double-right"></i></button>
									</form>
								</td>  
                        	</tr>
                        <?php endforeach;?>
 						</tbody>
                	</table>
            	</div>
                            <!-- /.table-responsive -->
			</div>
			
			<div class="panel-footer">

			</div>
		</div>
		
	</div>
</div>
