<br/>
<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <div>
                        <p><?php echo 'Usuario: '.$_SESSION['user']->NOMBRE?></p>
                        <p><?php echo 'RFC seleccionado: '.$_SESSION['rfc']?></p>
                        <p><?php echo 'Empresa Seleccionada'.$_SESSION['empresa']['nombre']?></p>  
                        <p><?php echo 'Se muestran los XML de Nomina '?></p>
                    </div>
                </h3>
            </div>
            
            <?php foreach ($info as $key): ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2><i class="fa fa-list-alt">&nbsp;&nbsp;<?php echo 'Nomina del: '.date('d-m-Y', strtotime($key->FECHA_INICIAL)).' al '.date('d-m-Y', strtotime($key->FECHA_FINAL))?></i></h2>
                        </div>
                    <div class="panel-body">
                        
                        <p><FONT size="4pxs"> <b>Recibos Detectados: </b><font color="blue"><?php echo ($key->RECIBOS)?></font>&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.xml.php?action=detalleNomina&fi=<?php echo $key->FECHA_INICIAL?>&ff=<?php echo $key->FECHA_FINAL?>" class="btn-sm btn-info">Detalle</a><br/>
                        <p><FONT size="4pxs"> <b>Empleados:
                        <?php $ln= 0; foreach($emp as $em): ?>    
                            <?php if($em->FI == $key->FECHA_INICIAL AND $em->FF == $key->FECHA_FINAL){ $ln++;?>
                                <?php }?>
                        <?php endforeach;?>
                    </b><font color="blue"><?php echo ($ln)?></font><br/>
                        <p><FONT size="4pxs"> <b>Percepciones</b><br/>
                        <?php foreach($per as $pr):?>
                            <?php if($pr->FI == $key->FECHA_INICIAL AND $pr->FF == $key->FECHA_FINAL){?>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;Sueldos: <font color=" #1a9178 "><?php echo '$ '.number_format($pr->SUELDOS,2);?></font></p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;Separaciones: <?php echo '$ '.number_format($pr->SEPARACIONES,2);?></p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;Jubilaciones: <?php echo '$ '.number_format($pr->JUBILACION,2);?></p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;Gravado: <?php echo '$ '.number_format($pr->GRAVADO,2);?></p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;Exento: <?php echo '$ '.number_format( empty($pr->EXENTO)? 0:$pr->EXENTO,2);?></p>
                            <?php }?>
                        <?php endforeach;?>
                        <p><FONT size="4pxs"> <b>Deducciones</b><br/>
                        <?php foreach($ded as $dd):?>
                            <?php if($dd->FI == $key->FECHA_INICIAL AND $dd->FF == $key->FECHA_FINAL){?>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;Retenciones: <?php echo '$ '.number_format($dd->RETENCIONES,2);?></p>
                                <p>&nbsp;&nbsp;&nbsp;&nbsp;Otras deducciones: <?php echo '$ '.number_format($dd->OTRAS_DEDUCCIONES,2);?></p>
                            <?php }?>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
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