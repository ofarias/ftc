<br />
<br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de productos para Distribuidora Liverpool 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pedido</th>
                                            <th>Pedido Cliente</th>
                                            <th>Clave Producto</th>
                                            <th>Descripcion</th>
                                            <th>Proveedor</th>
                                            <th>Clave Proveedor</th>
                                            <th>Costo Unitario Sin IVA</th>
                                            <th>Cantidad </th>
                                            <th>Fecha de Compra</th>
                                            <th>Precio Unitario Sin IVA</th>
                                            <th>Utilidad Calculada x Unidad</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($ids as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->COTIZA;?></td>
                                            <td><?php echo $data->CVE_PEDI;?></td>
                                            <td><?php echo $data->PROD;?></td>
                                            <td><?php echo $data->NOMPROD;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td align="center"><?php echo $data->CLAVE;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COST,2);?></td>
                                            <td align="center"><?php echo $data->CANT_ORIG;?></td>
                                            <td><?php echo $data->FECHA_DOC;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->PREC,2);?></td>
                                            <td align="right"><?php echo number_format($data->UTILIDAD,2).' %';?></td>      
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

