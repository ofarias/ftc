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
<label >Coeficiente de Utilidad Ejercicio Anterior <?php echo $anio - 1 ?> aplicable al <?php echo $anio?> : </label>
    <input type="number" name="c.u." id="cu" step="any" max="100" min="0" value="<?php echo $isr['cu']?>" class="por"> %
    <input type="button" class="btn-sm btn-primary calc" value="Calcular" anio="<?php echo $anio?>" tipo="<?php echo $isr['tipo']?>">
<br/><br/>
<label title="Se Utiliza para calculo de ISR de Abril a Diciembre">Coeficiente de Utilidad Ejercicio: <?php echo $anio?></label>
<input type="number" step="any" max="100" min="0" id="tisr_anual" class="por" value="<?php echo $isr['cu_act'] * 100?>"> %
<input type="button" class="btn-sm btn-primary setIsrAnu" anio="<?php echo $anio?>" value="Establecer">
<br/><br/>
<label>Tasa de ISR para el ejercicio: <?php echo $anio?></label>
<input type="number" step="any" max="100" min="0" id="tisr_anual" class="pori" value="<?php echo $isr['factor'] * 100?>"> %
<input type="button" class="btn-sm btn-primary setIsrAnu" anio="<?php echo $anio?>" value="Establecer">
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
                                                <th><?php echo $m->NOMBRE?></th>
                                            <?php endforeach ?>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <tr>
                                            <td title="Total de Ventas en el mes ">Ventas Facturadas</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Total de Ventas en el mes ">
                                                <?php $ctl=0;foreach($ventas as $v):?>
                                                    <?php if($v->MES == $m->NUMERO){$ctl++;?>
                                                        <?php echo '$ '.number_format($v->IMPORTE,2)?>
                                                    <?php } ?>
                                                <?php endforeach;?>
                                                <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr> 
                                        <tr>
                                            <td title="Anticipos de Clientes">Anticipo Clientes</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Anticipos de Clientes">
                                                    <?php  $ctl = 0; foreach($ant as $an):?>
                                                        <?php if($an->MES == $m->NUMERO){$ctl++;?>
                                                            <?php echo '$ '.number_format($an->IMPORTE,2)?>
                                                        <?php } ?>
                                                    <?php endforeach;?>
                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td title="Intereses pagados por el Banco cuando se tienen inversiones">Productos Financieros</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Intereses pagados por el Banco cuando se tienen inversiones">
                                                    <?php $ctl = 0; foreach($pfin as $prodF):?>
                                                        <?php if($prodF->MES == $m->NUMERO){ $ctl++;?>
                                                            <?php echo '$ '.number_format($prodF->IMPORTE,2)?>
                                                        <?php } ?>
                                                    <?php endforeach;?>
                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td title="Ingresos depositados en el Banco no relacionados a Venta, como Devoluciones de Compra, Devoluciones de Gasto, Ingresos pendientes de Identificar, Prestamos etc... ">Otros Productos</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right" title="Ingresos depositados en el Banco no relacionados a Venta, como Devoluciones de Compra, Devoluciones de Gasto, Ingresos pendientes de Identificar, Prestamos etc... ">
                                                    <?php $ctl = 0; foreach($oIng as $oing):?>
                                                        <?php if($oing->MES == $m->NUMERO){ $ctl++;?>
                                                            <?php echo '$ '.number_format($oing->IMPORTE,2)?>
                                                        <?php } ?>
                                                    <?php endforeach;?>
                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        
                                        <tr>
                                            <td title="Utilidad Cambiaria">Utilidad Cambiaria</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right">$ 0.00</td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td title="Utilidad Cambiaria">Venta de Activos</td>
                                            <?php foreach($meses as $m):?>
                                                <td align="right">$ 0.00</td>
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
                                                        echo '<font color="purpple"> $ '.number_format($tAn + $tOin + $tVen + $tPfi , 2).'</font>' 
                                                    ?>

                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                        <tr>
                                            <td>Total Ingresos Acumulados</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($aMen as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){
                                                            echo '$ '.number_format($value,2);
                                                        }
                                                        ?>
                                                    <?php }?>
                                                </b>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Coeficiente <?php echo $anio -1?></td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php echo $isr['cu']?>
                                                    </b>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Utilidad Fiscal</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){
                                                            echo '$ '.number_format( ($value*($isr['cu'])),2);
                                                        }
                                                        ?>
                                                    <?php }?>
                                                    </b>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Perdidas Pendientes de Amortizar</td>
                                            <?php foreach ($meses as $m): ?>
                                                <td style="text-align:right;"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k):?>
                                                            <input dir="rtl" align='right' type="text" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency"  max="<?php echo $value*($isr['cu'])?>" 
                                                            placeholder="$ 0.00"
                                                            class="ppa" 
                                                            id="ppa_<?php echo $k?>"  
                                                            mes="<?php echo $k?>" >
                                                        <?php endif;?>
                                                    <?php }?>
                                                    </b>
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
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr title="Total ISR Pagado">
                                            <td><font color="green"><b>Total Pagado</b></font></td><!-- Tipo, Folio y Fecha -->
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <input type="number" class="pprov">
                                                    </b>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr title="Grabar Calculo">
                                            <td><font color="green"><b>Grabar Calculo</b></font></td><!-- Tipo, Folio y Fecha -->
                                            <?php foreach ($meses as $m): ?>
                                                <td align="right"><b>
                                                    <?php foreach($tm as $k => $value){?>
                                                        <?php if($m->NUMERO == $k){ ?>
                                                            <input type="button" class="btn-sm btn-primary grabar" value="Grabar Calculo" mes="<?php echo $m->NOMBRE?>" nmes="<?php echo $k?>">
                                                        <?php }?>
                                                    <?php }?>
                                                    </b>
                                                </td>
                                            <?php endforeach; ?>
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

                            var utlfis = document.getElementById()
                            var perpen
                            $.alert('Se graba el calculo, con el total a pagar ' + totpg )
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
        var val = document.getElementById('tisr_anual').value
        $.ajax({
            url:'index.xml.php',
            type:'post',
            dataType:'json',
            data:{setISR:1, val, anio},
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


</script>