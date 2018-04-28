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
                                            <th>IMPORTE</th>
                                            <th>Aplicado</th>
                                            <th>Nota de Credito</th>
                                            <th>SALDO</th>
                                            <th>Pagos</th>
                                            <th>Nota de credito</th>
                         
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($factura as $datos):
                                          $cliente = $datos->CVE_CLPV;
                                          $documento = $datos->CVE_DOC;
                                          $saldof = $datos->SALDOFINAL;
                                          $rfc = $datos->RFC;
                                          ?>
                                       <tr>
                                            <td><?php echO $datos->CVE_DOC;?></td>
                                            <td><?php echo $datos->NOMBRE;?></td>
                                            <td><?php echo $datos->FECHAELAB;?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->IMPORTE,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->APLICADO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->IMPORTE_NC,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->SALDOFINAL,2);?></td>
                                            <td><?php echo $datos->ID_PAGOS?></td>
                                            <td><?php echo $datos->NC_APLICADAS?></td>
                                        <?php endforeach ?>
                                        </tr>                                 
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              Pagos
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables">
                                    <thead>
                                        
                                         <tr>
                                            <th>Folio Banco</th>
                                            <th>Fecha de Registro</th>
                                            <th>FECHA Estado de Cuenta</th>
                                            <th>Banco </th>
                                            <th>Monto</th>
                                            <th>Aplicado</th>
                                            <th>SALDO</th>
                                            <th>Aplicar a Factura</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($pagos as $datos):
                                          $monto = $datos->MONTO;
                                          $saldo = $datos->SALDO;
                                          $aplicado = $monto - $saldo; 
                                          ?>
                                       <tr>
                                            <td><?php echO $datos->FOLIO_X_BANCO;?></td>
                                            <td><?php echo $datos->FECHA;?></td>
                                            <td><?php echo $datos->FECHA_RECEP;?></td>
                                            <td align="right"><?php echo $datos->BANCO;?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->MONTO,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($aplicado,2);?></td>
                                            <td align="right"><?php echo '$ '.number_format($datos->SALDO,2);?></td>
                                            <form action="index.php" method="post">
                                              <input type="hidden" name="clie" value="<?php echo $clie?>">
                                              <input type="hidden" name="idpago" value="<?php echo $datos->ID?>">
                                              <input type="hidden" name="docf" value="<?php echo $docf?>">
                                              <input type="hidden" name="monto" value="<?php echo $datos->SALDO?>">
                                              <input type="hidden" name="saldof" value="<?php echo $saldof?>">
                                              <input type="hidden" name="rfc" value="<?php echo $rfc?>">
                                              <input type="hidden" name="tipo" value="1">
                                              <input type="hidden" name="tipo2" value="<?php echo $tipo?>">
                                            <td>
                                              <button name="PagoDirecto" value="envia" type = "submit" class="btn btn-success"> Aplciar </button>
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