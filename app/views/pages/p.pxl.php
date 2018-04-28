<meta http-equiv="Refresh" content="180">
<br /><br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Catalogo de Inventarios Almacen 9
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>PEDIDO</th>
											<th>CLAVE</th>
                                            <th>URGE</th>
                                            <th>NOMBRE</th>
                                            <th>FECHA</th>
                                            <th>PEDIDO CLIENTE</th>
                                            <th>IMPORTE</th>
                                            <th>Motivo Rechazo</th>
                                            <th>Liberar</th>
                                            <th>Rechazar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($pedidos as $data): 
                                            $color=$data->CAMPLIB2 =='U'?"style='background-color:red;'":"";    

                                        ?>
                                        <tr class="odd gradeX" <?php echo $color;?> >
                                            <td><a href="index.php?action=pedidodet&doc=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_DOC;?></a></td>
											<td><?php echo $data->CVE_CLPV;?></td>
                                            <td><?php echo $data->CAMPLIB2;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->CVE_PEDI;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <form action="index.php" method="post">
                                            <td><input name="motivoRechazo" type="text" /></td>
                                            <input name="docp" type="hidden" value="<?php echo $data->CVE_DOC?>"/>  
                                            <td><button name="liberarpedido" type="submit" class="btn btn-warning">Liberar</button></td>
                                            <td><button name="RechazarPedido" type="submit" class="btn btn-warning">Rechazar</button></td>
                                            </form>
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