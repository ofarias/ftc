<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Categorias.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCategorias">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>ID</th>
                                            <th>NOMBRE_CATEGORIA</th>
                                            <th>ABREVIATURA</th>
                                            <th>RESPONSABLE</th>
                                            <th>PRODUCTOS</th>
                                            <th>STATUS</th>
                                            <th>EDITAR</th>
                                            <th>MARCAS</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($categorias as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->NOMBRE_CATEGORIA;?></td>
                                            <td><?php echo $data->ABREVIATURA;?></td>
                                            <td><?php echo $data->RESPONSABLE;?></td>
                                            <td><?php echo $data->PRODUCTOS;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <form action="index.v.php" method="post">
                                            <input type="hidden" name="idcat" value="<?php echo $data->ID;?>"/>
                                            <td>
                                             <button name="editaCategoria" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Editar</button>
                                             </td> 
                                             <td>
                                                <button name="verMarcasxCategoria" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Ver Marcas </button>
                                                 <!--<a onclick="mensaje()" class= "btn btn-warning"> 
                                                Ver Marcas </a>-->
                                             </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                      <a href="index.v.php?action=crearCategoria" class="btn btn-success"> Nueva Categoria</a>
            </div>
        </div>
    </div>
</div>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Categorias Pendientes o de Baja.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCategorias2">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>ID</th>
                                            <th>NOMBRE_CATEGORIA</th>
                                            <th>ABREVIATURA</th>
                                            <th>RESPONSABLE</th>
                                            <th>PRODUCTOS</th>
                                            <th>STATUS</th>
                                            <th>EDITAR</th>
                                            <th>MARCAS</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($categoriasT as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->NOMBRE_CATEGORIA;?></td>
                                            <td><?php echo $data->ABREVIATURA;?></td>
                                            <td><?php echo $data->RESPONSABLE;?></td>
                                            <td><?php echo $data->PRODUCTOS;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <form action="index.v.php" method="post">
                                            <input type="hidden" name="idcat" value="<?php echo $data->ID;?>"/>
                                            <td>
                                             <button name="editaCategoria" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Editar</button>
                                             </td> 
                                             <td>
                                                <button name="verMarcasxCategoria" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Ver Marcas </button>
                                                 <!--<a onclick="mensaje()" class= "btn btn-warning"> 
                                                Ver Marcas </a>-->
                                             </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                           
                      </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function mensaje(){
        alert("Proximamente, favor de revisar despues del 20 de Abril... Gracias");
    }

</script>