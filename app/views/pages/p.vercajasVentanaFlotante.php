<style type="text/css">
    body {
        z-index:1;
    }
    h3 {
        text-transform:capitalize;
        font-family:Arial, Helvetica, sans-serif;
    }
    p {
        font-size:16px;
        font-family:Arial, Helvetica, sans-serif;
    }
    #capaVentana {
        visibility:hidden;
        position:absolute;
        padding:0px;
        left:100px;
        top:100px;
        z-index:3;
    }
    #capaFondo1 {
        visibility:hidden;
        position:absolute;
        padding:0px;
        left:0px;
        top:0px;
        right:0px;
        bottom:0px;
        background-image:url(trans01.gif);
        background-repeat:repeat;
        width:100%;
        height:596px;
        z-index:2;
    }
    #capaFondo2 {
        visibility:hidden;
        position:absolute;
        padding:0px;
        left:0px;
        top:0px;
        right:0px;
        bottom:0px;
        background-image:url(trans02.gif);
        background-repeat:repeat;
        width:100%;
        height:596px;
        z-index:2;
    }
    #capaFondo3 {
        visibility:hidden;
        position:absolute;
        padding:0px;
        left:0px;
        top:0px;
        right:0px;
        bottom:0px;
        background-image:url(trans03.gif);
        background-repeat:repeat;
        width:100%;
        height:596px;
        z-index:2;
    }
</style>
<body>
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
                                            <th>Caja</th>
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
                                        ?>
                                       <tr>
                                            <td><a href="index.php?action=detalleOC&doco=<?php echo $data->CVE_DOC?>"><?php echo $data->ID;?></a></td>
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
                                                <input type="button" name="preFactura" value="Prefactura" onclick="impPreFact(<?php echo $data->ID?>)">
                                            </td>
                                            <td>
                                                <input type="button" value="Cerrar" onclick="facturarCaja(<?php echo $data->ID?>, '<?php echo $data->CVE_FACT?>')" id="caja_<?php echo $data->ID?>">

                                            	<!--<form action="index.php" method="post">
                                            	   <input name="idcaja" type="hidden" value="<?php echo $data->ID?>" /> 
                                                   <input name="docf" type="hidden" value="<?php echo $data->CVE_FACT?>" />
                                            	   <button name="cerrarcaja" type="submit" value="enviar" class="btn btn-warning" <?php echo ($data->EMBALAJE == 'TOTAL') ? '':'disabled';?> >Cerrar <i class="fa fa-th-large"></i></button>
                                                </form> -->
                                                <a href="javascript:abrirVentana('3');">Simulacro de ventana Emergente 1</a>
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
</body>
<div id="capaVentana">
        <table border="0" cellpadding="0" cellspacing="0" width="450">
            <tr>
                <td style="background-image:url(top-left.gif);" width="4"><img src="pixel_trans.gif" /></td>
                <td style="background-image:url(top-center.gif); background-repeat:repeat-x" width="418" align="left">
                    <font color="#FFFFFF" style="font-size:14px;font-family:Arial, Helvetica, sans-serif;font-weight:600;">
                        &nbsp;&nbsp;Datos de Facturacion</font>
                </td>
                <td style="background-image:url(boton-cerrar.gif); cursor:pointer;" height="30" width="24"
                onclick="cerrarVentana()"> <img src="pixel_trans.gif" height="25" width="22" alt="Cerrar Ventana" />
                </td>
                <td style="background-image:url(top-right.gif);" height="30" width="4"><img src="pixel_trans.gif" /></td>
            </tr>
            <tr>
                <td style="background-image:url(medio-izq.gif); background-repeat:repeat-y;" width="4">
                    <img src="pixel_trans.gif" /></td>
                <td colspan="2">
                    <table cellpadding="10" cellspacing="0" border="0" width="100%" style="background-color:#EFECDC">
                    <tr>
                        <td style="text-align:center; font-size:14px; font-family:Arial, Helvetica, sans-serif;">
                            <input type="text" name="uso" placeholder="Uso de CFDI">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <form name="formulario">
                                <input type="button" name="bAceptar" value="Aceptar" onclick="cerrarVentana()"/>
                            </form>
                        </td>
                    </tr>
                    </table>
                </td>
                <td style="background-image:url(medio-der.gif); background-repeat:repeat-y;" width="4">
                    <img src="pixel_trans.gif" /></td>
            </tr>
            <tr>
                <td style="background-image:url(botton-left.gif);" height="4"><img src="pixel_trans.gif" /></td>
                <td style="background-image:url(botton-center.gif); background-repeat:repeat-x" height="4">
                    <img src="pixel_trans.gif" /></td>
                <td style="background-image:url(botton-center.gif); background-repeat:repeat-x" height="4">
                    <img src="pixel_trans.gif" /></td>
                <td style="background-image:url(botton-right.gif);" height="4" width="4"><img src="pixel_trans.gif" /></td>
            </tr>       
        </table>
    </div>
    
    <div id="capaFondo1">
    </div>
    <div id="capaFondo2">
    </div>
    <div id="capaFondo3">
    </div>

<form action ="index.php" method="POST" id='FORM_EXEC'>
    <input type="hidden" name="impPreFact" value="" id="val">
</form>
<script type="text/javascript">

    function facturarCaja(idcaja, docf){
        if(confirm('Desea cerrar la caja.')){
            document.getElementById('caja_'+idcaja).classList.add('hide');
            //alert('Prepara el JSon para la factura' + idcaja + docf );
            $.ajax({
                url:'index.php',
                method:'POST',
                dataType:'json',
                data:{facturar:idcaja},
                success:function(data){
                    if(data.status == 'ok'){
                        alert('Se ha creado la factura '+ data.factura);
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
                    }else{
                        alert('NO se pudo crear la factura, intente nuevamente');
                    }
                }
            });
        }else{
            alert('Le recordamos que no deben de quedar Cajas sin facturar.');
        }
    }
    function impPreFact(idc){
        if(confirm('Desea Descargar la Prefactura?')){
            document.getElementById('val').value=idc;
            var form= document.getElementById('FORM_EXEC');
            form.submit();
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


function abrirVentana(ventana)
    {
        if (ventana=="1")
        {
            document.getElementById("capaFondo1").style.visibility="visible";
            document.getElementById("capaFondo2").style.visibility="hidden";
            document.getElementById("capaFondo3").style.visibility="hidden";
        }
        else if (ventana=="2")
        {
            document.getElementById("capaFondo1").style.visibility="hidden";
            document.getElementById("capaFondo2").style.visibility="visible";
            document.getElementById("capaFondo3").style.visibility="hidden";
        }
        else
        {
            document.getElementById("capaFondo1").style.visibility="hidden";
            document.getElementById("capaFondo2").style.visibility="hidden";
            document.getElementById("capaFondo3").style.visibility="visible";
        }
        document.getElementById("capaVentana").style.visibility="visible";
        document.formulario.bAceptar.focus();
    }

function cerrarVentana()
    {
        document.getElementById("capaFondo1").style.visibility="hidden";
        document.getElementById("capaFondo2").style.visibility="hidden";
        document.getElementById("capaFondo3").style.visibility="hidden";
        document.getElementById("capaVentana").style.visibility="hidden";
        document.formulario.bAceptar.blur();
    }

    function test(cliente){
        alert(cliente);
         $.confirm({
                                                title: 'Envío de xml',
                                                content: '¿Seguro que deseas validar el xml del folio de factura ' + cliente + '?',
                                                buttons: {
                                                    Enviar: function () {
                                                        // here the key 'something' will be used as the text.
                                                        var url = "index.php"; // El script a dónde se realizará la petición.
                                                        $.ajax({
                                                            type: "POST",
                                                            url: url,
                                                            dataType: "json",
                                                            data: {compruebaXml: id}, // Adjuntar los campos del formulario enviado.
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
                                                                //console.log(data);
                                                                $('#pop').hide();
                                                                if (data.status == "OK") {
                                                                    //después de que la valiadacion sea correcta, eliminamos el row
                                                                    $('#' + id + '').remove();
                                                                    //y avisamos que se validó
                                                                    $.alert('Se validó correctamente.');
                                                                } else {
                                                                    $.alert('Algo salió mal, favor de verificarlo con el administrador de sistema, código de error: ' + data.response);
                                                                    console.log("XML:"+data.xml);
                                                                }


                                                            }
                                                        });

                                                    },
                                                    Cancelar: {
                                                        //text: 'Something else &*', // Some Non-Alphanumeric characters
//                                                        action: function () {
//                                                            $.alert('You clicked on something else');
//                                                        }
                                                    }
                                                }
                                            });
                                    }
    

</script>