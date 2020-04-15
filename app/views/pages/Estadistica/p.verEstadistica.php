
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Estadistica <?php echo $t=='Recibidos'? 'Proveedores':'Clientes'?> del <?php echo $anio?>
                           <br/>Total Venta: <?php echo '$ '.number_format($total,2)?>
                           <br/>Total Devoluciones: <?php echo '$ '.number_format($total_dev,2)?>
                           <br/>Total Cancelaciones: <?php echo '$ '.number_format($total_can,2)?>
                           <br/>Total General: <?php echo '$ '.number_format($total - $total_dev - $total_can,2)?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-stat" >
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th>Cliente</th>
                                            <th>Facturado</th>
                                            <th>Cancelado</th>
                                            <th>Devuelto</th>
                                            <th>Total</th>
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
                                            <td><?php echo $key->NOMBRE;?><br/><?php echo $key->RFC ?><a href="index.e.php?action=detStat&cliente=<?php echo $key->RFC?>&mes=<?php echo $mes?>&anio=<?php echo $anio?>&tipo=<?php echo $t?>" target="_blank" class="btn-sm btn-info"> Detalle</a></td>
                                            <td align="right"><font color="green"><?php echo '$ '.number_format($key->FACTURADO,2);?></font></td>
                                            <td align="right"><font color="red"><?php echo '$ '.number_format($key->CANCELADO,2);?></font></td>
                                            <td align="right"><font color="#ffa68e"><b><?php echo '$ '.number_format($key->NOTAS,2);?></b></font></td>
                                            <td><?php echo '$ '.number_format($key->TOTAL_CLIENTE,2)?></td>
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
