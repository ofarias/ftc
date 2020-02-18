<meta http-equiv="Refresh" content="240">
<br/>

<a href="index.serv.php?action=altaUsuario" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-success">Alta Usuarios</a>
	<br/><br/>
    	<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Usuarios. 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios-serv">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Cliente</th>
											<th>Nombre (s)</th>
                                            <th>Paterno</th>
                                            <th>Materno</th>
                                            <th>Celular</th>
                                            <th>Correo</th>
                                            <th>Estado</th>
                                            <th>Editar </th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    	<?php
                                    	foreach ($us as $data): 
                                        ?>                 
                                        <tr>
                                            <td><?php echo $data->ID?></td>
                                            <td><?php echo $data->CLIENTE?></td>
                                            <td><?php echo $data->NOMBRE.' '.$data->SEGUNDO ?></td>
                                            <td><?php echo $data->PATERNO ?></td>
                                            <td><?php echo $data->MATERNO ?></td>
                                            <td align="right"><?php echo $data->CELULAR?></td>
                                            <td><?php echo $data->CORREO?></td>
                                            <td align="center"><?php echo $data->STATUS ?></td>
                                            <td><button class="btn btn-info">Editar</button></td>
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