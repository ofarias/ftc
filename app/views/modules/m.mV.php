<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <div>
                <label> Bienvenido: <?php echo $usuario?></label>
            </div>
            <br/>
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
             
            <div class="col-md-2">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4>Crear Pedido</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.v.php?action=consultarCotizacion" class="btn btn-default"><img class="img-ico" src="app/views/images/Ventas/CrearPedido.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div> 
            <div class="col-md-2">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4>Cajas y Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=verCajasAlmacen" class="btn btn-default"><img class="img-ico" src="app/views/images/Ventas/LiberarPedido.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>  
             <div class="col-md-2">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4>Ventas x Mes</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.v.php?action=cajas" class="btn btn-default"><img class="img-ico" src="app/views/images/Ventas/VentasMes.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4>Imprimir Facturas</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=imprimeXML" class="btn btn-default"><img class="img-ico" src="app/views/images/Ventas/ImpFact.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4>Reporte de Ventas</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.v.php?action=repVentas" class="btn btn-default"><img class="img-ico" src="app/views/images/Ventas/RepVentas.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
           <div class="col-md-2">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4>Ventas de Mostrador</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.v.php?action=ventasMostrador" class="btn btn-default"><img class="img-ico" src="app/views/images/Ventas/RepVentas.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Solicitudes de Margen Bajo </h4>
                    </div>
                    <div class="panel-body">
                        <p>Definir Margen Bajo</p>
                        <center><a href="index.v.php?action=verSMB" class="btn btn-default"><img src="app/views/images/users.png"></a></center>
                    </div>
                </div>
            </div>    
            <?php if($letra == 'G'){?>
                <div class="col-xs-12 col-md-3">
                <div class="panel panel-default cu-panel-clie">
                    <div class="panel-heading">
                        <h4>Realizar Notas de Credito</h4>
                    </div>
                    <div class="panel-body">
                        <p>Notas de Credito y Refacturaciones </p>
                        <center><a href="index.php?action=buscaFacturaNC" class="btn btn-default"><img class="img-ico" src="app/views/images/Clipboard-Paste-icon.png"></a></center>
                    </div>
                </div>
            </div> 
            <?php }?>
        </div>
    </div>
    