<div class="row">
<br/>
</div>
<div class="row">
	<div class="col-md-6">
		<form action="index.php" method="post">
		  <div class="form-group">
		    <input type="text" name="docp" class="form-control" placeholder="Pedido">
		  </div>
		  <button type="submit" value = "enviar" name = "traePedido" class="btn btn-default">Buscar Pedido</button>
		  </form>
	</div>
</div>
<?php if(!empty($pedido)){?>
<br/>
<br/>
<label><font size="4pxs">Informacion del Pedido <font color="blue"><?php echo $docp?></font></font></label>
<br/>
<br/>

<?php $val=0;
        $caja='';
    foreach ($cajas as $ke): 
        $val=1;
        $caja=$ke->ID
        ;?>
   <label>Informacion de cajas</label>
   <n><p>Caja:<?php echo $ke->ID?>&nbsp;&nbsp;&nbsp;Status: <?php echo $ke->STATUS?>&nbsp;&nbsp;&nbsp;Pedido:<?php echo $ke->CVE_FACT?>&nbsp;&nbsp;&nbsp;Factura:<?php echo empty($ke->FACTURA)? '<font color="red">Sin Factura</font>':$ke->FACTURA?>&nbsp;&nbsp;&nbsp;Remision:<?php echo empty($ke->REMISION)? '<font color="red">Sin Remision</font>':$ke->REMISION?></p></n>
<?php endforeach ?>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                               Pedido.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Id</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Descripcion</th>
                                            <th>Ordenado</th>
                                            <th>Recibido</th>
                                            <th>Empacado</th>
                                            <th>Facturado</th>
                                            <th>Faltante</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pedido as $data): 
                                        	$faltante = $data->CANT_ORIG -$data->EMPACADO;
                                            $color = "style='background-color:white;'";
                                            if($data->STATUS == 'C'){
                                                $color = "style='background-color:red;'"; 
                                            }
                                             
                                        ?>
                                       <tr class='odd gradex' <?php echo $color?>>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->PROD?></td>
                                            <td><?php echo $data->CANT_ORIG?></td>
                                            <td><?php echo $data->NOMPROD?></td>
                                            <td><?php echo $data->ORDENADO?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->EMPACADO?></td>
                                            <td><?php echo $data->FACTURADO?></td>
                                            <td><?php echo $faltante?></td>                       
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                                 <?php if($val==0){?>
                                 <label>Preparar para Prefactura</label>&nbsp;&nbsp;&nbsp;<a onclick="prepararPrefactura('<?php echo $docp?>')" class="btn btn-success"></a>
                                 <?php }else{?>
                                    <label><font color="red">Ya existe la caja <?php echo $caja; ?>, la cual debe de ser facturada antes de poder procesar el faltante.</font></label>
                                <?php }?>
                </div>
            </div>
        </div>
	</div>
</div>
<?php }?>

<script type="text/javascript">
	
	function prepararPrefactura(docp){
		alert("Se prepara la cotizacion: "+docp + " para prefactura");
		$.ajax({
			url:"index.php",
			type:"post",
			dataType:"json",
			data:{prefactura:docp},
			success:function(data){
				alert('Funciono');
                location.reload(true);
            },
            error:function(data){
                alert('Esta pendiente por Facturar');
                location.reload(true);
            }
		});
	}
</script>