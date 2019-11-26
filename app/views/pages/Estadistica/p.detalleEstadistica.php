<br/>
<?php 
    $T = 0;
    foreach ($meses as $mx => $value) {
        $tot = 0;
        foreach ($info as $k) {
            if( date('m', strtotime($k->FECHA)) == $value){
                $T+=$k->IMPORTE;    
                $tot += $k->IMPORTE;
            }
        }
        $x[]=array($mx=>$tot);
    }
?>  
<div>
    <?php echo 'Total Vendido: $ '.number_format($T,2).'<br/>'?>
    <?php 
        for ($i=0; $i < count($x) ; $i++){ 
            foreach ($x[$i] as $m => $t){
                echo '<b>'.str_pad($m, 20,' ',STR_PAD_RIGHT).'</b> $ '.number_format($t,2).' <b>Porcentaje</b> <font color="blue"> '. (($t/$T) * 100).'</font><br/>';
            }
        } 
    ?>
    
</div>

<!--
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle de la Estadistica de Ventas del cliente <?php echo $cliente?>.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Mes</th>
                                            <th>Facturado</th>
                                            <th>Cancelado</th>
                                            <th>Devuelto</th>
                                            <th>Porcentaje</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    <?php $i=0; $por10=0; $monto10=0; foreach ($info as $key): $i++;
                                    
                                    ?>
                                        <tr>
                                            <td><?php echo $i?></td>
                                            <td><?php echo $key->NOMBRE;?><br/><?php echo $key->CLIENTE?><a href="index.e.php?action=detStat&cliente=<?php echo $key->CLIENTE?>" class="btn-sm btn-info"> Detalle</a></td>
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
-->
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle de la Estadistica de Ventas del cliente <?php echo $cliente?>.
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover"  id="dataTables-detStat">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Documento</th>
                                            <th>Fecha</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    <?php $i=0; $por10=0; $monto10=0; foreach ($info as $key): $i++; ?>
                                        <tr>
                                            <td><?php echo $i?></td>
                                            <td><?php echo $key->DOCUMENTO;?></td>
                                            <td><?php echo ($key->FECHA);?></td>
                                            <td><?php echo '$ '.number_format($key->SUBTOTAL,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IVA,2);?></td>
                                            <td align="right"><font color="blue"><b><?php echo '$ '.number_format($key->IMPORTE,2);?></b></font></td>
                                            
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
