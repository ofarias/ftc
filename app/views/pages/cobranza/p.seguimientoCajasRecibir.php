<br /><br/>

<p>Usuario: <?php echo $usuario?></p>
<p>Cartera: <?php echo $tipoUsuario?></p>
<p id="Total"></p>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Folios con Evidencia de Entrega.
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-seguimientoCajas">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <th>Caja</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>Estado<br/>CP</th>
                                            <th>Importe</th>
                                            <th>Factura / Remision</th>
                                            <th>Nota Devolucion <br/> Nota Credito</th>
                                            <th>Dias</th>
                                            <th>Unidad</th>
                                            <th>Logistica</th>
                                            <th>Status</th>
                                            <th>Archivos</th>
                                            <?php if($tipoUsuario == 'G'){?>
                                                <th>Cartera</th>
                                            <?php }?>
                                            <th>Contrarecibo</th>
                                            <th>Solicitar <br/>Refacturacion</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                            $i=0;
                                            foreach ($documentos as $data):  
                                            $i++;
                                            $color = '';
                                            $tipo = '';

                                            if(!empty($data->SALDOFINAL)){
                                                    $SALDOFINAL = $data->SALDOFINAL;
                                                }elseif(!empty($data->IMPREM)){
                                                    $SALDOFINAL = $data->IMPREM;
                                                }else{
                                                    $SALDOFINAL = $data->IMPPF;
                                            }

                                            if($data->STATUS_RECEPCION == 0 ){
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
                                                $tipo = 'Recibido, Con Contra Recibo';
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
                                            }elseif ($data->STATUS_RECEPCION == 61){
                                                $color = "style='background-color:#f2c294'";
                                                $tipo = 'Con Comprobante, Recibido';    
                                            }
                                        ?>

                                        <tr class="odd gradeX" <?php echo $color;?> id="linea_<?php echo $i?>">
                                            <input type="hidden" name="doc" value="<?php echo $data->DOCUMENTO?>" id ="doc_<?php echo $i?>">
                                            <td><?php echo $i?></td>

                                            <td align="center"><a href="index.php?action=verHC&idc=<?php echo $data->ID?>" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->ID;?></a></td>
                                            
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            
                                            <td><?php echo $data->NOMBRE;?><br/>

                                            <?php if($data->STATUS_RECEPCION == 61 OR $data->STATUS_RECEPCION == 6){?>
                                                <input type="button" name="recibir" value="recibir" class="btn btn-info" id="btnrec<?php echo $i?>"
                                             <?php echo ($data->STATUS_RECEPCION == 61)? 'disabled':''?>
                                             onclick="recibirDoc(<?php echo $data->ID?>, <?php echo $i?>)">
                                             <?php }?>
                                             
                                            </td>
                                            
                                            <td><?php echo $data->ESTADO.'<br/>'.$data->CODIGO;?></td>
                                            
                                            <td><?php echo '$ '.number_format($SALDOFINAL,2);?></td>
                                            
                                            <td><?php echo $data->DOCUMENTO;?> 
                                            <?php if(substr($data->DOCUMENTO,0,2) == 'PF'){?>
                                                 <a onclick="impPreFact(<?php echo substr($data->DOCUMENTO,2,10)?>, '<?php echo $data->CVE_FACT?>')"><br/><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a>
                                                <?php }?>
                                            <a href="/Facturas/facturaPegaso/<?php echo $data->DOCUMENTO ?>.pdf" download> <img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a> 
                                            <a href="/Facturas/facturaPegaso/<?php echo $data->DOCUMENTO?>.xml" download> <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>

                                            <?php echo ($data->DOCUMENTO == $data->HISTORIAL)? '':$data->HISTORIAL?><br/> $ <?php echo number_format($saldofinal,2)?>  
                                            </td>
                                            <td><a href="index.php?action=verDetalleDevolucion&idd=<?php echo substr($data->FOLIO_DEV,3,10)?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><?php echo $data->FOLIO_DEV?></a><br/><?php echo $data->NCP?></td>
                                            <td align="center"><?php echo $data->FECHA_REV.'<br/>'.$data->DIAS;?></td>
                                            
                                            <td><?php echo $data->UNIDAD;?></td>
                                            
                                            <td ><?php echo $data->STATUS_LOG?></td>
                                            
                                            <td><p id="st_<?php echo $i?>"><?php echo $tipo?></p></td>
                                            
                                            <td><?php echo !empty($data->ARCHIVOS)? '<a href="index.php?action=verComprobantesRecibo&idc='.$data->ID.'" target="pop-up" '.'>'.$data->ARCHIVOS.' Archivos</a>':'Sin Archivos'?></td>
                                            <?php if($tipoUsuario == 'G'){?>
                                                <td><?php echo $data->C_REVISION?></td>
                                            <?php }?>
                                            <td>
                                                <?php if($tipo2 == 6 and ($tipoUsuario =='G' or $tipoUsuario = 'R') ){?>
                                                <input type="text" maxlength="100" minlength="1" placeholder="Contrarecibo" value="" id="ctrcbo_<?php echo $data->ID?>" onchange="grabaCTRCBO(<?php echo $data->ID?>,<?php echo $i?>, this.value)">
                                                <?php }elseif($tipo2 == 7 ){?>
                                                <?php echo $data->CONTRARECIBO?>
                                            </td>

                                            <td> 
                                                <input type="button" name="recContra" value="Recibir Contra Recibo" onclick="grabaCTRCBO(<?php echo $data->ID?>, <?php echo $i?>, 'cob<?php echo $data->ID?>')" id="btn_rc<?php echo $data->ID?>">
                                            </td>
                                                <?php }elseif($tipo2 == 8){?>
                                            <td>
                                                <?php echo $data->CONTRARECIBO?>                                          
                                            </td>   
                                               <?php }?>
                                            <td>   
                                            <input type="hidden" class="datos" name="datos" importe="<?php echo $SALDOFINAL?>">
                                            <?php if(empty($data->INFOREFACT)){?>
                                            <input type="button" name="solrefact" value="Solicitar Refacturacion" 
                                            onclick="solRefact(<?php echo $i?>,<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>', '<?php echo $data->DOCUMENTO ?>')" >
                                            <?php }else{?>
                                            <?php echo $data->INFOREFACT?>
                                            <?php }?>   
                                            </td> 
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


        function solRefact(ln, idc, docp, docf){
            var tipoDoc = docf.trim().substring(0,1);
            if(tipoDoc == 'F' || tipoDoc == 'R'){
                enviaRefact(ln, idc, docp, docf);
            }else if(tipoDoc=='0'){
                alert('Esto es una remision');            
            }else{
                alert('Se desconoce el tipo de documento');
            }
        }

        function enviaRefact(ln, idc, docp, docf){
             $.confirm({
                title: 'Motivos de la Refacturacion',
                content: '¿Favor de Seleccionar el motivo de la refacturacion del documento: ' + docf + 
                '<form action="index.php" class="formName">' +
                '<div class="form-group">'+
                '<label>Seleccionar un motivo</label> <br/>'+
                '<br/>Motivos: <select name="motivo" required class="motivo">'+
                    '<option value="a">"Seleccione un motivo"</option>'+
                    '<option value="CAMBIO FECHA">"Fecha"</option>'+
                    '<option value="CAMBIO CLIENTE">"Cambio de Cliente"</option>'+
                    '<option value="partidas">"Division de partidas"</option>'+
                    '<option value="mixto">"Varios cambios"</option>'+
                '</select><br/>' +
                '<br/>Observaciones:<br/>' +
                '<textarea name="obs" rows="4" cols="45" class="obs" required></textarea>'+
                '</div><br/><br/>'+
                '</form>',
                    buttons: {
                    formSubmit: {
                    text: 'Generar Factura',
                    btnClass: 'btn-blue',
                    action: function () {
                        var motivo = this.$content.find('.motivo').val();
                        var obs = this.$content.find('.obs').val();
                        if(motivo=='a'){
                            $.alert('Debe de seleccionar un motivo...');
                            return false;
                        }else if(obs== ''){
                            $.alert('Debe de capturar una Observacion...');
                            return false;   
                        }else{   
                          //$.alert('Se timbrara la factura con los siguientes datos  ' + motivo + ', ' + obs);
                          //facturarCaja(idcaja, docf, val, uso, tpago, mpago);
                            $.ajax({
                                url:'index.cobranza.php',
                                type:'POST',
                                dataType:'json',
                                data:{creaSolRev:docf, idc:idc, docp:docp, obs:obs, motivo:motivo},
                                success:function(data){
                                    if(data.status == 'ok'){
                                        alert('Se Creo la solicitud');
                                    }else {
                                        alert(data.texto);
                                    }
                                }
                            });
                        }
                    }
                },
                cancelar: function () {
                    //close
                },
            },
            onContentReady: function () {
                // bind to events
                var jc = this;
                //alert(jc);
                this.$content.find('form').on('submit', function (e) {
                    // if the user submits the form by pressing enter in the field.
                    e.preventDefault();
                    jc.$$formSubmit.trigger('click'); // reference the button and click it
                });
            }
        });
    }




    function recibirDoc(idc, ln){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{recDocRev:idc},
            success:function(data){
                if(data.status == "no"){
                    alert(data.mensaje);
                }else{
                    document.getElementById("linea_"+ln).style='background-color:#f2c294';
                    document.getElementById('btnrec'+ln).disabled=true;
                    document.getElementById('st_'+ln).innerHTML="Con Comprobante, Recibido";
                }
            }
        });

    }

    function grabaCTRCBO(idc, i, ctrcbo){
        var doc = document.getElementById('doc_'+i).value;

        if(ctrcbo != 'cob'+idc){
             $mensaje = 'Desea colocar el Contrarecibo: ' + ctrcbo +' del documento:'+ doc;     
        }else{
            $mensaje = 'Desea Recibir el Documento: ' + doc;
        }
       
        if(confirm($mensaje)){
                if(ctrcbo != 'cob'+idc){
                     document.getElementById('ctrcbo_'+idc).readOnly=true;     
                }
                $.ajax({
                    url:"index.php",
                    method:"POST",
                    dataType:"json",
                    data:{grabaCtrCbo:1, idc:idc,doc:doc, info:ctrcbo},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert(data.razon);
                            if(ctrcbo !='cob'+idc){
                                document.getElementById('linea_'+i).style='background-color:#6699ff';
                                document.getElementById('st_'+i).innerHTML='Recibido, Con Contra Recibo';
                            }else{
                                document.getElementById('linea_'+i).style='background-color:#99ff99';
                                document.getElementById('st_'+i).innerHTML='Listo para Cobrar';
                                document.getElementById('btn_rc'+idc).disabled=true;     
                            }
                        }else{
                            alert(data.razon);
                            document.getElementById('sel_'+i).value='nada';
                        }
                    }
                })    
        }else{
            document.getElementById('ctrcbo_'+idc).value='';
        }
    }

    $(document).ready(function(){
        var total = 0;

        $("input.datos").each(function(){
            var importe = parseFloat($(this).attr("importe"),2);
            total = total + importe;
        });
        var numero = String(total).split(".");
        numero  = formato(numero);

        document.getElementById('Total').innerHTML="Total en Recibo" + numero;
    })

 function formato( numero){
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

</script>