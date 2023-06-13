<br /><br />
<!--
<style type="text/css">
    td.details-control {
        background: url('app/views/images/cuadre.jpg') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('app/views/images/cuadre.jpg') no-repeat center center;
    }
</style>
-->
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           <font size="5px"> Notas de venta </font>
                           <br/>
                           Semana <input type="radio" name="p1" class="temp" value="s" <?php echo $p == 's'? 'checked':''?>> &nbsp;&nbsp;
                           Mes <input type="radio" name="p1" class="temp" value="m" <?php echo $p == 'm'? 'checked':''?> > &nbsp;&nbsp;
                           Año <input type="radio" name="p1" class="temp" value="a" <?php echo $p == 'a'? 'checked':''?> > &nbsp;&nbsp;
                           Todas <input type="radio" name="p1" class="temp" value="t"  <?php echo $p == 't'? 'checked':''?>> &nbsp;&nbsp;
                           Del &nbsp;&nbsp;<font color ="black"><input type="date" name="fi" id="fi" value="01.01.1990"></font> &nbsp;&nbsp; al &nbsp;&nbsp;<font color ="black"><input type="date" name="ff" value="01.01.1990" id="ff"></font>&nbsp;&nbsp;<label class="ir">Ir</label>
                           <label class="leeLog">Lee Log</label>
                        </div>
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-nv">
                                    <thead>
                                        <tr>
                                            <th> S </th>
                                            <th> F </th>
                                            <th> Nota  </th>
                                            <th> Cliente </th>
                                            <th> Fecha Doc<br/><font color="blue">Fecha Elab</font> <br/> Nota Manual</th>
                                            <th> Status </th>
                                            <th> Productos <br/> Partidas </th>
                                            <th> Piezas </th>
                                            <th> Subtotal </th>
                                            <th> IVA </th>
                                            <th> IEPS </th>
                                            <th> Descuentos </th>
                                            <th> Total </th>
                                            <th> Saldo </th>
                                            <th> Forma de Pago </th>
                                            <th> Factura </th>
                                            <th> Vendedor </th><
                                            <th> Impresion </th>

                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($info as $i):
                                            $status='';
                                            switch($i->STATUS){
                                                case 'P':
                                                    $status = 'Pendiente';
                                                    break;
                                                case 'F':
                                                    $status = 'Facturado';
                                                    break;
                                                case 'R':
                                                    $status = 'Facturado Parcial';
                                                    break;
                                                case 'C':
                                                    $status = 'Cancelada';
                                                    break;
                                                default:
                                                    $status= '';
                                                    break;
                                            }
                                        ?>
                                       <tr>
                                            <td WIDTH="1"><?php echo $i->SERIE?></td>
                                            <td WIDTH="1"><?php echo $i->FOLIO?></td>
                                            <td WIDTH="3" class="details-control" ><a class="detalles" nv="<?php echo $i->DOCUMENTO?>"><?php echo $i->DOCUMENTO?></a> <br/> <a class="copiar" doc="<?php echo $i->DOCUMENTO?>"><font color="blue">copiar</font></a></td>

                                            <td ><?php echo '('.$i->CLIENTE.') '?>

                                            <a href="index.cobranza.php?action=edoCliente&cliente=<?php echo $i->CLIENTE?>&tipo=c&nombre=<?php echo $i->NOMBRE?>&maestro=''" target='popup' onclick='window.open(this.href, this.target, "width=1200, height=800"); return false;'><?php echo $i->NOMBRE;?></a>
                                            <br/><button class="glyphicon glyphicon-pencil infoCte" cte="<?php echo $i->CLIENTE?>"></button>
                                            </td>
                                            
                                            <td><?php echo $i->FECHA_DOC?><br/><font color="blue"><?php echo $i->FECHAELAB?></font></td>
                                            <td WIDTH="3"><?php echo $status?></td>
                                            <td align="center" WIDTH="3"><?php echo $i->PROD?></td>
                                            <td align="center" WIDTH="3"><?php echo $i->PIEZAS?> </td>
                                            <td align="right"><?php echo '$ '.number_format($i->SUBTOTAL,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->IVA,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->IEPS,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->DESC1,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->TOTAL,2)?></td>
                                            <td align="right"><?php echo '$ '.number_format($i->SALDO_FINAL,2)?></td>
                                            <td align="center"><?php echo $i->FP?></td>
                                            <td align="center"><?php if(empty($i->METODO_PAGO)){?>
                                                <?php }else{?>
                                                    <a href="index.cobranza.php?action=envFac&docf=<?php echo $i->METODO_PAGO?>" onclick="window.open(this.href, this.target, 'width=1000, height=800'); return false;"> <font color="green"><b><?php echo $i->METODO_PAGO?></b></font></a>

                                                    <br/>
                                                    <?php if(isset($i->F_UUID)){?>
                                                        <a href="/Facturas/facturaPegaso/<?php echo $i->METODO_PAGO.'.xml'?>" download>  <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>
                                                        <a href="index.php?action=imprimeFact&factura=<?php echo $i->METODO_PAGO?>" onclick="alert('Se ha descargado tu factura.')"><img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a>
                                                        <br/>
                                                        
                                                    <?php }else{?>
                                                        <a onclick="timbrar('<?php echo $i->METODO_PAGO?>')" >Timbrar</a>
                                                    <?php }?>
                                                <?php }?>
                                                
                                            </td>
                                            <td><?php echo $i->USUARIO?></td>
                                            <td><input type="button" name="" value="Imprimir N.V." class="btn-sm  btn-primary print" nv="<?php echo $i->DOCUMENTO?>"></td>
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

    var p = '';
    
    $(".genCep").click(function(){
        let doc = $(this).attr('factura')

        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{buscaCep:1},
            success:function(){

            },
            error:function(){
                
            }
        })
        $.confirm({
            title: 'Generar Comprobante de Pago',
            columnClass: 'col-md-6',
            content: '¿Seguro que deseas generar el Comprobante de pago de la factura '+ doc + ' ? <br/>' +
            '<br/> <label> Banco Origen:&nbsp;&nbsp;&nbsp;</label> <input type="text" class="bancoO" oninput="this.value = this.value.toUpperCase()" >' +
            '<br/> <label> Cuenta Origen:&nbsp;&nbsp; <input type="text" placeholder="Deben ser 10 o 13 caracteres" class="cuentaO" >' +
            '<br/> <label> Banco Destino:&nbsp;&nbsp; <input type="text" class="bancoD" oninput="this.value = this.value.toUpperCase()">' +
            '<br/> <label> Cuenta Destino:&nbsp; <input type="text" placeholder="Deben ser 10 o 13 caracteres" class="cuentaD">' +
            '<br/> <label> Fecha Deposito:&nbsp; <input type="date" class="fecha" >' +
            '<br/> <label> Monto Deposito:&nbsp; <input type="text" class="monto">' +
            '<br/> <label> Tipo pago:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select class="tipo">'+
            '<option value="sel">Tipo de Pago</option>' +     
            '<option value="01">Efectivo</option>' +     
            '<option value="03">Transferencia</option>' +     
            '<option value="02">Cheque Nominativo</option>' +     
            '<option value="28">Tarjeta de Debito</option>' +     
            '<option value="04">Tarjeta de Credito</option>' +
            '<option value="99">Por Definir</option>' +     
            '</select>'    

            ,
            buttons: {
                Si: function () {
                    let bancoO = this.$content.find('.bancoO').val();
                    let cuentaO = this.$content.find('.cuentaO').val();
                    let bancoD = this.$content.find('.bancoD').val();
                    let cuentaD = this.$content.find('.cuentaD').val();
                    let fecha = this.$content.find('.fecha').val();
                    let monto = this.$content.find('.monto').val();
                    let tipo = this.$content.find('.tipo').val();
                    
                    /*if (cuentaO.length == 10 || cuentaO.length == 13){   
                    }else{
                        $.alert('La longitud de la cuenta origen debe de ser de 10 o 13 numeros')
                        return false 
                    }
                    if (cuentaD.length == 10 || cuentaD.length == 13){
                    }else{
                        $.alert('La longitud de la cuenta destino debe de ser de 10 o 13 numeros')
                        return false 
                    }*/
                    if(isNaN(monto)){
                       $.alert('Debe ingresar un monto correcto')
                       return false 
                    }
                    if(isNaN(cuentaO)){
                       $.alert('Favor de revisar la cuenta origen, solo se admiten numeros')
                       return false  
                    }
                    if(isNaN(cuentaD)){
                       $.alert('Favor de revisar la cuenta destino, solo se admiten numeros')
                       return false  
                    }
                    if(tipo == 'sel'){
                       $.alert('Tipo de pago no valido.')
                       return false    
                    }
                    $.ajax({
                        type: "POST",
                        url: 'index.v.php',
                        dataType: "json",
                        data: {genCepNV:1, doc, bancoO, cuentaO, bancoD, cuentaD, fecha, monto, tipo },
                        beforeSend: function () {
                            var popup = $('#pop');
                            popup.css({
                                'position': 'absolute',
                                'left': ($(window).width() / 2 - $(popup).width() / 2) + 'px',
                                'top': ($(window).height() / 2 - $(popup).height() / 2) + 'px'
                            });
                            popup.show();
                        },
                        success: function (data)
                        {
                            $('#pop').hide();
                            if (data.status == "ok") {
                                $.alert(data.mensaje)
                                //window.open('index.v.php?action=nv2&doc='+data.NNV+'&idf=0', '_self')
                            } else {
                                //$.alert('Algo salió mal, favor de verificarlo con el administrador de sistema, código de error: ' + data.response);
                                //console.log("XML:"+data.status);
                            }
                        }
                    });
                },
                Cancelar: {
                }
            }
        })
    })

    $(".ir").click(function(){
        var fi = document.getElementById('fi').value
        var ff = document.getElementById('ff').value
        var p = $(".temp:checked").val()
        if(fi != ""){
            p = 'p'
        }
        window.open("index.v.php?action=verNV&p="+p+"&fi="+ fi + "&ff="+ff, "_self" )
    })

    $(".detalles").click(function(){
        var nv = $(this).attr('nv')
        //alert('Detalles de la Nota ' + nv)
        window.open("index.v.php?action=nv2&doc="+nv+"&idf=0", '_blank')
        //window.open("index.v.php?action=nv2&doc="+nv+"&idf=0", "_self")
    })

    $(".copiar").click(function(){
        var doc = $(this).attr('doc')
        $.confirm({
            title: 'Copia de Nota de Venta',
            content: '¿Seguro que deseas copiar la nota de venta '+ doc+ ' ?',
            buttons: {
                Si: function () {
                    $.ajax({
                        type: "POST",
                        url: 'index.v.php',
                        dataType: "json",
                        data: {copiaNV:1, doc},
                        success: function (data)
                        {
                            if (data.status == "ok") {
                                setTimeout(alert(data.Mensaje),4000)
                                location.reload(); 
                            } else {
                                $.alert('Algo salió mal, favor de verificarlo con el administrador de sistema, código de error: ' + data.response);
                                console.log("XML:"+data.status);
                            }
                        }
                    });
                },
                Cancelar: {
                }
            }
        });
    })

    function timbrar(doc){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{buscaDoc:doc},
            success:function(data){
                setTimeout(alert(data.mensaje),4000)
                location.reload()
            },
            error:function(data){

            }
        })
    }

    $(".print").click(function(){
        var nv = $(this).attr('nv')
        //$.alert("Nota de venta " + nv )
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{impNV:nv},
            success:function(data){
                if(data.status=='ok'){
                    window.open('/notas de venta/'+nv+'.pdf', 'download')
                }else{
                    $.alert('No se pudo generar la impresión.')
                }
            },
            error:function(){
                    $.alert('No se pudo generar la impresión.')
            }
        })
    })

    $(".infoCte").click(function(){
        var cte = $(this).attr('cte')
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{infoCte:cte}, 
            success:function(data){
                infoCte(data, cte)
            }
        })
    })

    function infoCte(data, cte){
        $.confirm({
            columnClass: 'col-md-8',
            title: '<b>Edicion de cliente</b> <br/><font color="blue">' + data.nombre + '</font>',
            content:'<b>Nombre</b>:<br/><input cte="'+cte+'"class="editCte" campo="nombre" value="'+data.nombre+'" size="100" maxlength="120"> '+
            '<br/><b>Calle</b>:<br/><input cte="'+cte+'"class="editCte" campo="calle" value="'+data.calle+'" size="100" maxlength="80"> '+
            '<br/><b>Ext</b>:<br/><input cte="'+cte+'"class="editCte" campo="numint" value="'+data.int+'" size="100" maxlength="80"> '+
            '<br/><b>Int</b>:<br/><input cte="'+cte+'"class="editCte" campo="numext" value="'+data.ext+'" size="100" maxlength="80"> '+
            '<br/><b>Colonia</b>:<br/><input cte="'+cte+'"class="editCte" campo="colonia" value="'+data.colonia+'" size="100" maxlength="50"> '+
            '<br/><b>Estado</b>:<br/><input cte="'+cte+'"class="editCte" campo="estado" value="'+data.estado+'" size="100" maxlength="50"> '+
            '<br/><b>RFC</b>:<br/><input cte="'+cte+'"class="editCte" campo="rfc" value="'+data.rfc+'" size="100" maxlength="13"> '+
            '<br/><b>CP</b>:<br/><input cte="'+cte+'"class="editCte" campo="codigo" value="'+data.cp+'" size="100" maxlength="5"> '+
            '<br/><b>Tel</b>:<br/><input cte="'+cte+'"class="editCte" campo="telefono" value="'+data.tel+'" size="100" maxlength="25">' +
            '<br/><b>CFDI 4</b>:<br/><input type="checkbox" cte="'+cte+'"class="editCte" campo="cfdi4" '+data.cfdi4+' id = "chkCfdi">' +

            //'<br/><b>Uso CFDI</b>:<br/><input cte="'+cte+'"class="editCte" campo="uso_cfdi" value="'+data.uso_cfdi+'" size="100" maxlength="25">' +
            '<br/><b>Uso CFDI</b>:<br/> <font color="red"><b> ' + data.uso_cfdi + '</b></font> '+
                '<br/><select cte="'+cte+'"class="editCte" campo="uso_cfdi">'+
                    '<option value="no" >Seleccionar un uso</option>'+
                    '<option value="G01" >G01 Adquisición de mercancías.</option>'+
                    '<option value="G02" >G02 Devoluciones, descuentos o bonificaciones.</option>'+
                    '<option value="G03" >G03 Gastos en general.</option>'+
                    '<option value="I01" >I01 Construcciones.</option>'+
                    '<option value="I02" >I02 Mobiliario y equipo de oficina por inversiones.</option>'+
                    '<option value="I03" >I03 Equipo de transporte.</option>'+
                    '<option value="I04" >I04 Equipo de computo y accesorios.</option>'+
                    '<option value="I05" >I05 Dados, troqueles, moldes, matrices y herramental.</option>'+
                    '<option value="I06" >I06 Comunicaciones telefónicas.</option>'+
                    '<option value="I07" >I07 Comunicaciones satelitales.</option>'+
                    '<option value="I08" >I08 Otra maquinaria y equipo.</option>'+
                    '<option value="D01" >D01 Honorarios médicos, dentales y gastos hospitalarios.</option>'+
                    '<option value="D02" >D02 Gastos médicos por incapacidad o discapacidad.</option>'+
                    '<option value="D03" >D03 Gastos funerales.</option>'+
                    '<option value="D04" >D04 Donativos.</option>'+
                    '<option value="D05" >D05 Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).</option>'+
                    '<option value="D06" >D06 Aportaciones voluntarias al SAR.</option>'+
                    '<option value="D07" >D07 Primas por seguros de gastos médicos.</option>'+
                    '<option value="D08" >D08 Gastos de transportación escolar obligatoria.</option>'+
                    '<option value="D09" >D09 Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.</option>'+
                    '<option value="D10" >D10 Pagos por servicios educativos (colegiaturas).</option>'+
                    '<option value="S01" >S01 Sin efectos fiscales.  </option>'+
                    '<option value="CP01" >CP01 Pagos</option>'+
                    '<option value="CN01" >CN01 Nómina</option>'+
                '</select>'+
            '<br/><b>Regimen </b>: <font color="red"><b>'+ data.regimen +'</b></font> '+
                '<br/><select cte="'+cte+'"class="editCte" campo="sat_regimen">' +
                    '<option value="no" >Seleccionar</option>'+
                    '<option value="601" >601 General de Ley Personas Morales</option>'+
                    '<option value="603" >603 Personas Morales con Fines no Lucrativos</option>'+
                    '<option value="605" >605 Sueldos y Salarios e Ingresos Asimilados a Salarios</option>'+
                    '<option value="606" >606 Arrendamiento</option>'+
                    '<option value="607" >607 Régimen de Enajenación o Adquisición de Bienes</option>'+
                    '<option value="608" >608 Demás ingresos</option>'+
                    '<option value="610" >610 Residentes en el Extranjero sin Establecimiento Permanente en México</option>'+
                    '<option value="611" >611 Ingresos por Dividendos (socios y accionistas)</option>'+
                    '<option value="612" >612 Personas Físicas con Actividades Empresariales y Profesionales</option>'+
                    '<option value="614" >614 Ingresos por intereses</option>'+
                    '<option value="615" >615 Régimen de los ingresos por obtención de premios</option>'+
                    '<option value="616" >616 Sin obligaciones fiscales</option>'+
                    '<option value="620" >620 Sociedades Cooperativas de Producción que optan por diferir sus ingresos</option>'+
                    '<option value="621" >621 Incorporación Fiscal</option>'+
                    '<option value="622" >622 Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras</option>'+
                    '<option value="623" >623 Opcional para Grupos de Sociedades</option>'+
                    '<option value="624" >624 Coordinados</option>'+
                    '<option value="625" >625 Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>'+
                    '<option value="626" >626 Régimen Simplificado de Confianza</option>'+
                '</select>'
            ,
            buttons:{
                cerrar:{
                    text:'Cerrar',
                    btnClass:'btn-blue',
                    
                }
            }
        })
    }

    $("body").on("change", ".editCte", function(e){
        e.preventDefault();
        var cte = $(this).attr('cte')
        var campo = $(this).attr('campo')
        var val = $(this).val()
        if(campo == 'cfdi4'){if($('#chkCfdi').prop('checked') ) {val = 1}else{val = 0}}
        if(campo == 'uso_cfdi' && val == 'no'){$.alert('Seleccione una opcion valida.');return false;}
        $.ajax({
            url:'index.v.php',
            type:'post', 
            dataType:'json',
            data:{editCte:cte, campo, val}, 
            success:function(data){

            }
        })
    })

    $(".leeLog").click(function(){
        $.ajax({
            url:'index.v.php',
            type:'post',
            dataType:'json',
            data:{leeLog:1},
            success:function(data){
                $.alert('Se leyo el archivo de logs')
            }
        })
    })
    
</script>