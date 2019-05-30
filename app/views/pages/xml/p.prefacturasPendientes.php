<br /><br />

<p>Cargar Json</p>
<form action = "uploadJson.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="hidden" name="caja" value="00">
    <input type="submit" value="Subir Pedido" name="submit" >
</form>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Cajas.
                        </div>
                        <!-- /.panel-heading -->
                           <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-cajas">
                                    <thead>
                                        <tr>
                                            <!--<th>Todos: <input type="checkbox" name="marcarTodo" id="marcarTodo" /></th>-->
                                            <th>Unir</th>
                                            <th>Caja<br/>Remision<br/>Fatcura</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>CP</th> 
                                            <th>Fecha Pedido</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Fecha Apertura Caja</th>
                                            <th>Embalaje Completo?<br/>Status Log</th>
                                            <th>Imprimir PreFactura</th>
                                            <th>Facturar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        $total= 0 ;
                                        $i = 0;
                                        foreach ($prefacturas as $data): 
                                            $color='';
                                            if($data->VALIDACION == 0){
                                                $color="style='background-color:#e6ffe6'";
                                            }else{
                                                $color="style='background-color:#ffebe6'";
                                            }
                                            if($data->CANCELADAS != '0'){
                                                $color="style='background-color:#3399ff'";
                                            }

                                            if($data->DET == 1){
                                                $color="style='background-color:#e600ac'";
                                            }

                                            $total+=$data->IMPORTEPREFACT;
                                            $i++;
                                            $masAntiguo=strtotime($data->FECHA_CREACION);
                                            if($masAntiguo < strtotime($data->FECHA_CREACION)){
                                                $masAntiguo = $data->FECHA_CREACION;
                                            }
                                        ?>
                                       <tr <?php echo $color?> class="titulo" linea="<?php echo($i)?>" id="l_<?php echo $i?>" caja="<?php echo $data->ID?>" >
                                            <input type="hidden" id="det_<?php echo $data->ID?>" value="<?php echo $data->DET?>">
                                            <td><input type="checkbox" name="docs" docu="<?php echo $data->ID?>" class="ja" onchange="revisaCliente(this.value,'<?php echo $data->CVE_MAESTRO?>')" value="<?php echo $data->ID?>" m="<?php echo $data->CVE_MAESTRO?>" id="unidad_<?php echo $data->ID?>">
                                             <input type="hidden" name="maestro" id="m_<?php echo $data->ID?>" value="<?php echo $data->CVE_MAESTRO?>">
                                             <input type="hidden" id="canceladas_<?php echo $data->ID?>" value="<?php echo $data->CANCELADAS?>">
                                            </td>
                                            <td>
                                                <a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->ID;?></a>
                                                <br/><?php echo $data->REMISION?>
                                                <br/><?php echo $data->FACTURA?>
                                                <br/><font color='white'><b><?php echo ($data->CANCELADAS == '0')? '':$data->CANCELADAS?></b></font>
                                              
                                            </td>

                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE.'<br/>'.$data->CVE_MAESTRO;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td align="right"><?php echo '$ '.number_format($data->IMPORTEPREFACT,2);?></td>
											<td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td><?php echo $data->FECHA_CREACION;?></td>
                                            <td><?php echo ($data->EMBALAJE == 'TOTAL')? 'Si':'No';?><br/><n><?php echo strtoupper($data->STATUS_LOG)?><n/></td>
                                            <td>
                                            <input type="button" name="preFactura" value="Imprimir Pre Factura" class="btn-success" onclick="impPreFact(<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>')">
                                            </td>
                                            <td>
                                                <input type="hidden" value="Facturar" onclick="facturarCaja(<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>', <?php echo $data->VALIDACION?>)" id="caja_<?php echo $data->ID?>">
                                                <label id="boton_<?php echo $data->ID?>"><input type="button" class="btn-info" onclick="test('<?php echo $data->NOMBRE?>', <?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>', <?php echo $data->VALIDACION?>)" value="Crear Factura"></label>
                                                <label id="prefact_<?php echo $data->ID?>"></label>
                                                <br/>
                                                <a href="index.v.php?action=verPartidas&caja=<?php echo $data->ID?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820' ); return false;"><b>Obs Partidas</b></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 <p><font color="blue" size="5pxs"><?php echo 'Total en Prefacturas: $ '.number_format($total,2)?></font></p>
                                 <p><font color="blue" size="5pxs"><?php echo 'Documentos '.$i.', Documento mas Antiguo: '.date('d/m/Y',$masAntiguo)?></font></p>
                                </table>
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
    
    $(".titulo").mouseover(function(){
        var i = $(this).attr("linea");
        //console.log(i);
        document.getElementById('l_'+i);
        var idc =$(this).attr("caja");
        $.ajax({
            url:"index.php",
            dataType:"json",
            method:"post",
            data:{ctrlParcial:1,idc:idc},
            success:function(data){

                $("#l_"+i).attr({
                    title: data.status
                });
            }
        });
    });

    function revisaCliente(id,m){
        $("input:checkbox:checked.ja").each(function() {
            var maestros =  $(this).attr("m");
            if(maestros != m ){
                alert('Solo se permiten unir documentos del mismo Maesto');
                document.getElementById('unidad_'+id).checked=false;
            }
        });
    }

    function facturarCaja(idcaja, docf, val, uso, tpago, mpago, rel, ocdet, entdet){
        if(val >0){
            alert('Faltan ' + val + ' Productos sin registro fiscal, los puede consultar en la prefactura, gracias');
        }else{
                console.debug(''+idcaja.length + '  -' +idcaja);
                if(idcaja.length == 5){
                    document.getElementById('caja_'+idcaja).classList.add('hide');    
                }else{
                    var idc=idcaja.substring(1);
                    var idcajas = idc.split(",");
                    for(var i=0; i >= idcajas.length; i++){
                        document.getElementById('caja_'+idcajas[i]).classList.add('hide'); 
                   }
                }
                $.ajax({
                    url:'index.php',
                    method:'POST',
                    dataType:'json',
                    data:{facturar:idcaja, uso:uso, tpago:tpago, mpago:mpago, rel:rel, ocdet, entdet},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert('Se ha creado la factura '+ data.factura + ', ' +data.razon);
                            var rfc = data.rfc; 
                            var factura=data.factura;
                            var fecha = data.fecha;
                            var archivo = rfc+'('+factura+')'+fecha;
                            document.getElementById("boton_"+idcaja).innerHTML="<a href='/Facturas/facturaPegaso/"+factura+".pdf' download> <img border='0' src='app/views/images/pdf.jpg' width='25' height='30'></a> <a href='/Facturas/facturaPegaso/"+factura+".xml' download> <img border='0' src='app/views/images/xml.jpg' width='25' height='30'></a>";
                            $.ajax({
                                url:'index.php',
                                method:'POST',
                                dataType:'json',
                                data:{cerrarcaja:1, idcaja:idcaja, docf:docf},
                            });
                        }else if(data.status == 'No'){
                            alert(data.razon);
                        }
                    }
                });
            }
    }
    
    function impPreFact(idc, docf ){
            document.getElementById('val').value=idc;
            document.getElementById('docf').value=docf;
            var cu = '';
            $("input:checkbox:checked.ja").each(function() {
                var cajas =  $(this).attr("docu");
                cu = cu + ',' + cajas;
            });
            if(cu.length > 0 ){
                alert('Estas seleccionadas las cajas ' + cu + ', se imprimiran esos valores, si desea solo imprimir el documento, deseleccione todos las cajas');
            } 
            document.getElementById('cu').value=cu;
            var form= document.getElementById('FORM_EXEC');
            form.submit();   
    }

    function test(cliente, idcaja, docf, val ){
        var relacion = document.getElementById("canceladas_"+idcaja).value;
        var det = document.getElementById("det_"+idcaja).value;
        var rela = '';
        if(relacion != '0'){
            rela = '<br/>Relacion 04: <input type="checkbox" name="rel" class="relac"> con la Factura '+ relacion;
        }
        var liverpool='si';
        var detallista='';
        if(det == 1){
            detallista = '<br/>Orden de Compra Detallista: <input type="text" name="oc" class="ocdet" required> <br/>' +
                         '<br/>Entrada Detallista:<input type="text" name="entrada" class="entdet" required>';
        }

        $.confirm({
            title: 'Datos Fiscales',
            columnClass: 'col-md-6',
            content: '¿Favor de colocar los datos fiscales para el cliente: ' + cliente + 
            '<form action="index.php" class="formName">' +
            '<div class="form-group">'+
            '<label>Colocar los datos Fiscales</label> <br/>'+
            '<br/>Uso de CFDI     : <select name="usoCFDI" required class="uso">'+
                '<option value="a">"Uso CFDI"</option>'+
                '<option value="G01">"G01 Adquisición de mercancias"</option>'+
                '<option value="G02">"G02 Devoluciones, descuentos o bonificaciones"</option>'+
                '<option value="G03">"G03 Gastos en general"</option>'+
                '<option value="I01">"I01 Construcciones"</option>'+
                '<option value="I02">"I02Mobilario y equipo de oficina por inversiones"</option>'+
                '<option value="I03">"I03Equipo de transporte"</option>'+
                '<option value="I04">"I04Equipo de computo y accesorios"</option>'+
                '<option value="I05">"I05Dados, troqueles, moldes, matrices y herramental"</option>'+
                '<option value="I06">"I06Comunicaciones telefónicas"</option>'+
                '<option value="I07">"I07Comunicaciones satelitales"</option>'+
                '<option value="I08">"I08Otra maquinaria y equipo"</option>'+
                '<option value="P01">"P01 Por definir"</option>'+
            '</select><br/>' +
            '<br/>Tipo de pago    : <select name="tpago" required class="tpago">'+
                '<option value="a">"Tipo de Pago"</option>'+
                '<option value="PUE">"PUE Pago en una sola exhibición"</option>'+
                '<option value="PPD">"PPD Pago en parcialidades o diferido"</option>'+
            '</select><br/>' +
            '<br/>Forma de Pago: <select name="mpago" required class="mpago">'+
                '<option value="a">"Metodo Pago"</option>'+
                '<option value="03">"03 Transferencia Electronica de Fondos"</option>'+
                '<option value="01">"01 Efectivo"</option>'+
                '<option value="02">"02 Cheque Nominativo"</option>'+
                '<option value="04">"04 Tarjeta de Credito"</option>'+
                '<option value="05">"05 Monedero Electronico"</option>'+
                '<option value="15">"15 Condonacion"</option>'+
                '<option value="17">"17 Compensacion"</option>'+
                '<option value="30">"30 Aplicacion de Anticipos"</option>'+
                '<option value="99">"99 Por Definir"</option>'+
            '</select><br/>' +
            '<input type="hidden" name="mpago" >'+
             rela +
             detallista+
            '</div><br/><br/>'+             
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Generar Factura',
                btnClass: 'btn-blue',
                action: function () {
                    var uso = this.$content.find('.uso').val();
                    var tpago = this.$content.find('.tpago').val();
                    var mpago = this.$content.find('.mpago').val();
                    var rel = this.$content.find('input:checked').length;
                    var ocdet = this.$content.find('.ocdet').val();
                    var entdet = this.$content.find('.entdet').val();
                    if(uso=='a'){
                        $.alert('Debe de seleccionar un Uso CFDI valido...');
                        return false;
                    }else if(tpago== 'a'){
                        $.alert('Debe de seleccionar un Tipo de pago valido...');
                        return false;   
                    }else if(mpago== 'a'){
                        $.alert('Debe de seleccionar un Metodo de pago valido...');
                        return false;   
                    }else if(liverpool== 'si' && ocdet == ''){
                        $.alert('Debe de colocar la Orden de compra...');
                        return false;
                    }else if(liverpool== 'si' && entdet == ''){
                        $.alert('Debe de colocar la entrada...');
                        return false;
                    }else{
                        
                      $.alert('Se timbrara la factura con los siguientes datos  ' + uso + ', ' + tpago  + ', '+ mpago);
                        var cu = '';
                        $("input:checkbox:checked.ja").each(function() {            
                                     var cajas =  $(this).attr("docu");         
                                     cu = cu + ',' + cajas;         
                        });         
                        if(cu.length > 0 ){         
                            alert('Estas seleccionadas las cajas ' + cu + ', se uniran las cajas en una sola y aparecera relacionada multiple veces en el control de cajas');
                            idcaja = cu;
                        }else{
                            idcaja = ''+idcaja;
                        } 
                      facturarCaja(idcaja, docf, val, uso, tpago, mpago, rel, ocdet, entdet);
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

    function cerrarCaja(idc, docf){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:'json',
            data:{cerrarcaja:idc, idcaja:idc, docf:docf, tipo:'remision'},
            success:function(data){
                if(data.status == 'error'){
                    alert('No se pudo cerrar la caja' +  data.mensaje);
                }else if(data.status == 'ok'){
                    alert('Se ha cerrado la caja, ahora esta en Asignacion de unidad Logistica.');
                    document.getElementById('cerrar_'+idc).classList.add('hide');
                    document.getElementById('cerrarLabel_'+idc).innerHTML='<font color="blue">C E R R A D A</font>';
                }
            }
        })
    }

</script>