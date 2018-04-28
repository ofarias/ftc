<br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                B&uacute;squeda de art&iacute;culo.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <form action="index.php" method="POST">
                    
                    
                    <div class="col-sm-1">
                        <?php
                            $cliente = $_SESSION['cliente'];
                            $folio = $_SESSION['folio_cotizacion'];
                            $partida = $_SESSION['partida_cotizacion'];
                        ?>
                        <input type="hidden" name='clave' value="<?php echo $cliente;?>" />   
                        <input type="hidden" name='folio' value="<?php echo $folio;?>" />   
                        <input type="hidden" name='partida' value="<?php echo $partida;?>" />   
                        <label for="articulo">Clave: </label>
                    </div>
                    <div class="col-sm-1">
                        <input type="text" name="articulo" id="articulo" value="" class="text" maxlength="30" style="width: 100%" />
                    </div>
                    <div class="col-sm-1">
                        <label for="descripcion">Articulo: </label>
                    </div>
                    <div class="col-sm-7">
                        <input type="text" name='descripcion' id='descripcion' value='' class="text" maxlength="90" style="width: 100%" />                    
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" value="Buscar" name="buscarArticulo" />
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
                Art&iacute;culos.
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-articulos">
                        <thead>
                            <tr>                                            
                                <th>ARTICULO</th>
                                <th>DESCRIPCION</th>
                                <th>COSTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO</th>
                                <th>DESCUENTO</th>
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php                            
                            foreach ($detalle as $data): 
                                $precio = number_format($data->PRECIO, 2, '.', ',');
                     
                            ?>
                            <tr class="odd gradeX clickable-row">
                                <td><?php echo $data->CVE_ART;?></td>
                                <td><?php echo $data->DESCRIPCION;?></td>
                                <td><?php echo $data->COSTO;?></td>
                                <td><input type="text" name="cantidad" id="cantidad_<?php echo $data->CVE_ART;?>" value="1" maxlength="3" class="text text-right text-muted" /></td>
                                <td><input type="text" name="precio" id="precio_<?php echo $data->CVE_ART;?>" value="<?php echo $precio;?>" maxlength="13" class="text text-right text-muted" /></td>
                                <td><input type="text" name="descuento" id="descuento_<?php echo $data->CVE_ART;?>" value="0.00" maxlength="13" class="text text-right text-muted" /></td>
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
                        <input type="hidden" name="actualizaCotizacionPartida" value="true" />
                        <input type="hidden" name="cotizacion" value="<?php echo $_SESSION['folio_cotizacion'];?>" />
                        <input type="hidden" name="partida" value="<?php echo $_SESSION['partida_cotizacion'];?>" />
                        <input type="hidden" name="articulo" id="producto" value="" />
                        <input type="hidden" name="precio" id="precio" value="" />
                        <input type="hidden" name="descuento" id="descuento" value="" />
                        <input type="hidden" name="cantidad" id="cantidad" value="" />
                    </form>
                </div>
                <div class="col-sm-1"><a href="index.php?action=verDetalleCotizacion&folio=<?php echo $_SESSION['folio_cotizacion'];?>">Cancelar</a></div>
                <div class="col-sm-2"><input type="button" id="seleccionar" value="Seleccionar" class="button" /></div>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">
    var clave, costo, precio, descuento, cantidad;
    $('#dataTables-articulos').on('click', '.clickable-row', function(event) {
        console.log(event);
        console.log(event.currentTarget.cells[0].innerHTML);
        console.log(event.currentTarget.cells[2].innerHTML);
        console.log(event.currentTarget.cells[3].firstElementChild.id);
        console.log(event.currentTarget.cells[4].firstElementChild.id);
        console.log(event.currentTarget.cells[5].firstElementChild.id);
        clave = event.currentTarget.cells[0].innerHTML;
        costo = event.currentTarget.cells[2].innerHTML;
        cantidad = $("#"+event.currentTarget.cells[3].firstElementChild.id);
        precio = $("#"+event.currentTarget.cells[4].firstElementChild.id);
        descuento = $("#"+event.currentTarget.cells[5].firstElementChild.id);        
        $(this).addClass('active').siblings().removeClass('active');
    });

    $("#seleccionar").click(function (event){
        valorPrecio = precio.val();
        valorCosto = costo;
        valorPrecioMinimo = valorCosto * 1.2;
        valorDescuento = descuento.val();
        valorCantidad = cantidad.val();
        if (valorPrecioMinimo > valorPrecio){
            OpenWarning("El precio mínimo para este artículo es de "+valorPrecioMinimo);
        } else {
            //Carga el formulario para que se vaya.            
            $("#producto").val(clave);            
            $("#precio").val(valorPrecio);
            $("#descuento").val(valorDescuento);
            $("#cantidad").val(valorCantidad);
            $("#FORM_ACTION").submit();
        }
    });
    function OpenWarning(mensaje) {
        var mensaje = mensaje || "Algo no salió como se esperaba...";
        bootbox.dialog({
            message: mensaje,
            title: "<i class=\"fa fa-warning warning\"></i>",
            className: "modal modal-message modal-warning fade",
            buttons: {
                "OK": {
                    className: "btn btn-warning",
                    callback: function () {}
                }
            }
        });
    }
</script>
