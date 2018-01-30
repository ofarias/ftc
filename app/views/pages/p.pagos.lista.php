<br /><br />
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
        	<div class="panel-heading">
            	Confirmar Pagos
        	</div>
        	<!-- /.panel-heading -->
        	<div class="panel-body">
            	<a href="index.php?action=pago_gastos">Ver gastos para pago</a>
            	<div class="table-responsive">  
                	<span>Solicitud de pago</span>
                	<table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                    	<thead>
                        	<tr>
                            	<th>ORDEN DE COMPRA</th>
                            	<th>PROVEEDOR</th>
                            	<th>FECHA ELABORACION</th>
                            	<th>RECOLECCION / ENTREGA</th>
                            	<th>FECHA ESTIMADA RECEPCION</th>
                            	<th>PAGO REQUERIDO</th>
                            	<th>CONFIRMADO</th>
                            	<th>URGENTE</th>
                            	<th>PAGO REQUERIDO</th>
                        	</tr>
                    	</thead>   
                    	<tfoot>
                        	<tr>
                            	<th colspan="11" style="text-align:right">Total:</th>
                            	<th></th>
                        	</tr>
                    	</tfoot>
                    	<tbody>
                        	<?php
                        	foreach ($exec as $data):

                            	$color = $data->DIAS;
                            	$urgencia = $data->URGENTE;
                            	if ($urgencia == 'U') {
                                	$color = "style='background-color: #04C3DF;'";
                            	} elseif ($color <= 1) {
                                	$color = "style='background-color: white;'";
                            	} elseif ($color == 3) {
                                	$color = "style='background-color:#FFBF00;'";
                            	} elseif ($color > 3 and $color < 7) {
                                	$color = "style='background-color:#81DAF5;'";
                            	} elseif ($color >= 7) {
                                	$color = "style='background-color:red;color:#F1E2E2;opacity: 0.5;'";
                            	}
                            	?>
                            	<tr class="odd gradeX" <?php echo $color; ?> onmousemove="this.style.fontWeight = 'bold';
                                    	this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                            	this.style.cursor = 'default';"
                                	onclick="seleccionaPago('<?php echo $data->CVE_DOC; ?>', '<?php echo $data->NOMBRE; ?>', '<?php echo $data->CVE_CLPV; ?>', '<?php echo $data->IMPORTE ?>', '<?php echo $data->FECHAELAB ?>');">
                                	<td><a href="index.php?action=documentodet&doc=<?php echo $data->CVE_DOC ?>"><?php echo $data->CVE_DOC; ?></a></td>
                                	<td><?php echo $data->NOMBRE; ?></td>
                                	<td><?php echo $data->FECHAELAB; ?></td>
                                	<td>
                                    	<?php
                                    	$tipo = $data->TE;
                                    	$tipo = strtoupper($tipo);
                                    	if ($tipo == 'E') {
                                        	$tipo = 'Entrega';
                                    	} elseif ($tipo == 'R') {
                                        	$tipo = 'Recoleccion';
                                    	} echo $tipo;
                                    	?>
                                	</td>
                                	<td><?php echo $data->FER; ?></td>
                                	<td><?php
                                    	$tipor = $data->TIPOPAGOR;
                                    	$tipor = strtoupper($tipor);
                                    	if ($tipor == 'TR') {
                                        	$tipor = 'Transferencia';
                                    	} elseif ($tipor == 'CH') {
                                        	$tipor = 'Cheque';
                                    	} elseif ($tipor == 'E') {
                                        	$tipor = 'Efectivo';
                                    	} elseif ($tipor == 'CR') {
                                        	$tipor = 'Credito';
                                    	}
                                    	echo $tipor;
                                    	?>
                                	</td>
                                	<td><?php echo $data->CONFIRMADO; ?></td>
                                	<td><?php echo $data->URGENTE; ?></td>
                                	<td><?php echo "$ " . number_format($data->IMPORTE, 2, '.', ','); ?></td>
                            	</tr>
                        	<?php endforeach; ?>
                    	</tbody>
                	</table>
                	<!-- /.table-responsive -->
            	</div>
        	</div>
    	</div>
	</div>
</div>
<form action="index.php" method="POST" id="FORM_ACTION_PAGOS">
	<input name="documento" id="docu" type="hidden" value=""/>
	<input name="proveedor" id="nomprov" type="hidden" value=""/>
	<input name="claveProveedor" id="cveprov" type="hidden" value=""/>
	<input name="importe" id="importe" type="hidden" value="" />
	<input name="fecha" id="fechadoc" type="hidden" value=""/>
	<input name="FORM_NAME" type="hidden" value="FORM_ACTION_PAGO"/>
</form>

<script language="javascript">
	function seleccionaPago(documento, proveedor, claveProveedor, importe, fecha) {
    	if (confirm("Esta seguro de realizar el pago de este documento?")) {
        	document.getElementById("docu").value = documento;
        	document.getElementById("nomprov").value = proveedor;
        	document.getElementById("cveprov").value = claveProveedor;
        	document.getElementById("importe").value = importe;
        	document.getElementById("fechadoc").value = fecha;
        	var form = document.getElementById("FORM_ACTION_PAGOS");
        	form.submit();
    	} else {
        	//nada
    	}
	}
</script>
