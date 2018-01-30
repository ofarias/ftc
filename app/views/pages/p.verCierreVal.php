<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                Revision de Facturacion.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-verFacturas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Proveedor</th>
                                            <th>Recepcion</th>
                                            <th>Fecha Recepcion</th>
                                            <th>Importe</th>
                                            <th>Orden de Compra</th>
                                            <th>Fecha OC</th>
                                            <th>Importe OC</th>
                                            <th>Status Validacion</th>

                                            <th>Usuario Validacion</th>
                                            <th>Factura Proveedor</th>
                                            <th>Guardar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($validaciones as $data): 
                                        ?>
                                       <tr>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo trim($data->CVE_DOC);?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
                                            <td><?php echo $data->OC;?></td>
                                            <td><?php echo $data->OC_FECHAELAB;?></td>
                                            <td><?php echo $data->OC_IMPORTE;?></td>
                                            <td><?php echo $data->OC_STATUS_VAL;?></td>

                                            <td><?php echo $data->OC_USUARIO_VAL;?></td>
                                            <form action="index.php" method="post">
                                            <input type="hidden" name="docr" value ="<?php echo $data->CVE_DOC?>" />
                                            <td>
                                            <input type="text" name="factura" placeholder= "<?php echo ($data->FACTURA_PROV == 'Pendiente')? "Factura Proveedor":"$data->FACTURA_PROV"; ?>" 
                                             <?php echo ($data->FACTURA_PROV == 'Pendiente')? "":"readonly"?> />
                                            </td>
                                            <td>
                                             <button name="guardaFacturaProv" type="submit" value="enviar " class= "btn btn-warning"
                                                <?php echo ($data->FACTURA_PROV != 'Pendiente') ? "disabled":"";?>> 
                                                Guardar <i class="fa fa-floppy-o"></i></button>
                                             </td>
                                            </form>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <form action="index.php" method="post">
                                <button name = "impCierreVal" value = "enviar" type = "submit" class="btn btn-warning">Imprimir Cierre</button>
                            </form>
                      </div>
            </div>
        </div>
</div>

  