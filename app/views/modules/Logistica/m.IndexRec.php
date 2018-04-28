
 <STYLE type="text/css">
  H1 { text-align: center};
  select {text-align: center};
 </STYLE>
 <div class="row">
            <div class="col-md-3 col-md-offset-1">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Favor de Escanear su documento</h3>
                    </div>
                    <div class="panel-body">
                       
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Escanee su documento por favor..." name="qr" type="text" autofocus required="required" id="qr">
                                </div>
                                <input type="button" name="cancelar" class="btn btn-danger" value="cancelar" id="btnc">
                            </fieldset>
                    </div>
                    
                    <H1>o</H1>
                    <div >
                              <select name="seleccion" id='sel' onchange="obtieneQR(this.value)">
                                <option value= "999">Seleccione Orden de Compra</option>
                                <?php foreach ($ocp as $ordenes): 
                                    $oc = $ordenes->OC;
                                ?>
                                    <option value="<?php echo $oc?>"><?php echo $oc.' --> '.$ordenes->OPERADOR.' --> '.$ordenes->IDU.' --> '.$ordenes->FECHA_RUTA?></option>    
                                <?php endforeach ?>    
                            </select>

                    </div>
                </div>
            </div>
        </div>

        <div id="cuerpo">
                   
        </div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">

    function obtieneQR(oc){
        alert('Se intenta obtener el QR' + oc);
        $.ajax({
            url:'index_log.php',
            type:'post',
            dataType:'json',
            data:{obtieneQR:oc},
            success:function(data){
                document.getElementById('qr').value=data.qr;
                var documento = "http://ofa.dyndns.org:8888/pegasoFTC/index_log.php?action=procesarDoco&doco====?"+data.qr;                  
                    $.ajax({
                    url:"index_log.php",
                    type:"POST",
                    dataType:"json",
                    data:{buscaQR:documento.toUpperCase()},
                    success:function(data){
                        if(data.status == 'ok' && data.documentos == 'No se encontro la ruta'){
                            document.getElementById('qr').value='';
                        }else if(data.status == 'ok' && data.documnetos != 'No se encontro la ruta'){
                            document.getElementById('qr').value='';
                                   tr = '';
                                $.each(data.documentos, function(key,value){
                                    var doco = value.toString().split(",");
                                    var num= parseFloat(doco[2]);
                                     var ventana="'width=2000,height=820'";
                                     var oc = "'"+doco[8]+"'";
                                     var color="";
                                     var info ="";
                                     if(doco[9]==1){
                                        var color = "style='background-color:red'";
                                        var info="<br/> Fecha Reg: "+doco[10] +"<br/> Folio Reg: " + doco[11] ;     
                                     }
                                     
                                     tr += '<tr id="l'+key+'" ' + color + ' >';
                                     tr += '<td>'+key+'</td><td>'+doco[0]+'</td><td>'+doco[1]+'</td><td align="right"> $ '+num +'</td>';
                                     tr += '<td>'+doco[3]+'</td><td>'+doco[4]+'</td><td>'+doco[5]+'</td><td>'+doco[6]+'</td>';
                                     tr += '<td>' + doco[7] +'</td>'+ '<td>' + doco[8] + info +'</td>';
                                     //tr += '<td> <a class="btn btn-success" href="index_log.php?action=procesarDoco&doco='+doco[8]+'" target="popup" onclick="window.open(this.href, this.target, '+ ventana +'); return false;">Procesar</td>';
                                     tr += '<td> <a class="btn btn-success" onclick="registraDoc('+oc+','+key+')";">Registrar</td>';
                                     tr += '<td><input type="text" length="40" max="40" placeholder="Escanea QR" value="" id="qr_'+key+'" onchange="habilitar('+key+', this.value)"</td>';
                                     tr += '<input type="hidden" name="doc" value="'+doco[8]+'" id="'+key+'">';
                                     tr += '</tr>';
                                });
                                    var tabla = '<table cellpadding="0" cellspacing="0" border="1" class="table table-striped table-bordered table-hover" id="lista_paciente">';
                                        tabla += '<caption>Doumentos pendientes del Operador</caption>';
                                        tabla += '<thead>';
                                        tabla += '<tr>';
                                        tabla += '<th>Linea</th><th>Identificador</th><th>Operador</th><th>Importe</th><th>Unidad</th><th>Forma de Pago</th><th>Confirmador Pegaso</th><th>Confirmado Proveedor</th><th>Tipo</th><th>Documento</th>';
                                        tabla += '</tr>';
                                        tabla += '</thead>';
                                        tabla += '<tbody>';
                                        tabla += tr;
                                        tabla += '</tbody></table>';
                                        $('#cuerpo').html( tabla );
                        }else {alert('No se encontro el documento: ' + doc);  
                            document.getElementById('qr').value='';  
                        }
                    }
                })
            }
        })

    }

    function habilitar(i,qr){
        var oc = document.getElementById(i).value;
        /*var info = qr.toUpperCase().split("Ñ");
        if(info.length<7){
            info=documento.split(":");
        }*/
        var oc = 0;
        $.ajax({
            url:"index_log.php",
            type:"POST",
            dataType:"json",
            data:{buscaQR2:1,qr:qr, oc:oc},
            success:function(data){
                if(data.validacion == 1){
                    var test="'width=2000,height=820'";
                    if(confirm('Se Encontro el documento se registra para su recepcion.' + oc)){
                        document.getElementById('l'+i).style.background="#80bfff";
                        document.getElementById('qr_'+i).value=info[0];
                        window.open("index_log.php?action=procesarDoco&doco="+oc, 'popup', test);
                    }
                }else{
                    alert('El documento no pertenece a la OC, favor de verificar.');
                    document.getElementById('qr_'+i).value='';
                }
            }
        })
    }



    $("#btnc").click(function(){
        if(confirm('Desea Cancelar el registro de documentos?')){
            window.location.href="index.php?action=login";
        }
    })

    $('#qr').change(function(){
        var documento = document.getElementById('qr').value;
        var info = documento.toUpperCase().split("Ñ");
        if(info.length<7){
            info=documento.split(":");
        }
        var doc = info[2];
       
        $.ajax({
            url:"index_log.php",
            type:"POST",
            dataType:"json",
            data:{buscaQR:documento.toUpperCase()},
            success:function(data){
                if(data.status == 'ok' && data.documentos == 'No se encontro la ruta'){
                    document.getElementById('qr').value='';
                }else if(data.status == 'ok' && data.documnetos != 'No se encontro la ruta'){
                    document.getElementById('qr').value='';
                           tr = '';
                        $.each(data.documentos, function(key,value){
                            var doco = value.toString().split(",");
                            var num= parseFloat(doco[2]);
                            /*
                            var formatNumber = {
                                 separador: ",", // separador para los miles
                                 sepDecimal: '.', // separador para los decimales
                                 formatear:function (num){
                                 num +='';
                                 var splitStr = num.split('.');
                                 var splitLeft = splitStr[0];
                                 var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
                                 var regx = /(\d+)(\d{3})/;
                                        while (regx.test(splitLeft)) {
                                            splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
                                        }
                                    return this.simbol + splitLeft +splitRight;
                                 },
                                 new:function(num, simbol){
                                 this.simbol = simbol ||'';
                                 return this.formatear(num);
                                 }
                                 }
                               */ 
                             var ventana="'width=2000,height=820'";
                             var oc = "'"+doco[8]+"'";
                             var color="";
                             var info ="";
                             if(doco[9]==1){
                                var color = "style='background-color:red'";
                                var info="<br/> Fecha Reg: "+doco[10] +"<br/> Folio Reg: " + doco[11] ;     
                             }
                             
                             tr += '<tr id="l'+key+'" ' + color + ' >';
                             tr += '<td>'+key+'</td><td>'+doco[0]+'</td><td>'+doco[1]+'</td><td align="right"> $ '+num +'</td>';
                             tr += '<td>'+doco[3]+'</td><td>'+doco[4]+'</td><td>'+doco[5]+'</td><td>'+doco[6]+'</td>';
                             tr += '<td>' + doco[7] +'</td>'+ '<td>' + doco[8] + info +'</td>';
                             //tr += '<td> <a class="btn btn-success" href="index_log.php?action=procesarDoco&doco='+doco[8]+'" target="popup" onclick="window.open(this.href, this.target, '+ ventana +'); return false;">Procesar</td>';
                             tr += '<td> <a class="btn btn-success" onclick="registraDoc('+oc+','+key+')";">Registrar</td>';
                             tr += '<td><input type="text" length="40" max="40" placeholder="Escanea QR" value="" id="qr_'+key+'" onchange="habilitar('+key+', this.value)"</td>';
                             tr += '<input type="hidden" name="doc" value="'+doco[8]+'" id="'+key+'">';
                             tr += '</tr>';
                        });
                            var tabla = '<table cellpadding="0" cellspacing="0" border="1" class="table table-striped table-bordered table-hover" id="lista_paciente">';
                                tabla += '<caption>Doumentos pendientes del Operador</caption>';
                                tabla += '<thead>';
                                tabla += '<tr>';
                                tabla += '<th>Linea</th><th>Identificador</th><th>Operador</th><th>Importe</th><th>Unidad</th><th>Forma de Pago</th><th>Confirmador Pegaso</th><th>Confirmado Proveedor</th><th>Tipo</th><th>Documento</th>';
                                tabla += '</tr>';
                                tabla += '</thead>';
                                tabla += '<tbody>';
                                tabla += tr;
                                tabla += '</tbody></table>';
                                $('#cuerpo').html( tabla );
                }else {alert('No se encontro el documento: ' + doc);  
                    document.getElementById('qr').value='';  
                }
            }
        })
    })


    function registraDoc(oc, l){
        
        if(confirm('Se intenta registrar el documento : ' + oc)){
            $.ajax({
                url:'index_log.php',
                type:'post',
                dataType:'json',
                data:{regDocOp:oc},
                success:function(data){
                    alert(data.mensaje);
                    if(data.status == 'ok'){
                        document.getElementById('l'+l).style.background='red';
                    }
                }
            })
        }else{

        }

    }

  
</script>