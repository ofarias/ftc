<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle de ventas mensuales del periodo: <?php echo $mes?> del año <?php echo $anio?>
                        </div>
                        <?php if($tipo == 'vf' or $tipo == 'ac'){?>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-iva">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>UUID</th>
                                            <th>Receptor</th>
                                            <th>SubTotal</th>
                                            <th>IVA</th>
                                            <th>Descuento</th>
                                            <th>Total</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                            $tdes=0; $tst = 0; $tiva = 0; $tt=0;
                                            foreach ($info as $c):
                                                $tst += (($c->UNITARIO_ORIGINAL * $c->CANTIDAD) - $c->DESCUENTO);
                                                $t = (($c->UNITARIO_ORIGINAL * $c->CANTIDAD) - $c->DESCUENTO) + $c->IVA160;
                                                $tt += $t;
                                         ?>
                                            <tr>
                                                <td><?php echo $c->DOCUMENTO ?></td>
                                                <td><?php echo $c->UUID?></td>    
                                                <td><?php echo $c->CLIENTE ?></td>    
                                                <td align="right"><?php echo '$ '. number_format($c->UNITARIO_ORIGINAL * $c->CANTIDAD,2)?></td>    
                                                <td align="right"><?php echo '$ '. number_format($c->IVA160,2)?></td>    
                                                <td align="right"><?php echo '$ '. number_format($c->DESCUENTO,2)?></td>    
                                                <td align="right"><?php echo '$ '. number_format(($c->UNITARIO_ORIGINAL * $c->CANTIDAD) + $c->IVA160,2)?></td>    
                                                <td><?php echo $c->FECHA_DOC?></td>
                                                
                                            </tr>
                                        <?php endforeach;?>
                                 </tbody>
                                 <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td align="right" ><?php echo number_format($tst,2)?></td>    
                                            <td colspan="2"></td>
                                            <td align="right"><?php echo number_format($tt,2)?></td>
                                            <td></td>    
                                        </tr>
                                 </tfoot>
                                </table>
                            </div>
                        </div>
                <?php }elseif($tipo == 'pf'){?>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-iva">
                                    <thead>
                                        <tr>
                                            <th>Banco <br/> Cuenta</th>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Usuario <br/>Conciliacion</th>
                                            <th>Referencia Banco</th>
                                            <th>Folio x Banco</th>
                                            <th>Tipo</th>
                                            <th>Poliza </th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php $total = 0;
                                            foreach ($info as $c):    
                                                $total += $c->MONTO;
                                         ?>
                                            <tr>
                                                <td><?php echo $c->BANCO ?></td>
                                                <td><?php echo $c->FECHA_RECEP ?></td>
                                                <td align="right"><?php echo '$ '.number_format($c->MONTO,2)?></td>    
                                                <td><?php echo $c->USUARIO?></td>    
                                                <td><?php echo $c->OBS?></td>    
                                                <td><?php echo $c->FOLIO_X_BANCO?></td>    
                                                <td><?php echo $c->TIPO?></td>    
                                                <td><?php echo $c->POLIZA_INGRESO?></td>
                                                
                                            </tr>
                                        <?php endforeach;?>
                                 </tbody>
                                 <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td align="right"><?php echo '$ '.number_format($total,2)?></td>    
                                            <td colspan="2"></td>
                                            <td align="right"></td>
                                            <td></td>    
                                        </tr>
                                 </tfoot>
                                </table>
                            </div>
                      </div>
                <?php }?>
            </div>
        </div>
</div>
<br/>