
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pedidos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                        	<th>ID</th>
                                            <th>Pedido</th>
                                            <th>Estatus</th>
                                            <th>Producto</th>
                                            <th>Pedido Cliente</th>
                                            <th>Motivo Cancelacion</th>
                                            <th>Cancelar Pedido</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($exec as $data): 
                        
                                            ?>
                                        <tr>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->CVE_PEDI;?></td>                                            
                                            <form action="index.php" method="POST">
                                            <td>
                                                <input type="text" name="razon" required="required"> 
                                                <input type="hidden" name="pedido" value="<?php echo $data->CVE_DOC;?>">                                               
                                            </td>
                                            <td>
                                                <button name="cancelaPedido" value="enviar"> Cancelar Pedido</button>
                                            </td>
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
