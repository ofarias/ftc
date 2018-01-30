<div class="row">
	<br />
</div>
<!--<div class="row">
	<div class="col-md-6">
		<form action="index.php" method="post">
		  <div class="form-group">
		    <input type="text" name="ped" class="form-control" id="pedido" placeholder="Numero de Pedido">
		  </div>
		  <button type="submit" id="pedido" class="btn btn-default">Buscar</button>
		  </form>
	</div>
</div>-->
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Documento
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                        	<th>DOCUMENTO</th>
                                            <th>NOMBRE</th>
                                            <th>FECHA ELABORACION</th>
                                            <th>CANTIDAD TOTAL</th>
                                            <th>IMPORTE</th>
                                            <th>HOY</th>
                                            <th>DIAS</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($cabecera as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->CAN_TOT;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->HOY;?></td>
                                            <td><?php echo $data->DIAS;?></td>        
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
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Detalle Documento
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>PARTIDA</th>
                                        	<th>ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>CANTIDAD</th>
                                            <th>PXR</th>
                                            <th>COSTO</th>
                                            <th>UNIDAD</th>
                                            <th>ALMACEN</th>
                                            <th>TOTAL PARTIDA</th>
                                            <th>RECEPCION DE DOCUMENTO</th>
                                            <th>ESTATUS DE DOCUMENTO</th>
                                            <th>FECHA DE RECEPCION DE DOC</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($detalle as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->COST;?></td>         
                                            <td><?php echo $data->UNI_VENTA;?></td> 
                                            <td><?php echo $data->NUM_ALM;?></td> 
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->DOC_RECEP;?></td>
                                            <td><?php echo $data->DOC_RECEP_STATUS;?></td>
                                            <td><?php echo $data->FECHA_DOC_RECEP;?></td> 
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                                <div class="row">
                                <div class="col-lg-10"></div>
                                <div class="col-lg-2">
                                    <button onclick="window.print()" >Imprimir! <img src="http://icons.iconarchive.com/icons/iconshow/hardware/64/Printer-icon.png"></button>
                                </div>
                                </div>
                                
                            </div>
                            <!-- /.table-responsive -->
			          </div>
			</div>
		</div>
</div>
