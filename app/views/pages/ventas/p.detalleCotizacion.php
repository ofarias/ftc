<br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="height: 40px">
                <div class="col-sm-10">
                    Cotizaci&oacute;n
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
                    <form id="FORM_UPDATE_PEDIDO" method="POST" action="index.v.php">
                        <label for="pedido">Pedido: </label>
                        <input type="text" id="pedido" name="pedido" style="width:90px" value="<?php echo $data->IDPEDIDO; ?>" maxlength='20' />
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
<br/>
<div class="col-sm-2">
    <a class="btn btn-info" href="index.v.php?action=consultarCotizacion">REGRESAR</a> &nbsp;&nbsp;&nbsp; <button onclick="refrescar()">Refrescar</button>
</div>
<br/>
<br/>
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
                                <th>COSTO <br/> CERTIFICADO</th>
                                <th>PRECIO <br/> SUGERIDO</th>
                                <th>UTILIDAD % </th>
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
                                $costo = $data->DBIMPCOS;
                                $utilidad = number_format(((round($precio,2)-round($costo,2)) / round($costo,2)) * 100);
                                $descuento = $data->DBIMPDES;
                                $desc = round(($data->DBIMPDES / 100) +1,3);
                                $desc = ($precio * $desc)-$precio; 
                                $subtotalPartida = round((round($cantidad * $precio, 2) - round($cantidad * $desc, 2)), 2);
                                $impuestoPartida = round(($subtotalPartida * .16), 2);
                                $totalPartida = $subtotalPartida + $impuestoPartida;
                                ?>
                                <tr class="odd gradeX">
                                    <td><a href="index.v.php?action=quitarPartida&folio=<?php echo $folio ?>&partida=<?php echo $partida ?>">quitar</a></td>
                                    <td><a class="focus button" href="index.v.php?action=consultaArticulo&folio=<?php echo $folio ?>&partida=<?php echo $partida ?>&clave=<?php echo $cliente; ?>">
                                    <?php echo $data->CVE_ART;?> <br/> Modelo: <?php echo $data->CLAVE_PROD?> </a></td>
                                    <td><?php echo $data->DESCR;?> </td>
                                    <td><?php echo $cantidad; ?></td>
                                    <td align="right"><?php echo '$ '.number_format($data->DBIMPCOS,2); ?></td>
                                    <td align="right"><?php echo '$ '.number_format($precio, 2, '.', ','); ?> <br/> <a href="index.v.php?action=solicitarMargenBajo&folio=<?php echo $folio?>&partida=<?php echo $data->CVE_ART?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Solicitar Margen Bajo</a></td>
                                    <td align="right"><?php echo  $utilidad.' %'?></td>
                                    <td align="right"><?php echo '% '.number_format($descuento, 2, '.', ','); ?></td>                                            
                                    <td align="right"><?php echo '$ '.number_format($subtotalPartida, 2, '.', ','); ?></td>
                                    <td align="right"><?php echo '$ '.number_format($impuestoPartida, 2, '.', ','); ?></td>         
                                    <td align="right"><?php echo '$ '.number_format($totalPartida, 2, '.', ','); ?></td>                                                        
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
                <form id="FORM_ACTION" method="GET" action="index.v.php">
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

    function refrescar(){
        window.reload(true);
    }
</script>