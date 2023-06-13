<br /> <br/> <br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Preparar Material.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Documento</th>
                                            <th>Fecha</th>                                         
                                            <th>Paquete</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Estatus Logistica</th>
                                            <th>Paquete1</th>
                                            <th>de</th>
                                            <th>Paquete2</th>
                                            <th>Tipo</th>
                                            <th>Embalar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($paquetespar as $data):
                                            ?>
                                        <tr>
                                          <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->FECHA_PAQUETE;?></td>
                                            <td><?php echo $data->EMPAQUE;?></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>      
                                            <form action="index.php" method="post" id="asignaembalaje">
                                            <td><input name="paquete1" type="text" required="required" /></td>
                                            <td> de </td>
                                            <td><input name="paquete2" type="text" required="required" /></td>
                                            <td><input name="tipo" type = "text" required="required" /></td>
                                            <td>
                                            <input name="docf" type="hidden" value="<?php echo $data->DOCUMENTO?>"/>
                                            <input name="id" type= "hidden" value="<?php echo $data->ID?>"/>
                                                <button name="asignaembalaje" type="submit" value="embalar" class="btn btn-warning"><i class="fa fa-check"></i></button>
                                            </td> 
                                            </form>      
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
<br/>
<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Materiales Preparados para envio o enviados.
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Documento</th>
                                            <th>Fecha</th>                                         
                                            <th>Paquetes</th>
                                            <th>Clave</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Estatus Logistica</th>

                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($emba as $data):
                                            ?>
                                        <tr>
                                          <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID_PREOC;?></td>
                                            <td><?php echo $data->DOCUMENTO;?></td>
                                            <td><?php echo $data->FECHA_PAQUETE;?></td>
                                            <td><?php echo $data->EMPAQUE;?></td>
                                            <td><?php echo $data->ARTICULO;?></td>
                                            <td><?php echo $data->DESCRIPCION;?></td>
                                            <td><?php echo $data->CANTIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>  
                                            <td><?php echo $data->PAQUETE1;?></td>
                                            <td> de </td>
                                            <td><?php echo $data->PAQUETE2;?></td>
                                            <td><?php echo $data->TIPO_EMPAQUE;?></td>
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
<br />