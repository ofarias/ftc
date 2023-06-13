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
                                            <th>Articulo</th>
											<th>No.Proveedor</th>
                                            <th>Prov</th>
                                            <th>Costo</th>
                                            <th>Nombre</th>
                                            <th>Marca</th>
                                            <th>Almacen</th>
                                            <th>Categoria</th>
                                            <!--<th>Modelo</th>
                                            <th>Division</th> -->
                                            <th>Existencias</th>
                                            <!--<th>Subcategoria</th> -->
                                            <th>CodigoFabricante</th>
                                            <th>ProvEmpaque</th>
                                            <th>CostoEmpaque</th>
                                            <th>UnidadEmpaque</th>
                                            <th>PzasEmpaque</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($exec as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->CVE_ART;?></td>
											<td><?php echo $data->CLAVE;?></td>
                                            <td><?php echo $data->PROVEEDOR;?></td>
                                            <td><?php echo $data->COSTO;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->ALMACEN;?></td>
                                            <td><?php echo $data->CATEGORIA;?></td>
                                            <!--<td><?php echo $data->MODELO;?></td>
                                            <td><?php echo $data->DIVISION;?></td> -->     
                                            <td><?php echo $data->EXIST;?></td> <!-- Colocar las existencias -->              
                                            <!--<td><?php echo $data->SUBCATEGORIA;?></td> -->    
                                            <td><?php echo $data->CODIGO_FABRICANTE;?></td> 
                                            <td><?php echo $data->PROVEEDOR_EMPAQUE;?></td>  
                                            <td><?php echo $data->COSTO_X_EMPAQUE;?></td>  
                                            <td><?php echo $data->UNIDAD_DE_EMPAQUE;?></td>   
                                            <td><?php echo $data->PIEZAS_POR_EMPAQUE;?></td>          
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