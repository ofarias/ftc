<br/>
<?php 
    $total = 0;
    $total_dev = 0;
    $total_can = 0;
    foreach($info as $inf){
    $total += $inf->TIPO_FISCAL=='I'? $inf->TOTAL:0; 
    $total_dev += $inf->TIPO_FISCAL=='E'? $inf->TOTAL:0; 
    $total_can += ($inf->TIPO_FISCAL=='I' and $inf->STATUS == 'C')? $inf->TOTAL:0; 
}?>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Estadistica de <?php echo $tipo ?> del <?php echo $anio?> por tipo de documento.
                           <br/>Total Venta: <?php echo '$ '.number_format($total,2)?>
                           <br/>Total Devoluciones: <?php echo '$ '.number_format($total_dev,2)?>
                           <br/>Total Cancelaciones: <?php echo '$ '.number_format($total_can,2)?>
                           <br/>Total General: <?php echo '$ '.number_format($total - $total_dev - $total_can,2)?>
                        </div>
                        <br/> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Ventas por Tipo" class="btn-sm btn-primary rep" tipo="vxt"> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Comparativo Anual" class="btn-sm btn-primary rep" tipo="anual"> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<select id="an">
                                                    <option>Seleccione el anio</option>
                                                    <?php foreach($anios as $a):?>
                                                        <option><?php echo $a->ANIO?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                <input type="button" value="Ver" class="btn-sm btn-primary rep" tipo="ver">
                        <br/><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;<label>Reporte Personalizado:</label><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;<label>Guia de Uso </label><img src="pdf"><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <select>    
                                <option>Seleccione un Parametros</option>
                                <option>Cliente</option>
                                <option>Anio</option>
                                <option>Fecha</option>
                                <option>Tipo</option>
                                <option>Comparativo</option>>
                                <option>Agrupacion</option>
                        </select>
                        &nbsp;&nbsp;
                        <input type="button" value="Agregar">
                        <input type="text" name="nomRep" placeholder="Nombre del Reporte">
                        <input title="Al guardar el reporte se puede llamar los parametros posteriormente" type="button" value="Guardar">
                        <input type="button" value="ejecutar">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-stat" >
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th>Tipo</th>
                                            <th>Status</th>
                                            <th>Anio</th>
                                            <th>SubTotal</th>
                                            <th>Descuento</th>
                                            <th>Iva</th>
                                            <th>Total</th>
                                            <th>Porcentaje</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    <?php $i=0; $por10=0; $monto10=0; foreach ($info as $key): $i++;
                                        
                                        $porcentaje = ($key->TOTAL / $total) * 100;
                                    ?>
                                        <tr>
                                            <td><?php echo $i?></td>
                                            <td><?php echo empty($key->TIPO_DOC)? 'Sin Definir':$key->TIPO_DOC;?></td>
                                            <td><?php echo $key->STATUS?></td>
                                            <td><?php echo $key->ANIO;?></td>
                                            <td align="right"><font color="green"><?php echo '$ '.number_format($key->SUBTOTAL,2);?></font></td>
                                            <td align="right"><font color="red"><?php echo '$ '.number_format($key->DESCUENTO,2);?></font></td>
                                            <td align="right"><font color="#ffa68e"><b><?php echo '$ '.number_format($key->IVA,2);?></b></font></td>
                                            <td><?php echo '$ '.number_format($key->TOTAL,2)?></td>
                                            <td><?php echo number_format($porcentaje,2).' %';?></td>
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
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    var t = <?php echo "'".$tipo."'"?>
    $(".rep").click(function(){
        var anio = document.getElementById('an').value
        window.open("index.e.php?action=repTipo&anio="+anio+"&tipo="+t, "_self")
    })

</script>