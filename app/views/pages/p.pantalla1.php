<meta http-equiv="Refresh" content="300">
<br /><br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Seguimiento a Pedidos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
											<th>Pedido</th>
											<th>Cliente</th>
                                            <th>Urgente</th>
                                            <th>Fact. Ant.</th>
                                            <th>Fecha Pedido</th>
                                            <th>Producto</th>
											<th>Descripcion</th>
                                            <th>Cantidad Original</th>
                                            <th>Orden de Compra</th>
                                            <!--<th>Cotizacion</th>-->
                                            <th>Cantidad Solicitada</th>
                                            <th>Falta Solicitar</th>
                                            <!--<th>Subcategoria</th> -->
                                            <th>Recepcion</th>
                                            <th>Cantidad Recibida</th>
                                            <th>Faltante por Recibir</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
											<th>Importe</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($exec as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->ID;?></td>
											<td><?php echo $data->PEDIDO;?></td>
											<td><?php echo $data->NOM_CLI;?></td>
                                            <td><?php echo $data->URGENTE;?></td>
                                            <td><?php echo $data->FACT_ANT;?></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->PROD;?></td>
											<td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->ORDEN_DE_COMPRA;?></td>
                                            <td><?php echo $data->CANT_SOLICITADA;?></td>     
                                            <td><?php echo $data->FALTA_SOLICITAR;?></td> <!-- Colocar las existencias -->              
                                            <td><?php echo $data->RECEPCION;?></td>     
                                            <td><?php echo $data->CANT_RECIBIDA;?></td> 
                                            <td><?php echo $data->REC_FALTANTE;?></td>  
                                            <td><?php echo $data->CVE_DOC;?></td>  
                                            <td><?php echo $data->FECHAELAB;?></td>   
                                            <td><?php echo $data->IMPORTE;?></td>
											<!--<td><?php echo $data->FECHFACT;?></td> -->
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