
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Estadistica <?php echo $t=='Recibidos'? 'Proveedores':'Clientes'?> del <?php echo $anio?>
                           <br/>Total Venta: <?php echo '$ '.number_format($total,2)?>
                           <br/>Total Devoluciones: <?php echo '$ '.number_format($total_dev,2)?>
                           <br/>Total Cancelaciones: <?php echo '$ '.number_format($total_can,2)?>
                           <br/>Total General: <?php echo '$ '.number_format($total - $total_dev - $total_can,2)?>
                        </div>
                        <br/> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Ventas por Tipo" class="btn-sm btn-primary rep" tipo="vxt">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Comparativo Anual" class="btn-sm btn-primary rep" tipo="anual"><br/><br/>
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
                        <br/>
                        <br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Ver Grafica" class="btn-sm btn-primary vg" >
                        <br class="grafica hidden" />
                        <br class="grafica hidden" />
                        <br class="grafica hidden" />
                        <br class="grafica hidden" />
                        <br class="grafica hidden" />

                        <img src="app/views/pages/graphs/pie.3d.graph.php?datos=<?php echo $gf?>&anio=<?php echo $anio?>" width="1150px" height="850px" class="grafica hidden" id="gfs"/>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-stat" >
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th>Cliente</th>
                                            <th>Documentos</th>
                                            <th>Facturado</th>
                                            <th>Cancelado</th>
                                            <th>Devuelto</th>
                                            <th>Total</th>
                                            <th>Porcentaje</th>
                                            
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    <?php $i=0; $por10=0; $monto10=0; foreach ($info as $key): $i++;
                                    if($i<=10){
                                        $por10 +=  $key->PORCENTAJE;
                                        $monto10 += $key->FACTURADO;
                                        $color="style=";
                                        }
                                    ?>
                                        <tr>
                                            <td ><?php echo $i?></td>
                                            <td>
                                                <a href="index.xml.php?action=infoProv&rfc=<?php echo $key->RFC?>&tipo=<?php echo $t?>" target="_blank" ><?php echo $key->NOMBRE;?></a><br/><?php echo $key->RFC ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.e.php?action=detStat&cliente=<?php echo $key->RFC?>
                                            &mes=<?php echo $mes?>&anio=<?php echo $anio?>&tipo=<?php echo $t?>" target="_blank" class="btn-sm btn-info"> Detalle</a>

                                            </td>
                                            <td align="center"><?php echo $key->DOCUMENTOS?></td>
                                            <td align="right"><font color="green"><?php echo '$ '.number_format($key->FACTURADO,2);?></font></td>
                                            <td align="right"><font color="red"><?php echo '$ '.number_format($key->CANCELADO,2);?></font></td>
                                            <td align="right"><font color="#ffa68e"><b><?php echo '$ '.number_format($key->NOTAS,2);?></b></font></td>
                                            <td><?php echo '$ '.number_format($key->TOTAL_CLIENTE,2)?></td>
                                            <td><?php echo number_format($key->PORCENTAJE,2).' %';?></td>
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

    $(".vg").click(function(){
        var f = $(this).val()
        var a = document.getElementsByClassName("grafica")
        
        for (var i = a.length - 1; i >= 0; i--) {
            if(f == "Ocultar Grafica"){
                a[i].classList.add("hidden")
                $(this).val("Ver Grafica")
            }else{
                a[i].classList.remove("hidden")
                $(this).val("Ocultar Grafica")
            }
        }
        //a[5].classList.remove("hidden")
    })

    var anio = <?php echo $anio?>;
    var t = <?php echo $t=='Recibidos'? "'Compras / Gastos'":"'Ventas'"?>;
    $(".rep").click(function(){
        
        window.open("index.e.php?action=repTipo&anio="+anio+"&tipo="+t, "_blank")

    })

</script>