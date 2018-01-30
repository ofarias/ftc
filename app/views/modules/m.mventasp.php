<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>

             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Liberar Pedido a Produccion </h4>
                    </div>
                    <div class="panel-body">
                        <p>Cajas y Pedidos.</p>
                        <center><a href="index.php?action=verCajasAlmacen" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>

             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Status Orden</h4>
                    </div>
                    <div class="panel-body">
                        
                        <center><a href="index.php?action=buscaOC2" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Crear Pedido</h4>
                    </div>
                    <div class="panel-body">
                        <p>Crear Pedidos</p>
                        <center><a href="index.v.php?action=consultarCotizacion" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Productos </h4>
                    </div>
                    <div class="panel-body">
                        <p>Asignar Clientes y SKU a Productos</p>
                        <center><a href="index.v.php?action=verFTCArticulosVentas" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>

            <?php if($rechazos >= 1){ ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Solicitudes Rechazadas Sin Revisar </h4>
                    </div>
                    <div class="panel-body">
                        <p>Solicitudes rechazadas <?php echo $rechazos?></p>
                        <center><a href="index.php?action=verRechazos" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>
            <?php } ?>            
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Estado de Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        
                        <center><a href="index.php?action=pedimento" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
               <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Buscar Cajas por pedido </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=BuscarCajasxPedido" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Lista de Todos los Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=lista_t_pedidos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Relacion Ids </h4>
                    </div>
                    <div class="panel-body">
                        <p> Reporte </p>
                        <center><a href="index.php?action=IdvsComp" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> PRODUCTOS POR RFC </h4>
                    </div>
                    <div class="panel-body">
                        <p> VENTAS POR RFC</p>
                        <center><a href="index.php?action=ProdRFC" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    