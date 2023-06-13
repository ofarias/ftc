<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              Facturas
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th>FACTURA</th>
                                            <th>CLIENTE</th>
                                            <th>FECHA FACTURACION</th>
                                            <th>FECHA VENCIMIENTO</th>
                                            <th>Dias Vencido</th>
                                            <th>IMPORTE</th>
                                            <th>Aplicado</th>
                                            <th>Nota de Credito</th>
                                            <th>SALDO</th>
                                            <th>Pagos</th>
                                            <th>Nota de credito</th>
                                            <th>Seleccionar Pago</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($docxmaestro as $datos): 
                                            $dias = $datos->DIAS;
                                            if($dias >= 0 ){
                                                $color='style="background-color:orange"';
                                            }else{
                                                $color ='';
                                            }

                                          ?>
                                       <tr  class="odd gradeX" <?php echo $color?>>
                                            <td><?php echO $datos->CVE_DOC;?></td>
                                            <td><?php echo $datos->NOMBRE;?></td>
                                            <td><?php echo $datos->FECHAELAB;?></td>
                                            <td><?php echo $datos->FECHA_VENCIMIENTO;?></td>
                                            <td><?php echo $dias;?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->IMPORTE,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->APLICADO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->IMPORTE_NC,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->SALDO,2);?></td>
                                            <td><?php echo $datos->ID_PAGOS?></td>
                                            <td><?php echo $datos->NC_APLICADAS?></td>
                                            <form action="index.php" method="POST">
                                            <td>
                                            <input name= "docf" type="hidden" value="<?php echo $datos->CVE_DOC;?>"/>
                                            <input type="hidden" name="maestro" value ="<?php echo $data->MAESTRO?>">
                                              <button name="pagoFacturaMaestro" type = "submit" value = "enviar">PAGAR</button>
                                            </td>
                                            </form>
                                        <?php endforeach ?>
                                        </tr>
                                       
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>