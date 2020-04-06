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
                        <p>Ver impuestos &nbsp;&nbsp;Si: <input type="radio" name="verImp" id="verImp" class="imp" value="si"> &nbsp;&nbsp;No: <input type="radio" name="verImp" id="NoverImp" class="imp" value="no">&nbsp;&nbsp;&nbsp;&nbsp; <font color="blue"><input type="button" ide="<?php echo $ide?>" value="Descargar a Excel" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>','x')"></font>
                            <font color="blue"><input type="button" ide="<?php echo $ide?>" value="Descarga Partidas a Excel" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>','xp')"></font>
                            <?php if($cnxcoi=='si'){?>
                            <font color="black"><input type="button" value="Consolidar Polizas" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'c')"></font>
                            <font color="red"><input type="button"  value="Revision Contabilizacion" onclick="excel(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'z')"></font>
                            <font color="green"><input type="button"  value="Polizas Automaticas" onclick="pAuto(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'pa')"></font>
                            <font color="#DC143C"><input type="button"  value="Acomodar Pólizas" onclick="pAcomodo(<?php echo $mes?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>', 'pa')"></font>
                            <font color="#1a8cff"><input type="button"  value="Carga Parametros" onclick="cargaParam()"></font>
                            <font color="red"><input type="button" value="Diot Batch" onclick="cargaBatch(<?php echo $mes ?>, <?php echo $anio?>, '<?php echo $ide?>', '<?php echo $doc?>')"> </font>
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
                                            <th>Sta</th>
                                            <th>UUID</th>
                                            <th>TIPO</th>
                                            <th>FOLIO</th>
                                            <th>FECHA</th>
                                            <th>RFC RECEPTOR</th>
                                            <th class="impDet">RFC EMISOR</th>
                                            <th>SUBTOTAL</th>
                                            <th class="impDet">IVA</th>
                                            <th class="impDet">RETENCION <br/>IVA</th>
                                            <th class="impDet">IEPS</th>
                                            <th class="impDet">RETENCION <br/>IEPS</th>
                                            <th class="impDet">RETENCION ISR</th>
                                            <th>DESCUENTO</th>
                                            <th>TOTAL <br/> <font color="blue">SALDO</font></th>
                                            <th>MON</th>
                                            <th>TC</th>
                                            <th>CLASIFICAR</th>
                                            <th>DESCARGA</th>                                            
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
                                            <td><?php echo $test.'<br/><font color="blue">'.$key->POLIZA.'</font>'?></td>
                                            <td <?php echo ($key->CEPA!='')? 'title="Ver el CEP"':'' ?>>
                                                <a href="index.coi.php?action=verPolizas&uuid=<?php echo $key->UUID ?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=1320'); return false"> <?php echo $key->UUID ?></a> <br/> <font color="purple" face="verdana"><b>
                                                    <?php if(strpos($key->CEPA,",")){
                                                        $val = explode(",", $key->CEPA);
                                                        for ($i=0; $i <count($val) ; $i++) { 
                                                            $cep = explode("|",$val[$i]);
                                                            echo '<a href="index.xml.php?action=verCEP&cep='.$val[$i].'" target="_blank">'.$cep[0].' <font color="red"> $ '.number_format($cep[1],2).'</font></a><br/>';
                                                        }
                                                    }else{
                                                        if(!empty($key->CEPA)){
                                                        $cep = explode("|",$key->CEPA);
                                                        echo '<a href="index.xml.php?action=verCEP&cep='.$key->CEPA.'" target="_blank">'.$cep[0].' <font color="red"> $ '.number_format($cep[1],2).'</font></a><br/>';
                                                        }
                                                    }
                                                    ?>
                                                </b></font> </td>
                                            <td><?php echo $tipo?><br/><font color='blue'><?php echo $key->METODOPAGO.'<br/>'.$key->FORMAPAGO.'<br/>'.$key->USO?></font></td>
                                            <td title="01--> Nota de crédito de los documentos relacionados&#10;02 --> Nota de débito de los documentos relacionados&#10;03 --> Devolución de mercancía sobre facturas o traslados previos&#10;04 --> Sustitución de los CFDI previos&#10;05 --> Traslados de mercancias facturados previamente&#10;06 --> Factura generada por los traslados previos&#10;07 --> CFDI por aplicación de anticipo "><?php echo $key->SERIE.$key->FOLIO?><br/>
                                                <?php if(!empty($key->RELACIONES)){?>
                                                <a href="index.xml.php?action=verRelacion&uuid=<?php echo $key->UUID?>" target="_blank"><font color="blue">
                                                <b><?php
                                                        $rel=explode(",",$key->RELACIONES);
                                                        //echo '<br/> Valor de rel: '.count($rel).'<br/>'; 
                                                        for($i=0; $i < count($rel); $i++){
                                                            //echo '<br/>'.var_dump($rel).'<br/>';
                                                            //echo $i.'<br/>'; 
                                                            $rl=explode("|", $rel[$i]);
                                                            //echo '<br/>'.var_dump($rl);
                                                            echo '<br/>'.$rl[1].'-->'.$rl[2].'<font color="red"> $ '.number_format($rl[3],2).'</font>';
                                                        }
                                                    ?>   
                                                </b>
                                                </font>
                                                </a>
                                               <?php } ?>
                                            </td>
                                            <td><?php echo $key->FECHA;?> </td>
                                            <td><?php echo '('.$key->CLIENTE.')  <br/><b>'.($key->NOMBRE).'<b/>';?></td>
                                            <td class="impDet"><?php echo '('.$key->RFCE.')  <br/><b>'.$key->EMISOR.'<b/>'?></td>
                                            <td><?php echo '$ '.number_format($key->SUBTOTAL,2);?></td>
                                            <td class="impDet"><?php echo '$ '.number_format($key->IVA,2);?></td>
                                            <td class="impDet"><?php echo '$ '.number_format($key->IVA_RET,2);?></td>
                                            <td class="impDet"><?php echo '$ '.number_format($key->IEPS,2);?></td>
                                            <td class="impDet"><?php echo '$ '.number_format($key->IEPS_RET,2);?></td>
                                            <td class="impDet"><?php echo '$ '.number_format($key->ISR_RET,2);?></td>
                                            <td><?php echo '$ '.number_format($key->DESCUENTO,2);?></td>
                                            <td><?php echo '$ '.number_format($key->IMPORTEXML,2);?> <br/>
                                            <font color="blue"><?php echo '$ '.number_format($key->SALDO_XML,2)?></font> </td>
                                            <td><?php echo '<b>'.$key->MONEDA.'<b/>';?> </td>
                                            <td><?php echo '$ '.number_format($key->TIPOCAMBIO,2);?> </td>
                                            <td align="center" title="" id="ia_<?php echo $ln?>" class="infoAdicional" >
                                                <a href="index.php?action=verXML&uuid=<?php echo $key->UUID?>&ide=<?php echo $ide?>&anio=<?php echo substr($anio,2)?>" class="btn btn-info" target="popup" onclick="marcar(<?php echo $ln?>, 'c'); window.open(this.href, this.target, 'width=1800,height=1320'); return false;"> Clasificar </a>
                                                <center><input type="checkbox" name="revision" id="<?php echo $ln?>" value="<?php echo $ln?>" color="<?php echo $color2?>" onclick="marcar(this.value, 'cb')" ></center>
                                                <br/>
                                                <?php if($ide == 'Recibidos'){?>
                                                    <select name="tipo" class="tipoDoc" uuid="<?php echo $key->UUID?>" >
                                                        <?php if($key->ID_RELACION > 0){?>
                                                            <option value="<?php echo $key->ID_RELACION?>"><?php echo $key->TIPO_DOC?></option>
                                                        <?php }else{?>
                                                            <option value="">¿Tipo?</option>
                                                        <?php }?>
                                                        <?php foreach($tipoDOC as $tdoc ):?>
                                                            <?php if($tdoc->ID_TIPO >= 2000 AND $tdoc->ID_TIPO< 3000 ){ ?>
                                                            <option><?php echo $tdoc->DESCRIPCION?></option>
                                                            <?php }?>   
                                                        <?php endforeach;?>
                                                    </select>
                                                <?php }else{?>
                                                    <select name="tipo" class="tipoDoc" uuid="<?php echo $key->UUID?>">
                                                        <?php if($key->ID_RELACION > 0){?>
                                                            <option value="<?php echo $key->ID_RELACION?>"><?php echo $key->TIPO_DOC?></option>
                                                        <?php }else{?>
                                                            <option value="">¿Tipo?</option>
                                                        <?php }?>
                                                        <?php foreach($tipoDOC as $tdoc ):?>
                                                            <?php if($tdoc->ID_TIPO >= 0 AND $tdoc->ID_TIPO < 2000 ){?>
                                                                <option value="<?php echo $tdoc->ID_TIPO?>"><?php echo $tdoc->DESCRIPCION?></option>
                                                            <?php }?>   
                                                        <?php endforeach;?>
                                                    </select>
                                                <?php }?>
                                            </td>
                                            <form action="index.php" method="POST">
                                                    <input type="hidden" name="factura" value="<?php echo $key->SERIE.$key->FOLIO?>">
                                                <td>
                                                    <?php if($ide == 'Recibidos'){?>
                                                        <a href="/uploads/xml/<?php echo $rfcEmpresa.'/'.$ide.'/'.$key->RFCE.'/'.$key->RFCE.'-'.$key->SERIE.$key->FOLIO.'-'.$key->UUID.'.xml'?>" 
                                                        download="<?php echo $key->RFCE.'-'.substr($key->FECHA, 0, 10).'-'.number_format($key->IMPORTE,2).'-'.$key->UUID.'.xml'?>">  
                                                        <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>

                                                    <?php }else{?>
                                                        <a href="/uploads/xml/<?php echo $rfcEmpresa.'/'.$ide.'/'.$key->CLIENTE.'/'.$key->RFCE.'-'.$key->SERIE.$key->FOLIO.'-'.$key->UUID.'.xml'?>" 
                                                            download="<?php echo $key->RFCE.'-'.substr($key->FECHA, 0, 10).'-'.number_format($key->IMPORTE,2).'-'.$key->UUID.'.xml'?>">  
                                                        <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>
                                                    <?php }?>
                                                    &nbsp;&nbsp;
                                                    <a href="index.php?action=imprimeUUID&uuid=<?php echo $key->UUID?>" onclick="alert('Se ha descargar tu factura, revisa en tu directorio de descargas')"><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a>
                                                
                                                <?php if($_SESSION['rfc']== 'IMI161007SY7'){?>
                                                    <input type="button" value="" class="btn-sm btn-info cargaSAE" doc="<?php echo $key->SERIE.$key->FOLIO?>" ruta="/uploads/xml/<?php echo $rfcEmpresa.'/'.$ide.'/'.$key->CLIENTE.'/'.$key->RFCE.'-'.$key->SERIE.$key->FOLIO.'-'.$key->UUID.'.xml'?>" serie="<?php echo $key->SERIE?>" folio ="<?php echo $key->FOLIO?>" uuid="<?php echo $key->UUID?>" rfcr="<?php echo $key->CLIENTE?>" ln="<?php echo $ln?>" tipo="<?php echo $doc?>">
                                                <?php }?>
                                                </td>
                                            </form>
                                        </tr>
                                        </form>
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
            '<br/>"Si existe una cuenta en los parametros ya establecidos se reemplazar con la cuenta del archivo en excel"' +
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
        //$.alert('El proceso busca las polizas en COI, si no la encuentra libera el XML para ser registrado nuevamente')
        $.ajax({
            url:'index.xml.php',
            type:'post',
            dataType:'json',
            data:{xmlExcel:1, mes, anio, ide, doc, t},
            success:function(data){
                if(data.status=='ok'){
                    window.open("/edoCtaXLS/"+data.archivo, 'download' );
                    //document.getElementById("descarga").innerHTML='<a href="/edoCtaXLS/Documentos 24.xlsx" download>Descargar</a>'
                }
                if(data.status == 'C' && data.mensaje == 'a'){
                    alert('Las polizas coinciden con COI')
                }else if(data.status == 'C' && data.mensaje != 'a'){
                    alert(data.mensaje + ' favor de actualizar la pantalla')
                }
            }, 
            error:function(){
                window.open("/edoCtaXLS/"+data.archivo, 'download' );
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
                    self.setTitle('Hola');
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



</script>