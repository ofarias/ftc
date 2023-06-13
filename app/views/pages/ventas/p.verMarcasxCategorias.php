<br/>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Categoria
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>NOMBRE_CATEGORIA</th>
                                            <th>ABREVIATURA</th>
                                            <th>RESPONSABLE</th>
                                            <th>PRODUCTOS</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($categoria as $data): 
                                        	$idcat=$data->ID;
                                        ?>
                                       <tr>
                                            <td><?php echo $data->NOMBRE_CATEGORIA;?></td>
                                            <td><?php echo $data->ABREVIATURA;?></td>
                                            <td><?php echo $data->RESPONSABLE;?></td>
                                            <td><?php echo $data->PRODUCTOS;?></td>
                                            <td><?php echo $data->STATUS;?></td>
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

<label>Buscar Marca: </label>
<form action="index.v.php" method="post">
	<input type="text" name="marca" maxlength="30" placeholder="Buscar por Nombre Comercial o Clave de Marca" >
	<input type="hidden" name="idcat" value="<?php echo $idcat?>">
	<button value = "enviar" type="submit" name="verMarcasxCategoria" class="btn btn-info"> Buscar </button>	
</form>

<?php if($marcas !=false){?>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Marcas x Asignar
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCategorias2">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>CLAVE MARCA</th>
                                            <th>NOMBRE COMERCIAL</th>
                                            <th>RAZON SOCIAL</th>
                                            <th>REVISION CADA:</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($marcas as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->CLAVE_MARCA;?></td>
                                            <td><?php echo $data->NOMBRE_COMERCIAL;?></td>
                                            <td><?php echo $data->RAZON_SOCIAL;?></td>
                                            <td><?php echo $data->REVISION;?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td>
                                            <form action="index.v.php" method="post">
                                            	
                                            	<input type="hidden" name="idmca" value="<?php echo $data->ID?>">
                                            	<input type="hidden" name="idcat" value="<?php echo $idcat?>">
                                            	<button value="enviar" type="submit" name="asignarMarca" class=<?php echo ($data->IDCAT != $idcat)? '"btn btn-success"':'"btn btn-danger"'?>  <?php echo ($data->IDCAT != $idcat)? '':'disabled="disabled"'?> > <?php echo ($data->IDCAT != $idcat)? 'Asignar':'Ya Asignado'?>Asignar </button>
                                            </form>
                                            </td>
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
	
<?php }?>

<?php if(isset($catxmarca)){ 
?>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Marcas Asignadas
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verCategorias2">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>CLAVE MARCA</th>
                                            <th>NOMBRE COMERCIAL</th>
                                            <th>RAZON SOCIAL</th>
                                            <th>REVISION CADA:</th>
                                            <th>STATUS</th>
                                            <th>DESASIGNAR</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($catxmarca as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->NOMBRE_COMERCIAL;?></td>
                                            <td><?php echo $data->RAZON_SOCIAL;?></td>
                                            <td><?php echo $data->REVISION.' Dias';?></td>
                                            <td><?php echo $data->STATUS;?></td>
                                            <td>
                                            <form action="index.v.php" method="post">
                                            	<input type="hidden" name="idmca" value="<?php echo $data->ID?>">
                                            	<input type="hidden" name="idcat" value="<?php echo $idcat?>">
                                            	<button value="enviar" type="submit" name="desasignarMarca" class="btn btn-danger" >DesAsignar</button>
                                            </form>
                                            </td>
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
<?php }?>