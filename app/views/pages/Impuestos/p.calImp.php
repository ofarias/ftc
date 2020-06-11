<br/><br/>
<style type="text/css">
    input[class = por] {
   width: 80px;
    }
    input[class = pori] {
   width: 40px;
    }
</style>
<div title="<?php echo $isr['mensaje']?> Se utiliza de Enero a Marzo.">
<label >Coeficiente de Utilidad Ejercicio Anterior <?php echo $anio - 2 ?> aplicable al <?php echo $anio -1 ?> : </label>
    <input type="number" name="c.u." id="cu" step="any" max="100" min="0" value="<?php echo $isr['cu']?>" class="por"> %
    <input type="button" class="btn-sm btn-primary calc" value="Calcular" anio="<?php echo $anio?>" tipo="<?php echo $isr['tipo']?>">
<br/><br/>
<label title="Se Utiliza para calculo de ISR de Abril a Diciembre">Coeficiente de Utilidad Ejercicio: <?php echo $anio - 1?></label>
<input type="number" step="any" max="100" min="0" id="cu_act" class="por" value="<?php echo $isr['cu_act'] ?>"> %
<input type="button" class="btn-sm btn-primary setIsrAnu" anio="<?php echo $anio?>" value="Establecer" tipo="cua">
<br/><br/>
<label>Tasa de ISR para el ejercicio: <?php echo $anio - 1?></label>
<input type="number" step="any" max="100" min="0" id="tisr_anual" class="pori" value="<?php echo $isr['factor'] * 100?>"> %
<input type="button" class="btn-sm btn-primary setIsrAnu" anio="<?php echo $anio?>" value="Establecer" tipo="isr">
</div>
<br/>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Calculo de ISR del ejercicio <?php echo $anio?> 
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Concepto</th>
                                            <?php foreach ($meses as $m):?>
                                                <th><?php echo $m->NOMBRE?><br/><font color="brown">Guardado:</font></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <tr>
                                            <td title="Total de Ventas en el mes ">Ventas Facturadas</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Total de Ventas en el mes ">
                                                    <!-- Datos Calculados Basados en los XML Emitidos-->
                                                    <a href="index.xml.php?action=isrDet&mes=<?php echo $m->NUMERO?>&anio=<?php echo $anio?>&tipo=vf", target="_blank", onClick="window.open(this.href, this.target, 'width=1100,height=800'); return false;">
                                                    <?php $ctl=0;foreach($ventas as $v):?>
                                                        <?php if($v->MES == $m->NUMERO){$ctl++;?>
                                                            <label id="tvm_<?php echo $v->MES?>"><?php echo '$ '.number_format($v->IMPORTE,2)?></label>
                                                        <?php } ?>
                                                    <?php endforeach;?>
                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                    <!-- Finaliza los Datos desde el Sistema -->
                                                    </a>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->VENTAS_FACTURADAS,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>

                                                </td>
                                            <?php endforeach;?>
                                        </tr> 
                                        <tr>
                                            <td title="Anticipos de Clientes">Anticipo Clientes</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Anticipos de Clientes">
                                                    <a href="index.xml.php?action=isrDet&mes=<?php echo $m->NUMERO?>&anio=<?php echo $anio?>&tipo=ac", target="_blank", onClick="window.open(this.href, this.target, 'width=1100,height=800'); return false;">
                                                    <?php  $ctl = 0; foreach($ant as $an):?>
                                                        <?php if($an->MES == $m->NUMERO){ $ctl++;?>
                                                            <label id="antcl_<?php echo $m->NUMERO?>"><?php echo '$ '.number_format($an->IMPORTE,2)?></label>
                                                        <?php } ?>
                                                    <?php endforeach;?>
                                                    </a>
                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                     <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->ANTICIPO_CLIENTES,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>

                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td title="Intereses pagados por el Banco cuando se tienen inversiones">Productos Financieros</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Intereses pagados por el Banco cuando se tienen inversiones">
                                                    <a href="index.xml.php?action=isrDet&mes=<?php echo $m->NUMERO?>&anio=<?php echo $anio?>&tipo=pf", target="_blank", onClick="window.open(this.href, this.target, 'width=1100,height=800'); return false;">
                                                    <?php $ctl = 0; foreach($pfin as $prodF):?>
                                                        <?php if($prodF->MES == $m->NUMERO){ $ctl++;?>
                                                            <label id="profin_<?php echo $m->NUMERO?>"><?php echo '$ '.number_format($prodF->IMPORTE,2)?></label>
                                                        <?php } ?>
                                                    <?php endforeach;?>
                                                    </a>
                                                        <label id="profin_<?php echo $m->NUMERO?>"><?php echo ($ctl==0)? '$ '.number_format(0,2):''?></label>

                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->PRODUCTOS_FINANCIEROS,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>


                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td title="Ingresos depositados en el Banco no relacionados a Venta, como Devoluciones de Compra, Devoluciones de Gasto, Ingresos pendientes de Identificar, Prestamos etc... ">Otros Productos</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Ingresos depositados en el Banco no relacionados a Venta, como Devoluciones de Compra, Devoluciones de Gasto, Ingresos pendientes de Identificar, Prestamos etc... ">
                                                    <?php $ctl = 0; foreach($oIng as $oing):?>
                                                        <?php if($oing->MES == $m->NUMERO){ $ctl++;?>
                                                            <label id="otrpro_<?php echo $m->NUMERO?>"><?php echo '$ '.number_format($oing->IMPORTE,2)?></label>
                                                        <?php } ?>
                                                    <?php endforeach;?>
                                                    <label id="otrpro_<?php echo $m->NUMERO?>"><?php echo ($ctl==0)? '$ '.number_format(0,2):''?></label>
                                                
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->OTROS_PRODUCTOS,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>

                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        
                                        <tr>
                                            <td title="Utilidad Cambiaria">Utilidad Cambiaria</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right">
                                                        <label id="utlcam_<?php echo $m->NUMERO?>">$ 0.00</label>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->UTILIDAD_CAMBIARIA,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td title="Venta de Activos">Venta de Activos</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right"><label id="venact_<?php echo $m->NUMERO?>">$ 0.00</label>
                                                <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->VENTA_ACTIVOS,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>    
                                            <?php endforeach;?>
                                        </tr>

                                        <tr>
                                            <td title="Total de los ingresos">Total Ingresos Mensuales</td>
                                            <?php $aMen=array();$am=0;$tm=array();
                                            
                                            foreach($meses as $m):
                                                $tVen=0; $tAn = 0; $tPfi= 0; $tOin=0; 
                                            ?>

                                                <td align="right" >
                                                    <?php  $ctl = 0; foreach($ventas as $v):
                                                            $ctl++;?>
                                                        <?php if($v->MES == $m->NUMERO){
                                                                $ctl++;
                                                                $tVen=$v->IMPORTE;
                                                         } ?>
                                                    <?php endforeach;?>

                                                    <?php  $ctl = 0; foreach($ant as $an):
                                                            $ctl++;?>
                                                        <?php if($an->MES == $m->NUMERO){
                                                                $ctl++;
                                                                $tAn=$an->IMPORTE;
                                                         } ?>
                                                    <?php endforeach;?>

                                                    <?php $ctl = 0; foreach($pfin as $prodF):?>
                                                        <?php   if($prodF->MES == $m->NUMERO){ 
                                                                    $ctl++;
                                                                    $tPfi= $prodF->IMPORTE;
                                                                }
                                                        ?>
                                                    <?php endforeach;?>
                                                    

                                                    <?php  $ctl = 0; foreach($oIng as $oing):
                                                            $ctl++;?>
                                                        <?php if($oing->MES == $m->NUMERO){
                                                                $ctl++;
                                                                $tOin=$oing->IMPORTE;
                                                         } ?>
                                                    <?php endforeach;?>
                                                 
                                                    <?php 
                                                        $am=$am + ($tAn + $tOin + $tVen + $tPfi);
                                                        $aMen[$m->NUMERO]=$am;
                                                        $tm[$m->NUMERO]=($tAn + $tOin + $tVen + $tPfi);
                                                        echo "<font color='purpple'><label id='toting_$m->NUMERO'> $ ".number_format($tAn + $tOin + $tVen + $tPfi , 2)."</label></font>"; 
                                                    ?>
                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>

                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->TOTAL_INGRESOS_MENSUALES,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td>Total Ingresos Acumulados</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($aMen as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="ingacu_<?php echo $m->NUMERO?>"><?php echo '$ '.number_format($value,2); ?></label>
                                                        <?php } ?>
                                                    <?php }?>
                                                </b>
                                                <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->TOTAL_INGRESOS_ACUMULADOS,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Coeficiente <?php echo ($anio - 2).' / '.($anio -1)?></td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php echo ($m->NUMERO<=3)? $isr['cu']:$isr['cu_act']?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown">
                                                                <?php echo number_format( ($m->NUMERO<=3)? $i->CU:$i->CU_ACT,6)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>

                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Utilidad Fiscal</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="utlf_<?php echo $m->NUMERO?>"> <?php echo '$ '.number_format( ($value*(
                                                                ($m->NUMERO<=3)? $isr['cu']:$isr['cu_act']) ),2) ?></label>
                                                        <?php } ?>
                                                    <?php }?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->UTL_FISCAL,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Perdidas Pendientes de Amortizar</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td style="text-align:right;"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k):?>
                                                            <input dir="rtl" align='right' type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency"  max="<?php echo $value*( ($m->NUMERO <=3)?$isr['cu']:$isr['cu_act'] )?>" 
                                                            placeholder="$ 0.00"
                                                            class="ppa" 
                                                            id="ppa_<?php echo $k?>"  
                                                            mes="<?php echo $k?>" >
                                                        <?php endif;?>
                                                    <?php }?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->PERDIDAS_PENDIENTES,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td> 
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Base ISR </td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="bisr_<?php echo $k?>"></label>
                                                        <?php } ?>
                                                    <?php }?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo number_format($i->BASE_ISR,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Tasa ISR <?php echo $isr['factor']*100 ?>%</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="vtisr_<?php echo $k?>"></label>
                                                        <?php } ?>
                                                        <input type="hidden" id="tisr_<?php echo $k?>" value="<?php echo $isr['factor'] ?>">
                                                    <?php }?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo number_format($i->TASA_ISR,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>

                                        <tr>
                                            <td>Impuesto del Mes </td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="impmes_<?php echo $k?>"></label>
                                                            <input type="hidden" id="impmval_<?php echo $k?>">
                                                        <?php }?>
                                                    <?php }?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->IMPUESTO_MES,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Pagos Provisional Acumulado</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="pgprac_<?php echo $k?>"></label>
                                                            <input dir="rtl" type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"  
                                                                    placeholder="$ 0.00"
                                                                    class="pgprac" 
                                                                    id="pgpracval_<?php echo $k?>"  
                                                                    mes="<?php echo $k?>"
                                                                    value="$ 0.00">
                                                        <?php }?>
                                                    <?php }?>
                                                    
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->PAGO_PROVISIONAL,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr title="ISR retenido por el Banco o clientes">
                                            <td>ISR Retendido</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="retbc_<?php echo $k?>"></label>
                                                            <input dir="rtl" type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"  
                                                                    placeholder="$ 0.00"
                                                                    class="pgprac" 
                                                                    id="retbcval_<?php echo $k?>"  
                                                                    mes="<?php echo $k?>"
                                                                    value="$ 0.00">
                                                        <?php }?>
                                                    <?php }?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->ISR_RETENIDO,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr title="Total a pagar ISR Mensual">
                                            <td><font color="blue"><b>Total a Pagar ISR Mensual</b></font></td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <label id="totpagisr_<?php echo $k?>"></label>
                                                        <?php }?>
                                                    <?php }?>
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->TOTAL_PAGAR_MES,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr title="Total ISR Pagado">
                                            <td><font color="green"><b>Total Pagado</b></font></td><!-- Tipo, Folio y Fecha -->
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <input class="pprov" id="isrpg_<?php echo $m->NUMERO?>" dir="rtl" type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"  
                                                                    placeholder="$ 0.00"
                                                                    class="pgprac"
                                                                    mes="<?php echo $k?>"
                                                                    value="$ 0.00">
                                                    </b>
                                                    <?php foreach ($info as $i): ?>
                                                        <?php if($m->NUMERO == $i->MES):?>
                                                            <br/> <label><font color="brown"><?php echo '$ '.number_format($i->TOTAL_PAGADO,2)?></font></label>
                                                        <?php endif;?>    
                                                    <?php endforeach; ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr title="Grabar Calculo">
                                            <td><font color="green"><b>Grabar Calculo</b></font></td><!-- Tipo, Folio y Fecha -->
                                            <?php foreach ($meses as $m): ?>
                                                <td align="center"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <input type="button" class="btn-sm btn-primary grabar" value="Grabar Calculo" mes="<?php echo $m->NOMBRE?>" nmes="<?php echo $k?>" ><br/><br/>
                                                            <input type="button" class="btn-sm btn-secundary regPag" value="Registro Pago" mes="<?php echo $m->NOMBRE?>" nmes="<?php echo $k?>" anio="<?php echo $anio?>">
                                                        <?php }?>
                                                    <?php }?>
                                                    </b>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Archivos: </td>
                                            <?php foreach($meses as $m):?>
                                                <td >      
                                                    <?php foreach($files as $f){?>
                                                        <?php if($m->NUMERO == $f->MES){ $archivo='..//'.str_replace("\\", "//", substr($f->UBICACION,16)).'//'.$f->NOMBRE; ?>
                                                            <label title="<?php echo substr($f->NOMBRE, 19)?>">
                                                                <a href="<?php echo $archivo ?>" download><?php echo substr($f->NOMBRE, 19, 18).'...'?></a></label>
                                                        <?php } ?>
                                                    <?php }?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
</div>
<!--
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Documentos efectivamente Pagados / Cobrados del mes <?php echo $mes?> 
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" >
                                    <thead>
                                        <tr>
                                            <th>UUID</th>
                                            <th>Serie / Folio </th>
                                            <th>Fecha <br/> Cobro</th>
                                            <th>Banco <br/> Cobro</th>
                                            <th>Cliente</th>
                                            <th>SubTotal</th>
                                            <th>Descuento</th>
                                            <th>impuestos</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($info['pagado'] as $pgd): 
                                        ?>
                                        <tr>
                                            <td><?php echo $pgd->UUID?></td>
                                            <td><?php echo $pgd->DOCUMENTO?></td>
                                            <td><??></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr> 
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
            </div>
        </div>
</div>
-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript"> 

    var anio = <?php echo $anio?>
    
    $(".grabar").click(function(){
        var mes = $(this).attr('mes')
        var nmes = $(this).attr('nmes')
        $.confirm({
            title:'Calculo de ISR Mensual',
            content:'Grabar Calculo del mes ' + mes + ' ?',
            buttons:{
                grabar:{
                    text:'Grabar Calculo',
                    action: function(){
                        var totpg = document.getElementById('totpagisr_'+ nmes).innerHTML
                        if(totpg === undefined ||totpg ==''){
                            $.alert('No se ha realizado ningun calculo')
                        }else{
                            var tvm = document.getElementById('tvm_'+nmes).innerHTML
                            var antcl = document.getElementById('antcl_'+nmes).innerHTML
                            var profin = document.getElementById('profin_'+nmes).innerHTML
                            var otrpro = document.getElementById('otrpro_'+nmes).innerHTML
                            var utlcam = document.getElementById('utlcam_'+nmes).innerHTML
                            var venact = document.getElementById('venact_'+nmes).innerHTML
                            var toting = document.getElementById('toting_' +nmes).innerHTML
                            var ingacu = document.getElementById('ingacu_'+nmes).innerHTML
                            var utlfis = document.getElementById('utlf_'+nmes).innerHTML
                            var ppa = document.getElementById('ppa_'+nmes).value
                            var bisr = document.getElementById('bisr_'+nmes).innerHTML
                            var vtisr = document.getElementById('vtisr_'+nmes).innerHTML
                            var impmes = document.getElementById('impmes_'+nmes).innerHTML
                            var pgpracval = document.getElementById('pgpracval_'+ nmes).innerHTML
                            var retbc = document.getElementById('retbc_'+nmes).innerHTML
                            var isrpg = document.getElementById('isrpg_'+nmes).value
                            var cu = document.getElementById('cu').value
                            var cu_act = document.getElementById('cu_act').value
                            var tisr_anual = document.getElementById('tisr_anual').value
                            var datos={totpg, tvm, antcl, profin, otrpro, utlcam, venact, toting, ingacu, utlfis, ppa, bisr, vtisr, impmes, pgpracval, retbc, isrpg, cu, cu_act, tisr_anual}
                            $.ajax({
                                url:'index.xml.php',
                                type:'post',
                                dataType:'json',
                                data:{gIsr:nmes, anio, datos},
                                success:function(data){
                                    $.alert(data.mensaje)
                                }, 
                                error:function(){
                                    $.alert('Lo sentimos, pero no se pudo realizar la operacion.')
                                }
                            })
                        }
                    }
                },
                cancelar:{
                    text:'Cancelar',
                    action:function(){
                        $.alert('No se realizo ningun cambio.')
                    }
                }
            }
        })
    })

    $(".setIsrAnu").click(function(){
        var anio = $(this).attr('anio')
        var tipo = $(this).attr('tipo')
        if(tipo == 'isr'){
            var val = document.getElementById('tisr_anual').value
        }else{
            var val = document.getElementById('cu_act').value
        }
        $.ajax({
            url:'index.xml.php',
            type:'post',
            dataType:'json',
            data:{setISR:1, val, anio, tipo},
            success:function(data){
                $.alert(data.mensaje)
                location.reload(true)
            }, 
            error:function(){
                $.alert('Ocurrio un error, favor de verificar la informacion')
            }
        })
    })

    $(".ppa").change(function(){
        var mes = $(this).attr('mes')
        calculoMensual(mes)
    })

    function calculoMensual(mes){
        var max = parseFloat(document.getElementById("ppa_"+mes).getAttribute('max')) + .01
        var val = document.getElementById("ppa_"+mes).value
        var tisr = parseFloat(document.getElementById("tisr_"+mes).value)
        var pgprac = document.getElementById('pgpracval_' + mes).value
        var retbc = document.getElementById('retbcval_' + mes).value
        var signo = "$"
        val = val.replace(/,/g,"")
        val = val.replace(signo,"")
        val = parseFloat(val)
        pgprac = pgprac.replace(/,/g,"")
        pgprac = pgprac.replace(signo,"")
        pgprac = parseFloat(pgprac)
        retbc = retbc.replace(/,/g,"")
        retbc = retbc.replace(signo,"")
        retbc = parseFloat(retbc)
        var res = max - val
        var vtisr = res * tisr
        var tpisr = (vtisr - pgprac - retbc).toFixed(2)

        if(val > max){
            max = parseFloat(max,2)
            $.alert('El valor es mayor al total a pagar mensual, se ajustara al total mensual.')
            document.getElementById('ppa_' + mes).value = max
            document.getElementById('bisr_' + mes).value = res
        }else{

            document.getElementById('bisr_' + mes).innerHTML = format(String(res).split("."))
            document.getElementById('vtisr_' + mes).innerHTML = format(String(vtisr).split("."))
            document.getElementById('impmes_'+mes).innerHTML = format(String(vtisr).split("."))
            document.getElementById('impmval_' + mes).value = vtisr
            document.getElementById('totpagisr_' + mes).innerHTML = format(String(tpisr).split("."))
        }
    }

    $(".pgprac").change(function(){
        var mes = $(this).attr('mes')
        calculoMensual(mes)
    })

    $(".calc").click(function(){
        var cu = document.getElementById("cu").value
        var anio = $(this).attr('anio')
        var tipo = $(this).attr('tipo')
        if(cu > 0 && cu < .999 ){
            $.confirm({
                content:'Desea establecer ' + cu + '% para el calculo del ejercicio ' + anio + ' ?',
                buttons:{
                    aceptar:{
                        text:'Aceptar',
                        action:function(){
                            $.ajax({
                                url:'index.xml.php',
                                type:'post',
                                dataType:'json',
                                data:{setCU:1, cu, anio, tipo},
                                success:function(data){
                                    if(data.status=='Si'){
                                        $.alert(data.mensaje)
                                        location.reload(true)
                                    }else{
                                        return false;
                                    }
                                },
                                error:function(){
                                    $.alert('Revise la informacion')
                                }
                            })
                        }
                    },
                    cancelar:{
                        text:'Cancelar',
                        action:function(){
                            $.alert('No se realizo ningun cambio')
                        }
                    }
                }
            })
        }else{
            $.alert("Debe de colocar un factor mayor a 0")
            return false;
        }
    })    


    $("input[data-type='currency']").on({
        keyup: function() {
          formatCurrency($(this));
        },
        blur: function() { 
          formatCurrency($(this), "blur");
        }
    });

    function format(numero){
            var long = numero[0].length;
            var cent = numero[1].substring(0,2);
            if(long > 6){
                var tipo = 'Millones';
                if (long == 9){
                    var mill = 3;
                }else if(long == 8){
                    var mill = 2;
                }else if(long == 7){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles + ','+ unidades +'.' + cent;
            }else if(long > 3){
                if (long == 6){
                    var mill = 3;
                }else if(long == 5){
                    var mill = 2;
                }else if(long == 4){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + ',' + miles +'.' + cent;
            }else if(long > 0){
                if (long == 3){
                    var mill = 3;
                }else if(long == 4){
                    var mill = 2;
                }else if(long == 1){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones +'.' + cent;
            }else if(long == 0){
                var tipo = 'Menos de peso';
                var texto = 'Entro: ' + tipo;
            }
            return (texto);
    } 

    function formatNumber(n) {
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }

    function formatCurrency(input, blur) {
          var input_val = input.val();
          if (input_val === "") { return; }
          var original_len = input_val.length;
          var caret_pos = input.prop("selectionStart");
          if (input_val.indexOf(".") >= 0) {
            var decimal_pos = input_val.indexOf(".");
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);
            left_side = formatNumber(left_side);
            right_side = formatNumber(right_side);
            if (blur === "blur") {
              right_side += "00";
            }
            right_side = right_side.substring(0, 2);
            input_val = "$" + left_side + "." + right_side;
          } else {
            input_val = formatNumber(input_val);
            input_val = "$" + input_val;
            if (blur === "blur") {
              input_val += ".00";
            }
          }
          input.val(input_val);
          var updated_len = input_val.length;
          caret_pos = updated_len - original_len + caret_pos;
          input[0].setSelectionRange(caret_pos, caret_pos);
    }

    $(".regPag").click(function(){
        var mes  = $(this).attr('mes')
        var nmes = $(this).attr('nmes')
        var anio = $(this).attr('anio')
        var monto = document.getElementById('isrpg_'+ nmes).value

        $.confirm({
            columnClass: 'col-md-6',
            title: 'Grabar Pago',
            content:'Al registrar el pago los valores ya no podran moverse. Esta seguro de continuar?, Se registra el pago de ' + mes  + ' por un monto de <font color="green">' + monto + '</font>',
            buttons:{
                grabar:{
                    text:"Grabar Pago",
                    action:function(){
                        $.ajax({
                            url:'index.xml.php',
                            type:'post',
                            dataType:'json',
                            data:{gp:1, nmes, anio, monto},
                            success:function(data){
                                $.alert(data.mensaje)
                            }, 
                            error:function (){
                                $.alert('Listo')
                            }
                        })
                    }
                }, 
                cancelar:{
                    text:"Cancelar",
                    action:function(){
                        $.alert('No hace ninguna accion')
                        return;
                    }
                }, 
                comprobante:{
                    text:"Registro de Pago",
                    action:function(){
                        //$.alert('Formulario para carga de archivos.')
                        $.confirm({
                            columnClass: 'col-md-12',
                            title: 'Carga Comprobante SAT Declaración Provisional de ISR',
                            content: 'Favor de seleccionar el archivo PDF comprobante del pago del mes de ' + mes + 
                            '<form action="upload_comp_pago_sat.php" method="post" enctype="multipart/form-data" class="compsat">' +
                            '<div class="form-group">'+
                            '<br/>Acuse de Recibo SAT: <input type="file" name="fileToUpload" class="pdf" accept="application/pdf"> <br/>'+
                            '<br/>Declaracion Pagada: <input type="file" name="fileToUpload2" class="pdf2" accept="application/pdf"> <br/>'+
                            '<br/>"Se almacenaran los archivos."' +
                            '<input type="hidden" name ="nmes" value="'+nmes+'" > '+ 
                            '<input type="hidden" name ="mes" value="'+mes+'" > '+ 
                            '<input type="hidden" name ="anio" value="'+anio+'" > '+ 
                            '<input type="hidden" name ="tipo" value="ISR" > '+ 
                            '</form>',
                            buttons: {
                                formSubmit: {
                                    text: 'Cargar Comprobantes',
                                    btnClass: 'btn-blue',
                                    action: function () {
                                        var archivo = this.$content.find('.pdf').val();
                                        var archivo2 = this.$content.find('.pdf2').val();
                                        var form = this.$content.find('.compsat');
                                        if(archivo=='' || archivo2 ==''){
                                            $.alert('Debe de seleccionar el Acuse y la Declaracion Pagada');
                                            return false;
                                        }else{
                                            $.alert('se manda el formulario')
                                            form.submit()
                                        }    
                                    }
                                },       
                                cancelar: function(){
                                },
                            },
                        });
                    }
                }
            }
        })
    })

</script>