

<br /><br />
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Inventatio patio.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-oc1">
                                    <thead>
                                        <tr>
                                            <th>PRODUCTO</th>
                                            <th>DESCRIPCION</th>
                                            <th>UNIDAD</th>
                                            <th>MARCA</th>
                                            <th>CATEGORIA</th>
                                            <th>CANTIDAD</th>
                                            <th>COSTO</th>
                                            <th>SUBTOTAL</th>
                                            <th>IVA</th>
                                            <th>TOTAL</th>
                                            <th>PROVEEDOR</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $totalCosto = 0;
                                        foreach ($inventario as $data): 
                                            $color = '';
                                            $totalCosto = $totalCosto + ($data->COSTO * $data->RESTANTE);
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?> >
                                            <td><?php echo $data->PRODUCTO?></td>
                                            <td><?php echo $data->DESCRIPCION?></td>
                                            <td><?php echo $data->UNIDAD?></td>
                                            <td><?php echo $data->MARCA?></td>
                                            <td><?php echo $data->CATEGORIA?></td>
                                            <td><?php echo $data->RESTANTE?></td>
                                            <td><?php echo $data->COSTO?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->COSTO * $data->RESTANTE,2);?></td>
                                            <td align="right"> <font color="blue"><?php echo '$ '.number_format(($data->COSTO * $data->RESTANTE * .16),2)?></font></td>
                                            <td align="right"><?php echo '$ '.number_format( ($data->COSTO * $data->RESTANTE * 1.16),2)?></td>
                                            <td><?php echo $data->PROVEEDOR?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <label><font size="15px"> <b>Costo Total del Inventario:</b> </font> <font color="red" size="13px"><?php echo '$ '.number_format($totalCosto,2)?></font> <font size="8px"> &nbsp;&nbsp; <font color="blue">IVA : <?php echo number_format($totalCosto*.16,2)?> </font> Total <?php echo '$ '.number_format($totalCosto*1.16,2)?> </font></label>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
                </div>
        </div>
    </div>
</div>
<div>
    <br/>
    <a href="index.php?action=invPatioGral&opcion=5" class="btn btn-success" > Guardar Inventario </a>     
</div>