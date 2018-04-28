<meta http-equiv="Refresh" content="240">
<br><br>
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Asignar XML y PDF.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        	<th>Recepción</th>
                                            <th>Orden de compra</th>
                                            <th>Proveedor</th>
                                            <th>Importe</th>
                                            <th>Folio</th>
                                            <th>Estatus</th>
                                            <th>Comprobante</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($exec as $data): 
                                        ?>
                                        <tr class="odd gradeX">                                            
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->ORDEN;?></td>
                                            <td><?php echo $data->PROVEEDOR;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->FOLIO;?></td>
                                            <td><?php echo $data->STATUS_PAGO;?></td>
                                            <td>
                                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                                    Selecciona el XML:
                                                    <input type="file" name="fileToUpload_XML" id="fileToUpload_XML"><br />
                                                    Selecciona el PDF:
                                                    <input type="file" name="fileToUpload_PDF" id="fileToUpload_PDF"><br />
                                                    <input type="submit" value="Cargar archivo" name="submit">
                                                    <input type="hidden" name="cve_doc" value="<?php echo $data->RECEPCION;?>" />
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