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
                        <table class="table table-bordered" id="dataTables-facturas-maestro">
                            <thead>
                            <tr>
                                <th>Clave <br/> Cliente</th>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Importe</th>
                                <th><font color="purple"> Fecha Documento</font> /<br/> <font color="blue">Fecha Cobranza</font> </th>
                                <th>Contrarecibo  <br/> Plazo </th>
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
                            ?>
                                    <tr>
                                       <td><?php echo $doc->CVE_CLPV?></td>
                                        <td><?php echo $doc->CVE_DOC?></td>
                                        <td><?php echo $doc->NOMBRE?></td>                                    
                                        <td align="right"><?php echo '$ '.number_format($doc->IMPORTE,2);?></td>
                                        <td> <?php echo '<font color="purple">'.$doc->FECHA_DOC.'</font><br/> <font color="blue">'.$doc->FECHA_INI_COB.'</font>'?></td>
                                        <td><?php echo '<font color="purple">'.$doc->DIASCREDITO.'</font><br/><font color="blue"'.$doc->CONTRARECIBO.'</font>'?></td>
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
<?php if(count($liberado) >0){?>
<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
              Detalle de lo Liberado para su entrega.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Documento <br/><font color="purple"> Solicitud</font><br/><font color="blue">Liberado </font></th>
                                <th>Producto <br/>id</th>
                                <th><font color="purple">Cotizado</font><br/><font color="blue">Recepcion</font></th>
                                <th>Precio</th>
                                <th>Por Facturar <br/> Facturado</th>
                                <th>Total </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total =0;
                            foreach($liberado as $sc):
                                $total = $total + ($sc->COSTO * ($sc->CANT_ORIG-$sc->EMPACADO));    
                            ?>
                                    <tr>
                                        <td><?php echo '('.$sc->CLIEN.')'.$sc->NOM_CLI?></td>
                                        <td><?php echo '<b>'.$sc->COTIZA.'</b><br/><font color="purple">'.$sc->FECHASOL.'</font><br/></font><font color="blue">'.$sc->FECHA_LIB.'</font>'?></td>                                    
                                        <td><?php echo $sc->PROD.' -->'.$sc->NOMPROD;?></td>
                                        <td align="right"><font color="purple"> <?php echo $sc->CANT_ORIG;?></font><br/><font color="blue"><?php echo $sc->RECEPCION?></font></td>
                                        <td align="right"><?php echo '$ '.number_format($sc->COSTO,2,".",",");?></td>
                                        <td align="right"><?php echo $sc->CANT_ORIG - $sc->EMPACADO.'<br/>'.$sc->EMPACADO;?></td>
                                        <td align="right"><?php echo '$ '.number_format($sc->COSTO * ($sc->CANT_ORIG-$sc->EMPACADO),2);?></td>
                                    
                                    </tr> 
                            <?php endforeach;?>
                        </tbody>
                        <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>TOTALES </b></td>
                                        <td><font size="3pxs" color="blue"><b><?php echo '$ '.number_format($total,2)?></b></font></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>
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