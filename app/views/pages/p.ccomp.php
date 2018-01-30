<div class="container">
	<div class="row">
		<button id="opener" class="btn btn-warning">Agregar Nuevo <i class="fa fa-plus-circle"></i></button>
	</div>
	<br />
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Componentes dados de alta
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>DURACION</th>
                                            <th>TIPO</th>
                                            <th>USUARIO</th>
                                            <th>FECHA CREACION</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($exec as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->SEG_NOMBRE;?></td>
                                            <td><?php echo $data->SEG_DURACION;?></td>
                                            <td><?php echo $data->SEG_TIPO;?></td>
                                            <td><?php echo $data->USUARIO;?></td>
                                            <td><?php echo $data->FECHAR_CREACION;?></td>         
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
<!--Fancy Box para agregar nuevo componente-->
<div id="dialog" title="Agregar Nuevo Componente">
  <form action="index.php" method="post">
	<input type="hidden" name="ccomp" />
	<input type="text" name="nombre" placeholder="Colocar Nombre Componente" /><br />
	<input type="text" name="duracion" placeholder="Duracion en Horas" /><br />
	<input type="text"  name="tipo" placeholder="Tipo" /><br />
	<button type="submit" class="btn btn-warning" >Agregar</button>
  </form>
</div>