<br/><br/>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Resultado de Ordenes - Compra
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">
                            <input type="hidden" value="" name="INSRTORCOM"/>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc">
                                    <thead>
                                            <th>PEDIDO</th>
                                            <th>FECHA PEDIDO</th>
                                            <th>CLAVE ARTICULO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UM</th>
                                            <th>CANTIDAD ORIGINAL</th>
                                            <th>FALTANTE</th>
                                            <th>NOMBRE PROVEEDOR</th>
                                            <th>TOTAL</th> 
                                            <th>MOTIVO</th>
                                            <th>MODIFICAR</th>
                                          <!--  <th>CANCELAR</th> -->
                                    </thead>   
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data):
                                        	$ID = $data->ID;?>
                                        <tr class="odd gradeX">
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data ->FECHASOL;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->UM;?></td>
                                            <td><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->REST;?></td>
                                            <td><?php echo $data->NOM_PROV;?></td>          
                                            <td><?php echo number_format($data->TOTAL,2 , '.', ',');?></td>
                                            <td><?php echo $data->OBS;?> </td>
                                            <form name="motivonosuministraF" action="index.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $data->ID;?>" />
                                            <td><button name="modificapreorden" type="submit" class="btn btn-warning" value="Modificar">Modificar</button></td>
                                         <!--   <td><button name="formcancelapreorden" type="submit" class="btn btn-warning" value="Modificar" disabled>Cancelar</button></td> -->
                                          </tr>
                                        </form>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                             <!--   <form name="nosumini" id="nosumini" action="index.php" method="post"></form> -->
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
