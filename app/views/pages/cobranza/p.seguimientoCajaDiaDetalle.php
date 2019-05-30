
<br/>
<p id="TOTALDIA"></p>
<br/>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Ruta de Entrega.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-foliofacturas">
                                    <thead>
                                        <tr>     
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado</th>
                                            <th>CP</th>
                                            <th>Factura <br/> Remision</th>
                                            <th>Nota Devolucion <br/> Nota Credito</th>
                                            <th>Refactuaciones</th>
                                            <th>Dias</th>
                                            <th>Unidad</th>
                                            <th>Logistica</th>
                                            <th>Statust</th>
                                            <th>Archivos</th>
                                            <th>Adjuntar</th>
                                            </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $i=0;
                                        $saldo=0;
                                        foreach ($dias as $data):  
                                            $i++;
                                            $sr2=$data->STATUS_RECEPCION;
                                            $saldofinal =0;
                                            $sr = $data->STATUS_RECEPCION;
                                            if($data->SALDOFINAL != 0){
                                                $saldofinal = $data->SALDOFINAL;
                                            }elseif($data->IMPPF != 0){
                                                $saldofinal = $data->IMPPF;
                                            }
                                            $saldodoc=$data->SALDO_DOC;
                                            $saldo += $saldodoc;
                                            $color = '';
                                            $tipo = '';
                                            if($data->STATUS_RECEPCION == 0 or $data->STATUS_RECEPCION==''){
                                                    $color = "style='background-color:#FA5858'";
                                                    $tipo ='Asignacion de Unidad';
                                            }elseif ($data->STATUS_RECEPCION == 1) {
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'Secuencia';
                                            }elseif($data->STATUS_RECEPCION == 2){
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'Administracion';
                                            }elseif($data->STATUS_RECEPCION == 3){
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'En Bodega';
                                            }elseif($data->STATUS_RECEPCION == 4){
                                                $color = "style='background-color:#FA5858'";
                                                $tipo = 'En Bodega Cambio de Status';
                                            }elseif ($data->STATUS_RECEPCION == 5){
                                                $color = "style='background-color:#F2F5A9'";
                                                $tipo = 'Procesado';
                                            }elseif($data->STATUS_RECEPCION == 6){
                                                $color = "style='background-color: #CEE3F6'";
                                                $tipo = 'Con Comprobante <br/> Listo para Recepcion';
                                            }elseif ($data->STATUS_RECEPCION == 7){
                                                $color = "style='background-color:#81BEF7'";
                                                $tipo = 'Recibido, Sin Contra Recibo';
                                            }elseif ($data->STATUS_RECEPCION == 8){
                                                $color = "style='background-color:#6699ff'";
                                                $tipo = 'Recibido, Con Contra Recibo';
                                            }elseif ($data->STATUS_RECEPCION == 9){
                                                $color = "style='background-color:#6699ff'";
                                                $tipo = 'Listo para Cobrar';
                                            }elseif ($data->STATUS_RECEPCION == 10){
                                                $color = "style='background-color:#ffb3ff'";
                                                $tipo = 'Vencido';
                                            }elseif ($data->STATUS_RECEPCION == 11){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Cobrado';
                                            }elseif ($data->STATUS_RECEPCION ==22){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Nota de Credito Total';
                                            }elseif ($data->STATUS_RECEPCION ==33){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Nota de credito Parcial';
                                            }elseif ($data->STATUS_RECEPCION ==44){
                                                $color = "style='background-color:#2d862d'";
                                                $tipo = 'Refacturado';
                                            }elseif($data->STATUS_RECEPCION == 77){
                                                $color = "style='background-color:#33cc33'";
                                                $tipo = 'Pagada';    
                                            }
                                        ?>
                                       <tr class="odd gradeX" <?php echo $color;?> id="linea_<?php echo $i?>">
                                            <td align="center">
                                                <a href="index.php?action=verHC&idc=<?php echo $data->ID?>" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->ID;?></a></td> 
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->ESTADO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->DOCUMENTO;?> 
                                            <?php if(substr($data->DOCUMENTO,0,2) == 'PF'){?>
                                                 <a onclick="impPreFact(<?php echo substr($data->DOCUMENTO,2,10)?>, '<?php echo $data->CVE_FACT?>')"><br/><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a>
                                                <?php }?>
                                            <a href="/Facturas/facturaPegaso/<?php echo $data->DOCUMENTO ?>.pdf" download> <img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a> 
                                            <a href="/Facturas/facturaPegaso/<?php echo $data->DOCUMENTO?>.xml" download> <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>

                                            <?php echo ($data->DOCUMENTO == $data->HISTORIAL)? '':$data->HISTORIAL?><br/> $ <?php echo number_format($saldofinal,2)?>  
                                            </td>
                                            <td><?php echo $data->NC?>
                                                <a href="index.php?action=verDetalleDevolucion&idd=<?php echo substr($data->FOLIO_DEV,3,10)?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->FOLIO_DEV?></a>
                                            </td>
                                            <td><?php echo $data->REFACTURAS?></td>
                                            <td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->UNIDAD;?></td>
                                            <td><?php echo $data->STATUS_LOG?></td>
                                            <td><?php echo $tipo?>
                                            <?php if($tipo == 'Pagada'){?>
                                                <br/><a href="index.cobranza.php?action=verComprobantesPago&docf=<?php echo $data->DOCUMENTO?>" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Ver Comprobante(s)</a>
                                            <?php }?>
                                            </td>
                                            <td>
                                                <?php echo !empty($data->ARCHIVOS)? '<a href="index.php?action=verComprobantesRecibo&idc='.$data->ID.'" target="pop-up" '.'>'.$data->ARCHIVOS.' Archivos</a>':'Sin Archivos'?>
                                            </td>
                                            
                                            <td>
                                                <?php if(($rol == 'cobranza' OR $rol == 'revision' or $tipo2 == 'G')  and $sr2 >=5){?>
                                                <input type="button" name="cara" value="Subir Archivos" onclick="caratula('<?php echo $data->CLAVE?>',<?php echo $data->ID?>, '<?php echo $data->DOCUMENTO?>', '<?php echo $dia.','.$mes.','.$anio?>')">
                                                <?php }else{?>
                                                   <n>Sin Finalizar</n>
                                                <?php }?>
                                            </td>
                                               
                                            <input type="hidden" name="monto" importe="<?php echo empty($data->SALDO_DOC)? 0:$data->SALDO_DOC?>" class="total">
                                            </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                      </div>
                </div>
        </div>
    </div>
</div>

<form action ="index.php" method="POST" id='FORM_EXEC'>
        <input type="hidden" name="impPreFact" value="" id="val">
        <input type="hidden" name="docf" value="" id="docf">
        <input type="hidden" name="tipo" value="" id="">
        <input type="hidden" name="cajas" value="" id="cu">
</form>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    function impPreFact(idc, docf ){
            document.getElementById('val').value=idc;
            document.getElementById('docf').value=docf;
            var form= document.getElementById('FORM_EXEC');
            form.submit();   
    }

    $(document).ready(function(){
        var total = 0;
        $("input.total").each(function(){
            var importe = parseFloat($(this).attr("importe"),2);
            total = total + importe;
        });
        var numero = String(total).split(".");
        numero = formato(numero);
        document.getElementById('TOTALDIA').innerHTML="Total Facturado / Remisionado por Dia: $ "+ numero;
    
    })

     function formato(numero){
            var long = numero[0].length;
            //alert('Tipo: '+ tipo + 'Monto: '  + numero);
            if(numero[0].length > 6){
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
                var texto = '$  '+ millones + ',' + miles + ','+ unidades + '.00';
            }else if(numero[0].length > 3){
                var tipo = 'Miles';
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
                var texto = '$  '+ millones +',' + miles + '.00';
            }else if(numero[0].length > 0){
                    if (long == 3){
                    var mill = 3;
                }else if(long == 2){
                    var mill = 2;
                }else if(long == 1){
                    var mill = 1
                }
                var millones = numero[0].substring(0,mill);
                var miles = numero[0].substring(mill, mill + 3 );
                var unidades = numero[0].substring(mill + 3, mill +6);
                var texto = '$  '+ millones + '.00';
            }
            
            return texto;

        }
        
    function caratula(cl, idc, doc, fecha){
        $.ajax({
            url:'index.php',
            type:'POST',
            dataType:'json',
            data:{caratula:1, cl:cl, idc:idc, fecha:fecha},
            success:function(data){
                if(data.status =='ok'){
                     window.location.href ='index.php?action=caratula&cl='+cl+'&idc='+idc+'&doc='+doc+'&fecha='+fecha+'&tipo=2';
                }else{
                    alert('El cliente no tiene caratula');
                }
            }
        })
    }
    
    function finalizar(fin, i){
        var caja = document.getElementById("caja2_"+i).value;
        var statusA = document.getElementById("statusA_"+i).value;
        if(statusA != fin){
            if(confirm('Desea Cambiar el status de la Caja '+ caja + ' Status Actual: ' + statusA + ' Nuevo Status: '+ fin)){
                $.ajax({
                    url:"index.php",
                    method:"POST",
                    dataType:"json",
                    data:{finRutaLog:3,fin:fin,idcaja:caja},
                    success:function(data){
                        if(data.status == 'ok'){
                            document.getElementById('linea_'+i).style='background-color:#fcf3cf';
                        }else{
                            alert(data.mensaje);
                            document.getElementById('sel_'+i).value='nada';
                        }
                        
                    }
                })
            }    
        }
    }


</script>