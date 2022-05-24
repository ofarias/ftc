<br/>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div>
                        <p><?php echo 'Usuario: '.$_SESSION['user']->NOMBRE?></p>
                        <p><?php echo 'RFC seleccionado: '.$_SESSION['rfc']?></p>
                        <p><?php echo 'Empresa Seleccionada: <b>'.$_SESSION['empresa']['nombre']."</b>"?></p>  
                        <?php if($mes == 0 ){?>
                            <p><?php echo 'Se muestran los XML '.$ide.' del ejercicio '.$anio?></p>    
                        <?php }else{?>
                            <p><?php echo 'Se muestran los XML '.$ide." del mes ".$mes." del ".$anio?></p>
                        <?php }?>
                            <font color="blue"><input type="button" ide="<?php echo $ide?>" value="Descargar a Excel" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>','x')"></font>
                            <!--<font color="blue"><input type="button" ide="<?php echo $ide?>" value="Descarga Partidas a Excel" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>','xp')"></font>-->
                            <?php if($cnxcoi=='si'){?>
                            <font color="black"><input type="button" value="Consolidar Polizas" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'c')"></font>
                            <font color="red"><input type="button"  value="Revision Contabilizacion" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'z')"></font>
                            <font color="green"><input type="button"  value="Polizas Automaticas" onclick="pAuto(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'pa')"></font>
                            <font color="#DC143C"><input type="button"  value="Acomodar Pólizas" onclick="pAcomodo(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'pa')"></font>
                            <font color="#1a8cff"><input type="button"  value="Carga Parametros" onclick="cargaParam()"></font>
                            <font color="red"><input type="button" value="Diot Batch" onclick="cargaBatch(<?php echo $mes ?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>')"> </font>
                            <font color="purple"><input type="button" value="Ver Provision" class="verProv" anio="<?php echo $anio?>" mes="<?php echo $mes?>" ide="<?php echo $ide?>" doc="<?php echo $doc?>"></font>
                            <font color="dark blue"><input type="button" value="Relacionar Facturas" class="rfg" anio="<?php echo $anio?>" mes="<?php echo $mes?>" ide="<?php echo $ide?>" doc="<?php echo $doc?>" title="Relaciona facturas de gastos del mes seleccionado a facturas de Ventas para un calculo de Utilidades"></font>
                            <br/><br/>
                            <!--
                            <font>Filtro XML:&nbsp; Todas <input type="radio" name="verXML" class="ver" value="x" checked> &nbsp;Pendientes:&nbsp;  <input type="radio" name="verXML" class="ver" value="pend"> &nbsp;Provision: &nbsp; <input type="radio" name="verXML" class="ver" value="d"> &nbsp;Eg: &nbsp; <input type="radio" name="verXML" class="ver" value="ie"> </font>
                             -->
                        <?php }else{?>
                            <font color="black"><input type="button" value="Consolidar Polizas" onclick="info()"></font>
                            <font color="red"><input type="button"  value="Revision Contabilizacion" onclick="info()"></font>
                            <font color="green"><input type="button"  value="Polizas Automaticas" onclick="info()"></font>
                        <?php }?>
                        </p>
                    </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Ln</th>
                                            <!--<th>Sta</th>-->
                                            <th>UUID</th>
                                            <th>TIPO</th>
                                            <th>FOLIO</th>
                                            <th>FECHA PAGO</th>
                                            <th>FECHA</th>
                                            <th class="impDet">EMISOR</th>
                                            <th>RECEPTOR</th>
                                            <th>MON</th>
                                            <th>TC</th>
                                            <th>MONTO PAGO</th>
                                            <th>DETALLE PAGO</th>                                            
                                       </tr>
                                    </thead>                                   
                                  <tbody>
                                        <?php $ln=0;
                                            foreach ($info as $key): 
                                            $color='';
                                            $color2= "";
                                            $ln++;
                                            $descSta = '';
                                            if($key->TIPO == 'I'){
                                                $tipo = 'Ingreso';
                                                $color =  'style="background-color: #56df27"';
                                                $color2= "#56df27";
                                            }elseif ($key->TIPO =='E') {
                                                $tipo = 'Egreso';
                                                $color = 'style="background-color:yellow"';
                                                $color2= "yellow";
                                            }elseif($key->TIPO == 'P'){
                                                $tipo = 'Pago';
                                                $color = 'style="background-color:#aee7e3"';
                                                $color2= "#aee7e3";
                                            }else{
                                                $tipo = 'Desconocido';
                                                $color = 'style="background-color:brown"';
                                                $color2= "brown";
                                            }
                                            $rfcEmpresa=$_SESSION['rfc'];
                                            $test= 'Pago';
                                            if($key->STATUS == 'P'){
                                                $descSta = 'P';
                                                $test= 'Pendiente';
                                            }elseif($key->STATUS== 'D'){
                                                $descSta = 'Poliza de Dr para ver la poliza del documento da click en el UUID';
                                                $color = 'style="background-color:#f9fbae"';
                                                $test = 'Poliza Dr';
                                                $color2= "#f9fbae";
                                            }elseif($key->STATUS=='I'){
                                                $descSta = 'Con Poliza de Ingreso para ver las polizas del documento da click en el UUID';
                                                $color = 'style="background-color:#a0ecfb"';
                                                $test = 'Poliza Ig';
                                                $color2= "#a0ecfb";
                                            }elseif($key->STATUS=='E'){
                                                $descSta = 'Con Poliza de Egreso para ver las polizas del documento da click en el UUID';
                                                $color = 'style="background-color:#bcffe9"';
                                                $test = 'Poliza Eg';
                                                $color2= "#bcffe9";
                                            }elseif($key->STATUS=='C'){
                                                $descSta = 'El Documento esta cancelado en el SAT';
                                                $color = 'style="background-color:#fa8055"';
                                                $test = 'Cancelado';
                                                $color2= "#bcffe9";
                                            }
                                        ?>
                                        <tr class="<?php echo $test?> odd gradeX " <?php echo $color ?> title="<?php echo $descSta?>" id="ln_<?php echo $ln?>" >

                                            <td><?php echo $ln?></td>
                                            <!--<td><?php echo $test.'<br/><font color="blue">'.$key->POLIZA.'</font>'?></td>-->
                                            <td><?php echo $key->UUID?></td>
                                            <td><font color='blue'><?php echo $tipo?><br/><?php echo $key->METODOPAGO.'<br/>'.$key->FORMAPAGO.'<br/>'.$key->USO?></font></td>
                                            <td><?php echo $key->DOCUMENTO?></td>

                                            <td><b><?php echo $key->FECHA_PAGO;?> </b></td>

                                            <td><?php echo $key->FECHA;?> </td>

                                            <td><?php echo $key->RFCE.'<br/><b>'.$key->RECEPTOR.'<b/>'?></td>

                                            <td><?php echo $key->CLIENTE.'<br/><b>'.$key->EMISOR.'<b/>'?></td>


                                            <td><?php echo $key->MONEDA;?> </td>
                                    
                                            <td align='right'><?php echo '$ '.number_format($key->TIPOCAMBIO,2);?></td>
                                            <td align='right'><?php echo '$ '.number_format($key->MONTO_PAGO,2);?></td>
                                            <td><label id="<?php echo $key->UUID?>" uuid="<?php echo $key->UUID?>" class="pagodet" ></label></td>
                                        </tr>
                                        <?php endforeach; ?>
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

    $(document).ready(function(){
        detallePago();
    })                                            
    function detallePago(){
        $(".pagodet").each(function(){
            var uuid = $(this).attr("uuid")
            //alert("Traemos el pago del documento "  + uuid)
            var pos=document.getElementById(uuid)
            var doc = 0
            $.ajax({
                url:'index.pago.php',
                type:'post', 
                dataType:'json', 
                data:{detallePago:uuid},
                success:function(data){
                    if(data.status=='ok'){
                        //pos.innerHTML = "Traemos la informacion"
                        if(data.datos.length > 0){
                            for(const [key, value] of Object.entries(data.datos)){                                 
                                doc++
                                for(const [k,val] of Object.entries(value)){
                                    if(k=='SERIE'){var serie=val}
                                    if(k=='FOLIO'){var folio=val}
                                    if(k=='SALDO'){ var saldo=val}    
                                    if(k=='PAGO'){ var pago=val}   
                                    if(k=='SALDO_INSOLUTO'){ var saldo_ins=val}   
                                    if(k=='METODO_PAGO'){ var mp=val}
                                    if(k=='ID_DOCUMENTO'){ var uuid_doc=val}   
                                    if(k=='TIPO_CAMBIO'){ var tc=val}   
                                }
                                saldo = saldo.toLocaleString(undefined, { minimumFractionDigits: 2,maximumFractionDigits: 2})
                                pago = pago.toLocaleString(undefined, { minimumFractionDigits: 2,maximumFractionDigits: 2})
                                saldo_ins = saldo_ins.toLocaleString(undefined, { minimumFractionDigits: 2,maximumFractionDigits: 2})
                                tc = tc.toLocaleString(undefined, { minimumFractionDigits:2, maximumFractionDigits:2})
                                pos.innerHTML+="<b> "+ doc +" </b> <br/>"
                                pos.innerHTML+="<b> UUID :</b>"+ uuid_doc +"  <br/>"
                                pos.innerHTML+="<b>Documento:</b> " + serie + folio + ' Metodo de Pago: '+ mp + '<br/>'
                                pos.innerHTML+="<b> Saldo: </b> <font color='green'>" + saldo + '</font><br/>'
                                pos.innerHTML+="<b> Pago : </b> <font color='blue'>" + pago + "</font> TC: <font color='blue'>"+ tc + "</font><br/>"
                                pos.innerHTML+="<b> Saldo Insoluto: </b> <font color='red'>" + saldo_ins + '</font><br/>'
                                pos.innerHTML+="<b> ______________________________ </b> <br/>"
                            }
                        }
                    }else{
                        pos.innerHTML = "No se encontro informacion del pago..."
                    }
                },
                error:function(){
                    pos.innerHTML = "No se encontro informacion del pago..."
                }
            })
        })
    }

    $(".infoPago").mouseover(function(){
        var text = 'Nuevo Texto'
        var id = $(this).attr('ln')
        var uuid = $(this).attr('uuid')
        $.ajax({
            url:'index.cobranza.php',
            type:'post',
            dataType:'json',
            data:{aplUUID:1, uuid},
            success:function(data){
                
            },
            error:function(){
                text = 'Sin pago detectado'
            }
        })
        $("#tip_"+id).attr('title',text)
    })

    $(".verProv").click(function(){
        var mes = $(this).attr('mes')
        var anio = $(this).attr('anio')
        var ide = $(this).attr('ide')
        var doc = $(this).attr('doc')
        window.open("index.xml.php?action=verProv&mes="+mes+"&anio="+anio+"&ide="+ide+"&doc="+doc, "_blank")
    })

    $(".infoAdicional").mouseover(function(){
        var id =$(this).attr('id')
        document.getElementById(id).value
    })

    $(".tipoDoc").change(function(){
        if(confirm('Se cambio el tipo de documento y afectara a las estadisticas, esta de acuerdo?')){
            var uuid = $(this).attr('uuid')
            var tipo = $(this).val()
            $.ajax({
                url:'index.coi.php',
                type:'post',
                dataType:'json',
                data:{tipoDoc:1, uuid, tipo},
                success:function(){
                    alert(data.mensaje)
                }, 
                error:function(){
                    alert('Ocurrio un error inesperado, favor de revisar la informacion o solicitar soporte.')
                }
            })
        }else{
            return false
        }

    })

    function cargaBatch(mes, anio, ide, doc){
        $.confirm({
            columnClass: 'col-md-8',
            title: 'Carga Archivo Excel para Batch DIOT',
            content: 'Favor de seleccionar un archivo de excel (xls o xlsx)' + 
            '<form action="xls_diot.php" method="post" enctype="multipart/form-data" class="formdiot">' +
            '<div class="form-group">'+
            '<br/>Archivo: <input type="file" name="fileToUpload" class="xls" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> <br/>'+
            '<br/><font color ="red">Generar Archivo desde el sistema? </font> <input type="text" placeholder="Si o No" size="5" class="op1" name="x" value=""> '+
            '<br/><a href="app/tmp/Layout_DIOT.xlsx" download>Layout</a>'+
            '<br/>"Se genera un archivo con el formato de la DIOT carga Batch apartir de los datos que existen en el sistema"' +
            '<input type="hidden" name ="mes" value="'+mes+'" > '+ 
            '<input type="hidden" name ="anio" value="'+anio+'" > '+ 
            '<input type="hidden" name ="ide" value="'+ide+'" > '+ 
            '<input type="hidden" name ="doc" value="'+doc+'" > '+ 
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Cargar Archivo de Excel',
                btnClass: 'btn-blue',
                action: function () {
                    var archivo = this.$content.find('.xls').val();
                    var form = this.$content.find('.formdiot')
                    var op1= this.$content.find('.op1').val();
                    if(op1 == 'Si'){
                        //alert('Se genera el archivo desde el sistema, colocamos un ajax aqui...')
                        $.ajax({
                            url:'index.xml.php',
                            type:'post',
                            dataType:'json',
                            data:{generaDiot:1, mes, anio},
                            success:function(data){
                                window.open('app/tmp/Layout_DIOT.xlsx', 'download')
                            },  
                            error:function(){
                                alert('ocurrio un error al procesar la informacion.')
                            }

                        })
                    }else{
                        if(archivo==''){
                            $.alert('Debe de seleccionar un archivo...');
                            return false;
                        }else{
                            form.submit()
                        }    
                    }
                }
            },
            cancelar: function () {
            },
        },
    });
    }

    function cargaParam(){
        $.confirm({
            columnClass: 'col-md-8',
            title: 'Carga de parametros',
            content: 'Favor de seleccionar un archivo' + 
            '<form action="upload_param.php" method="post" enctype="multipart/form-data" class="upl">' +
            '<div class="form-group">'+
            '<br/>Archivo: <input type="file" name="fileToUpload" class="cl" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> <br/>'+
            '<br/><font color ="red">Reemplazar las cuentas existentes? </font> <input type="text" placeholder="Si o No" size="5" class="remp" name="x" value=""> '+
            '<input type="hidden" name="eje" value="'+<?php echo substr($anio,2)?>+'">'+
            '<br/><label>"Si existe una cuenta en los parametros ya establecidos se reemplazar con la cuenta del archivo en excel"</label>' +
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Cargar Archivo',
                btnClass: 'btn-blue',
                action: function () {
                    var cliente = this.$content.find('.cl').val();
                    var form = this.$content.find('.upl')
                    var rem= this.$content.find('.remp').val();
                    if(cliente==''){
                        $.alert('Debe de seleccionar un archivo...');
                        return false;
                    }else if(rem != 'Si' && rem !='No'){
                        $.alert('Dede de colocar "Si" para el reemplazo o "No" para el no reemplazo')
                        return false;
                    }else{
                        form.submit()
                    }
                }
            },
            cancelar: function () {
            },
        },
        //onContentReady: function () {
        //    // bind to events
        //    var jc = this;
        //    //alert(jc);
        //    this.$content.find('form').on('submit', function (e) {
        //        // if the user submits the form by pressing enter in the field.
        //        e.preventDefault();
        //        jc.$$formSubmit.trigger('click'); // reference the button and click it
        //    });
        //}
    });
    }

    function excel(mes, anio, ide, doc, t){
        if(mes==0 & t=='c'){
            $.alert('Este proceso solo se puede realizar por periodo y no de forma anual.')
            return
        }
        if(t == 'c' ){
            var con = 'Se han cosolidado las polizas de COI correctamente'
            var tit = 'Consolidacion de polizas COI vs sat2app'
        }else if (t == 'x' || t == 'xp' || t == 'z'){
            var con = 'Su archivo esta listo =) <br/>Revise su archivo en la carpeta de "Descargas"'
            var tit = 'Descarga de archivo en Excel (XLSX).'
        }
        //$.alert('El proceso busca las polizas en COI, si no la encuentra libera el XML para ser registrado nuevamente')
        $.confirm({
                buttons:{
                        ok:{
                            text:'ok',
                            action: function (){
                            return;
                            }
                        }
                },
            content:function(){
                var self = this;
                self.setContent(con);
                return  $.ajax({
                            url:'index.pago.php',
                            type:'post',
                            dataType:'json',
                            data:{xmlExcel:1, mes, anio, ide, doc, t}
                            }).done(function(data){
                                if(data.status=='ok'){
                                    window.open("/edoCtaXLS/"+data.archivo, 'download' );
                                    //document.getElementById("descarga").innerHTML='<a href="/edoCtaXLS/Documentos 24.xlsx" download>Descargar</a>'
                                }
                                if(data.status == 'C' && data.mensaje == 'a'){
                                    alert('Las polizas coinciden con COI')
                                }else if(data.status == 'C' && data.mensaje != 'a'){
                                    alert(data.mensaje + ' favor de actualizar la pantalla')
                                }
                            }).fail(function(){
                                self.setContentAppend('Ocurrio algo inesperado, favor de reportar a sistemas... al numero 55-5055-3392')
                                window.open("/edoCtaXLS/"+data.archivo, 'download' );
                            }).always(function(){
                                self.setTitle(tit);
                                
                                //self.setContentAppend(a)
                            })
                        }
        })
    }

    function pAuto(mes, anio, ide, doc, t){
        $.confirm({
            content: function () {
                var self = this;
                return $.ajax({
                    url: 'index.xml.php',
                    dataType: 'json',
                    method: 'post',
                    data:{xmlExcel:1, mes, anio, ide, doc, t}
                }).done(function (response) {
                    self.setContent('Description: ' + response.mensaje);
                    self.setContentAppend('<br>Status: ' + response.status);
                    self.setTitle('Creacion de polizas de forma Autimaticas.');
                }).fail(function(){
                    self.setTitle('Procesamiento de polizas Automaticas');
                    self.setContent('Se ha procesado la informacion y se envio un correo con el resultado.');
                });
            }
        });
        $.alert("El procesa tardara de 1 a 5 minutos, dependiendo el total de documentos a analizar, le suplicamos sea paciente... :)")
    }

    function marcar(ln, t){
        var renglon = document.getElementById("ln_"+ln)
        var chek = document.getElementById(ln)
        var color = chek.getAttribute("color")
        if(t == 'c'){
            renglon.style.background="#F08080";         
        }else if(chek.checked){
            renglon.style.background="#F08080";         
        }else{
            renglon.style.background=color;
        }
    }

    function pAcomodo(mes, anio, ide, doc, t){
        if(confirm("Desea Reacomodar las polizas del periodo " + mes + " ejercicio " + anio)){
            $.ajax({
                url:'index.coi.php',
                type:'post',
                dataType:'json',
                data:{acmd:1, mes, anio},
                success:function(data){
                    alert("Listo se acomodaron las polizas, favor de revisar los cambios")
                },
                error:function(){

                }
            })
        }else{
            return
        }
    }

    $(".imp").click(function(){
        var x = $(this).val()
        if(x == 'no'){
            $(".impDet").hide()
        }else{
            $(".impDet").show()
        }
    })

    $(".cargaSAE").click(function(){
        var doc = $(this).attr('doc')
        var serie = $(this).attr('serie')
        var folio = $(this).attr('folio')
        var uuid = $(this).attr('uuid')
        var ruta = $(this).attr('ruta')
        var rfcr = $(this).attr('rfcr')
        var ln = $(this).attr('ln')
        var tipo = $(this).attr('tipo')
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{cargaSae:1, doc, serie, folio, uuid, ruta, rfcr, tipo},
            success:function(data){
                if(data.status == 'ok'){
                   marcar(ln, 'c')
                }
            },
            error:function(){
                alert('No se inserto :(')
            }
        })
    })

    function info(){
        $.alert('No se encontro la conexion a la BD de COI, favor de comunicarse con Soporte Tecnico al 55-5055-3392')
    }

    $(".rfg").click(function(){
        alert("Relaciona las facturas de gastos a facturas de ventas para un calculo de utilidad")
        window.open('index.xml.php?action=gxf&m='+$(this).attr('mes')+'&a='+$(this).attr('anio')+'&i='+$(this).attr('ide')+'&d='+$(this).attr('doc') , "_blank")
    })



</script>