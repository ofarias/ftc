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
                                            <th>Documento</th>
                                            <th>Folio</th>
											<th>Proveedor</th>
                                            <th>Nombre</th>
											<th>Fecha</th>
                                            <th>Tipo Pago Tesoreria</th>
                                            <th>Fecha Pago Tesoreria</th>
                                            <th>Monto</th>
                                            <th>Estado Recepcion</th>
                                            <th>Dias de Atraso</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($exec as $data): ?>
                                        <tr class="odd gradeX">
                                        <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->FOLIO;?></td>
											<td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
											<td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->TP_TES;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
                                            <td><?php echo $data->CAN_TOT;?></td>
                                            <td><?php echo $data->ENLAZADO;?></td>                          
                                            <td><?php echo $data->DIAS;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div> 
			          </div>
			</div>
		</div>
</div>