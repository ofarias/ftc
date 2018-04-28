<br/>
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
        	 <div class="panel-heading">
             	<h4>Ordenes</h4> 
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
                            <th>Avanzar</th>
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
                                            <td>
                                            	<form action="index.php" method="post">
                                            		<input name="orden" type= "hidden" value="<?php echo $data->CVE_DOC;?>"/>
                                                	<button name="AvanzarOrden" type="submit" value="enviar" class="btn btn-warning">Avanzar <i class="fa fa-angle-double-right"></i></button>
                                            	</form>
                                            </td> 
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