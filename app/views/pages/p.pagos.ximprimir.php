<br /><br />
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
        	<div class="panel-heading">
            	Confirmar Pagos
        	</div>
        	<!-- /.panel-heading -->
        	<div class="panel-body">           	 
            	<div class="table-responsive">  
                	<span>Conciliaci&oacute;n de pagos</span>
                	<table class="table table-striped table-bordered table-hover" id="dataTables-table-2">
                    	<thead>
                        	<tr>
                            	<th>TIPO</th>
                            	<th>IDENTIFICADOR</th>
                            	<th>PROVEEDOR</th>
                            	<th>FECHA ELABORACION</th>
                            	<th>IMPORTE</th>
                        	</tr>
                    	</thead>   
                    	<tbody>                       	 
                        	<?php
                        	if($exec!=null){
                            	foreach ($exec as $data):
                            	?>
                            	<tr class="odd gradeX" onmousemove="this.style.fontWeight = 'bold';
                                    	this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                            	this.style.cursor = 'default';"
                                	onclick="seleccionaPago('<?php echo $data->IDENTIFICADOR; ?>', '<?php echo $data->TIPO;?>');">
                                	<td><?php echo $data->TIPO; ?></td>
                                	<td><?php echo $data->IDENTIFICADOR; ?></td>
                                	<td><?php echo $data->NOMBRE; ?></td>
                                	<td><?php echo $data->FECHA_PAGO; ?></td>
                                	<td><?php echo "$ " . number_format($data->MONTO, 2, '.', ','); ?></td>
                            	</tr>
                        	<?php
                            	endforeach;
                        	} else {
                            	?>                          	 
                            	<tr class="odd gradeX">
                                	<td colspan="6">No hay datos</td>
                            	</tr>
                                    	<?php
                        	}
                        	?>
                    	</tbody>
                	</table>
                	<!-- /.table-responsive -->
            	</div>
        	</div>
    	</div>
	</div>
</div>
<form action="index.php" method="POST" id="FORM_ACTION">
	<input name="identificador" id="identificador" type="hidden" value=""/>
	<input name="tipo" id="tipo" type="hidden" value=""/>
	<input name="FORM_ACTION_IMPRIMIR" type="hidden" value="FORM_ACTION_IMPRIMIR"/>
</form>

<script language="javascript">
	function seleccionaPago(documento, tipo) {
    	if (confirm("Esta seguro de imprimir este pago?")) {
        	document.getElementById("identificador").value = documento;
        	document.getElementById("tipo").value = tipo;
        	var form = document.getElementById("FORM_ACTION");
        	form.submit();
    	} else {
        	//nada
    	}
	}
</script>