<br/>
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
        	 <div class="panel-heading">
             	<h4>Recepción</h4> 
             </div>
             <div class="panel-body">
             	<div class="table-responsive">
                	<table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                    	<thead>
                        	<th>Recepción</th>
                           	<th>OC</th>
                       		<th>Proveedor</th>
                            <th>Unidad</th>
                            <th>Operador</th>
                            <th>Fecha Recoleccion</th>
                            <th>Estado Recoleccion</th>
                            <th>Fecha Recepcion</th>
                            <th>Estado de la Recepcion</th>
                    	</thead>                                   
                        <tbody>
                        <?php 
                        	foreach ($recepcioncabecera as $data): 
                        	$statusrec = $data->ENLAZADO; 
                        	if($statusrec == 'T') $statusrec = 'Total';
                            	elseif($statusrec == 'P') $statusrec = 'Parcial';
                                		else $statusrec = 'Otro';?>
                                		
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->DOC_ANT;?></td>
                                            <td><?php echo $data->PROVEEDOR;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->FECHA_SECUENCIA;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $statusrec;?></td>
                                            <form action="index.php" method="post" id="cancelarecepcion">
                                            <input name="orden" type="hidden" value="<?php echo $data->DOC_ANT;?>"/>
                                            <input name="recepcion" type= "hidden" value="<?php echo $data->CVE_DOC;?>"/>
                                            </form>      
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
             	<h4>Partidas Recepción</h4> 
             </div>
             <div class="panel-body">
             	<div class="table-responsive">
                	<table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                    	<thead>
                        	<th>Partida</th>
                        	<th>Cantidad</th>
                        	<th>Producto</th>
                        	<th>Costo</th>
                        	<th>Iva</th>
                        	<th>Total</th>
                    	</thead>                                   
                        <tbody>
                        <?php foreach ($partrecepcion as $partida): ?>
                        	<tr class="odd gradeX">
								<td><?php echo $partida->NUM_PAR;?></td>
								<td><?php echo $partida->CANT;?></td>
								<td><?php echo $partida->DESCR;?></td>
								<td><?php echo $partida->COST;?></td>
								<td><?php echo $partida->TOTIMP4;?></td>
								<td><?php echo $partida->TOT_PARTIDA;?></td>  
                        	</tr>
                        <?php endforeach;?>
 						</tbody>
                	</table>
            	</div>
                            <!-- /.table-responsive -->
			</div>
			
			<div class="panel-footer">
				<button name="CancelRecepQuery" type="submit" value="enviar" class="btn btn-warning" form="cancelarecepcion">Cancelar <i class="fa fa-times"></i></button>
			</div>
		</div>
		
	</div>
</div>
