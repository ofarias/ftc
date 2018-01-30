<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Solicitudes Rechazadas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>ID</th>
                                            <th>DESCRIPCION</th>
                                            <th>MARCA</th>
                                            <th>CATEGORIA</th>
                                            <th>FECHA RECHAZO</th>
                                            <th>RECHAZADO POR</th>
                                            <th>MOTIVO</th>
                                            <th>FECHA SOLICITUD</th>
                                            <th>CLIENTE</th>
                                            <th>COTIZACION</th>
                                            <th>ENTERADO</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($rechazos as $data):
                                         
                                        ?>
                                       <tr>
                                            <td><?php echo $data->IDSOL?></td>
                                            <td><?php echo $data->GENERICO?></td>
                                            <td><?php echo $data->MARCA;?></td>
                                            <td><?php echo $data->CATEGORIA;?></td>
                                            <td><?php echo $data->FECHARECHAZO;?></td>
                                            <td><?php echo $data->USUARIORECHAZO;?></td>
                                            <td><?php echo $data->MOTIVO;?></td>
                                            <td><?php echo $data->FECHASOL?></td>
                                            <td><?php echo '( '.$data->CVE_CLIENTE.') '.$data->CLIENTE?></td>
                                            <td><?php echo $data->COTIZACION?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="idr" value="<?php echo $data->IDRECHAZO;?>"/>
                                            <td>
                                            <button name="enterado" type="submit" value="enviar " class= "btn btn-warning"> 
                                            OK    
                                            </button>
                                             </td> 
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
    </div>
</div>
