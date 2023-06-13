<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <?php foreach ($cierres as $key): 
                    if($key->MES == 1){
                        $mes = 'ENERO';
                    }elseif($key->MES == 2){
                        $mes = 'FEBRERO';
                    }elseif($key->MES == 3){
                        $mes = 'MARZO';
                    }elseif($key->MES == 4){
                        $mes = 'ABRIL';
                    }elseif($key->MES == 5){
                        $mes = 'MAYO';
                    }elseif($key->MES == 6){
                        $mes = 'JUNIO';
                    }elseif($key->MES == 7){
                        $mes = 'JULIO';
                    }elseif($key->MES == 8){
                        $mes = 'AGOSTO';
                    }elseif($key->MES == 9){
                        $mes = 'SEPTIEMBRE';
                    }elseif($key->MES == 10){
                        $mes = 'OCTUBRE';
                    }elseif($key->MES == 11){
                        $mes = 'NOVIEMBRE';
                    }elseif($key->MES == 12){
                        $mes = 'DICIEMBRE';
                    }
                ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i>&nbsp;&nbsp;&nbsp;<?php echo $mes?>&nbsp;&nbsp;<?php echo $key->ANIO?> </h4>
                        </div>
                        <div class="panel-body">
                            <p><?php echo $key->USUARIO_CIERRE;?> </p>
                            <p> Monto Inicial: <?php echo '$ '.number_format($key->INICIAL,2)?></p>
                            <p> Monto Final: <?php echo '$ '.number_format($key->FINAL,2);?></p>
                            <p> Fecha Cierre <?php echo $key->FECHA_CIERRE?></p>
                            <center><a href="index.php?action=verInvRemisiones&mes=<?php echo $key->MES;?>&anio=<?php echo $key->ANIO?>" class="btn btn-default"><img src="app/views/images/Shopping-basket-refresh-icon_small.png"></a></center>
                        </div>
                    </div>
                </div>    
                <?php endforeach ?>
                </div>
        </div>
    </div>