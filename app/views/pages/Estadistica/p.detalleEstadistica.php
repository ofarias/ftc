<br/>
<?php 
    $T=0;$N=0;$C=0;$TC=0;$NC=0;
    foreach ($meses as $mx => $value) {
        $tot = 0; $totn = 0; $totc=0;
        foreach ($info as $k) {
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'I'){
                $T+=$k->IMPORTE;
                $tot += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'E'){
                $N+=$k->IMPORTE;
                $totn += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->STATUS == 'C'){
                $C+=$k->IMPORTE;
                $totc += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'I' and $k->STATUS == 'C'){
                $TC+=$k->IMPORTE;
                //$tot_TC += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'E' and $k->STATUS == 'C'){
                $NC+=$k->IMPORTE;
                //$tot_NC += $k->IMPORTE;
            }
        }
        $x[]=array($mx=>$tot);
    }
?>  
<div>
    <?php echo '<b>Total Facturado: $ '.number_format($T,2).'<b/><br/>'?>
    <?php echo '<b>Total Facturado Cancelado: $ '.number_format($TC,2).'<b/><br/>'?>
    <?php echo '<b>Total Facturado Vigente: $ '.number_format($T - $TC,2).'<b/><br/><br/>'?>

    <?php echo '<b>Total Notas de Credito: $ '.number_format($N,2).'<b><br/>'?>
    <?php echo '<b>Total Notas de Credito Canceladas: $ '.number_format($NC,2).'<b/><br/>'?>
    <?php echo '<b>Total Notas de Credito Vigente: $ '.number_format($N - $NC,2).'<b/><br/><br/>'?>
    
    <?php echo '<b>Total Vendido Anual: $ '.number_format( ($T-$TC) - ($N-$NC),2).'<b/><br/><br/>'?>
    
    <?php 
        for ($i=0; $i < count($x) ; $i++){ 
            foreach ($x[$i] as $m => $t){
                echo '<b>'.str_pad($m, 20,' ',STR_PAD_RIGHT).'</b> $ '.number_format($t,2).' <b>Porcentaje</b> <font color="blue"> '. (($t/$T) * 100).'</font><br/>';
            }
        } 
    ?>
    <img src="app/views/pages/graphs/blocks.graph.php" width="200px" height="200px" />
</div>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle de la Estadistica de Ventas del cliente <font color="black"><?php echo $k->NOMBRE?></font> 
                           <?php echo '('.$cliente.')'?> .
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover"  id="dataTables-detStat">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Documento</th>
                                            <th>Estado</th>
                                            <th>Tipo</th>
                                            <th>Fecha</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    <?php $i=0; $por10=0; $monto10=0; foreach ($info as $key): $i++; 
                                            $color='';
                                            if($key->TIPO =='I' and $key->STATUS!='C'){
                                                $color = "style='background-color:#edf7d5'";
                                            }elseif($key->TIPO =='E' and $key->STATUS!='C'){
                                                $color = "style='background-color:#fedd9f '";
                                            }elseif($key->STATUS=='C'){
                                                $color = "style='background-color:red'";
                                            }
                                    ?>
                                        <tr class="odd gradeX" <?php echo $color?>>
                                            <td><?php echo $i?></td>
                                            <td><?php echo $key->DOCUMENTO;?></td>
                                            <td><?php echo $key->STATUS?></td>
                                            <td><?php echo $key->TIPO=='I'? 'Ingreso':'Egreso'?></td>
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
