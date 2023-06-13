<br>
<br>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Registro de pagos Asociados al cliente y sin asociacion: 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>ID pago</th>
                                            <th>Cliente</th>
                                            <th>Fecha Edo Cta</th>
                                            <th>Monto</th>
                                            <th>Saldo Actual</th>
                                            <th>BANCO</th>
                                            <th>Seleccionar</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>

                                        <?php 
                                        foreach ($pagos as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->CLIENTE;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td><?php echo $data->BANCO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="clie" type="hidden" value="<?php echo $clie?>"/>
                                            <input name="id" type="hidden" value="<?php echo $data->ID?>" />
                                            <input type="hidden" name="monto" value="<?php echo $data->SALDO;?>" />
                                            <input type="hidden" name="saldof" value="<?php echo $saldof?>" />
                                            <td>
                                                <button name="aplicaPago" type="submit" value="enviar" class="btn btn-warning">Seleccionar <i class="fa fa-money"></i></button></td> 
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