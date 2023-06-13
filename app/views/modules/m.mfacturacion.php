<div class="container">
    <?php foreach ($docs as $key){
                            $status5='';
                            $status6='';
                            $status7='';
                            $status8='';
                            $status9='';
                            $status10='';
                            $cantidad6=0;
                            $cantidad7=0;
                            $cantidad8=0;
                            $cantidad9=0;
                            $cantidad10=0;
                             if($key->STATUS_RECEPCION < 6 ){
                                $status5 = 'Logistica';
                            }elseif($key->STATUS_RECEPCION == 6){
                                $status6 ='Recibidos';
                                $cantidad6 = $key->COUNT;
                            }elseif($key->STATUS_RECEPCION == 7){
                                $status7 = 'Archivos';
                                $cantidad7 = $key->COUNT;
                            }elseif ($key->STATUS_RECEPCION == 8) {
                                $status8  = 'Contrarecibo';
                                $cantidad8 = $key->COUNT;
                            }elseif ($key->STATUS_RECEPCION == 9) {
                                $status9 = 'Cobranza';
                                $cantidad9 = $key->COUNT;
                            }elseif($key->STATUS_RECEPCION == 61){
                                $status10 = 'Recibidos';
                                $cantidad10 = $key->COUNT;
                            }
                        };?>
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
                            <h4><i class="fa fa-list-alt"></i> Inventario Fisico Empaque </h4>
                        </div>
                        <div class="panel-body">
                            <p>Inventario Fisico (<font color= 'blue' size="3pxs"> <?php echo count($cajas)?></font>) Cajas</p>
                            <center><a href="index.php?action=invPatio" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i> Recoge y Entrega </h4>
                        </div>
                        <div class="panel-body">
                            <p>Facturacion Anticipada</p>
                            <center><a href="index.php?action=verPedidosSinMaterial" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i> FOLIOS DE FACTURACION </h4>
                        </div>
                        <div class="panel-body">
                            <p>Logistica / Bodega / CxC </p>
                            <center><a href="index.php?action=seguimientoCajas" class="btn btn-default"><img src="app/views/images/Clipboard-Paste-icon.png"></a></center>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i> Catálogo de clientes.</h4>
                        </div>
                        <div class="panel-body">
                            <p><br></p>
                            <center><a href="index.php?action=documentos_cliente" class="btn btn-default"><img src="app/views/images/User-Files-icon.png"></a></center>
                        </div>
                    </div>
                </div>   
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"> Imprimir Facturas</i></h4>
                        </div>
                    <div class="panel-body">
                        <p>Impresion de Facturas</p>
                        <center><a href="index.php?action=imprimeXML" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i> Docs Recibidos Sin Contrarecibo</h4>
                        </div>
                        <div class="panel-body">
                            <p>Recibir Documentos</p>
                            <p><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" ><?php echo $status10.': <font color="green" size="3pxs">'.$cantidad10.'</font>'?></a></p>
                            <p><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" ><?php echo 'Pendientes de Recibir: <font color="red" size="3.pxs">'.$cantidad6.'</font>'?></a></p>
                            <p><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" ><?php echo 'Total en Contrarecibo: <font color="red" size="3.pxs">'.( (int)$cantidad10+ (int)$cantidad6) .'</font>'?></a></p>
                            <!--<center><a href="index.php?action=seguimientoCajasRecibir&tipo=6" class="btn btn-default"><img src="app/views/images/folder-invoices-icon.png"></a></center>-->
                        </div>
                    </div>
                </div>
                <?php if(count($prefacturas)>0){?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"> Prefacturas Pendientes</i></h4>
                        </div>
                        <div class="panel-body">
                            <p>Facturar Prefacturas</p>
                            <center><a href="index.php?action=prefacturasPendientes" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                        </div>
                    </div>
                </div>
                <?php }?>
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
                            <h4><i class="fa fa-list-alt"></i> Abrir Caja</h4>
                        </div>
                        <div class="panel-body">
                            <p>Abrir Caja </p>
                            <center><a href="index.php?action=abrirCajaBodega" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    