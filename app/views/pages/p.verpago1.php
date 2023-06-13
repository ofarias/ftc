<meta http-equiv="Refresh" content="240">
<br /><br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ver XML y PDF.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Orden de compra</th>
                                            <th>Proveedor</th>
                                            <th>Importe</th>
                                            <th>Documento anterior</th>
                                            <th>Tipo de pago</th>
                                            <th>Estatus</th>
                                            <th>Comprobante</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($pagos as $data): 
                                        ?>
                                        <tr class="odd gradeX";?>                                            
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->PAGOTESORERIA;?></td>
                                            <td><?php echo $data->TPP;?></td>
                                            <td><?php echo $data->STATUS_PAGO;?></td>

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