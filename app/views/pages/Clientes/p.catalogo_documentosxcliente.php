<br /><br />
<button id="clienteNuevo" class="btn btn-info">Crear Cliente nuevo</button>

<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Clientes y requisitos asociados.</h4>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Clave<br/>Serv</th>
                                <th>Cliente<br/> Correo facturas</th>
                                <th>Pertenece a:</th>
                                <th>Requisitos asociados</th>
                                <!--<th>Cartera Cobranza</th>
                                <th>Cartera Revision</th>-->
                                <th>Dias Revision</th>
                                <th>Dias Pago</th>
                                <th>Dos Pasos</th>
                                <th>Plazo</th>
                                <th>Addenda</th>
                                <th>ADD_PORTAL</th>
                                <th>ENVIO</th>
                                <th>CP</th>
                                <th>Google MAPS</th>
                                <th>Modificar</th>
                                <th>Datos Cobranza</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($exec as $row): ?>
                            <tr>
                                <td><?php echo $row->CLAVE;?><br/><input type="checkbox" name="serv" checked="checked" class="servicio"></td>
                                <td title="De click para ver las facturas del cliente"><a href="index.cobranza.php?action=edoCliente&cliente=<?php echo $row->CLAVE?>&tipo=c&nombre=<?php echo $row->NOMBRE?>&maestro=<?php echo $row->CVE_MAESTRO?>" target='popup' onclick='window.open(this.href, this.target, "width=1200, height=800"); return false;'><?php echo $row->NOMBRE;?></a><?php echo ' ( '.$row->RFC.' )'?><br/>&nbsp;&nbsp;&nbsp;

                                    <button class="glyphicon glyphicon-pencil infoCte" cte="<?php echo $row->CLAVE?>"></button> 
                                    <input class="correo" type="email" placeholder="Correo para envio de documentos" value="<?php echo $row->EMAILPRED?>"  multiple size="60" cl="<?php echo $row->CLAVE ?>"></td>
                                <td><?php echo $row->MAESTRO;?></td>
                                <td><?php echo $row->DOCUMENTOS_ASOCIADOS;?></td>
                                <!--<td><?php echo $row->CARTERA_COBRANZA;?></td>
                                <td><?php echo $row->CARTERA_REVISION;?></td>-->
                                <td><?php echo $row->DIAS_REVISION;?></td>
                                <td><?php echo $row->DIAS_PAGO;?></td>
                                <td><?php echo $row->REV_DOSPASOS;?></td>
                                <td><?php echo $row->PLAZO;?></td>
                                <td><?php echo $row->ADDENDA;?></td>
                                <td><?php echo $row->ADD_PORTAL;?></td>
                                <td><?php echo $row->ENVIO;?><a href="index.php?action=verDatosEnvio&cliente=<?php echo $row->CLAVE?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" class="btn btn-info">Ver</a></td>
                                <td><?php echo $row->CP;?></td>
                                <td><a href="<?php echo $row->MAPS;?>" target="_blank"><?php echo $row->MAPS;?></a></td>
                               <!-- <form action="index.php" method="post"> -->
                                <!-- <input type="hidden" name="clave" value="<?php echo $row->CLAVE;?>"/> -->
                                <td><a href="index.php?action=documentosdelcliente&clave=<?php echo $row->CLAVE;?>" class="btn btn-warning">Requisitos <i class="fa fa-pencil-square-o"></i></a></td>
                                <td>
                                    <form action="index.php" method="post">
                                        <input type="hidden" name="idcliente" value="<?php echo $row->CLAVE;?>"/>
                                        <button type="submit" name="datosCarteraCliente" class="btn btn-info">Datos cartera <i class="fa fa-pencil-square-o"></i></button>
                                    </form>
                                </td>
                                <!--</form>-->
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
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

            //'<br/><b>Regimen</b>:<br/><input cte="'+cte+'"class="editCte" campo="sat_regimen" value="'+data.regimen+'" size="100" maxlength="25">' 
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


    $(".correo").change(function(){
        var correo = $(this).val()
        var cl = $(this).attr('cl')
        if(correo.indexOf('@',0)> 0){
            alert("Se cambia el correo")
            $.ajax({
                url:'index.v.php',
                type:'post',
                dataType:'json',
                data:{chgEmail:1, cl, correo},
                success:function(data){
                    setTimeout(alert('Se ha actualizado el correo electronico.'),4000)
                    location.reload()
                },
                error:function(){
                }
            })
        }else{
            alert("El correo " + correo + ', no parece ser valido')
        }
    })

    $("#clienteNuevo").click(function(){ 
           $.confirm({
            columnClass: 'col-md-8',
            title: 'Datos Fiscales',
            content: 'Favor de colocar los datos del Cliente' + 
            '<form action="index.php" class="formName">' +
            '<div class="form-group">'+
            'Nombre del cliente: <input name="cliente" type="text" placeholder="Nombre del cliente" size="120" class="cl"> <br/>'+
            'Direccion Calle: <br/><input name="direccionC" type="text" placeholder="Calle " size="80" class="dirC"> <br/>'+
            'Direccion No Exterior:<br/><input name="direccionE" type="text" placeholder="Numero exterior" size="15" class="dirE"> <br/>'+
            'Colonia: <br/> <input name="colonia" type="text" placeholder="Colonia" size="50" class="col"> <br/>'+
            'Ciudad: <br/> <input name="ciudad" type="text" placeholder="Ciudad" size="50" class="ciu"> <br/>'+
            'RFC: <br/> <input name="rfc" type="text" placeholder="RFC sin espacion ni guiones" size="35" maxlength="13" class="rfc" onchange="valida(this.value)"> <br/>'+
            'Codigo Postal: <br/> <input name="cp" type="text" placeholder="Codigo Postal" size="10" class="cp" > <br/>'+
            'Correo envio de Facturas: <br/> <input name="correo" type="email" placeholder="Correo de envio Facturas" size="100" class="mailfact" multiple> <br/>'+
            'Correo Cobranza: <br/> <input name="emailCob" type="email" placeholder="Correo Cobranza" size="100" class="mailCob" multiple> <br/>'+
            'Motivo: <br/><input name="motivo" type="text" placeholder="Motivo de Alta" size ="100" class="mot"> <br/>' +
            '</div><br/><br/>'+
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Solicitud Alta de Cliente',
                btnClass: 'btn-blue',
                action: function () {
                    var cliente = this.$content.find('.cl').val();
                    var direccionC = this.$content.find('.dirC').val();
                    var direccionE = this.$content.find('.dirE').val();
                    var colonia = this.$content.find('.col').val();
                    var ciudad =this.$content.find('.ciu').val();
                    var rfc = this.$content.find('.rfc').val();
                    var motivo = this.$content.find('.mot').val(); 
                    var cp = this.$content.find('.cp').val();
                    var mail = this.$content.find('.mailfact').val();
                    var mailc = this.$content.find('.mailCob').val();
                    if(cliente==''){
                        $.alert('Debe de colocar el nombre del cliente...');
                        return false;
                    }else if(direccionC== ''){
                        $.alert('Debe de colocar la direccion del cliente...');
                        return false;   
                    }else if(colonia== ''){
                        $.alert('Debe de colocar la colonia del cliente...');
                        return false;   
                    }else if(ciudad == ''){
                        $.alert('Debe de colocar la ciudad del cliente...');
                        return false;   
                    }else if(rfc == '' || rfc.length < 12){
                        $.alert('Favor de revisar el RFC del cliente...');
                        return false;   
                    }else if(cp == ''){
                        $.alert('Es necesario el codigo postal ...');
                        return false;      
                    }else{
                        $.alert('Se dara de alta el cliente: ' + cliente + ', ' + direccionC  + ', '+ direccionE +','+colonia);
                        $.ajax({
                            url:'index.php',
                            type:'post',
                            dataType:'json',
                            data:{crearCliente:1, cliente, direccionC, direccionE, colonia, ciudad, rfc, motivo, cp, mail, mailc},
                            success:function(data){
                                alert('Se intenta Crear el cliente');
                            }
                        });
                    }
                   }
            },
            cancelar: function () {
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
    })


    function valida(rfc){
        $.ajax({
            url:'index.php',
            type:'post',
            dataType:"json",
            data:{validaRFC:rfc, tipo:'cliente'},
            success:function(data){
                if(data.status=='ok'){

                }else{
                    alert(data.aviso);
                }
            }
        });
    }

    $(".servicio").change(function(){
        /// obtener el nuevo status y mandar la funcion correcta.
        alert('Cambio')
    })

</script>