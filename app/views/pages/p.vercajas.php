<br /><br />
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
                                            <th>Caja<br/>Remision<br/>Fatcura</th>
                                            <th>Pedido</th>
                                            <th>Cliente</th>
                                            <th>CP</th> 
                                            <th>Fecha Pedido</th>
                                            <th>Importe</th>
                                            <th>Dias Atraso</th>
                                            <th>Fecha Cita</th>
                                            <th>Fecha Apertura Caja</th>
                                            <th>Embalaje Completo?</th>
                                            <th>Imprimir PreFactura</th>
                                            <th>Facturar</th>
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($exec as $data): 
                                            $color='';
                                            if($data->VALIDACION == 0){
                                                $color="style='background-color:#e6ffe6'";
                                            }else{
                                                $color="style='background-color:#ffebe6'";
                                            }
                                        ?>
                                       <tr <?php echo $color?> >
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->ID;?></a>
                                                <br/><?php echo $data->REMISION?>
                                                <br/><?php echo $data->FACTURA?>
                                            </td>
                                            <td><?php echo $data->CVE_FACT;?></td>
                                            <td><?php echo $data->NOMBRE;?></td>
                                            <td><?php echo $data->CODIGO;?></td>
                                            <td><?php echo $data->FECHAELAB;?></td>
                                            <td><?php echo $data->IMPORTE;?></td>
											<td><?php echo $data->DIAS;?></td>
                                            <td><?php echo $data->CITA;?></td>
                                            <td><?php echo $data->FECHA_CREACION;?></td>
                                            <td><?php echo ($data->EMBALAJE == 'TOTAL')? 'Si':'No';?></td>
                                            <td>
                                                <input type="button" name="preFactura" value="Prefactura" onclick="impPreFact(<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>')">
                                            </td>
                                            <td>
                                                <input type="hidden" value="Facturar" onclick="facturarCaja(<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>', <?php echo $data->VALIDACION?>)" id="caja_<?php echo $data->ID?>">

                                            	<!--<form action="index.php" method="post">
                                            	   <input name="idcaja" type="hidden" value="<?php echo $data->ID?>" /> 
                                                   <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                            	   <button name="cerrarcaja" type="submit" value="enviar" class="btn btn-warning" <?php echo ($data->EMBALAJE == 'TOTAL') ? '':'disabled';?> >Cerrar <i class="fa fa-th-large"></i></button>
                                                </form> -->
                                                <label id="boton_<?php echo $data->ID?>"><input type="button" class="btn btn-info" onclick="test('<?php echo $data->NOMBRE?>', <?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>', <?php echo $data->VALIDACION?>)" value="Crear Factura"   ></label>
                                                <label id="prefact_<?php echo $data->ID?>"></label>
                                                <?php if(!empty($data->REMISION)){?>
                                                    <br/><input type="button" name="cerrarCajas" value="Cerrar Caja" 
                                                    onclick="cerrarCaja(<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>')" 
                                                    class="btn btn-success"
                                                    id="cerrar_<?php echo $data->ID ?>">
                                                    <label id="cerrarLabel_<?php echo $data->ID?>"></label>
                                                <?php }?>
                                                <!--<a href="index.php?action=imprimeFact&factura=FP889134">Imprime Factura</a>-->
                                            </td>
                                             </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            <!-- /.table-responsive -->
                      </div>
            </div>
        </div>
</div>
<form action ="index.php" method="POST" id='FORM_EXEC'>
    <input type="hidden" name="impPreFact" value="" id="val">
    <input type="hidden" name="docf" value="" id="docf">
    <input type="hidden" name="tipo" value="Refac">
    <input type="hidden" name="cajas" value="" id="cu">
</form>
<script type="text/javascript">

    function facturarCaja(idcaja, docf, val, uso, tpago, mpago){
        if(val >0){
            alert('Faltan ' + val + ' Productos sin registro fiscal, los puede consultar en la prefactura, gracias');
        }else{
            if(confirm('Desea cerrar la caja.')){
                document.getElementById('caja_'+idcaja).classList.add('hide');
                //alert('Prepara el JSon para la factura' + idcaja + docf );
                $.ajax({
                    url:'index.php',
                    method:'POST',
                    dataType:'json',
                    data:{facturar:idcaja, uso:uso, tpago:tpago, mpago:mpago},
                    success:function(data){
                        if(data.status == 'ok'){
                            alert('Se ha creado la factura '+ data.factura);
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
                                success:function(data){
                                    if(data.status == 'ok'){
                                        alert('Se ha cerrado la caja.' + mensaje);
                                    }else{
                                        alert('No se ha cerrado la caja, razon:' + data.mensaje)
                                    }
                                }
                            });
                        }else if(data.status == 'No'){
                            alert(data.razon);
                        }
                    }
                });
            }else{
                alert('Le recordamos que no deben de quedar Cajas sin facturar.');
            }
        }
    }
    function impPreFact(idc, docf ){
        if(confirm('Desea Descargar la Prefactura, al hacerlo se cerrara la caja y se marca como remisionada?')){
            document.getElementById('val').value=idc;
            document.getElementById('docf').value = docf;
            var form= document.getElementById('FORM_EXEC');
            form.submit();
            document.getElementById('prefact_'+idc).innerHTML="<font color='blue'>Prefacurada</font>";
            //location.reload(true);
            /*$.ajax({
                url:"index.php",
                method:"POST",
                dataType:"json",
                data:{impPreFact:idc},
                success:function(){
                }
            })*/
        }
    }

    function test(cliente, idcaja, docf, val ){
        
         $.confirm({
            title: 'Datos Fiscales',
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
                    if(uso=='a'){
                        $.alert('Debe de seleccionar un Uso CFDI valido...');
                        return false;
                    }else if(tpago== 'a'){
                        $.alert('Debe de seleccionar un Tipo de pago valido...');
                        return false;   
                    }else if(mpago== 'a'){
                        $.alert('Debe de seleccionar un Metodo de pago valido...');
                        return false;   
                    }else{
                        
                      $.alert('Se timbrara la factura con los siguientes datos  ' + uso + ', ' + tpago  + ', '+ mpago);
                      facturarCaja(idcaja, docf, val, uso, tpago, mpago);
                        
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