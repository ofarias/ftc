<br/><br/>

<label>Coeficiente de Utilidad Ejercicio Anterior <?php echo $anio - 1 ?> : </label>
    <input type="number" name="c.u." id="cu" step="any" max="100" min="0"> %
    <input type="button" class="btn-sm btn-primary calc" value="Calcular"  >
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
                                                <?php $ctl=0;foreach($ventas as $v):$ctl++;?>
                                                    <?php if($v->MES == $m->NUMERO){?>
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
                                                    <?php  $ctl = 0; foreach($ant as $an):$ctl++;?>
                                                        <?php if($an->MES == $m->NUMERO){?>
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
                                            <td title="Total de los ingresos">Total de Ingresos</td>
                                            <?php $tVen=0; $tAn = 0; $tPfi= 0; ; $tOin=0; foreach($meses as $m):?>
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
                                                    <!--   
                                                    <?php  $ctl = 0; foreach($ant as $an):
                                                            $ctl++;?>
                                                        <?php if($an->MES == $m->NUMERO){
                                                                $ctl++;
                                                                $tAn=$an->IMPORTE;
                                                         } ?>
                                                    <?php endforeach;?>
                                                    
                                                    <?php  $ctl = 0; foreach($ant as $an):
                                                            $ctl++;?>
                                                        <?php if($an->MES == $m->NUMERO){
                                                                $ctl++;
                                                                $tAn=$an->IMPORTE;
                                                         } ?>
                                                    <?php endforeach;?>
                                                    -->
                                                    <?php echo '<font color="purpple"> $ '.number_format($tAn + $tOin + $tVen + $tPfi , 2).'</font>' ?>

                                                    <?php echo ($ctl==0)? '$ '.number_format(0,2):''?>
                                                </td>
                                            <?php endforeach;?>
                                        </tr>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                 Documentos efectivamente Pagados / Cobrados del mes <?php echo $mes?> 
                        </div>
                        <!-- /.panel-heading -->
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
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>

<script>

document.addEventListener("DOMContentLoaded",function(){
    var fac = document.getElementsByName("factura");
    var boton = document.getElementsByName("asociarFactura");
    var up = document.getElementsByName("archivo"); //uploadfile
    var botonup = document.getElementsByName("comprobanteCaja");
        var xmlfile = document.getElementsByName("xmlfile");
    var cuentaCajas = 0;
    var cuentaUp = 0;   //uploadfile
    for(contador = 0; contador < fac.length; contador++){
        if(fac[contador].value == ""){
            //boton[contador].disabled = true;
            //botonup[contador].disabled = true;
            //fac[contador].readOnly = true;
        }else{
            //boton[contador].disabled = false;
            //fac[contador].readOnly = true;
            cuentaCajas += 1;
        }
        
        if(up[contador].value != ""){   //uploadfile
            cuentaUp += 1;
        }                               //uploadfile
        
        if(xmlfile[contador].value != ""){
            document.getElementsByName("xml")[contador].type = 'text';
            document.getElementsByName("xml")[contador].readOnly = true;
            document.getElementsByName("xml")[contador].value = xmlfile[contador].value;
            document.getElementsByName("xmlFactura")[contador].disabled=true;
            cuentaXml += 1;
        }

        //if(fac[contador].value != "" && up[contador].value == ""){
        //    botonup[contador].disabled = false;
        //}
    }


});

document.getElementById("imprimir").addEventListener("click",function(){
    setTimeout(function(){ window.location.reload(); }, 1000);  
});

/*function validarTextBox(texto,boton1,boton2){
    //alert(texto+boton1+boton2);
    if(texto.length > 5){
        document.getElementById(boton2).disabled = false;
        document.getElementById(boton1).disabled = false;
    }else if(texto.length < 5){
        document.getElementById(boton2).disabled = true;
        document.getElementById(boton1).disabled = true;
    }
}*/

</script>