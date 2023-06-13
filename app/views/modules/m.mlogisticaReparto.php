<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
             <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> FOLIOS DE FACTURACION </h4>
                    </div>
                    <div class="panel-body">
                        <p>Logistica / Bodega / CxC </p>
                        <center><a href="index.php?action=seguimientoCajas" class="btn btn-default">Ver Folios</a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Unidades</h4>
                    </div>
                    <div class="panel-body">
                        <p>Unidades</p>
                        <center><a href="index.php?action=funidades" class="btn btn-default">Ver Unidades</a></center>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Paso 1 Asignacion Unidad</h4>
                    </div>
                    <div class="panel-body">
                        <p><font color="blue"> Paso 1 Asignar</font></p>
                        <center><a href="index.php?action=arutaReparto" class="btn btn-info" <?php echo ($aruta>0 )? '':'disabled'?>> <?php echo '<font color="red">'.$aruta.'</font> Documentos' ?></a>
                        </center>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Asignaciones del día</h4>
                    </div>
                    <div class="panel-body">
                        <p>Rutas asignadas en el día</p>
                        <center><a href="index.php?action=RutasDelDia" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>
        -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Paso 2  Asignacion de Secuencia</h4>
                    </div>
                    <div class="panel-body">
                        <p><font color="blue"> Paso 2 Secuencia</font></p>
                        <center><a href="index.php?action=submenusecRec" class="btn btn-default"  <?php echo ($secuencia>0 )? '':'disabled'?>><?php echo $secuencia?> Rutas</a></center>
                    </div>
                </div>
            </div>
                        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Paso 3 Administrar Rutas</h4>
                    </div>
                    <div class="panel-body">
                        <p><font color="blue"> Paso 3 Administrar</font></p>
                        <center><a href="index.php?action=adminrutaRep" class="btn btn-default" <?php echo ($administrar>0 )? '':'disabled'?>><?php echo $administrar?> Rutas</a></center>
                    </div>
                </div>
            </div>
                <!-- Sub menu para poder asignar la ruta a las unidades -->
           <!-- <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cierre de Rutas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Cierre de Rutas</p>
                        <center><a href="index.php?action=cierrerutaRep" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cierre General x Dia</h4>
                    </div>
                    <div class="panel-body">
                        <p>Cierre General</p>
                        <center><a href="index.php?action=cierrerutagen" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
                 <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cierre diario entrega</h4>
                    </div>
                    <div class="panel-body">
                        <p>Cierre General</p>
                        <center><a href="index.php?action=cierreReparto" class="btn btn-default"><img src="app/views/images/Ecommerce-Delivery-icon.png"></a></center>
                    </div>
                </div>
            </div>
            
                        <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ver Ruta del Dia</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Ruta del Dia</p>
                        <center><a href="index.php?action=verRutaDia" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>
              <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Rutas del Dia</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ruta del Dia X Uniddad</p>
                        <center><a href="index.php?action=subMenuRutaDia" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>  
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ver Recepciones</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=recepciones" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Modificar Estatus Entrega </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verCajasLogistica" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            
        
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento de operadores</h4>
                    </div>
                    <div class="panel-body">
                        <p>Busqueda de operadores</p>
                        <center><a href="index.php?action=RegistroOperadores&formro=1" class="btn btn-default"><img src="app/views/images/Truck-icon.png"></a></center>
                    </div>
                </div>
            </div>
            -->
              <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Buscar Cajas por pedido </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=BuscarCajasxPedido" class="btn btn-default">Busca Cajas</a></center>
                    </div>
                </div>
            </div>
               
            </div>
        </div>
    </div>
    