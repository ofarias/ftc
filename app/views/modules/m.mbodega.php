<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <!--<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ver Cajas Almacen</h4>
                    </div>
                    <div class="panel-body">
                        <p>Cajas y Pedidos.</p>
                        <center><a href="index.php?action=verCajasAlmacen" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>-->

             <?php if($login == 'ulisesgb'){?>
              <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Recibir Orden de compra</h4>
                    </div>
                    <div class="panel-body">
                        <p>Recepcion de producto </p>
                        <center><a href="index.php?action=recepcionOC" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <?php }?>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Asignar el Material</h4>
                    </div>
                    <div class="panel-body">
                        <p>Asignar el Material</p>
                        <center><a href="index.php?action=AMaterial" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>

             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Embalaje</h4>
                    </div>
                    <div class="panel-body">
                        <p>Embalar Material</p>
                        <center><a href="index.php?action=embalar" class="btn btn-default"><img src="app/views/images/Packing-1-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Documentar Cajas</h4> 
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=Cajas" class="btn btn-default"><img src="app/views/images/packing-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Facturación Parcial</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=PedidosAnticipados" class="btn btn-default"><img src="app/views/images/Order-history-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Urgencias</h4>
                    </div>
                    <div class="panel-body">
                        <p>Pedidos anticipados de urgencias</p>
                        <center><a href="index.php?action=AnticipadosUrgencias" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Pendientes Por Recibir Urgencias</h4>
                    </div>
                    <div class="panel-body">
                        <p>Pedidos anticipados de urgencias</p>
                        <center><a href="index.php?action=AnticipadosUrgencias" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
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
                        <h4><i class="fa fa-list-alt"></i> Lote Aduana y Nuevas Facturas </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=VerLoteEnviar" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>

          <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Inventario de Empaque</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=VerInventarioEmpaque" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Estado de Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Consulta detalle</p>
                        <center><a href="index.php?action=pedimento" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Buscar Caja para Embalar</h4>
                    </div>
                    <div class="panel-body">
                        <p>Caja para Embalar</p>
                        <center><a href="index.php?action=buscarCajaEmabalar" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
          

               <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Abrir Caja</h4>
                    </div>
                    <div class="panel-body">
                        <p>Abrir Caja </p>
                        <center><a href="index.php?action=abrirCajaBodega" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
            

             <!-- <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>  Preparar pedidos completos</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verPedidosPendientes" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>-->

        </div>
    </div>
    