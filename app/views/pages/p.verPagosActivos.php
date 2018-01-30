<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pagos Registrados al Estado de cuenta.
                        </div>
                        <!-- /.panel-heading -->
<br />
<div class="row">
    <br />
</div>
<div class="row">
    <div class="col-md-6">
        <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" name="monto" class="form-control" required="required" placeholder="Monto del Pago sin comas o Numero de Nota de Credito ">
        </div>
          <button type="submit" value = "enviar" name = "verPagosActivos" class="btn btn-default">Buscar Pago</button>
        </form>
    </div>
</div>
<br />
<br />
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-aplicapago">
                                    <thead>
                                        <tr>
                                            <th>ID pago</th>
                                            <th>FOLIO BANCO</th>
                                            <th>Cliente / RFC</th>
                                            <th>Fecha Edo de Cuenta</th>
                                            <th>Monto</th>
                                            <th>Saldo Actual</th>
                                            <th>BANCO</th>
                                            <th>Seleccionar</th>
                                            <th>Procesar Pago</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                        foreach ($pagos as $data): 
                                            ?>
                                        <tr>
                                         <!--<tr class="odd gradeX" style='background-color:yellow;' >-->
                                            <td><?php echo $data->ID;?></td>
                                            <td><?php echo $data->FOLIO_X_BANCO;?></td>
                                            <td><?php echo $data->CLIENTE.' / '.$data->RFC;?></td>
                                            <td><?php echo $data->FECHA_RECEP;?></td>
                                            <td><?php echo '$ '.number_format($data->MONTO,2);?></td>
                                            <td><?php echo '$ '.number_format($data->SALDO,2);?></td>
                                            <td><?php echo $data->BANCO;?></td>
                                            <form action="index.php" method="post">
                                            <input name="clie" type="hidden" value="<?php echo $cliente?>"/>
                                            <input name="tipo" type="hidden" value="<?php echo $data->CLIENTE?>">
                                            <input name="idpago" type="hidden" value="<?php echo $data->ID?>" />
                                            <input name="docf" type="hidden" value="<?php echo $docf;?>" />
                                            <input type="hidden" name="monto" value="<?php echo $data->SALDO;?>" />
                                            <input type="hidden" name="rfc" value="<?php echo $data->RFC?>" />
                                            <input type="hidden" name="saldof" value="<?php echo $saldof?>" />
                                            <input type="hidden" name="montopago" value="<?php echo $data->MONTO?>" />
                                            <input type="hidden" name="saldopago" value="<?php echo $data->SALDO?>" />
                                            <td>

                                            <?php if($data->SALDO >= 10 ){
                                                ?>

                                                <button name="aplicaPagoDirecto" type="submit" value="enviar" class="btn btn-warning"> Aplicar a Facturas <i class="fa fa-money"></i></button>
                                            <?php }else{ ?>
                                            <a href="index.php?action=pagoFacturas&idp=<?php echo $data->ID?>" target="_blank"? class='btn btn-success'> VerPagos </a>
                                            <?php }?>
                                            </td>
                                            
                                            <td>
                                                <select name = "tipoPago" class="form-control">
                                                    <option value='SS'>--- Seleccione un tipo ---</option>> 
                                                    <option value="DC">Devolucion de Compra</option>
                                                    <option value="DG">Devolucion de Gasto</option>
                                                    <option value="oTEC">Transferencia Entre Cuentas</option>
                                                    <option value="oPCC">Prestamo Caja Chica</option>
                                                </select>
                                                <button name="procesarPago" type="submit" value="enviar" class="btn btn-warning" > --> </button>
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
<br />

