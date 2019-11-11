<br /><br />
<button id="clienteNuevo" class="btn btn-info">Crear Cliente nuevo</button>
<button id="" class="btn btn-info">Crear Cliente nuevo</button>

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
                                <th>Clave</th>
                                <th>Cliente</th>
                                <th>Pertenece a:</th>
                                <th>Requisitos asociados</th>
                                <th>Cartera Cobranza</th>
                                <th>Cartera Revision</th>
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
                                <td><?php echo $row->CLAVE;?></td>
                                <td title="De click para ver las facturas del cliente"><a href="index.cobranza.php?action=edoCliente&cliente=<?php echo $row->CLAVE?>&tipo=c&nombre=<?php echo $row->NOMBRE?>" target='popup' onclick='window.open(this.href, this.target, "width=800, height=800"); return false;'><?php echo $row->NOMBRE;?></td>
                                <td><?php echo $row->MAESTRO;?></td>
                                <td><?php echo $row->DOCUMENTOS_ASOCIADOS;?></td>
                                <td><?php echo $row->CARTERA_COBRANZA;?></td>
                                <td><?php echo $row->CARTERA_REVISION;?></td>
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
            'RFC: <br/> <input name="rfc" type="text" placeholder="RFC sin espacion ni guiones" size="15" class="rfc" onchange="valida(this.value)"> <br/>'+
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
                    //var maestr = this.$content.find('mae').val(); 
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
                    }else if(motivo == ''){
                        $.alert('Dede de colocar el motivo de la Solicitud...');
                        return false;
                    }else if(maestro = ''){
                        $.alert('Es necesario un maestro...');
                        return false;      
                    }else{
                        $.alert('Se creara la Solicitud de alta del cliente ' + cliente + ', ' + direccionC  + ', '+ direccionE +','+colonia);
                        $.ajax({
                            url:'index.php',
                            type:'post',
                            dataType:'json',
                            data:{crearCliente:1, cliente, direccionC,direccionE, colonia, ciudad, rfc, motivo},
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

</script>