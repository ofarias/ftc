

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Revision Ordenes Fallidas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Orden</th>
                                            <th>Proveedor</th>
                                            <th>Fecha Orden</th>
                                            <th>PAGO <br/>TESORERIA</th>
                                            <th>FECHA PAGO</th>
                                            <th>Unidad</th>
                                            <th>Confirmó Proveedor</th>
                                            <th>Historial <br/>Fallos</th>
                                            <th>Motivo Rechazo</th>
                                           
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($fallido as $data):  
                                        ?>
                                       <tr>
                                            <td><?php echo $data->OC;?></td>
                                            <td><?php echo $data->NOMBRE.'<br/>'.$data->ESTADO.'<br/>'.$data->CP;?></td>
                                            <td><?php echo $data->FECHA_OC;?></td>
											<td><?php echo $data->TP_TES;?></td>
                                            <td><?php echo $data->FECHA_PAGO;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->CONFIRMADO;?></td>
                                            <td><?php echo $data->VUELTAS?></td>                      
                                            <td><a href="index.php?action=motivosFallidos&oc=<?php echo $data->OC?>" targe="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Ver y Capturar Motivos </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>