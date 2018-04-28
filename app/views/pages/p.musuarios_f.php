<br /><br />
<div class="alert-success"><h2>Usuario Actualizado correctamente.</h2></div>
		<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Modifica Usuarios
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios">
                                    <thead>
                                        <tr>
                                           <th>Usuario</th>
                                           <th>Email</th>
                                           <th>Estatus</th>
                                           <th>Rol</th>
                                           <th>Modificar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	//var_dump($exec); 
                                    	foreach ($exec as $data): ?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->USER_LOGIN;?></td>
                                            <td><?php echo $data->USER_EMAIL;?></td>
                                            <td><?php echo $data->USER_STATUS;?></td>
                                            <td><?php echo $data->USER_ROL;?></td>
                                            <!--<td><p><i class="fa fa-chevron-right"></i></p></td> --> 
                                            <td><center><a href="index.php?action=modifica&e=<?php echo $data->USER_EMAIL?>" class="btn btn-warning" role="button"><p><i class="fa fa-chevron-right"></i></p></a></center></td>
                                            <!--<td><center><a style="text-decoration: none" href="index.php?action=modifica&e=<?php echo $data->USER_EMAIL;?>"><p><i class="fa fa-chevron-right"></i></p></a></center></td>-->                                           
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