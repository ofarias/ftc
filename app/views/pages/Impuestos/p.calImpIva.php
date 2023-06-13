<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle del calculo del IVA Pagado vs Acreditado.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-iva">
                                    <thead>
                                        <tr>
                                            <th>Documento<br/>UUID</th>
                                            <th>Emisor</th>
                                            <th>Receptor</th>
                                            <th>Importe <br/>Documento</th>
                                            <th><font color="brown">Cargo</font> / <br/> <font color="green">Abono</font></th>
                                            <th>Fecha</th>
                                            <th>Forma Pago</th>
                                            <th>Banco Receptor</th>
                                            <th>No Operacion</th>
                                            <th>Fecha Pago</th>
                                            <th>Referencia <br/> Estado de Cuenta</th>
                                            <th>Porcentaje Pago</th>
                                            <th>IVA del <br/>Documento</th>
                                            <th>Efecto del Iva</th>
                                            <th>Iva Pagado</th>
                                            <th>Iva Cobrado</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php 
                                            $total = 0;
                                            $totCar =0;
                                            $totAbn = 0;
                                            foreach ($abonos as $a):
                                                $totalIVA = ($a->TOTAL_IVA * $a->NAT);
                                                $total += $totalIVA;
                                                $totAbn += $a->TOTAL_IVA * $a->NAT;
                                         ?>
                                            <tr>
                                                <td><?php echo $a->DOCUMENTO;?><br/><?php echo $a->UUID?></td>
                                                <td><?php echo $a->RFC;?></td>
                                                <td><?php echo $a->NOMBRE;?></td>
                                                <td align="right"><font color="blue"><b><?php echo '$ '.number_format($a->IMPORTE,2);?></b></font></td>
                                                <td align="right"><font color="green"><b><?php echo '$ '.number_format($a->ABONO,2);?></b></font></td>
                                                <td><?php echo $a->FECHA_DOC;?></td>
                                                <td><?php echo $a->FORMA_PAGO?></td>
                                                <td><?php echo $a->BANCO_CUENTA;?></td>
                                                <td><?php echo $a->REF_EDO?></td>
                                                <td><?php echo $a->FECHA_PAGO;?></td>
                                                <td><?php echo $a->REF_EDO_BAN?></td>
                                                <td align="center"><?php echo number_format(($a->PORCENTAJE * 100),2)." %"?></td>
                                                <td align="right"><?php echo '$ '.number_format($a->IVA,2)?></td>
                                                <td align="right"><?php echo '$ '.number_format($totalIVA,2)?></td>
                                                <td align="right"><?php echo '$ '.number_format(0,2)?></td>
                                                <td align="right"><font color="green"><?php echo '$ '.number_format($a->TOTAL_IVA,2)?></font></td>
                                            </tr>
                                        <?php endforeach;?>
                                        <?php foreach ($cargos as $c):
                                            $totalIVA = $c->TOTAL_IVA * $c->NAT;
                                            $total += $totalIVA;
                                            $totCar += ($c->TOTAL_IVA * $a->NAT);
                                         ?>
                                            <tr>
                                                <td><?php echo $c->DOCUMENTO;?><br/><?php echo $c->UUID?></td>
                                                <td><?php echo $c->RFC;?></td>
                                                <td><?php echo $c->NOMBRE;?></td>
                                                <td align="right"><font color="blue"><b><?php echo '$ '.number_format($c->IMPORTE,2);?></b></font></td>
                                                <td align="right"><font color="brown"><b><?php echo '$ '.number_format($c->CARGO,2);?></b></font></td>
                                                <td><?php echo $c->FECHA_DOC;?></td>
                                                <td><?php echo $c->FORMA_PAGO?></td>
                                                <td><?php echo $c->BANCO_CUENTA;?></td>
                                                <td><?php echo $c->REF_EDO?></td>
                                                <td><?php echo $c->FECHA_PAGO;?></td>
                                                <td><?php echo $c->REF_EDO_BAN?></td>
                                                <td align="center"><?php echo number_format(($c->PORCENTAJE*100),2)." %"?></td>
                                                <td align="right"><?php echo '$ '.number_format($c->IVA,2)?></td>
                                                <td align="right"><?php echo '$ '.number_format($totalIVA,2)?></td>
                                                <td align="right"><font color="brown"><?php echo '$ '.number_format($c->TOTAL_IVA,2)?></font></td>
                                                <td align="right"><?php echo '$ '.number_format(0,2)?></td>
                                            </tr>
                                        <?php endforeach;?>
                                 </tbody>
                                 <tfoot>
                                        <tr>
                                            <td colspan="13"></td>
                                            <td align="right"><b><?php echo '$ '. number_format($total,2)?></b></td>
                                            <td align="right"><b><?php echo '$ '.number_format($totCar,2)?></b></td>
                                            <td align="right"><b><?php echo '$ '.number_format($totAbn,2)?></b></td>
                                        </tr>
                                 </tfoot>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<br/>