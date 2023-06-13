<br /><br />
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="index.v.php?action=consultarCotizacion"><div class="glyphicon"><img src="app/views/images/boxes-brown-icon.png" width="24px"/></div></a>&nbsp;&nbsp;&nbsp;&nbsp;Cotizaciones
            </div>
        </div>
    </div>
</div>

<div>
    <label>Copiar Cotizacion</label><br/>
    <label>Cotizacion Original: </label>&nbsp;&nbsp;<input type="text" name="cotizacionOriginal" maxlength="10" id="cotOriginal"> &nbsp;&nbsp;<a onclick="clonar()" class="btn btn-success" >Copiar</a>
</div>
<br/>

<div class="row">
    <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">              
            <div class="panel-heading"><b>Panel de b&uacute;squeda.</b></div>
        </div>
        <div class="panel col-lg-12">
            <form action="index.v.php" method="POST" id="FORM_SEARCH">
                <div class="col-lg-2">
                    <label for="buscar_folio">Folio:</label>
                    <input type="text" name="busca_folio" id="busca_folio" value="" class="text" maxlength="6" style="width: 60px" />
                </div>
                
                <div class="col-lg-2">
                    <label for="buscar_folio">RFC: </label>
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
                <a id="ver_cerradas" href="index.v.php?action=consultarCotizacion&cerradas=si" class="button">Ver cerradas</a>
            </div>
        </div>
    </div>
    </div>
</div>

<?php if(count($exec) > 0){?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">                               
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-cotizaciones">
                        <thead>
                            <tr>                                            
                                <th>DOCUMENTO</th>
                                <th>CLIENTE</th>
                                <th>NOMBRE</th>
                                <th>RFC  <br/> Productos</th>
                                <th>SALDO CORRIENTE /<br/> VENCIDO </th>
                                <th>FECHA</th>
                                <th>PEDIDO</th>
                                <th>Importe</th>
                                <th>ESTATUS</th>
                                <th>Cambiar de cliente&nbsp;</th>
                                <th>Cancelar cotizaci&oacute;n&nbsp;</th>
                                <th>Urgencia / Lib Credito</th>
                                <th>Generar cotizaci&oacute;n&nbsp;</th>
                            </tr>
                        </thead>   
                        <tbody>
                            <?php                                       
                            foreach ($exec as $data):
                            $saldo = $data->SALDO_VENCIDO; 
                            $skus = $data->SINSKUS;   
                            $test = '';
                            $control = 0;
                            if(($data->RFC == 'SUB910603SB' or $data->RFC == 'DLI83051718') and $data->ADDENDA==''){
                                $test="<font color='red'>El Cliente Requiere Addenda y no  esta configurada, favor de reportar a CxC.</font>";
                                $control = 1;
                            }
                            ?>
                            <tr class="odd gradeX">                                            
                                <td>
                                <?php if($data->ESTATUS == 'PENDIENTE'){?>
                                <a class="glyphicon glyphicon-pencil" href="index.v.php?action=verDetalleCotizacion&folio=<?php echo $data->FOLIO;?>" style="color:#245269;"></a>
                                <?php } ?>
                                &nbsp;&nbsp; <?php echo $data->SERIE.$data->FOLIOL;?></td>
                                <td><?php echo $data->CLIENTE;?>
                                        <br/>
                                        <a href="index.v.php?action=verSKUS&cliente=<?php echo $data->CLIENTE?>&cdfolio=<?php echo $data->FOLIO?>"   target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Capturar SKUS </a>   
                            
                                </td>
                                <td><?php echo $data->NOMBRE;?><br/><?php echo $test?></td>
                                <td><?php echo $data->RFC.'<br/>'.$data->PRODUCTOS;?> </td>
                                <td align="right"><?php echo '$ '.number_format($data->SALDO_CORRIENTE,2)?> <br/> <?php echo '$ '.number_format($data->SALDO_VENCIDO,2)?></td>
                                <td><?php echo $data->FECHA;?></td>
                                <td><?php echo $data->IDPEDIDO;?></td>
                                <td align="right"><?php echo '$ '.number_format($data->TOTAL,2)?></td>
                                <td><?php echo $data->ESTATUS;?></td>
                                <?php if(strtoupper($data->ESTATUS)=='PENDIENTE' or $data->ESTATUS == 'LIBERADO'){ ?>
                                <td>
                                <?php if($data->ESTATUS == 'PENDIENTE'){?>
                                <a class="glyphicon glyphicon-copy" href="index.v.php?action=cambiaCliente&folio=<?php echo $data->FOLIO;?>" style="color:#245269;">&nbsp;<br/><font color ="blue">Cambia Cliente</font></a>
                                <?php }?>
                                </td>
                                <td>
                                <a class="glyphicon glyphicon-eject" href="index.v.php?action=cancelarCotizacion&folio=<?php echo $data->FOLIO;?>" style="color:#245269;">&nbsp;<br/><font color ="red">Cancelar</font></a> 
                                </td>
                                
                                <input type="hidden" id="saldo" name="saldo" value="<?php echo $saldo?>">
                                <td>
                                    <?php if($data->URGENTE =='No'){?>
                                    <a class="glyphicon glyphicon-magnet" style="color:#245269;" href="index.v.php?action=marcarUrgente&folio=<?php echo $data->FOLIO?>"> <br/><labe>Urgente</labe></a>
                                    <?php }?>
                                  
                                    <?php if($data->SALDO_VENCIDO >= 1 AND $data->ESTATUS == 'PENDIENTE'){?>
                                    /
                                    <a class="glyphicon glyphicon-usd" style="color:#245269;" href="index.v.php?action=solLiberacion&folio=<?php echo $data->FOLIO?>&cliente=<?php echo $data->CLIENTE?>"></a>
                                    <?php } ?>
                                </td>
                                <td>
                                <a class="glyphicon glyphicon-print" style="color:#245269;" href="index.php?action=verPedido&folio=<?php echo $data->FOLIO;?>"><br/>Impresion</a>

                                <a onClick="test1(<?php echo $data->FOLIO?>,<?php echo $skus?>, <?php echo $control?>)" id="cotiza_<?php echo $data->FOLIO?>" 
                                class="glyphicon glyphicon-briefcase" style="color:#245269;" 
                                <?php echo (($data->SALDO_VENCIDO >0 and $data->ESTATUS =='PENDIENTE') OR $skus > 0 or $control == 1) ? '':"href='index.v.php?action=avanzaCotizacion&folio=$data->FOLIO'" ?>  

                                <?php echo ($data->SALDO_VENCIDO >0 and $data->ESTATUS =='PENDIENTE')? 'onclick="restriccion()"':''?> >&nbsp;<br/>Crear Pedido  </a>
                                </td>

                                <!--  href="index.v.php?action=avanzaCotizacion&folio=<?php echo $data->FOLIO;?>  <?php echo ($data->SALDO_VENCIDO = 0 )? 'onclick="restriccion()"':''?>" -->
                                <?php } else { ?>
                                    <td>-</td>
                                    <td><a  class="glyphicon glyphicon-eject" href="index.v.php?action=cancelarCotizacion&folio=<?php echo $data->FOLIO;?>" style="color:#245269;">&nbsp; </a></td>
                                    <td><a class="glyphicon glyphicon-print" style="color:#245269;" href="index.php?action=verPedido&folio=<?php echo $data->FOLIO;?>"></a></td>
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
<?php }?>
 <form action="index.v.php" method="POST" id="FORM_ACTION">
                    <input type="hidden" name="generaNuevaCotizacion" value="true" />
                </form>
<div class="row">
    <div class="col-sm-2">
        <input type="button" name="nuevaCotizacion" id="nuevaCotizacion" class="btn-success " value="Nueva Cotizacion" />
    </div>
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>   
<script type="text/javascript" language="JavaScript" src="app/views/bower_components/jquery/dist/jquery.min.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

$("#nuevaCotizacion").click(function (event){    
     $("#FORM_ACTION").submit();
});

function clonar(){
    var cotizacion = document.getElementById('cotOriginal').value;
        $.ajax({
            type:"POST",
            url:"index.v.php",
            dataType:"json",
            data:{copiarCotizacion:cotizacion},
            success: function(data){
                if(data.status == 'ok'){
                    alert('OK');
                     if(confirm('Estas seguro que quieres copiar la cotizacion'+ cotizacion + ', del cliente ' + data.cliente)){
                                $.ajax({
                                    type: "POST",
                                    url:"index.v.php",
                                    dataType: "json",
                                    data : {copiar:cotizacion},
                                    success: function(data){
                                        if(data.status== 'ok'){
                                            alert('Se creo la cotizacion ' + data.nueva + ', con ' + data.productos + ' partidas; Favor de capturar el numero de pedido del cliente ');
                                            window.location.reload(true);
                                        }else{
                                            alert('No se creo la cotizacion, reporte a sistemas');
                                            //window.location.reload(true);
                                        }
                                    }
                                });
                            }
                    }else{
                        alert('La cotizacion "' + cotizacion + '" no existe, favor de seleccionar una Cotizacion valida.');
                    }
            },
            error: function(data){
                alert('Sucedio un error, revise la informacion');
            }
        })
}

function test1(a, n, c){
    //var x = document.getElementById('cotiza');
    //document.getElementById('button-id').classList.add('hide');
    if(n >0 && c == 0){
        alert('Aun hay ' + n + ' sku(s), pendientes de capturar.');    
    }else if (c = 1){
        alert('El cliente debe de tener la addenda para continuar.');
    }else{
        document.getElementById('cotiza_'+a).classList.add('hide');
    }
}

function cancelar(id){
    OpenWarning("Por el momento no se puede ejecutar esta acción");
}

function generar(id){
    
}

function restriccion(saldo){
    var s = document.getElementById("saldo").value;
    OpenWarning("No se puede generar el pedido, debido a que el cliente tiene "+ s +" saldo vencido, favor de Solicitar un incremento de linea o comunicarse con Cuentas x Cobrar, Gracias...");
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