<br/>
<br/>
<div>
 <label>Nuevo Producto</label>
 <a href="index?action=altaProducto" class="btn btn-success">Nuevo</a>
 
</div>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Lista de Productos de Ventas.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Vendedor</th>
                                            <th>Categoria</th>
                                            <th>Linea</th>
                                            <th>Marca</th>
                                            <th>Generico / Sinonimo</th>
                                            <th>Clave Distribuidor</th>
                                            <th>Modelo</th>
                                            <th>Empaque</th>
                                            <th>Clave Fabricante</th>
                                            <th>Seleccionar</th>
                                            <th>Produccion</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($catProductos as $data): 
                                            ?>
                                        <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->VENDEDOR;?></td>
                                            <td><?php echo $data->CATEGORIA;?></td>
                                            <td><?php echo $data->LINEA;?></td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->GENERICO;?> <br/> <?php echo $data->SINONIMO?> <br/> <?php echo $data->CALIFICATIVO?></td>
                                            <td><?php echo $data->CLAVE_FABRICANTE?></td>
                                            <td><?php echo $data->SKU_CLIENTE?></td>
                                            <td><?php echo $data->EMPAQUE?></td>
                                            <td><?php echo $data->SKU?></td>
                                            <form action="index.php" method="post">
                                            <input name="ids" type="hidden" value="<?php echo $data->ID?>"/>
                                            <td>
                                            <a href="index.php?action=editaFTCART&ids=<?php echo $data->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Editar </a>
 
                                               <!-- <button name="editaFTCART" type="submit" value="enviar" class="btn btn-info"> Editar </button> -->
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
<br />
