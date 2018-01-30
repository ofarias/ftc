<br/><br/>
     <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Resultado de Ordenes - Compra
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                            <th>PEDIDO</th>
                                            <th>FECHA PEDIDO</th>
                                            <th>CLAVE ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UM</th>
                                            <th>CANTIDAD ORIGINAL</th>
                                            <th>FALTANTE</th>
                                            <th>NOMBRE PROVEEDOR</th>
                                            <th>TOTAL</th> 
                                            <th>MOTIVO</th>
                                            <th>GUARDAR</th>
                                    </thead>   
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data):
                                        	$ID = $data->ID;?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data ->FECHASOL;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data ->REST;?></td>
                                            <td><?php echo $data->NOM_PROV;?></td>          
                                            <td><?php echo number_format($data->TOTAL,2 , '.', ',');?></td>
                                        	<form name="motivonosuministraF" action="index.php" method="post">
                                            <td><input type="text" name="motivo" placeholder="Motivo"></td>
                                            <td>
                                            	<input type="hidden" name="idorden" value="<?php echo $data->ID;?>"/>
                                            	<input type="submit" value="Guardar" name="motivonosuministra" class="btn btn-warning"/>
                                            </td>
                                          </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
            <div class="panel panel-default">	<!-- No suministrables en el menu de ventas (con motivo) -->
                        <div class="panel-heading">
                            No suministrables en panel de ventas
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                            <th>PEDIDO</th>
                                            <th>FECHA PEDIDO</th>
                                            <th>CLAVE ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UM</th>
                                            <th>CANTIDAD ORIGINAL</th>
                                            <th>FALTANTE</th>
                                            <th>NOMBRE PROVEEDOR</th>
                                            <th>TOTAL</th> 
                                            <th>MOTIVO</th>
                                    </thead>   
                                  <tbody>
                                        <?php
                                        foreach ($execm as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data ->FECHASOL;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data ->REST;?></td>
                                            <td><?php echo $data->NOM_PROV;?></td>          
                                            <td><?php echo number_format($data->TOTAL,2 , '.', ',');?></td>
                                            <td><?php echo $data->OBS;?></td>
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