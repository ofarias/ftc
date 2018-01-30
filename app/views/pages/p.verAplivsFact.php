
<br />


                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>ID pago</th>
                                            <th>Fecha Edo de Cuenta</th>
                                            <th>Monto</th>
                                            <th>Saldo Actual</th>
                                            <th>BANCO</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($aplicaciones as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td align="center"><?php echo $data->ID;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td align="center"><?php echo $data->BANCO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="idpago" type="hidden" value="<?php echo $data->ID;?>"/>
                                            <td>
                                                <button name="imprimirComprobante" type="submit" value="enviar" class="btn btn-warning">Imprimir Comprobante <i class="fa fa-print"></i></button></td> 
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
<br />

