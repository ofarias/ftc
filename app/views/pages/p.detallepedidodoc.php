<div class="row">
	<div class="col-md-8"></div>
    <div class="col-md-4">
        <table class="table table-hover">
            <thead>
                <th>Estatus</th>
            </thead>
            <tbody>
                <td>estatus</td>
            </tbody>
        </table>
    </div>
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
                                            <th>ORDEN DE COMPRA</th>
                                            <th>PAGO</th>
                                            <th>UNIDAD</th>
                                            <th>CANTIDAD OC</th>
                                            <th>FALTANTE SOLICITAR</th>
                                            <th>RECEPCION</th>
                                            <th>RECIBIDO</th>
                                            <th>FALTANTE</th>
                                            <th>REMISION</th>
                                            <th>FECHA</th>
                                            <th>FACTURA</th>
                                            <th>FECHA</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($detalle as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->ORDEN_DE_COMPRA;?></td>
                                            <td><?php echo $data->TP_TES;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->CANT_SOLICITADA;?></td>         
                                            <td><?php echo $data->FALTA_SOLICITAR;?></td> 
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->CANT_RECIBIDA;?></td>
                                            <td><?php echo $data->REC_FALTANTE;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->FECHA_REM;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->FECHA_FAC;?></td>  
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
