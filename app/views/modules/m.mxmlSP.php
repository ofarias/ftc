<?php 
                $te=0; 
                $tf=0; 
                $tp=0; 
                foreach ($anual as $at){
                    if($at->TIPO == 'E'){
                        $tipot = 'Notas de Credito';
                        $te++;
                    }elseif($at->TIPO == 'I'){
                        $tipot = 'Factura';
                        $tf++;
                    }elseif($at->TIPO == 'P'){
                        $tipot = 'Pago';
                        $tp++;
                    }elseif($at->TIPO == 'N'){
                        $tipot = 'Recibo de Nomina';
                    }else{
                        $tipot = 'No identificado';
                    }
                }
            ?>
<br/>
<div class="container">
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
            <?php if($te == 0){?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt">&nbsp;&nbsp;<?php echo $tipot.'Notas de Credito'?></i></h4>
                        </div>
                        <div class="panel-body">
                            <p><FONT size="4pxs"> <b>&nbsp;&nbsp;<font color='red'>TOTAL EJERCICIO <?php echo $at->ANIO?></font><b/></FONT></p>
                            <p><font color="blue">XMLs </font><b><?php echo '0'?></b><font color="blue"> Sin procesar: <?php echo '0'?></font></p>
                            <p>Monto Anual: 0.00</p>
                            <p>Sub Total: <?php echo '$ '.number_format(0,2)?></p>
                            <p>Total: <?php echo '$ '.number_format(0,2)?></p>
                            <center><a href="index.php?action=verXMLSP&mes=0&anio=<?php echo $a->ANIO?>&ide=<?php echo $ide?>&doc=E" class="btn btn-info">Ver</a>&nbsp;&nbsp;&nbsp;<a href="" class="btn btn-success">Zip</a></center>
                        </div>
                    </div>
                </div>
            <?php }?>
            <?php 
                $te=0; 
                $tf=0; 
                $tp=0; 
                foreach ($anual as $a):
                    if($a->TIPO == 'E'){
                        $tipo1 = 'Notas de Credito';
                        $te++;
                    }elseif($a->TIPO == 'I'){
                        $tipo1 = 'Factura';
                        $tf++;
                    }elseif($a->TIPO == 'P'){
                        $tipo1 = 'Pago';
                        $tp++;
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
                        <center><a href="index.php?action=verXMLSP&mes=0&anio=<?php echo $a->ANIO?>&ide=<?php echo $ide?>&doc=<?php echo $a->TIPO?>" class="btn-sm btn-info" title="Ver XMLs">Ver</a>&nbsp;&nbsp;&nbsp;<a href="index.xml.php?action=zipXML&mes=0&anio=<?php echo $a->ANIO?>&ide=<?php echo $ide?>&doc=<?php echo $a->TIPO?>" class="btn-sm btn-success" title="Descarga de XML en ZIP">Zip</a></a>&nbsp;&nbsp;&nbsp;<a href="index.xml.php?action=p_c&anio=<?php echo $a->ANIO?>&mes=0?>" target="_blank" title="Pagado & Cobrado" class="btn-sm btn-warning">P / C</a>
                        </center>
                        <br/>
                        <?php if($usuario=='Oscar Farias (Pruebas Conta)'){?>
                            <center>
                                <a href="index.e.php?action=stat&mes=0&anio=<?php echo $a->ANIO?>&tipo=<?php echo $a->TIPO?>&t=<?php echo $ide?>" class="btn-sm btn-info">Estadisticas</a>
                                <a class="btn-sm btn-success actualiza"  eje="<?php echo $a->ANIO?>">Mobile</a>
                            </center>
                        <?php }?>
                    </div>
                </div>
            </div>                 
            <?php endforeach;?>

<!-- >
    Termina el area de los datos del Ejercicio.
<-->

            <?php if($tp == 0){?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt">&nbsp;&nbsp;<?php echo 'Pagos'?></i></h4>
                        </div>
                        <div class="panel-body">
                            <p><FONT size="4pxs"> <b>&nbsp;&nbsp;<font color='red'>TOTAL EJERCICIO <?php echo $a->ANIO?></font><b/></FONT></p>
                            <p><font color="blue">XMLs </font><b><?php echo '0'?></b><font color="blue"> Sin procesar: <?php echo '0'?></font></p>
                            <p>Monto Anual: 0.00</p>
                            <p>Sub Total: <?php echo '$ '.number_format(0,2)?></p>
                            <p>Total: <?php echo '$ '.number_format(0,2)?></p>
                            <center><a href="index.php?action=verXMLSP&mes=0&anio=<?php echo $a->ANIO?>&ide=<?php echo $ide?>&doc=P" class="btn btn-info">Ver</a>&nbsp;&nbsp;&nbsp;<a href="" class="btn btn-success">Zip</center>
                        </div>
                    </div>
                </div>
            <?php }?>
            <!--- Comienza la parte mensual -->
            <?php 
                    $ncm= 0;
                    $fm = 0;
                    $pm = 0;
                foreach ($subMenuXMLSP as $key): 
                    if($key->TIPO == 'E'){
                        $tipo = 'Notas de Credito';
                        $ncm++;
                    }elseif($key->TIPO == 'I'){
                        $tipo = 'Factura';
                        $fm++;
                    }elseif($key->TIPO == 'P'){
                        $tipo = 'Pago';
                        $pm++;
                    }elseif($key->TIPO == 'N'){
                        $tipo = 'Recibo de Nomina';
                    }else{
                        $tipo = 'No identificado';
                    }
                ?>
                <!--
            <?php if($ncm == 0){?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-list-alt">&nbsp;&nbsp;<?php echo 'NC'?></i></h4>
                            </div>
                        <div class="panel-body">
                            <p><FONT size="4pxs"> <b><?php echo $key->NOMBRE."&nbsp;&nbsp;<font color='red'>".$key->ANIO."</font>"?><b/></FONT></p>
                            <p><font color="blue">XMLs </font><b><?php echo 0?></b><font color="blue"> Sin procesar: <?php echo 0?></font></p>
                            <p>Sub Total: <?php echo '$ '.number_format(0,2)?></p>
                            <p>Total: <?php echo '$ '.number_format(0,2)?></p>
                            <center><a href="index.php?action=verXMLSP&mes=<?php echo $key->MES?>&anio=<?php echo $key->ANIO?>&ide=<?php echo $ide?>" class="btn btn-info">Ver</a>&nbsp;&nbsp;&nbsp;</center>
                        </div>
                    </div>
                </div>
            <?php }?>
        -->
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
                        <center><a href="index.php?action=verXMLSP&mes=<?php echo $key->MES?>&anio=<?php echo $key->ANIO?>&ide=<?php echo $ide?>&doc=<?php echo $key->TIPO?>" class="btn btn-info">Ver</a>&nbsp;&nbsp;&nbsp;<a href="index.xml.php?action=zipXML&mes=<?php echo $key->MES?>&anio=<?php echo $key->ANIO?>&ide=<?php echo $ide?>&doc=<?php echo $key->TIPO?>" class="btn btn-success">Zip</a></center>
                    </div>
                </div>
            </div>
            <!--
            <?php if($pm == 0){?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4><i class="fa fa-list-alt">&nbsp;&nbsp;<?php echo 'Pago'?></i></h4>
                            </div>
                        <div class="panel-body">
                            <p><FONT size="4pxs"> <b><?php echo $key->NOMBRE."&nbsp;&nbsp;<font color='red'>".$key->ANIO."</font>"?><b/></FONT></p>
                            <p><font color="blue">XMLs </font><b><?php echo 0?></b><font color="blue"> Sin procesar: <?php echo 0?></font></p>
                            <p>Sub Total: <?php echo '$ '.number_format(0,2)?></p>
                            <p>Total: <?php echo '$ '.number_format(0,2)?></p>
                            <center><a href="index.php?action=verXMLSP&mes=<?php echo $key->MES?>&anio=<?php echo $key->ANIO?>&ide=<?php echo $ide?>" class="btn btn-info">Ver</a>&nbsp;&nbsp;&nbsp;</center>
                        </div>
                    </div>
                </div>
            <?php }?>
        -->
            <?php endforeach ?>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
    $(".actualiza").click(function(){
        var eje = $(this).attr('eje')
        if(confirm('Se actualizara la informacion del ' + eje)){

            $.ajax({
                url:'index.e.php',
                type:'post',
                dataType:'json',
                data:{updateInfo:1, eje},
                success:function(){

                },
                error:function(){

                }
            })
            //window.open("index.e.php?action=updateInfo&eje=" + eje )
        }else{
            return false
        }
    })
</script>