<br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="height: 40px">
                <div class="col-sm-10">
                    Cotizaci&oacute;n
                </div>
                <div class="col-sm-2">
                    <a class="focus button btn-link" href="index.php?action=consultarCotizacion">REGRESAR</a>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <?php
                $subtotal = 0.0;
                $impuesto = 0.0;
                $total = 0.0;
                $cliente = "";
                foreach ($cabecera as $data):
                    $cliente = $data->CVE_CLIENTE;
                    $folio = $data->CDFOLIO;
                    ?>
                    <div class="col-sm-3">
                        <label for="folio">Folio: </label>
                        <label id="folio" style="width:90px"><?php echo $data->CDFOLIO; ?></label>
                    </div>
                    <div class="col-sm-7">
                        <label for="cliente">Cliente: </label>
                        <label id="cliente" style="width:400px"><?php echo $data->NOMBRE; ?></label>
                    </div>
                    <div class="col-sm-2">
                        <label for="fecha">Fecha: </label>
                        <label id="fecha" style="width:90px"><?php echo $data->FECHA; ?></label>
                    </div>
                    <div class="col-sm-3">
                        <label for="palabra">Palabra: </label>
                        <label id="palabra" style="width:90px"><?php echo $data->DSIDEDOC; ?></label>
                    </div>
                    <div class="col-sm-7">
                    <form id="FORM_UPDATE_PEDIDO" method="POST" action="index.php">
                        <label for="pedido">Pedido: </label>
                        <input type="text" id="pedido" name="pedido" style="width:90px" value="<?php echo $data->IDPEDIDO; ?>" />
                        <input type="hidden" id="pedido_folio" name="folio" value="<?php echo $folio;?>" />
                        <input type="submit" id="actualiza_pedido" name="actualizaPedido" value="Actualizar" />
                    </form>
                    </div>
                    <div class="col-sm-2">
                        <label for="estatus">Estatus: </label>
                        <label id="estatus" style="width:90px"><?php echo $data->INSTATUS;?></label>
                    </div>

                    <div class="col-sm-12">    
                        <label for="lugarEntrega">Lugar de entrega: </label>
                        <label id="lugarEntrega"><?php echo $data->DSENTREG;?></label>
                    </div>
                    <div class="col-sm12">
                        <label for="planta">Planta: </label>                            
                        <label id="planta"><?php echo $data->DSPLANTA;?></label>
                    </div>
                    <?php
                    $subtotal = $data->DBIMPSUB;
                    $impuesto = $data->DBIMPIMP;
                    $total = $data->DBIMPTOT;
                endforeach;
                ?>
            </div>
        </div>
    </div>
</div>
<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Partidas
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-usuarios1">
                        <thead>
                            <tr>            
                                <th>&nbsp;</th>
                                <th>ARTICULO</th>
                                <th>DESCRIPCION</th>
                                <th>CANTIDAD</th>
                                <th>COSTO</th>
                                <th>PRECIO</th>
                                <th>DESCUENTO</th>
                                <th>SUBTOTAL</th>
                                <th>IMPUESTO</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>                                   
                        <tbody>
                            <?php
                            foreach ($detalle as $data):
                                $partida = $data->CVE_ART;
                                $cantidad = $data->FLCANTID;
                                $precio = $data->DBIMPPRE;
                                $descuento = $data->DBIMPDES;
                                $subtotalPartida = round((round($cantidad * $precio, 2) - round($cantidad * $descuento, 2)), 2);
                                $impuestoPartida = round(($subtotalPartida * .16), 2);
                                $totalPartida = $subtotalPartida + $impuestoPartida;
                                ?>
                                <tr class="odd gradeX">
                                    <td><a href="index.php?action=quitarPartida&folio=<?php echo $folio ?>&partida=<?php echo $partida ?>">Quitar</a></td>
                                    <td><a class="focus button" href="index.php?action=consultaArticulo&folio=<?php echo $folio ?>&partida=<?php echo $partida ?>&clave=<?php echo $cliente; ?>"><?php echo $data->CVE_ART; ?></a></td>
                                    <td><?php echo $data->DESCR; ?></td>
                                    <td><?php echo $cantidad; ?></td>
                                    <td><?php echo $data->DBIMPCOS; ?></td>
                                    <td><?php echo number_format($precio, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($descuento, 2, '.', ','); ?></td>                                            
                                    <td><?php echo number_format($subtotalPartida, 2, '.', ','); ?></td>
                                    <td><?php echo number_format($impuestoPartida, 2, '.', ','); ?></td>         
                                    <td><?php echo number_format($totalPartida, 2, '.', ','); ?></td>                                                        
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-10">
                            <input type="button" name="nuevaParida" id="nuevaPartida" class="button" value="Nueva Partida" />
                        </div>
                        <div class="col-sm-1">
                            <label for="subtotal">Subtotal: </label>
                            <br />
                            <label for="impuesto">Impuesto: </label>
                            <br />
                            <label for="total">Total: </label>
                        </div>
                        <div class="col-sm-1">
                            <div class="pull-right"> 
                                <label id="subtotal"><?php echo number_format($subtotal, 2, '.', ','); ?></label>
                                <br />
                                <label id="impuesto"><?php echo number_format($impuesto, 2, '.', ','); ?></label>
                                <br />
                                <label id="total"><?php echo number_format($total, 2, '.', ','); ?></label>
                            </div>
                        </div>
                    </div>                                
                </div>
                <form id="FORM_ACTION" method="GET" action="index.php">
                    <input type="hidden" name="action" value="consultaArticulo" />
                    <input type="hidden" name="folio" value="<?php echo $folio; ?>" />                                
                    <input type="hidden" name="clave" value="<?php echo $cliente; ?>" />
                </form>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">
    var clave, costo, precio, descuento, cantidad;
    $('#nuevaPartida').click(function(event) {
        $("#FORM_ACTION").submit();
    });
</script>