<meta http-equiv="Refresh" content="240">
<br /><br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Productos Almacen 10 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Clave Pegaso</th>
											<th>Descripcion</th>
                                            <th>Marca</th>
                                            <th>Categoria</th>
                                            <th>Precio Lista</th>
                                            <th>Desc1</th>
                                            <th>Desc2</th>
                                            <th>Desc3</th>
                                            <th>Desc4</th>
                                            <th>Desc5</th>
                                            <th>IVA</th>
                                            <th>Costo</th>
                                            <th>Factor</th>
                                            <th>Unidad</th>
                                            <th>Ver Proveedores</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($productos as $data): 
                                           /* $color = $data->ESTADO;
                                            if ($color == 'Baja'){
                                               $color="style='background-color:orange;'";             
                                            }*/ 
                                        ?>


                                        <!--<tr class="odd gradeX" <?php echo $color;?>>-->
                                                                                        
                                        <tr>
                                            <td><?php echo $data->ID;?><a class="glyphicon glyphicon-pencil" href="index.php?action=editProd&id=<?php echo $data->ID;?>" style="color:#245269;"></a>&nbsp;&nbsp;</a></td>
											<td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->MARCA1;?></td>
                                            <td><?php echo $data->CATEGORIA;?></td>
                                            <td><?php echo $data->COSTO_TOTAL;?></td>
                                            <td><?php echo $data->DESC1;?></td>
                                            <td><?php echo $data->DESC2;?></td>
                                            <td><?php echo $data->DESC3;?></td>
                                            <td><?php echo $data->DESC4;?></td>
                                            <td><?php echo $data->DESC5;?></td>
                                            <td><?php echo $data->IVA;?></td>
                                            <td><?php echo $data->COSTO_TOTAL;?></td>
                                            <td><?php echo $data->FACTOR_COMPRA;?></td>
                                            <td><?php echo $data->UNIDAD_COMPRA;?></td>
                                            <td>
                                                <input type="button" value="Ver Proveedores"  name="enviar" id="verProv" class="btn btn-info"></center>
                                            </td>

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