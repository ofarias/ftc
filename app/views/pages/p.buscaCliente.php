<br />
<?php

    if(isset($_SESSION['cotizacion_mover_cliente']) && $_SESSION['cotizacion_mover_cliente']==true){
        $esCambioCliente = true;
    } else {
        $esCambioCliente = false;
    }
    
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                B&uacute;squeda de cliente.
            </div>
            
            <div class="panel-body">
                <form action="index.php" method="POST">                            
                    <div class="col-sm-1">
                        <label for="articulo">Clave: </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="text" name="clave" id="clave" value="" class="text" maxlength="30" style="width: 100%" />
                    </div>
                    <div class="col-sm-1">
                        <label for="cliente">Cliente: </label>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" name='cliente' id='cliente' value='' class="text" maxlength="90" style="width: 100%" />                    
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" value="Buscar" name="buscarCliente" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Clientes.
            </div>            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-clientes">
                        <thead>
                            <tr>                                            
                                <th>Clave</th>
                                <th>Cliente</th>
                                <th>RFC</th>
                                <?php if(!$esCambioCliente){?>
                                <th>Clave Documento</th>
                                <?php }?>
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php                            
                            foreach ($detalle as $data): 
                     
                            ?>
                            <tr class="odd gradeX clickable-row">
                                <td><?php echo $data->CLAVE;?></td>
                                <td><?php echo $data->NOMBRE;?></td>
                                <td><?php echo $data->RFC;?></td>
                                <?php if(!$esCambioCliente){?>
                                <td>
                                    <select id="letra_<?php echo $data->CLAVE;?>" class="selected text text-muted">
                                        <option value="--">--seleccione--</option>
                                    <?php                                    
                                    $myArray = explode(',', $data->LETRAS);
                                    foreach($myArray as $value):
                                        echo '<option value="'.$value.'">'.$value.'</option>';
                                    endforeach;                                    
                                    ?>
                                    </select>
                                </td>
                                <?php }?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            
            <div class="panel-body">
                <div class="col-sm-9">
                    <form action="index.php" method="POST" id="FORM_ACTION">
                        <input type="hidden" name="seleccionaCliente" value="true" />
                        <input type="hidden" name="clave" id="claveCliente" value="" />                        
                        <input type="hidden" name="cliente" id="nombreCliente" value="" /> 
                        <input type="hidden" name="identificadorDocumento" id="identificadorDocumento" value="--">
                    </form>
                </div>
                <div class="col-sm-1">
                    <a class ="button" href="index.php?action=consultarCotizacion">Cancelar</a>
                </div>
                <div class="col-sm-2">
                    <input type="button" id="seleccionar" value="Seleccionar" class="button" />
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">
    var clave, cliente, letra;
    $('#dataTables-clientes').on('click', '.clickable-row', function(event) {
        console.log(event);
        console.log(event.currentTarget.cells[0].innerHTML);
        console.log(event.currentTarget.cells[1].innerHTML);    
        
        clave = event.currentTarget.cells[0].innerHTML;
        cliente = event.currentTarget.cells[1].innerHTML;
        <?php if(!$esCambioCliente){?>
            console.log(event.currentTarget.cells[3].firstElementChild.id);    
            letra = event.currentTarget.cells[3].firstElementChild.id;
        <?php }?>
        
        $(this).addClass('active').siblings().removeClass('active');
    });

    $("#seleccionar").click(function (event){
        //Carga el formulario para que se vaya.            
        $("#claveCliente").val(clave);            
        $("#nombreCliente").val(cliente);        
        <?php if(!$esCambioCliente){?>
        $("#identificadorDocumento").val($("#"+letra).val());
        <?php }?>
        $("#FORM_ACTION").submit();
    });
</script>


