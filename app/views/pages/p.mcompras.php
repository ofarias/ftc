<br /><br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cotizaciones pendientes de compra
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>PEDIDO</th>
                                            <th>FECHA PEDIDO</th>
                                            <th>DIAS</th>
                                            <th>CLAVE ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UM</th>
                                            <th>CANTIDAD ORIGINAL</th>
                                            <th>FALTANTE</th>
                                            <th>NOMBRE PROVEEDOR</th>
                                            <th>TOTAL</th> 
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($consulta1 as $data): ?>
                                    	
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->COTIZA;?><input type="hidden" name="CVE_DOC" value="<?php echo $data->COTIZA;?>"/></td>
                                            <td><?php echo $data ->FECHASOL;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data ->REST;?><input type="hidden" name="RESTTXT" id="rest_<?php echo $data->ID;?>" value="<?php echo $data->REST;?>"/></td>
                                            <td><?php echo $data->NOM_PROV;?></td>          
                                            <td><?php echo number_format($data->TOTAL,2 , '.', ',');?></td>
                                            <input type="hidden" name="TOTALTXT" value="<?php echo $data->TOTAL;?>"/>
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
<br>
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pago días
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>ORDEN DE COMPRA</th>
                                            <th>PROVEEDOR</th>
                                            <th>FECHA ELABORACION</th>
                                            <th>DIAS</th>
                                            <th>RECOLECCION / ENTREGA</th>
                                            <th>FECHA ESTIMADA RECEPCION</th>
                                            <th>PAGO REQUERIDO</th>
                                            <th>CONFIRMADO</th>
                                            <th>URGENTE</th>
                                            <th>PAGO REQUERIDO</th>                   
                      
                                        </tr>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($consulta2 as $data):?>
                                        <tr class="odd gradeX">
                                           <td><a href="index.php?action=documentodet&doc=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_DOC;?></a></td>
                                           <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php $tipo = $data->TE;
                                             $tipo = strtoupper($tipo);
                                        if ($tipo == 'E'){
                                            $tipo = 'Entrega';
                                        }elseif ($tipo == 'R'){
                                            $tipo = 'Recoleccion';
                                        }  echo $tipo;?> </td>
                                            <td><?php echo $data->FER;?></td>
                                            <td><?php 
                                                    $tipor = $data->TIPOPAGOR;
                                                     $tipor = strtoupper($tipor); 
                                                    if ($tipor == 'TR'){
                                                        $tipor = 'Transferencia';
                                                        }elseif ($tipor =='CH'){
                                                        $tipor = 'Cheque';
                                                        }elseif ($tipor =='E') {
                                                        $tipor = 'Efectivo';
                                                        }elseif($tipor == 'CR'){
                                                        $tipor = 'Credito';
                                                        }
                                                    echo $tipor;?></td>
                                            <td><?php echo $data->CONFIRMADO;?></td>
                                            <td><?php echo $data->URGENTE;?></td>
                                            <td><?php echo "$ " . number_format($data->IMPORTE,2,'.',',');?></td>
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
<br>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Orden sin ruta
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Orden de Compra</th>
                                            <th>Proveedor</th>
                                            <th>Estado</th>
                                            <th>CP</th>
											<th>Fecha OC</th>
                                            <th>Fecha Pago</th>
                                            <th>Monto del Pago</th>
                                            <th>Tipo de Pago</th>
                                            <th>Dias de Atraso</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($consulta3 as $data): ?>
                                       <tr class="odd gradeX" >
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_DOC;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADOPROV;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
											<td><?php echo $data->PAGO_TES;?></td>
                                            <td><?php echo $data->TP_TES;?></td>
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
<br>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Orden sin recepción
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Orden</th>
											<th>Proveedor</th>
											<th>Estado</th>
											<th>CP</th>
											<th>Fecha orden</th>
											<th>Dias</th>
											<th>Unidad</th>
											<th>Ruta</th>
											<th>Operador</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($consulta4 as $data):?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->RUTA;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>       
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