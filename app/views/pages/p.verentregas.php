<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Asignacion de Unidad Entrega.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <!--<th>Or</th>-->
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Factura</th>
                                            <th>Fecha Factura</th>
                                            <th>Remision</th>
                                            <th>Fecha Remision</th>
                                            <th>Estatus</th>
                                            <th>Recibir Documentos</th>
                                            <th>Contra Recibo</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($entregas as $data): 
                                            $var=$data->DOCS;
                                        ?>
                                       <tr class="odd gradeX" >
                                            <td><?php echo $data->ID;?></td>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_FACT?>"><?php echo $data->CVE_FACT;?></a></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->FACTURA;?></td>
                                            <td><?php echo $data->FECHAFAC;?></td>
                                            <td><?php echo $data->REMISION;?></td>
                                            <td><?php echo $data->FECHAREM;?></td>
                                            <td><?php echo $data->STATUS_LOG;?></td>
                                            <td>
                                            <form action="index.php" method="post">
                                             <button name="docs" type="submit" value="enviar " class= "btn btn-warning" <?php echo ($var == 'No') ? "" : "disabled";?>>Recibir<i class="fa fa-floppy-o"></i></button></td> 
                                            <td>
                                                <form action="index.php" method="post">
                                                <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                                <input name="idcaja" type = "hidden" value = "<?php echo $data->ID?>" />
                                                <input name="contra" type = "input" value ="" />
                                            </td>                                            
                                            <td>                                                
                                                <button name="guardacr" type="submit" value="enviar" class="btn btn-warning" <?php echo ($var == 'No' )? "disabled":"";?>>Asigna<i class="fa fa-floppy-o"></i></button></td>
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