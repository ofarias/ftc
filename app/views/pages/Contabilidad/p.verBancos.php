<br /><br />
<button id="clienteNuevo" class="btn btn-info">Alta de Cuenta</button>
<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>Clientes y requisitos asociados.</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">                            
                    <table class="table table-striped table-bordered table-hover" id="dataTables-table-3">
                        <thead>
                            <tr>
                                <th>Ln</th>
                                <th>Banco</th>
                                <th>Cuenta</th>
                                <th>Dia de<br/> Corte</th>
                                <th>RFC</th>
                                <th>Nombre Fiscal</th>
                                <th>Nombre Comercial</th>
                                <th>Clave</th>
                                <th>Editar</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $ln=0; foreach($info as $row): $ln++;?>
                            <tr>
                                <td><?php echo $ln;?></td>
                                <td><?php echo $row->BANCO;?></td>
                                <td><?php echo $row->NUM_CUENTA;?></td>
                                <td align="center"><b><?php echo $row->DIA_CORTE?></b></td>
                                <td><?php echo $row->RFC;?></td>
                                <td><?php echo $row->FISCAL;?></td>
                                <td><?php echo $row->COMERCIAL;?></td>
                                <td><?php echo $row->CLAVE;?></td>
                                <td><input type="button" name="editar" onclick="editar(<?php echo $row->ID?>)" value="Editar" class="btn btn-info"></td>
                            </tr>
                            <?php endforeach ?>
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

    function editar(idb){
        alert('Id del Banco' + idb)
        window.open('index.coi.php?action=editBanco&idb='+idb, 'popup', 'width=800,height=600')
        return false
    }
    
    $("#clienteNuevo").click(function(){ 
           $.confirm({
            columnClass: 'col-md-8',
            title: 'Datos de la Cuenta',
            content: 'Alta de cuenta bancaria' +

            '<form action="index.coi.php" class="formName">' +
            '<div class="form-group">'+
            'Banco: <br/>'+
                    '<select class="ban">'+
                    '<option value="">Seleccione el Banco</option>'+
                    '<?php foreach($ban as $bn):?>'+
                    '<option value="<?php echo $bn->ID?>"><?php echo "(".$bn->BANCO.") ".$bn->NOMBRE?></option>'+
                    '<?php endforeach;?>'+
            '<br/>'+
            'No. de Cuenta: <br/>' + 
            '<input name="cuenta" type="text" placeholder="Numero de Cuenta " size="80" class="cta"> <br/>'+
            'Tipo: <br/><select name="tipo" requied class="tip"> <br/>'+
                    '<option value="">Tipo de cuenta</option>'+
                    '<option value="CM">Cuenta Maestra</option>'+
                    '<option value="Inv">Inversion</option>'+
                    '<option value="ch">Cheque</option>'+
                    '<option value="crev">Credito Revolvente</option>'+
                    '<option value="td">Tarjeta de Debito</option>'+
                    '<option value="tc">Tarjeta de Credito</option>'+
                    '</select><br/>'+
            'Moneda: <br/> <select name="moneda" class="mon"> <br/>'+
                            '<option value="">Seleccione una Moneda</option>'+
                            '<option value="1">Peso (MNX)</option>'+
                            '<option value="2">Dolar Americano (USD)</option>'+
                            '<option value="3">Euro (EU)</option>'+
                            '</select> <br/>'+
            'Saldo Inicial: <br/> <input name="saldo" type="number" step="any" placeholder="Saldo Inicial" size="50" class="sal"> <br/>'+

            'Dia de Corte: <br/> <input name="fecha" type="number" placeholder="Dia de corte de la Cuenta" min="1" max="31" class="fec" "> <br/>'+
            
            'Serie: <br/><input name="motivo" type="text" placeholder="Serie de los folios" size ="100" class="obs"> <br/>' +

            '</div><br/><br/>'+
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Alta de Cuenta Bancaria',
                btnClass: 'btn-blue',
                action: function () {
                    var banco = this.$content.find('.ban').val();
                    var cuenta = this.$content.find('.cta').val();
                    var tipo = this.$content.find('.tip').val();
                    var moneda = this.$content.find('.mon').val();
                    var saldo =this.$content.find('.sal').val();
                    var fecha = this.$content.find('.fec').val();
                    var serie = this.$content.find('.obs').val(); 
                    //var maestr = this.$content.find('mae').val(); 
                    if(banco==''){
                        $.alert('Debe de colocar el nombre del Banco ...');
                        return false;
                    }else if(cuenta== ''){
                        $.alert('Debe de colocar la cuenta ...');
                        return false;   
                    }else if(tipo== ''){
                        $.alert('Por favor seleccione un tipo de cuenta...');
                        return false;   
                    }else if(moneda == ''){
                        $.alert('Por favor seleccione una moneda...');
                        return false;   
                    }else if(saldo == '' ){
                        $.alert('Colocar el Saldo inicial de la cuenta...');
                        return false;   
                    }else if(fecha == ''){
                        $.alert('Fecha de corte...');
                        return false;
                    }else if(serie == ''){
                        $.alert('Es necesario una Serie para identificar...');
                        return false;      
                    }else{
                        //$.alert('Se creara la Solicitud de alta del cliente ' + cliente + ', ' + direccionC  + ', '+ direccionE +','+colonia);
                        $.ajax({
                            url:'index.coi.php',
                            type:'post',
                            dataType:'json',
                            data:{insertaBanco:1, banco, cuenta, tipo, moneda, saldo, fecha, serie},
                            success:function(data){
                                alert('Inserta la cuenta');
                                location.reload(true)
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