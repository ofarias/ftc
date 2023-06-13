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
                            Resumen del Producto
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                        	<th>ID</th>
                                            <th>PEDIDO</th>
                                            <th>STATUS</th>
                                            <th>PRODUCTO</th>
                                            <th>ORIGINAL</th>
                                            <th>ORDENADO</th>
                                            <th>FALTANTE</th>
                                            <th>RECIBIDO</th>
                                            <th>FALTANTE</th>
                                            <th>STATUS VENTAS</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($pedido as $data): 
                                            $TIME = time();
                                            $HOY = date("Y-m-d H:i:s", $TIME);    
                                                ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->ORDENADO;?></td>
                                            <td><?php echo $data->REST;?></td>
                                            <td><?php echo $data->RECEPCION;?></td>
                                            <td><?php echo $data->REC_FALTANTE;?></td>
                                            <td><?php echo $data->STATUS_VENTAS?></td>                                                  
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                            </div>
			          </div>
			</div>
		</div>
</div>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ordenes del producto
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                        	<th>ORDEN</th>
                                            <th>PARTIDA</th>
                                            <th>ARTICULO</th>
                                            <th>CANTIDAD</th>
                                            <th>PXR</th>
                                            <th>COSTO</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php 
                                    	foreach ($orden as $data): 
                                            $color = $data->PXR;
                                            if ($color > 0){
                                                $color = "style='background-color:yellow;'";
                                            }?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->PXR;?></td>
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                </table>
                                
                            </div>
			          </div>
			</div>
		</div>
</div>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Recepciones del Producto
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>RECEPCION</th>
                                            <th>PARTIDA</th>
                                            <th>CLAVE</th>
                                            <th>DESCRIPCION</th>
                                            <th>CANTIDAD</th>
                                            <th>COSTO</th>
                                            <th>ESTADO</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php
                                        //var_dump($exec); 
                                        foreach ($recepcion as $data): 

                                            ?>
                                        <tr class="odd gradeX" <?php echo $color;?>>
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->CVE_DOC;?></td>
                                            <td><?php echo $data->NUM_PAR;?></td>
                                            <td><?php echo $data->CVE_ART;?></td>
                                            <td><?php echo $data->DESCR;?></td>
                                            <td><?php echo $data->CANT;?></td>
                                            <td><?php echo $data->TOT_PARTIDA;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
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