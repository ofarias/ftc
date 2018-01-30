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
                        <h4><i class="fa fa-list-alt"></i> Status Orden</h4>
                    </div>
                    <div class="panel-body">
                        <p>Alta de Unidades</p>
                        <center><a href="index.php?action=buscaOC2" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
                    </div>
                </div>
            </div>
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
                        <h4><i class="fa fa-list-alt"></i> Abrir Caja</h4>
                    </div>
                    <div class="panel-body">
                        <p>Abrir Caja </p>
                        <center><a href="index.php?action=abrirCajaBodega" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Inventario Patio</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Inventario Patio (<font color= 'blue' size="3pxs"> <?php echo count($cajas)?></font>) Cajas</p>
                        <center><a href="index.php?action=invPatio" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Vales Patio</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver <font size="3pxs" color="red"><?php echo $vales->VALES?></font> Vales Patio con valor de: <font color="red" size="3pxs"><?php echo '$ '.number_format($vales->MONTO,2)?> </font></p>
                        <center><a href="index.php?action=verValesPatio" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>

            <?php if($usuario == 'Alejandro Perla'){?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i>Ver Deudores</h4>
                        </div>
                        <div class="panel-body">
                            <p>Ver Deudores</p>   
                            <center><a href="index.php?action=verDeudores" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                        </div>
                    </div>
                </div>
                <?php }?>  
        </div>
    </div>
    