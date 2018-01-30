<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                               Categorias por Marcas
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCategorias">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Categoria</th>
                                            <th>Marca</th>
                                            <th>Coordinador</th>
                                            <th>Total <br/> Productos</th>
                                            <th>Auxiliar <br/> Asignado</th>
                                            <th>Asignar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($mxc as $data): 
                                        ?>
                                       <tr>
                                            <form action="index.php" method="post">
                                            <td><?php echo $data->NOMBRE_CATEGORIA;?></td>
                                            <td><?php echo $data->CLAVE_MARCA;?></td>
                                            <td><?php echo $data->RESPONSABLE;?></td>
                                            <td><?php echo $data->PRODXMARCA;?></td>
                                            <td><?php echo $data->AUXILIAR;?></td>
                                            <input type="hidden" name="id" value="<?php echo $data->ID;?>"/>
                                            <td>
                                                <button name="editarMXC" type="submit" value="enviar" 
                                                <?php echo empty($data->AUXILIAR)? "class='btn btn-success'":"class='btn btn-danger'"?>class="btn btn-success"
                                                > 
                                                <?php echo empty($data->AUXILIAR)? "Asignar":"Cambiar" ?> </button>
                                            </td>
                                            <td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; 
                                        ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>