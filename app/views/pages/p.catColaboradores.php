<br /><br />

<br /><br />
<button id="clienteNuevo" class="btn btn-info">Alta Colaborador</button>
<br/><br/>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                          Catalogo de Colaboradores.
            </div>
            <div class="panel-body">
                            <div class="table-responsive">                            
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Numero</th>
                                            <th>Nombre</th>
                                            <th>Segundo</th>
                                            <th>Paterno</th>
                                            <th>Materno</th>
                                            <th>Compañia</th>
                                            <th>Area</th>
                                            <th>Clave <br/>InterBancaria</th>
                                            <th>Banco <br/>Clave</th>
                                            <th>Tarjeta <br/>Bancaria</th>
                                            <th>Banco <br/>Tarjeta</th>
                                            
                                        </tr>
                                    </thead>
                                  <tbody>
                                        <?php
                                        foreach ($colaboradores as $c): 
                                            
                                    ?>
                                       <tr class="odd gradeX" >
                                            <td><?php echo $c->ID;?></td>
                                            <td><?php echo $c->NOMBRE?></td>
                                            <td><?php echo $c->SEGUNDO_NOMBRE?></td> 
                                            <td><?php echo $c->PATERNO ?></td>
                                            <td><?php echo $c->MATERNO;?></td>
                                            <td><?php echo $c->CIA;?></td>
                                            <td><?php echo $c->AREA;?></td>
                                            <td><?php echo $c->CLAVE_INTERBANCARIA;?></td>
                                            <td><?php echo $c->BANCO_CLAVE;?></td>
                                            <td><?php echo $c->NUMERO_TARJETA;?></td>
                                            <td><?php echo $c->BANCO_TARJETA;?></td>

                                        </tr>
                                        <?php endforeach; ?>
                                 </tbody>
                                 </table>
                            </div>
            </div>
                        <div class="panel-footer text-right">
                            <form action="index.php" method="post">
                                <button type="submit" name="generarCierreEnt" class="btn btn-warning" formtarget="_blank" onclick="refrescar()" >Generar LayOut <i class="fa fa-save"></i></button>
                            </form>                            
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
            title: 'Datos Colaborador',
            content: 'Favor de colocar los datos del Colaborador' + 
            '<form action="index.php" class="formName">' +
            '<div class="form-group">'+
            'Nombre: <br/> <input name="nombre" type="text" placeholder="Nombre " size="50" class="nom"> <br/>'+
            'Segundo: <br/><input name="segundo" type="text" placeholder="Segundo Nombre " size="50" class="seg"> <br/>'+
            'Paterno:<br/><input name="paterno" type="text" placeholder="Paterno" size="50" class="pat"> <br/>'+
            'Materno: <br/> <input name="materno" type="text" placeholder="Materno" size="50" class="mat"> <br/>'+
            'Compañia: <br/> <input name="compania" type="text" placeholder="Compañia" size="50" class="com"> <br/>'+
            'Puesto: <br/> <input name="puesto" type="text" placeholder="Puesto" size="50" class="pue"> <br/>'+
            'Clave: <br/> <input name="clave" type="text" placeholder="Clave" size="18" class="cve"> <br/>'+
            'Banco Clave: <br/> <input name="bancoC" type="text" placeholder="Banco" size="50" class="bcve"> <br/>'+
            'Tarjeta: <br/><input name="tarjeta" type="text" placeholder="16 digitos" size =16" class="tar"> <br/>' +
            'Banco Tarjeta: <br/><input name="tarjetaB" type="text" placeholder="Banco Tarjeta" size =50" class="tarB"> <br/>' +
            '</div><br/><br/>'+
            '</form>',
                buttons: {
                formSubmit: {
                text: 'Solicitud Alta de Colaborador',
                btnClass: 'btn-blue',
                action: function () {
                    var nombre = this.$content.find('.nom').val();
                    var segundo = this.$content.find('.seg').val();
                    var paterno = this.$content.find('.pat').val();
                    var materno = this.$content.find('.mat').val();
                    var compania =this.$content.find('.com').val();
                    var puesto = this.$content.find('.pue').val();
                    var clave = this.$content.find('.cve').val(); 
                    var cveBanco = this.$content.find('.bcve').val(); 
                    var tarjeta = this.$content.find('.tar').val(); 
                    var tarBanco = this.$content.find('.tarB').val(); 
                     if(nombre==''){
                        $.alert('Debe de colocar el nombre del Colaborador...');
                        return false;
                    }else if(paterno== ''){
                        $.alert('Debe de colocar el Apellido Paterno...');
                        return false;   
                    }else if(materno== ''){
                        $.alert('Debe de colocar el Apellido Materno...');
                        return false;   
                    }else if(compania == ''){
                        $.alert('Debe de colocar la compañia...');
                        return false;   
                    }else if(puesto == ''){
                        $.alert('Favor de colocar el Puesto...');
                        return false;   
                    }else if(clave== '' || clave.length != 18 ){
                        $.alert('Dede de colocar una clave de 18 digitos...');
                        return false;
                    }else if(tarjeta = '' || tarjeta.length !=16){
                        $.alert('Es necesaria la tarjeta a 16 digitos...');
                        return false;
                    }else if(cveBanco = ''){
                        $.alert('Es necesario el banco de la Clave...');
                        return false;
                    }else if(tarBanco = ''){
                        $.alert('Es necesario el banco de la Tarjeta...');
                        return false;
                    }else{
                        $.alert('Se creara el alta del Colaborador ' + nombre + ' ' +segundo + ' ' + paterno  + ' '+ materno +' a la compañia '+compania);
                        $.ajax({
                            url:'index.php',
                            type:'post',
                            dataType:'json',
                            data:{crearColaborador:1, nombre, segundo, paterno, materno, compania, puesto, clave, tarjeta, cveBanco, tarBanco},
                            success:function(data){
                                alert('Se intenta Crear el cliente');
                                window.reload(true);
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