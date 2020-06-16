<br/>
<?php 
    $T=0;$N=0;$C=0;$TC=0;$NC=0;
    $rfcEmpresa = $_SESSION['rfc'];
    foreach ($meses as $mx => $value) {
        $tot = 0; $totn = 0; $totc=0;
        foreach ($info as $k) {
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'I'){
                $T+=$k->IMPORTE;
                $tot += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'E'){
                $N+=$k->IMPORTE;
                $totn += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->STATUS == 'C'){
                $C+=$k->IMPORTE;
                $totc += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'I' and $k->STATUS == 'C'){
                $TC+=$k->IMPORTE;
                //$tot_TC += $k->IMPORTE;
            }
            if( date('m', strtotime($k->FECHA)) == $value and $k->TIPO == 'E' and $k->STATUS == 'C'){
                $NC+=$k->IMPORTE;
                //$tot_NC += $k->IMPORTE;
            }
        }
        $x[]=array($mx=>$tot);
    }
?>  
<div>
    <?php echo '<b>Total Facturado: $ '.number_format($T,2).'<b/><br/>'?>
    <?php echo '<b>Total Facturado Cancelado: $ '.number_format($TC,2).'<b/><br/>'?>
    <?php echo '<b>Total Facturado Vigente: $ '.number_format($T - $TC,2).'<b/><br/><br/>'?>
    <?php echo '<b>Total Notas de Credito: $ '.number_format($N,2).'<b><br/>'?>
    <?php echo '<b>Total Notas de Credito Canceladas: $ '.number_format($NC,2).'<b/><br/>'?>
    <?php echo '<b>Total Notas de Credito Vigente: $ '.number_format($N - $NC,2).'<b/><br/><br/>'?>
    <?php echo '<b>Total Vendido Anual: $ '.number_format( ($T-$TC) - ($N-$NC),2).'<b/><br/><br/>'?>
    <?php 
        for ($i=0; $i < count($x) ; $i++){ 
            foreach ($x[$i] as $m => $t){
                echo '<b>'.str_pad($m, 20," ",STR_PAD_RIGHT).':</b> $ '.number_format($t,2).' <b>Porcentaje</b> <font color="blue"> '. number_format((($t/$T) * 100),2).' %</font><br/>';
            }
        } 
    ?>
    <br/>
        <input type="button" value="<?php echo $vw=='S'? 'Ocultar Grafica':'Ver Grafica'?>" class="btn-sm btn-primary vgf">
        <br class="gf <?php echo $vw=='S'? '':'hidden' ?>" />
        <br class="gf <?php echo $vw=='S'? '':'hidden' ?>" />
        &nbsp;&nbsp;<label class="gf <?php echo $vw=='S'? '':'hidden' ?>">Periodo de Grafica :</label>
        <select class="tgf <?php echo $vw=='S'? '':'hidden' ?> gf">
            <option value="">Seleccione el periodo de la grafica</option>
            <option value="M">Mensual</option>
            <option value="B">Bimestra</option>
            <option value="T">Trimestral</option>
            <option value="Q">Cuartos</option>
            <option value="S">Semestre</option>
            
        </select>
    <br/>
    <br/>
    <img src="app/views/pages/graphs/blocks.graph.php?eje=<?php echo $anio?>&tipo=<?php echo $tipo?>&rfc=<?php echo $cliente?>&data=<?php echo $per?>" width="1800px" height="850px" class="gf <?php echo $vw=='S'? '':'hidden' ?>"/>

</div>
<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Detalle de la Estadistica de Ventas del cliente <font color="black"><?php echo $k->NOMBRE?></font> 
                           <?php echo '('.$cliente.')'?> .
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover"  id="dataTables-detStat">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Documento</th>
                                            <th>Estado</th>
                                            <th>Tipo</th>
                                            <th>Fecha</th>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th>Documento</th>
                                        </tr>
                                    </thead>                                   
                                  <tbody>
                                    <?php $i=0; $por10=0; $monto10=0; foreach ($info as $key): $i++; 
                                            $color='';
                                            if($key->TIPO =='I' and $key->STATUS!='C'){
                                                $color = "style='background-color:#edf7d5'";
                                            }elseif($key->TIPO =='E' and $key->STATUS!='C'){
                                                $color = "style='background-color:#fedd9f '";
                                            }elseif($key->STATUS=='C'){
                                                $color = "style='background-color:red'";
                                            }
                                    ?>
                                        <tr class="odd gradeX" <?php echo $color?>>
                                            <td><?php echo $i?></td>
                                            <td><?php echo $key->DOCUMENTO;?></td>
                                            <td><?php echo $key->STATUS?></td>
                                            <td><?php echo $key->TIPO=='I'? 'Ingreso':'Egreso'?></td>
                                            <td><?php echo ($key->FECHA);?></td>
                                            <td><?php echo '$ '.number_format($key->SUBTOTAL,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IVA,2);?></td>
                                            <td align="right"><font color="blue"><b><?php echo '$ '.number_format($key->IMPORTE,2);?></b></font></td>
                                            <td align="rght">
                                                 <?php if($tipo == 'Recibidos'){?>
                                                        <a href="/uploads/xml/<?php echo $rfcEmpresa.'/'.$tipo.'/'.$key->RFCE.'/'.$key->RFCE.'-'.$key->SERIE.$key->FOLIO.'-'.$key->UUID.'.xml'?>" 
                                                        download="<?php echo $key->RFCE.'-'.substr($key->FECHA, 0, 10).'-'.number_format($key->IMPORTE,2).'-'.$key->UUID.'.xml'?>">  
                                                        <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>

                                                    <?php }else{?>
                                                        <a href="/uploads/xml/<?php echo $rfcEmpresa.'/'.$tipo.'/'.$key->CLIENTE.'/'.$key->RFCE.'-'.$key->SERIE.$key->FOLIO.'-'.$key->UUID.'.xml'?>" 
                                                            download="<?php echo $key->RFCE.'-'.substr($key->FECHA, 0, 10).'-'.number_format($key->IMPORTE,2).'-'.$key->UUID.'.xml'?>">  
                                                        <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>
                                                    <?php }?>
                                                    &nbsp;&nbsp;
                                                    <a href="index.php?action=imprimeUUID&uuid=<?php echo $key->UUID?>" onclick="alert('Se ha descargar tu factura, revisa en tu directorio de descargas')"><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a>
                                                
                                                <?php if($_SESSION['rfc']== 'IMI161007SY7'){?>
                                                    <input type="button" value="" class="btn-sm btn-info cargaSAE" doc="<?php echo $key->SERIE.$key->FOLIO?>" ruta="/uploads/xml/<?php echo $rfcEmpresa.'/'.$tipo.'/'.$key->CLIENTE.'/'.$key->RFCE.'-'.$key->SERIE.$key->FOLIO.'-'.$key->UUID.'.xml'?>" serie="<?php echo $key->SERIE?>" folio ="<?php echo $key->FOLIO?>" uuid="<?php echo $key->UUID?>" rfcr="<?php echo $key->CLIENTE?>" ln="<?php echo $ln?>" tipo="<?php echo $doc?>">
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                 </tbody>
                                </table>
                            </div>
                      </div>
            </div>
        </div>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    var mes = <?php echo $mes?>;
    var anio = <?php echo $anio?>;
    var tipo = <?php echo "'".$tipo."'"?>;
    var rfc = <?php echo "'".$cliente."'"?>;

    $(".vgf").click(function(){
        var f = $(this).val()
        if(f == ""){
            return
        }   
        var a = document.getElementsByClassName("gf")
        for (var i = a.length - 1; i >= 0; i--) {
            if(f == 'Ver Grafica'){
                a[i].classList.remove("hidden")
                $(this).val("Ocultar Grafica")
            }else{
                a[i].classList.add("hidden")
                $(this).val("Ver Grafica")
            }
        }
    })

    $(".tgf").change(function(){
        var gt = $(this).val()
        var text = $(".tgf option:selected").text()
        $.confirm({
            title:"Grafica",
            content:"Desea cambiar a grafica "+ text + "?",
            buttons:{
                Aceptar:function(){
                    window.open("index.e.php?action=detStat&cliente="+rfc+"&mes="+mes+"&anio="+anio+"&tipo="+tipo+"&gt="+gt+"&view=S", "_self")
                },
                Cancelar:function(){
                    return
                }
            }
        })
    })

</script>