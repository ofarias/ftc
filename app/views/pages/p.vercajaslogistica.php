
<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Administracion de ruta de Entrega .
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Fecha Solicitud</th>
                                            <th>Fecha Factura</th>
                                            <th>Factura</th>
                                            <th>Dias Transcurridos</th>
                                            <th>Unidad</th>
                                            <th>Secuencia</th>
                                            <th>Estado Actual</th>
                                            <th>Elije Status </th>
                                            <th>Cambiar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($listacajas as $data):  
                                        ?>
                                       <tr>
                                           <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->FECHFACT;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->SECUENCIA;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td>
                                              <form action="index.php" method="post">
                                                <input name="idc" type="hidden" value="<?php echo $data->ID?>"/>
                                                <input name="docp" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                                <input name="secuencia" type="hidden" value="<?php echo $data->SECUENCIA?>"/>
                                                <input name="uni" type="hidden" value="<?php echo $data->UNIDAD?>" />
                                                <input name="idu" type="hidden" value="<?php echo $data->IDU?>" />
                                                <input name="tipoold" type = "hidden" value = "<?php echo $data->STATUS_LOG?>" />
                                                <select name="tipo" required="required">
                                                    <option>--Elige Nuevo Status--</option>
                                                    <option value="nuevo">Nuevo</option>
                                                    <option value="sec">Secuencia</option>
                                                    <option value="admin">Administracion</option>
                                                </select>
                                            </td>
                                            <td>                                             
                                                <button name="cambiarStatus" type="submit" value="enviar" class="btn btn-warning">Cambiar<i class="fa fa-car"></i></button>
                                              </form>
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
