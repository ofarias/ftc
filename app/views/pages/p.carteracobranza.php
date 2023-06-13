<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Saldo General de la Cartera de clientes .
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr> 
                                <th>Saldo Global 2015</th>
                                <th>Saldo Globla 2016</th>
                                <th>Saldo Globla 2017</th>
                                <th>Total Acreedores <br/> Identificado / Por Identificar</th>                                
                                <th>Total Cartera de Clientes</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach ($saldoAcumulado as $d):
                            
                            $s15=$d->SA15;
                            $s16=$d->SA16;
                            $s17=$d->SA17;
                            $ac = $d->SAC;
                            $pa = $d->PORAPLICAR;
                            $TA = ( $s16 + $s17) - $ac - $pa;
                        ?>
                            <tr>
                                <td align="center"> <a href="index.php?action=verFolio2015">Consultar 2015</a></td>
                                <td align="center" ><?php echo '$ '.number_format($d->SA16,2);?></td>
                                <td align="center"><?php echo '$ '.number_format($d->SA17,2,".",",");?></td>
                                <td align="center"><?php echo '$ '.number_format($d->PORAPLICAR,2)?>  <br/> 
                                <?php echo '$ '.number_format($d->IDENTIFICADO,2).' / $ '?><a href="index.php?action=verCPNoIdentificados" target='_blank'><?php echo number_format($d->NOIDENTIFICADO,2)?></a>

                                </td>
                                <td align="center" ><?php echo '$ '.number_format($TA,2)?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>   
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Totales por Cartera .
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables">
                        <thead>
                            <tr> 
                                <th>Semana: <br/> <?php $semana=date('W');
                                         echo $semana; ?></th>
                                 <?php if ($cartera =='CCA' || $cartera == '99'):?>        
                                <th>Cartera A / <br/>
                                    Vencido
                                 </th>
                             <?php endif;?>
                                <?php if ($cartera =='CCB' || $cartera == '99'):?>
                                <th>Cartera B / <br/> Vencido</th>
                            <?php endif;?>
                                <?php if ($cartera =='CCC' || $cartera == '99'):?>
                                <th>Cartera C / <br/>Vencido</th>
                            <?php  endif;?>
                                 <?php if ($cartera =='CCD' || $cartera == '99'):?>
                                <th>Cartera D / <br/>Vencido</th>
                            <?php  endif;?>
                             <?php if ( $cartera == '99'):?>
                                <th>Total Carteras / <br/>vencido</th>
                            <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                    $saldovl = 0;
                                    $saldovma = 0;
                                    $saldovmi = 0;
                                    $saldovj = 0;
                                    $saldovv = 0;
                                    $saldoCCAMV = 0;
                                    $saldovbl = 0;
                                    $saldovbma = 0;
                                    $saldovbmi = 0;
                                    $saldovbj = 0;
                                    $saldovbv = 0;
                                    $saldoCCBMV = 0;
                                    $saldovcl = 0;
                                    $saldovcma = 0;
                                    $saldovcmi = 0;
                                    $saldovcj = 0;                       
                                    $saldovcv = 0;
                                    $saldoCCCMV = 0;
                                    $saldovdl = 0;
                                    $saldovdma = 0;
                                    $saldovdmi = 0;
                                    $saldovdj = 0;
                                    $saldovdv = 0;
                                    $saldoCCDMV = 0;
                                    $saldol = 0;
                                    $saldoma= 0;
                                    $saldomi = 0;
                                    $saldoj = 0;
                                    $saldov =0;
                                    $saldoCCAM = 0;
                                    $saldobl = 0;
                                    $saldobma= 0;
                                    $saldobmi = 0;
                                    $saldobj = 0;
                                    $saldobv =0;
                                    $saldoCCBM = 0;
                                    $saldocl = 0;
                                    $saldocma= 0;
                                    $saldocmi = 0;
                                    $saldocj = 0;
                                    $saldocv =0;
                                    $saldoCCCM = 0;
                                    $saldodl = 0;
                                    $saldodma= 0;
                                    $saldodmi = 0;
                                    $saldodj = 0;
                                    $saldodv =0;
                                    $saldoCCDM = 0;

                                    foreach ($saldoCartera as $datos){
                                        if($datos->CC == 'CCA' and $datos->DIAS_PAGO == 'L'){
                                            $saldol=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCA' and $datos->DIAS_PAGO=='MA'){
                                            $saldoma=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCA' and $datos->DIAS_PAGO=='MI'){
                                            $saldomi=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCA' and $datos->DIAS_PAGO=='J'){
                                            $saldoj=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCA' and $datos->DIAS_PAGO=='V'){
                                            $saldov=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCA' and strlen($datos->DIAS_PAGO) > 3){
                                            $saldomu=$datos->TOTAL;
                                        }elseif($datos->CC == 'CCB' and $datos->DIAS_PAGO == 'L'){
                                            $saldobl=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCB' and $datos->DIAS_PAGO=='MA'){
                                            $saldobma=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCB' and $datos->DIAS_PAGO=='MI'){
                                            $saldobmi=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCB' and $datos->DIAS_PAGO=='J'){
                                            $saldobj=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCB' and $datos->DIAS_PAGO=='V'){
                                            $saldobv=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCB'){
                                            $saldobmu=$datos->TOTAL;
                                        }elseif($datos->CC == 'CCC' and $datos->DIAS_PAGO == 'L'){
                                            $saldocl=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCC' and $datos->DIAS_PAGO=='MA'){
                                            $saldocma=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCC' and $datos->DIAS_PAGO=='MI'){
                                            $saldocmi=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCC' and $datos->DIAS_PAGO=='J'){
                                            $saldocj=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCC' and $datos->DIAS_PAGO=='V'){
                                            $saldocv=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCC'){
                                            $saldocmu=$datos->TOTAL;
                                        }elseif($datos->CC == 'CCD' and $datos->DIAS_PAGO == 'L'){
                                            $saldodl=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCD' and $datos->DIAS_PAGO=='MA'){
                                            $saldodma=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCD' and $datos->DIAS_PAGO=='MI'){
                                            $saldodmi=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCD' and $datos->DIAS_PAGO=='J'){
                                            $saldodj=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCD' and $datos->DIAS_PAGO=='V'){
                                            $saldodv=$datos->TOTAL;
                                        }elseif ($datos->CC =='CCD'){
                                            $saldodmu=$datos->TOTAL;
                                        }
                                }

                                foreach ($saldoVencido as $data){
                                    if($data->CC == 'CCA' and $data->DIAS_PAGO == 'L'){
                                        $saldovl = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCA' and $data->DIAS_PAGO == 'MA'){
                                        $saldovma = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCA' and $data->DIAS_PAGO == 'MI'){
                                        $saldovmi = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCA' and $data->DIAS_PAGO == 'J'){
                                        $saldovj = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCA' and $data->DIAS_PAGO == 'V'){
                                        $saldovv = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif($data->CC == 'CCB' and $data->DIAS_PAGO == 'L'){
                                        $saldovbl = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCB' and $data->DIAS_PAGO == 'MA'){
                                        $saldovbma = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCB' and $data->DIAS_PAGO == 'MI'){
                                        $saldovbmi = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCB' and $data->DIAS_PAGO == 'J'){
                                        $saldovbj = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCB' and $data->DIAS_PAGO == 'V'){
                                        $saldovbv = empty($data->TOTAL)? '0.00':$data->TOTAL;  
                                    }elseif($data->CC == 'CCC' and $data->DIAS_PAGO == 'L'){
                                        $saldovcl = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCC' and $data->DIAS_PAGO == 'MA'){
                                        $saldovcma = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCC' and $data->DIAS_PAGO == 'MI'){
                                        $saldovcmi = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCC' and $data->DIAS_PAGO == 'J'){
                                        $saldovcj = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCC' and $data->DIAS_PAGO == 'V'){
                                        $saldovcv = empty($data->TOTAL)? '0.00':$data->TOTAL;  
                                    }elseif($data->CC == 'CCD' and $data->DIAS_PAGO == 'L'){
                                        $saldovcl = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCD' and $data->DIAS_PAGO == 'MA'){
                                        $saldovcma = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCD' and $data->DIAS_PAGO == 'MI'){
                                        $saldovcmi = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCD' and $data->DIAS_PAGO == 'J'){
                                        $saldovcj = empty($data->TOTAL)? '0.00':$data->TOTAL; 
                                    }elseif ($data->CC == 'CCD' and $data->DIAS_PAGO == 'V'){
                                        $saldovcv = empty($data->TOTAL)? '0.00':$data->TOTAL;  
                                    }
                                }

                                foreach ($saldoVMultiple as $data){
                                    if($data->CC == 'CCA'){
                                        $saldoCCAMV = $data->SM;
                                    }elseif($data->CC == 'CCB') {
                                        $saldoCCBMV = $data->SM;
                                    }elseif ($data->CC == 'CCC'){
                                        $saldoCCCMV = $data->SM;
                                    }elseif ($data->CC=='CCD'){
                                        $saldoCCDMV = $data->SM;
                                    }
                                }

                                foreach ($saldoMultiple as $data){
                                    if($data->CC == 'CCA'){
                                        $saldoCCAM = $data->SM;
                                    }elseif($data->CC == 'CCB') {
                                        $saldoCCBM = $data->SM;
                                    }elseif ($data->CC == 'CCC'){
                                        $saldoCCCM = $data->SM;
                                    }elseif ($data->CC=='CCD'){
                                        $saldoCCDM = $data->SM;
                                    }
                                }



                                ?>

                                <td >Lunes: / <br> Vencido  </td>
                                <?php if (stripos($cartera, 'CCA') !== False || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldol,2);?> <br> 
                                    $ <?php echo (empty($saldovl))? '0.00':number_format($saldovl,2) ?> </td>
                                <?php endif;?>
                                <?php if ($cartera =='CCB' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldobl,2,".",",");?>  <br> 
                                    $ <?php echo (empty($saldovbl))? '0.00':number_format($saldovbl,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCC' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldocl,2)?>  <br> 
                                    $ <?php echo (empty($saldovcl))? '0.00':number_format($saldovcl,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCD' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldodl,2)?> <br/>
                                        $ <?php echo (empty($saldovdl))? '0.00':number_format($saldovdl,2) ?></td>
                                <?php endif;?>
                                <?php if ( $cartera == '99'):?>
                                <td>
                                     $ <?php $sumSaldoL=($saldol + $saldobl + $saldocl +$saldodl);  echo number_format($sumSaldoL,2); ?>
                                <br/>
                                    $ <?php echo number_format(($saldovl + $saldovbl + $saldovcl + $saldovdl),2)?>
                                </td>
                                <?php endif;?>
                            </tr>
                            <tr>
                                <td >Martes: / <br> Vencido</td>
                                 <?php if ($cartera =='CCA' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldoma,2);?><br/>
                                     $ <?php echo (empty($saldovma))? '0.00':number_format($saldovma,2) ?>
                                </td>
                                <?php endif;?>
                                 <?php if ($cartera =='CCB' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldobma,2,".",",");?> <br> 
                                    $ <?php echo (empty($saldovbma))? '0.00':number_format($saldovbma,2) ?></td>
                                 <?php endif;?>
                                 <?php if ($cartera =='CCC' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldocma,2)?>  <br> 
                                    $ <?php echo (empty($saldovcma))? '0.00':number_format($saldovcma,2) ?></td>
                                 <?php endif;?>
                                 <?php if ($cartera =='CCD' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldodma,2)?> <br/>
                                        $ <?php echo (empty($saldovdma))? '0.00':number_format($saldovdma,2) ?></td>
                                 <?php endif;?>
                                 <?php if ( $cartera == '99'):?>
                                <td>
                                      $ <?php $sumSaldoMa=($saldoma + $saldobma + $saldocma +$saldodma);  echo number_format($sumSaldoMa,2); ?>
                                <br/>
                                    $ <?php echo number_format(($saldovma + $saldovbma + $saldovcma + $saldovdma),2)?></td>
                                <?php endif;?>
                            </tr>
                            <tr>
                                <td >Miercoles: / <br> Vencido</td>
                                <?php if ($cartera =='CCA' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldomi,2);?> <br/>
                                     $ <?php echo (empty($saldovmi))? '0.00':number_format($saldovmi,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCB' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldobmi,2,".",",");?>  <br> 
                                    $ <?php echo (empty($saldovbmi))? '0.00':number_format($saldovbmi,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCC' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldocmi,2)?>  <br> 
                                    $ <?php echo (empty($saldovcmi))? '0.00':number_format($saldovcmi,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCD' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldodmi,2)?> <br/>
                                        $ <?php echo (empty($saldovdmi))? '0.00':number_format($saldovdmi,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera == '99'):?>
                                <td>
                                     $ <?php $sumSaldoMi=($saldomi + $saldobmi + $saldocmi +$saldodmi);  echo number_format($sumSaldoMi,2); ?>
                                <br/>
                                    $ <?php echo number_format(($saldovmi + $saldovbmi + $saldovcmi + $saldovdmi),2)?></td>
                                <?php endif;?>
                            </tr>
                            <tr>
                                <td>Jueves: / <br> Vencido</td>
                                <?php if ($cartera =='CCA' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldoj,2);?> <br/>
                                     $ <?php echo (empty($saldovmi))? '0.00':number_format($saldovj,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCB' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldobj,2,".",",");?> <br> 
                                    $ <?php echo (empty($saldovbj))? '0.00':number_format($saldovbj,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCC' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldocj,2)?>  <br> 
                                    $ <?php echo (empty($saldovcj))? '0.00':number_format($saldovcj,2) ?></td>
                                <?php endif;?>
                                <?php if ($cartera =='CCD' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldodj,2)?> <br/>
                                        $ <?php echo (empty($saldovdj))? '0.00':number_format($saldovdj,2) ?></td>
                                <?php endif;?>
                                <?php if ( $cartera == '99'):?>
                                <td>
                                $ <?php $sumSaldoJ=($saldoj + $saldobj + $saldocj +$saldodj);  echo number_format($sumSaldoJ,2); ?>
                                <br/>
                                    $ <?php echo number_format(($saldovj + $saldovbj + $saldovcj + $saldovdj),2)?></td>
                                <?php endif;?>                          
                            </tr>
                            <tr>
                                <td>Viernes: / <br> Vencido</td>
                                <?php if ($cartera =='CCA' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldov,2);?> <br/>
                                     $ <?php echo (empty($saldovv))? '0.00':number_format($saldovv,2) ?></td>
                                <?php endif;?>    
                                <?php if ($cartera =='CCB' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldobv,2,".",",");?> <br> 
                                    $ <?php echo (empty($saldovbv))? '0.00':number_format($saldovbv,2) ?></td>
                                <?php endif;?> 
                                <?php if ($cartera =='CCC' || $cartera == '99'):?>
                                <td align="center"><?php echo '$ '.number_format($saldocv,2)?>  <br> 
                                    $ <?php echo (empty($saldovcv))? '0.00':number_format($saldovcv,2) ?></td>
                                <?php endif;?> 
                                <?php if ($cartera =='CCD' || $cartera == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format($saldodv,2)?> <br/>
                                        $ <?php echo (empty($saldovdv))? '0.00':number_format($saldovdv,2) ?></td>
                                <?php endif;?> 
                                <?php if ( $cartera == '99'):?>
                                <td>
                                $ <?php $sumSaldoV=($saldov + $saldobv + $saldocv +$saldodv);  echo number_format($sumSaldoV,2); ?>
                                <br/>
                                    $ <?php echo number_format(($saldovv + $saldovbv + $saldovcv + $saldovdv),2)?></td>
                                <?php endif;?> 
                            </tr>
                            <tr>
                                <td>Multiples Dias: / <br> Vencido</td>
                                <?php if ($cartera == 'CCA'|| $cartera == '99'):
                                    ?>
                                <td align="center"> $ <?php echo (empty($saldoCCAM))? '0.00':number_format($saldoCCAM,2)?> <br/>
                                     $ <?php echo (!isset($saldoCCAMV))? '0.00':number_format($saldoCCAMV,2) ?></td>
                                <?php endif ?>
                                <?php if ($cartera == 'CCB' || $cartera == '99'):?>
                                <td align="center"> $ <?php echo (empty($saldoCCBM))? '0.00':number_format($saldoCCBM,2)?>  <br> 
                                    $ <?php echo (!isset($saldoCCBMV))? '0.00':number_format($saldoCCBMV,2) ?></td>
                                <?php endif;?>
                                <?php if($cartera == 'CCC' || $cartera == '99'):?>
                                <td align="center"> $ <?php echo (empty($saldoCCCM))? '0.00':number_format($saldoCCCM,2)?> <br> 
                                    $ <?php echo (!isset($saldoCCCMV))? '0.00':number_format($saldoCCCMV,2) ?></td>
                                <?php endif;?>
                                <?php if($cartera == 'CCD' || $cartera  == '99'):?>
                                <td align="center"> $ <?php echo (empty($saldoCCDM))? '0.00':number_format($saldoCCDM,2)?> <br/>
                                        $ <?php echo (empty($saldoCCDMV))? '0.00':number_format($saldoCCDMV,2) ?>
                                </td>
                                <?php endif;?>
                                <?php if($cartera == '99'):?>
                                <td>
                                $ <?php $sumSaldoMu=($saldoCCAM + $saldoCCBM + $saldoCCCM + $saldoCCDM);  echo number_format($sumSaldoMu,2); ?>
                                <br/>
                                    $ <?php echo number_format(($saldoCCAMV + $saldoCCBMV + $saldoCCCMV + $saldoCCDMV),2)?></td>
                                <?php endif; ?>
                            </tr>
                            <tr style="background-color: yellow">
                                <td>Total: </td>
                                <?php if($cartera == 'CCA' || $cartera  == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format(($saldol + $saldoma + $saldomi + $saldoj + $saldov + $saldoCCAM),2);?> <br/>
                                    $ <?php echo number_format(($saldovl + $saldovma + $saldovmi + $saldovj + $saldovv + $saldoCCAMV),2)?>
                                </td>
                                <?php endif;?>
                                <?php if($cartera == 'CCB' || $cartera  == '99'):?>
                                <td align="center"><?php echo '$ '.number_format(($saldobl + $saldobma + $saldobmi + $saldobj + $saldobv + $saldoCCBM),2,".",",");?> <br/>
                                    $ <?php echo number_format(($saldovbl + $saldovbma + $saldovbmi + $saldovbj + $saldovbv + $saldoCCBMV),2)?> </td>
                                <?php endif;?>
                                <?php if($cartera == 'CCC' || $cartera  == '99'):?>
                                <td align="center"><?php echo '$ '.number_format(($saldocl + $saldocma + $saldocmi + $saldocj + $saldocv + $saldoCCCM),2)?> <br/>
                                    $ <?php echo number_format(($saldovcl + $saldovcma + $saldovcmi + $saldovcj + $saldovcv + $saldoCCCM),2)?></td>
                                <?php endif;?>
                                <?php if($cartera == 'CCD' || $cartera  == '99'):?>
                                <td align="center" ><?php echo '$ '.number_format(($saldodl + $saldodma + $saldodmi + $saldodj + $saldodv + $saldoCCDM),2)?> <br/>
                                    $ <?php echo number_format(($saldovdl + $saldovdma + $saldovdmi + $saldovdj + $saldovdv + $saldoCCDM),2)?> </td>
                                <?php endif;?>
                                <?php if($cartera  == '99'):?>
                                <td>
                                    $ <?php echo number_format(
                                        ($sumSaldoL + 
                                        $sumSaldoMa + 
                                        $sumSaldoMi + 
                                        $sumSaldoJ+
                                        $sumSaldoV +
                                        $sumSaldoMu ),2)?>
                                <br/>
                                    $ <?php echo number_format(
                                        ($saldovl + $saldovma + $saldovmi + $saldovj + $saldovv + $saldoCCAMV) + 
                                        ($saldovbl + $saldovbma + $saldovbmi + $saldovbj + $saldovbv + $saldoCCBM)+
                                        ($saldovcl + $saldovcma + $saldovcmi + $saldovcj + $saldovcv + $saldoCCCM)+ 
                                        ($saldovdl + $saldovdma + $saldovdmi + $saldovdj + $saldovdv + $saldoCCDM)
                                        ,2)?>
                                </td>
                                <?php endif;?>
                            </tr>
                        </tbody>
                    </table>   
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>
 <!--<form action="index.php" method="POST">
    <button name="calendarCxC" type="submit" value="CCA"> Ver Calendario CARTERA "A" </button>
    <button name="calendarCxC" type="submit" value="CCB"> Ver Calendario Cartera "B"</button>
    <button name="calendarCxC" type="submit" value="CCC">Ver Calendario Cartera "C"</button>
     <button name="calendarCxC" type="submit" value="CCD">Ver Calendario Cartera "D"</button>
 </form>-->
 <br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Saldos General por Maestro del Dia.
            </div>
            <!-- /.panel-heading -->
             <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr> 
                                <th>Nombre Maestro</th>
                                <th>Cartera / Dias Pago</th>
                                <th>Credito Global</th>
                                <th>Sucursales</th>
                                
                                <th>Saldo 2016</th>
                                <th>Saldo 2017</th>
                                <th>Acreedores</th>
                                <th>Total Deuda</th>
                                <th>Detalle</th>
                                <th>Aplicaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($saldoxmaestrodia as $data):
                            $s15=$data->S15;
                            $s16=$data->SALDO2016;
                            $s17=$data->S17;
                            $ac = $data->ACREEDOR;
                            $TOTAL = ($s16 + $s17) - $ac;
                            switch (date('w')){
                                    case '0':
                                        $dia = 'D';
                                        break;
                                    case '1':
                                        $dia = 'L';
                                        break;
                                    case '2':
                                        $dia = 'MA';
                                        break;
                                    case '3':
                                        $dia = 'MI';
                                        break;
                                    case '4':
                                        $dia = 'J';
                                        break;
                                    case '5':
                                        $dia = 'V';
                                        break;
                                    case '6':
                                        $dia = 'S';
                                        break;
                                    default:
                                        break;                  
                                }                              
                                if(strpos($data->CC_DP, "$dia") !== False){
                                    $color =  "style='background-color:gold;'"; 
                                }else{
                                    $color = '';
                                }
                        ?>
                            <tr class="odd gradeX" <?php echo $color;?>">
                            <form action="index.php" method="POST">
                                <td>
                                <a href="index.php?action=verDocumentosMaestro&maestro=<?php echo $data->MAESTRO?>"> <?php echo substr($data->NOM_MAESTRO,0,20);?> </a>    
                                </td>
                                
                                <td><?php echo $data->CARTERA_COBRANZA?>/ <?php echo $data->CC_DP;?></td>
                                <td><?php echo '$ '.number_format($data->CREDITOXMAESTRO,2);?></td>
                                <td><?php echo $data->SUCURSALES;?></td>
                                
                                <td><?php echo '$ '.number_format($data->SALDO2016,2);?></td>
                                <td><?php echo '$ '.number_format($data->S17,2,".",",");?></td>
                                <td><?php echo '$ '.number_format($data->ACREEDOR,2)?></td>
                                <td><?php echo '$ '.number_format($TOTAL,2)?></td>
                                <td><a href="index.php?action=CarteraxCliente&cve_maestro=<?php echo $data->MAESTRO;?>" class="btn btn-info"><i class="fa fa-plus"></i></a></td>
                                
                                <td>
                                    <input name="maestro" type = "hidden" value = "<?php echo $data->MAESTRO?>" />
                                    <button name="facturapagomaestro" type = "submit" value ="enviar" class="btn btn-success">Facturas a Pago</button>
                                    <button name="PagoFactura" type = "submit" value ="enviar" class="btn btn-info" disabled = "disabled"> Pagos a Facturas </button>
                                </td>
                                
                                   
                           </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>   
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

<br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default" id="">
            <div class="panel-heading">
                Saldos General por Maestro que no son del dia.
            </div>
            <!-- /.panel-heading -->
             <div class="panel-body">
                 <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr> 
                                <th>Nombre Maestro</th>
                                <th>Cartera / Dias Pago</th>
                                <th>Credito Global</th>
                                <th>Sucursales</th>
                                <th>Saldo 2016</th>
                                <th>Saldo 2017</th>
                                <th>Acreedores</th>
                                <th>Total Deuda</th>
                                <th>Detalle</th>
                                <th>Aplicaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($saldoxmaestro as $data):
                            $s15=$data->S15;
                            $s16=$data->SALDO2016;
                            $s17=$data->S17;
                            $ac = $data->ACREEDOR;
                            $TOTAL = ($s16 + $s17) - $ac;
                            switch (date('w')){
                                    case '0':
                                        $dia = 'D';
                                        break;
                                    case '1':
                                        $dia = 'L';
                                        break;
                                    case '2':
                                        $dia = 'MA';
                                        break;
                                    case '3':
                                        $dia = 'MI';
                                        break;
                                    case '4':
                                        $dia = 'J';
                                        break;
                                    case '5':
                                        $dia = 'V';
                                        break;
                                    case '6':
                                        $dia = 'S';
                                        break;
                                    default:
                                        break;                  
                                }                              
                                if(strpos($data->CC_DP, "$dia") !== False){
                                    $color =  "style='background-color:gold;'"; ;
                                }else{
                                    $color = '';
                                }
                        ?>
                            <tr class="odd gradeX" <?php echo $color;?>">
                            <form action="index.php" method="POST">
                                <td><?php echo substr($data->NOM_MAESTRO,0,20);?></td>
                                <td><?php echo $data->CARTERA_COBRANZA?>/ <?php echo $data->CC_DP;?></td>
                                <td><?php echo '$ '.number_format($data->CREDITOXMAESTRO,2);?></td>
                                <td><?php echo $data->SUCURSALES;?></td>
                                <td><?php echo '$ '.number_format($data->SALDO2016,2);?></td>
                                <td><?php echo '$ '.number_format($data->S17,2,".",",");?></td>
                                <td><?php echo '$ '.number_format($data->ACREEDOR,2)?></td>
                                <td><?php echo '$ '.number_format($TOTAL,2)?></td>
                                <td><a href="index.php?action=CarteraxCliente&cve_maestro=<?php echo $data->MAESTRO;?>" class="btn btn-info"><i class="fa fa-plus"></i></a></td>
                                
                                <td>
                                    <input name="maestro" type = "hidden" value = "<?php echo $data->MAESTRO?>" />
                                    <button name="facturapagomaestro" type = "submit" value ="enviar" class="btn btn-success">Facturas a Pago</button>
                                    <button name="PagoFactura" type = "submit" value ="enviar" class="btn btn-info" disabled = "disabled"> Pagos a Facturas </button>
                                </td>
                                
                                   
                           </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>   
                    <!-- /.table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>


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