<br />
<?php if(count($facturado)> 0){?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                  Detalle de lo facturado sin contrarecibo.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                        <table class="table table-bordered" id="dataTables-empresas">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Clave <br/> Cliente</th>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Importe</th>
                                <th><font color="purple"> Fecha Documento</font> /<br/> <font color="blue">Fecha Cobranza</font> </th>
                                <th>Contrarecibo  <br/> Plazo </th>
                                <th>Vencimiento</th>
                                <th>Aplicaciones</th>
                                <th>Notas de <br/>Credito</th>
                                <th>Saldo Factura</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0;
                            foreach($facturado as $doc):
                                //$linea=$sc->LINEA_CRED;
                                $total = $total + $doc->SALDOFINAL;
                                $color = '';
                                if($doc->VENCIMIENTO >= 0 AND $doc->VENCIMIENTO <= 29){
                                    $color="style='background-color:green;'";
                                }elseif($doc->VENCIMIENTO > 29 ){
                                    $color = "style='background-color:red;'";
                                }elseif($doc->VENCIMIENTO < 0 ){
                                    $color = "style='background-color:#bbfab6;'";
                                }
                            ?>
                                    <tr class="odd gradeX" <?php echo $color?> > 
                                        <td><input type="checkbox" name="sel" class="docs" ></td>
                                       <td><?php echo $doc->CVE_CLPV?></td>
                                        <td><?php echo $doc->CVE_DOC?></td>
                                        <td><?php echo $doc->NOMBRE?></td>                                    
                                        <td align="right"><?php echo '$ '.number_format($doc->IMPORTE,2);?></td>
                                        <td> <?php echo '<font color="purple">'.$doc->FECHA_DOC.'</font><br/> <font color="blue">'.$doc->FECHA_INI_COB.'</font>'?></td>
                                        <td><?php echo '<font color="purple">'.$doc->DIASCREDITO.'</font><br/><font color="blue"'.$doc->CONTRARECIBO.'</font>'?></td>
                                        <td><?php echo $doc->VENCIMIENTO?></td>
                                        <td align="right"><font color="red"><b><?php echo '$ '.number_format($doc->PAGOS,2,".",",");?></b></font></td>
                                        <td align="right"><font color="red"><b><?php echo '$ '.number_format($doc->IMPORTE_NC,2);?></b></font></td>
                                        <td align="right"><b><?php echo '$ '.number_format($doc->SALDOFINAL,2);?></b></td>
                                    </tr> 
                            <?php endforeach;?>
                        </tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>Total Por Cobrar: </b></td>
                                        <td><font size="3pxs" color="blue"><b><?php echo '$ '.number_format($total,2)?></font></b></td>
                                        <td></td>
                                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php  }?>

<script>/*
    function muestraOculta(clave){
        var fila = document.getElementById(clave);
        if(fila.style.display=="none"){
            fila.style.display="table-cell";
            document.getElementById("a"+clave).innerHTML="-";
        }else{
            fila.style.display="none";
            document.getElementById("a"+clave).innerHTML="+";
        }
    }*/
</script>