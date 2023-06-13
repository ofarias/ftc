<div class="container">
	<div class="row">
		<button id="openeU" class="btn btn-warning">Nueva Unidad <i class="fa fa-plus-circle"></i></button>
	</div>
	<br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Modifica Unidades
                        </div>
                        <?php
                          if(isset($response)){
                            if($response == 'correcto'){
                              ?>
                                <div class="col-lg-12"><center><h3>Comando Ejecutado Correctamente</h3></center></div>
                                <?php
                              }else{

                              }
                          }else{
                          }
                        ?>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                           <th>Numero</th>
                                           <th>Marca</th>
                                           <th>Modelo</th>
                                           <th>Placas</th>                                           
                                           <th>Operador</th>
                                           <th>Tipo</th>
                                           <th>Tipo2</th>
                                           <th>Coordinador</th>
                                           <th>Editar</th>
                                           <th>Eliminar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($unidades as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->NUMERO;?></td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->MODELO;?></td>
                                            <td><?php echo $data->PLACAS;?></td>
                                            <td><?php echo $data->OPERADOR;?></td>
                                            <td><?php echo $data->TIPO;?></td>
                                            <td><?php echo $data->TIPO2;?></td>
                                            <td><?php echo $data->COORDINADOR;?></td>
                                            <td><center><a href="index.php?action=modificaUn&un=<?php echo $data->IDU?>" class="btn btn-warning" role="button"><p><i class="fa fa-pencil-square-o"></i></p></a></center></td>
                                            <td><center><a style="text-decoration: none" href="index.php?action=eliminaUn&un=<?php echo $data->IDU;?>" class="btn btn-warning" role="button"><p><i class="fa fa-trash"></i></p></a></center></td>                   
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
</div>

<!--Fancy Box para nuevo usuarios-->
<div id="dialogU" title="Nueva Unidad">
<div class="row">
	<div class="col-lg-12">
		<h2>Alta Nueva Unidad</h2>
	</div>
	<br /><br />
	<div class="col-lg-6">
		<form action="index.php" method="post" class="form-group">
			<label for="usuario">Numero: </label>
			<input type="text" name="numero" class="form-control" required="required" />
			<label for="contrasena">Marca: </label>
			<input type="text" name="marca" class="form-control" required="required" />
			<label for="modelo">Modelo: </label>
			<input type="text" name="modelo" class="form-control" required="required" />
			<label for="placas">Placas: </label>
			<input type="text" name="placas" class="form-control" required="required" />	
			<label for="operador">Operador: </label>
			<input type="text" name="operador" class="form-control" required="required" />
			<label for="tipo">Tipo: </label>
                        <select name="tipo" class="form-control" required>
                            <option value ="E">Entrega</option>
                            <option value="R">Reparto</option>
                            <option value="A">Ambos</option>
                        </select>
			<label for="tipo2">Tipo 2: </label>                        
                        <select name="tipo2" class="form-control" required>
                            <option value ="E">Entrega</option>
                            <option value="R">Reparto</option>
                            <option value="A">Ambos</option>
                        </select>
			<label for="coordindor">Coordinador: </label>
			<input type="text" name="coordinador" class="form-control" required="required" />
			<br />
			<button type="submit" name="faltaunidades" class="btn btn-success">Alta</button>
		</form>
	</div>
</div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
  var delay = 2500; //delay
    setTimeout(function()
    { $('#creado').hide(); }, delay);
</script>
