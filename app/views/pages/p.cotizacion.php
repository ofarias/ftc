<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="index.php?action=consultarCotizacion"><div class="glyphicon"><img src="app/views/images/refresh.png" width="24px"/></div></a>&nbsp;&nbsp;&nbsp;&nbsp;Cotizaciones
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">              
            <div class="panel-heading"><b>Panel de b&uacute;squeda.</b></div>
        </div>
        <div class="panel col-lg-12">
            <form action="index.php" method="POST" id="FORM_SEARCH">
                <div class="col-lg-2">
                    <label for="buscar_folio">Folio:</label>
                    <input type="text" name="busca_folio" id="busca_folio" value="" class="text" maxlength="6" style="width: 60px" />
                </div>
                
                <div class="col-lg-2">
                    <label for="buscar_folio">RFC:</label>
                    <input type="text" name="busca_rfc" id="busca_rfc" value="" class="text" maxlength="13" style="width: 120px" />
                </div>

                <div class="col-lg-4">
                    <label for="buscar_cliente">Cliente:</label>
                    <input type="text" name="busca_cliente" id="busca_cliente" value="" class="text" maxlength="90" style="width: 300px" />
                </div>
                
                <div class="col-lg-2">
                    <input type="submit" name="buscarFolioCotizacion" value="Buscar">
                </div>
            </form>
            
            <div class="col-lg-2 pull-right">
                <a id="ver_cerradas" href="index.php?action=consultarCotizacion&cerradas=si" class="button">Ver cerradas</a>
            </div>
        </div>
    </div>
    </div>
</div>

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">                               
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-cotizaciones">
                        <thead>
                            <tr>                                            
                                <th>FOLIO</th>
                                <th>CLIENTE</th>
                                <th>NOMBRE</th>
                                <th>RFC</th>
                                <th>FECHA</th>
                                <th>PEDIDO</th>
                                <th>ESTATUS</th>
                                <th title="Cambiar de cliente">&nbsp;</th>
                                <th title="Cancelar cotizaci&oacute;n">&nbsp;</th>
                                <th title="Generar cotizaci&oacute;n">&nbsp;</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php                                       
                            foreach ($exec as $data):                                                      
                            ?>
                            <tr class="odd gradeX">                                            
                                <td><a class="glyphicon glyphicon-pencil" href="index.php?action=verDetalleCotizacion&folio=<?php echo $data->FOLIO;?>" style="color:#245269;"></a>&nbsp;&nbsp;<?php echo $data->FOLIO;?></td>
                                <td><?php echo $data->CLIENTE;?></td>
                                <td><?php echo $data->NOMBRE;?></td>
                                <td><?php echo $data->RFC;?></td>
                                <td><?php echo $data->FECHA;?></td>
                                <td><?php echo $data->IDPEDIDO;?></td>
                                <td><?php echo $data->ESTATUS;?></td>
                                <?php if(strtoupper($data->ESTATUS)=='PENDIENTE'){ ?>
                                <td><a class="glyphicon glyphicon-copy" href="index.php?action=cambiaCliente&folio=<?php echo $data->FOLIO;?>" style="color:#245269;">&nbsp;</a></td>
                                <td><a class="glyphicon glyphicon-eject" href="index.php?action=cancelarCotizacion&folio=<?php echo $data->FOLIO;?>" style="color:#245269;">&nbsp;</a></td>
                                
                                <td><a class="glyphicon glyphicon-briefcase" href="index.php?action=avanzaCotizacion&folio=<?php echo $data->FOLIO;?>" style="color:#245269;">&nbsp;</a>
                                </td>
                                <?php } else { ?>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                <?php }?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <form action="index.php" method="POST" id="FORM_ACTION">
                    <input type="hidden" name="generaNuevaCotizacion" value="true" />
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-2">
        <input type="button" name="nuevaCotizacion" id="nuevaCotizacion" class="button" value="Nueva Cotizacion" />
    </div>
</div>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

$("#nuevaCotizacion").click(function (event){    
     $("#FORM_ACTION").submit();
});

function cancelar(id){
    OpenWarning("Por el momento no se puede ejecutar esta acción");
}

function generar(id){
    
}

function OpenWarning(mensaje) {
                var mensaje = mensaje || "Algo no salió como se esperaba...";
                bootbox.dialog({
                    message: mensaje,
                    title: "<i class=\"fa fa-warning warning\"></i>",
                    className: "modal modal-message modal-warning fade",
                    buttons: {
                        "OK": {
                            className: "btn btn-warning",
                            callback: function () {
                            }
                        }
                    }
                });
}

function OpenSuccess(mensaje) {
                var mensaje = mensaje || "Todo bien...";
                bootbox.dialog({
                    message: mensaje,
                    title: "<i class=\"fa fa-check success\"></i>",
                    className: "modal modal-message modal-success fade",
                    buttons: {
                        "OK": {
                            className: "btn btn-success",
                            callback: function () {
                                 window.location="index.php?action=ordcomp";
                            }
                        }
                    }
                });
}
</script>