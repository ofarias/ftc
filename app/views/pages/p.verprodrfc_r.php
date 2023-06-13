<div class="row">
	<br />
</div>
<div class="row">
	<div class="col-md-6">
		<form action="index.php" method="post">
		  <div class="form-group">
		    <input type="text" name="VerProdRFC2" class="form-control"  placeholder="RFC cliente">
		  </div>
		  <button type="submit" id="VerProdRFC2" class="btn btn-default">Buscar</button>
		  </form>
	</div>
</div>
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            PRODUCTOS POR RFC 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-clientes">
                                    <thead>
                                        <tr>
                                        	<th>Ultimo ID</th>
                                            <th>Ultimo Pedido</th>
                                            <th>Producto</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad Pedida</th>
                                            <th>Nombre Cliente</th>
                                            <th>Clave</th>
                                            <th>Fecha</th>
                                            <th>Precio</th>


                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($productos as $data):

                                            ?>
                                        <tr >
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->NOM_CLI;?></td>
                                            <td><?php echo $data->CLIEN;?></td>
                                            <td><?php echo $data->FECHASOL;?></td>
                                            <td><?php echo $data->PREC;?></td>      
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
