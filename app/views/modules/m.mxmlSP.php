<div class="container">
        <!-- Marketing Icons Section -->

        <div class="row">
            
            <div class="col-lg-12">
                <h3 class="page-header">
                    <div>
                        <p><?php echo 'Usuario: '.$_SESSION['user']->NOMBRE?></p>
                        <p><?php echo 'RFC seleccionado: '.$_SESSION['rfc']?></p>
                        <p><?php echo 'Empresa Seleccionada'.$_SESSION['empresa']['nombre']?></p>  
                        <p><?php echo 'Se muestran los XML '.$ide?></p>
                    </div>
                </h3>
            </div>
            <?php foreach ($anual as $a):
                  if($a->TIPO == 'E'){
                        $tipo1 = 'Notas de Credito';
                    }elseif($a->TIPO == 'I'){
                        $tipo1 = 'Factura';
                    }elseif($a->TIPO == 'P'){
                        $tipo1 = 'Pago';
                    }elseif($a->TIPO == 'N'){
                        $tipo1 = 'Recibo de Nomina';
                    }else{
                        $tipo1 = 'No identificado';
                    }
            ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt">&nbsp;&nbsp;<?php echo $tipo1?></i></h4>
                    </div>
                    <div class="panel-body">
                        <p><FONT size="4pxs"> <b>&nbsp;&nbsp;<font color='red'>TOTAL EJERCICIO <?php echo $a->ANIO?></font><b/></FONT></p>
                        <p><font color="blue">XMLs </font><b><?php echo $a->XMLS?></b><font color="blue"> Sin procesar: <?php echo $a->FALTANTES?></font></p>
                        <p>Monto Anual: </p>
                        <p>Sub Total: <?php echo '$ '.number_format($a->EGRESOSS,2)?></p>
                        <p>Total: <?php echo '$ '.number_format($a->EGRESOST,2)?></p>
                        <center><a href="index.php?action=verXMLSP&mes=0&anio=<?php echo $a->ANIO?>&ide=<?php echo $ide?>" class="btn btn-info">Ver</a></center>
                    </div>
                </div>
            </div>     
            <?php endforeach;?>
            <?php foreach ($subMenuXMLSP as $key): 
                    if($key->TIPO == 'E'){
                        $tipo = 'Notas de Credito';
                    }elseif($key->TIPO == 'I'){
                        $tipo = 'Factura';
                    }elseif($key->TIPO == 'P'){
                        $tipo = 'Pago';
                    }elseif($key->TIPO == 'N'){
                        $tipo = 'Recibo de Nomina';
                    }else{
                        $tipo = 'No identificado';
                    }
                ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-list-alt">&nbsp;&nbsp;<?php echo $tipo?></i></h4>
                </div>
                <div class="panel-body">
                    <p><FONT size="4pxs"> <b><?php echo $key->NOMBRE."&nbsp;&nbsp;<font color='red'>".$key->ANIO."</font>"?><b/></FONT></p>
                    <p><font color="blue">XMLs </font><b><?php echo $key->XMLS?></b><font color="blue"> Sin procesar: <?php echo $key->FALTANTES?></font></p>
                    <p>Sub Total: <?php echo '$ '.number_format($key->EGRESOSS,2)?></p>
                    <p>Total: <?php echo '$ '.number_format($key->EGRESOST,2)?></p>
                    <center><a href="index.php?action=verXMLSP&mes=<?php echo $key->MES?>&anio=<?php echo $key->ANIO?>&ide=<?php echo $ide?>" class="btn btn-info">Ver</a></center>
                </div>
            </div>
        </div>        
            <?php endforeach ?>
    </div>
</div>
