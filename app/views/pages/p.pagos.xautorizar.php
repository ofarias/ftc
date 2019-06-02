<br /><br />
<div class="row">
	<div class="col-lg-12">
    	<div class="panel panel-default">
        	<div class="panel-heading">
            	Autorizaci&oacute;n de pagos
        	</div>
        	<!-- /.panel-heading -->
        	<div class="panel-body">           	 
            	<div class="table-responsive">  
                	<span>Autorizaci&oacute;n de pagos</span>
                	<table class="table table-striped table-bordered table-hover" id="dataTables">
                    	<thead>
                        	<tr>
                            	<th>TIPO</th>
                            	<th>IDENTIFICADOR</th>
                            	<th>PROVEEDOR</th>
                            	<th>FECHA ELABORACION</th>
<!--                            	<th>CUENTA BANCARIA</th>-->
                            	<th>IMPORTE</th>
                            	<th>DIFERENCIA</th>
                        	</tr>
                    	</thead>   
<!--                    	<tfoot>
                        	<tr>
                            	<th colspan="11" style="text-align:right">Total:</th>
                            	<th></th>
                        	</tr>
                    	</tfoot>-->
                    	<tbody>
                       	 
                        	<?php
                        	if($pagos!=null){
                            	foreach ($pagos as $data):
                            	?>
                            	<tr class="odd gradeX" onmousemove="this.style.fontWeight = 'bold';
                                    	this.style.cursor = 'pointer'" onmouseout="this.style.fontWeight = 'normal';
                                            	this.style.cursor = 'default';"
                                	onclick="seleccionaPago('<?php echo $data->IDENTIFICADOR; ?>', '<?php echo $data->TIPO;?>');">
                                	<td><?php echo $data->TIPO; ?></td>
                                	<td><?php echo $data->IDENTIFICADOR; ?></td>
                                	<td><?php echo $data->NOMBRE; ?></td>
                                	<td><?php echo $data->FECHA_PAGO; ?></td>
                                	<!-- <td><?php echo $data->CUENTA;?></td> -->                                             	 
                                	<td><?php echo "$ " . number_format($data->MONTO, 2, '.', ','); ?></td>
                                	<td><?php echo "$ " . number_format($data->DIFERENCIA, 2, '.', ','); ?></td>
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
	<input name="documento" id="documento" type="hidden" value=""/>
	<input name="tipo" id="tipo" type="hidden" value=""/>
	<input name="FORM_ACTION_XDICTAMINAR" type="hidden" value="FORM_ACTION_XDICTAMINAR"/>
</form>

<script language="javascript">
	function seleccionaPago(documento, tipo) {
        	document.getElementById("documento").value = documento;
        	document.getElementById("tipo").value = tipo;
        	var form = document.getElementById("FORM_ACTION");
        	form.submit();
	}
</script>
