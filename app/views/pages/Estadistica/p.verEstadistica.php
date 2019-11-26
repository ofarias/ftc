
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle del Recibo Electronico de Pago.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th>Cliente</th>
                                            <th>Facturado</th>
                                            <th>Cancelado</th>
                                            <th>Devuelto</th>
                                            <th>Porcentaje</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    <?php $i=0; $por10=0; $monto10=0; foreach ($info as $key): $i++;
                                    if($i<=10){
                                        $por10 +=  $key->PORCENTAJE;
                                        $monto10 += $key->FACTURADO;
                                        $color="style=";
                                        }
                                    ?>
                                        <tr>
                                            <td><?php echo $i?></td>
                                            <td><?php echo $key->NOMBRE;?><br/><?php echo $key->CLIENTE?><a href="index.e.php?action=detStat&cliente=<?php echo $key->CLIENTE?>&mes=<?php echo $mes?>&anio=<?php echo $anio?>&tipo=<?php echo $tipo?>" class="btn-sm btn-info"> Detalle</a></td>
                                            <td><?php echo '$ '.number_format($key->FACTURADO,2);?></td>
                                            <td><?php echo '$ '.number_format($key->CANCELADO,2);?></td>
                                            <td align="right"><font color="blue"><b><?php echo '$ '.number_format($key->NOTAS,2);?></b></font></td>
                                            <td><?php echo number_format($key->PORCENTAJE,2).' %';?></td>
                                        </tr>
                                    <?php endforeach ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<br/>

<div>
    Total en los primeros 10 = <?php echo number_format($por10,2).' %'?><br/>
    Monto de Venta en los primeros 10 = <?php echo '$ '.number_format($monto10,2)?>
</div>
