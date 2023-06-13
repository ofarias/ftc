<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Marcas Activas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCategorias">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>ID</th>
                                            <th>Clave </th>
                                            <th>NOMBRE COMERCIAL</th>
                                            <th>RAZON SOCIAL</th>
                                            <th>DIRECCION</th>
                                            <th>TELEFONO</th>
                                            <th>CONTACTO</th>
                                            <th>STATUS</th>
                                            <th>EDITAR</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($marcas as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLAVE_MARCA;?></td>
                                            <td><?php echo $data->NOMBRE_COMERCIAL;?></td>
                                            <td><?php echo $data->RAZON_SOCIAL;?></td>
                                            <td><?php echo $data->DIRECCION;?></td>
                                            <td><?php echo $data->TELEFONO;?></td>
                                            <td><?php echo $data->CONTACTO?></td>
                                            <td><?php echo $data->STATUS?></td>
                                            <form action="index.v.php" method="post">
                                            <input type="hidden" name="idm" value="<?php echo $data->ID;?>"/>
                                            <td>
                                             <button name="editaMarca" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Editar</button>
                                             </td> 
                                            </form>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                      <a href="index.v.php?action=crearMarca" class="btn btn-success"> Nueva Marca</a>
            </div>
        </div>
    </div>
</div>
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Marcas Pendientes o de Baja.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCategorias2">
                                    <thead>
                                       <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>ID</th>
                                            <th>Clave </th>
                                            <th>NOMBRE COMERCIAL</th>
                                            <th>RAZON SOCIAL</th>
                                            <th>DIRECCION</th>
                                            <th>TELEFONO</th>
                                            <th>CONTACTO</th>
                                            <th>STATUS</th>
                                            <th>EDITAR</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($marcasT as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLAVE_MARCA;?></td>
                                            <td><?php echo $data->NOMBRE_COMERCIAL;?></td>
                                            <td><?php echo $data->RAZON_SOCIAL;?></td>
                                            <td><?php echo $data->DIRECCION;?></td>
                                            <td><?php echo $data->TELEFONO;?></td>
                                            <td><?php echo $data->CONTACTO?></td>
                                            <td><?php echo $data->STATUS?></td>
                                            <form action="index.v.php" method="post">
                                            <input type="hidden" name="idm" value="<?php echo $data->ID;?>"/>
                                            <td>
                                             <button name="editaMarca" type="submit" value="enviar " class= "btn btn-warning"> 
                                                Editar</button>
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
