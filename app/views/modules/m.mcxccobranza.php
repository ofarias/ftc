<div class="row">
    <div class="col-lg-16">
         <div class="col-xs-16 col-md-6">
            <br/><br/>
            <label>&nbsp;&nbsp;Buscar Factura o Remision :</label>&nbsp;&nbsp;<input type="text" name="idp" value="" placeholder="Colocar Documento " id="docv">&nbsp;&nbsp;<input type="button" name="buscar" value="Buscar" class="btn btn-info" id="buscar">
             <div id="resultado">
            </div>
            <div id="o">
            </div>
        </div>
        </div>
       
    </div>

<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>
            <div class="col-md-3">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h4><i class="fa fa-list-alt"></i>CEP desde Edo de Cuenta</h4>
              </div>
              <div class="panel-body">
                  <p>Recuperar CEP</p>
                  <center><a href="index.php?action=edoCta_docs" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
              </div>
          </div>
         </div>
            <?php foreach ($docs as $key){     
                    if($key->STATUS_RECEPCION == 5 ){
                        $status5 = 'Por Recibir';
                        $cantidad5 = $key->DOCUMENTOS;
                    }elseif($key->STATUS_RECEPCION == 6 ){
                        $status6 ='Recibidos';
                        $cantidad6 = $key->DOCUMENTOS;
                    }elseif($key->STATUS_RECEPCION == 7){
                        $status7 = 'Archivos';
                        $cantidad7 = $key->DOCUMENTOS;
                    }elseif ($key->STATUS_RECEPCION == 8) {
                        $status8  = 'Contrarecibo';
                        $cantidad8 = $key->DOCUMENTOS;
                    }elseif ($key->STATUS_RECEPCION == 9) {
                        $status9 = 'Cobranza';
                        $cantidad9 = $key->DOCUMENTOS;
                    }elseif($key->STATUS_RECEPCION == 61){
                        $status10 = 'Recibidos';
                        $cantidad10 = $key->DOCUMENTOS;
                    }
                }
            ?>                
            <?php 
                $cantidad5 = isset($cantidad5)? (int)$cantidad5:0;
                $cantidad6 = isset($cantidad6)? (int)$cantidad6:0;
                $cantidad7 = isset($cantidad7)? (int)$cantidad7:0;
                $cantidad8 = isset($cantidad8)? (int)$cantidad8:0;
                $cantidad9 = isset($cantidad9)? (int)$cantidad9:0;
                $cantidad10 = isset($cantidad10)? (int)$cantidad10:0;
                $sinAvanzar = $cantidad5 + $cantidad6 + $cantidad10;
            ?>

            <?php if($usuario =='Eli cxcc'){?>
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
                        <h4><i class="fa fa-list-alt"></i> Inventario Fisico Empaque </h4>
                    </div>
                    <div class="panel-body">
                        <p>Inventario Fisico (<font color= 'blue' size="3pxs"> <?php echo count($cajas)?></font>) Cajas</p>
                        <center><a href="index.php?action=invPatio" class="btn btn-default"><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <?php }?>          

            <?php if ($tipoUsuario !='G' and substr($tipoUsuario, 0,1) ==  'C'){ ?>

            <?php foreach($cobranza as $d):?>
                 <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Documentos Con Contarrecibo</h4>
                    </div>
                    <div class="panel-body">
                        <p>Documentos con Contrarecibo</p>
                        <p>Cantidad: <font color="red"><?php echo $cantidad7?></font> </p>
                        <center><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=7" class="btn btn-default"><img src="app/views/images/User-Files-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cobranza General  </h4>
                    </div>
                    <div class="panel-body">
                        <p title="Incluye Extra Judicial"><a href="index.cobranza.php?action=detalleCobranza&tipo=semanal" target="blank" >Cobranza Total:  <?php echo '$ '.number_format($d->COBRANZA,2)?></a></p>
                        <p><a href="index.cobranza.php?action=detalleCobranza&tipo=semanal">Vencido 7 dias: <?php echo '$ '.number_format($d->SEMANA,2)?></a></p>
                        <p><a href="index.cobranza.php?action=detalleCobranza&tipo=semanal">Vencido 8  a 28 dias: <?php echo '$ '.number_format($d->MES,2)?></a></p>
                        <p><a href="index.cobranza.php?action=detalleCobranza&tipo=semanal">Extra Judicial 2018: <?php echo '$ '.number_format($d->EJ,2)?></a></p>
                        <center></center>
                    </div>
                </div>
            </div>
         <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Imprimir Polizas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Imprimir Relacion de Pago</p>
                        <center><a href="index.php?action=buscaPagosActivos" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div> 
            <?php endforeach;?>
             <?php if(count($prefacturas)>0){?>
            <div class="col-md-3">
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
            <div class="col-md-3">
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
        <?php }elseif($tipoUsuario != 'G' and substr($tipoUsuario,0,1) ==  'R'){?>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Docs Recibidos Sin Contrarecibo</h4>
                    </div>
                    <div class="panel-body">
                        <p>Recibir Documentos</p>
                        <p><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" ><?php echo (isset($status10))? '':$status10.': <font color="green" size="3pxs">'.$cantidad10.'</font>'?></a></p>
                        <p><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" ><?php echo 'Pendientes de Recibir: <font color="red" size="3.pxs">'.$cantidad6.'</font>'?></a></p>
                        <p><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" ><?php echo 'Total en Contrarecibo: <font color="red" size="3.pxs">'.( (int)$cantidad10+ (int)$cantidad6) .'</font>'?></a></p>
                        <!--<center><a href="index.php?action=seguimientoCajasRecibir&tipo=6" class="btn btn-default"><img src="app/views/images/folder-invoices-icon.png"></a></center>-->
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Documentos Con Contarrecibo</h4>
                    </div>
                    <div class="panel-body">
                        <p>Documentos con Contrarecibo</p>
                        <p>Cantidad: <font color="red"><?php echo $cantidad7?></font> </p>
                        <center><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=7" class="btn btn-default"><img src="app/views/images/User-Files-icon.png"></a></center>
                    </div>
                </div>
            </div>
             <?php if(count($prefacturas)>0){?>
            <div class="col-md-3">
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
            <div class="col-md-3">
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
        <?php }else{ ?>
            <?php foreach($cobranza as $d):?>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cobranza <br/>General</h4>
                    </div>
                    <div class="panel-body">
                        <p title="Incluye Extra Judicial"><a href="index.cobranza.php?action=detalleCobranza&tipo=general"  target="blank">Cobranza Total:  <?php echo '$ '.number_format($d->COBRANZA,2)?></a></p>
                        <p><a href="index.cobranza.php?action=detalleCobranza&tipo=semanal">Vencido 7 dias: <?php echo '$ '.number_format($d->SEMANA,2)?></a></p>
                        <p><a href="index.cobranza.php?action=detalleCobranza&tipo=semanal">Vencido 8  a 28 dias: <?php echo '$ '.number_format($d->MES,2)?></a></p>
                        <p><a href="index.cobranza.php?action=detalleCobranza&tipo=ej">Extra Judicial 2018: <?php echo '$ '.number_format($d->EJ,2)?></a></p>
                        <center></center>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
              <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cobranza </h4>
                    </div>
                    <div class="panel-body">
                        <p>Cobranza</p>
                        <center><a href="index.cobranza.php?action=cobranza" class="btn btn-default"></a></center>
                    </div>
                </div>
            </div>
        <?php if(count($prefacturas)>0){?>
            <div class="col-md-3">
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
            <div class="col-md-3">
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
                        <h4><i class="fa fa-list-alt"></i> FOLIOS DE FACTURACION </h4>
                    </div>
                    <div class="panel-body">
                        <p>Logistica / Bodega / CxC </p>
                        <center><a href="index.php?action=seguimientoCajas" class="btn btn-default"><img src="app/views/images/Clipboard-Paste-icon.png"></a></center>
                    </div>
                </div>
            </div>
              <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ver Consecutivo de Facturas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Facturas </p>
                        <center><a href="index.php?action=verFolioFacturas" class="btn btn-default"><img src="app/views/images/users.png"></a></center>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Realizar Notas de Credito</h4>
                    </div>
                    <div class="panel-body">
                        <p>Notas de Credito y Refacturaciones </p>
                        <center><a href="index.php?action=buscaFacturaNC" class="btn btn-default"><img src="app/views/images/Clipboard-Paste-icon.png"></a></center>
                    </div>
                </div>
            </div> 
             
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ver Solicitudes de Liberacion.</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Solicitudes de Liberacion</p>
                        <center><a href="index.php?action=verCotPenLib" class="btn btn-default"><img src="app/views/images/Clipboard-Paste-icon.png"></a></center>
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
                        <p><?php echo (!isset($status10))? '':$status10.': <font color="green" size="3pxs">'.$cantidad10.'</font>'?></p>
                        <?php if(isset($status5)){?>
                            <p><?php echo 'Finalizados Logistica: <font color="red" size="3.pxs">'.$cantidad5.'</font>'?></p>
                        <?php }?>

                        <p><?php echo 'Pendientes de Recibir: <font color="red" size="3.pxs">'.$cantidad6.'</font>'?></p>
                        <p><?php echo 'Total Sin Avanzar: <font color="red" size="3.pxs">'.$sinAvanzar.'</font>'?></p>
                        <center><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=6" class="btn btn-default"><img src="app/views/images/folder-invoices-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Documentos Con Contarrecibo</h4>
                    </div>
                    <div class="panel-body">
                        <p>Documentos con Contrarecibo</p>
                        <p>Cantidad: <font color="red"><?php echo $cantidad7?></font> </p>
                        <center><a href="index.cobranza.php?action=seguimientoCajasRecibir&tipo=7" class="btn btn-default"><img src="app/views/images/User-Files-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Documentos Recibidos en Cobranza</h4>
                    </div>
                    <div class="panel-body">
                        <p>Documentos Listos para Cobrar</p>
                        <p>Cantidad: <font color="red"><?php echo $cantidad8?></font> </p>
                        <center><a href="index.php?action=seguimientoCajasRecibir&tipo=8" class="btn btn-default"><img src="app/views/images/pesos.png"></a></center>
                    </div>
                </div>
            </div>
        
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Recibir Documentos desde Revisión.</h4>
                    </div>
                    <div class="panel-body">
                        <p>Recibir Documentos</p>
                        <center><a href="index.php?action=RecibirDocsRevision" class="btn btn-default"><img src="app/views/images/Clipboard-Paste-icon.png"></a></center>
                    </div>
                </div>
            </div> 
            
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Crear Ruta Cobranza</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verCxCRutas" class="btn btn-default"><img src="app/views/images/Documents-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Rutas Activas</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verRutasVigentes" class="btn btn-default"><img src="app/views/images/Documents-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Resultado de Rutas</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verRutasFinalizadas" class="btn btn-default"><img src="app/views/images/Documents-icon.png"></a></center>
                    </div>
                </div>
            </div>
        -->
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Catálogo de requisitos.</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=catalogo_documentos" class="btn btn-default"><img src="app/views/images/Documents-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Maestros y CARTERAS</h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verMaestros" class="btn btn-default"><img src="app/views/images/Documents-icon.png"></a></center>
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
            
            <!--
              <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cartera Cobranza </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=CCobranza" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div>
            -->
            <!--- DESABILITADO EL 28 DE MAYO DEL 2018 POR OSCAR FARIAS
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Cobranza.</h4>
                    </div>
                    <div class="panel-body">
                        <p>Catalogo de cobranza.</p>
                        <center><a href="index.php?action=CarteraCobranza" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div> 
        -->
            <!--
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Rastreador de Facturas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Buscar Facturas.</p>        
                     <center><a href="index.php?action=buscaFacturas" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>

             <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Cierre Cartera</h4>
                    </div>
                    <div class="panel-body">
                        <p>Cierre de Cartera.</p>        
                     <center><a href="index.php?action=SMCarteraCobranza" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
            
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Carga de Pagos.</h4>
                    </div>
                    <div class="panel-body">
                        <p>CARGA DE PAGOS</p>
                        <center><a href="index.php?action=listaClientes" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div> 
-->
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Imprimir Aplicaciones</h4>
                    </div>
                    <div class="panel-body">
                        <p>Imprimir aplicaciones de Pago</p>
                        <center><a href="index.php?action=verAplicaciones" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div>
          
             <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Imprimir Polizas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Imprimir Relacion de Pago</p>
                        <center><a href="index.php?action=buscaPagosActivos" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div> 
            <!--  
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Aplicaciones a Facturas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Relacion de Pagos vs facturas</p>
                        <center><a href="index.php?action=verAplivsFact" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div> 
            -->
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Registro de Cargos Financieros </h4>
                    </div>
                    <div class="panel-body">
                        <p></p>        
                     <center><a href="index.php?action=regCargosFinancieros" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
               <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Asociar Cargo Financiero a Pago</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>        
                     <center><a href="index.php?action=asociaCF" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Enviar a Acreedor</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>        
                     <center><a href="index.php?action=verPagosConSaldo" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>

            -->
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> CAPTURA DE ABONOS</h4>
                    </div>
                    <div class="panel-body">
                        <p>Captura de Abonos</p>
                        <center><a href="index.php?action=selectBanco" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <!--
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Cancelacion de aplicaciones</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>   
                        <center><a href="index.php?action=buscaPagos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
            -->

            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Aplicaciones Directas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Asociar Aplicaciones Directas</p>
                        <center><a href="index.php?action=buscaPagosActivos" class="btn btn-default"><img src="app/views/images/dollar-collection-icon.png"></a></center>
                    </div>
                </div>
            </div> 
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Preparar Cierre Contabilidad</h4>
                    </div>
                    <div class="panel-body">
                        <p>Pagos Registrados</p>   
                        <center><a href="index.php?action=verCargaPagosCXC" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
        </div>
<?php  }?>    
    </div>  
</div>

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script type="text/javascript">
     $("#buscar").click(function(){
            var id = document.getElementById("docv").value;
            if(id ==""){
                alert("Favor de capturar un documento.");
            }else{
                $.ajax({
                    url:'index.php',
                    type:'post',
                    dataType:'json',
                    data:{buscaDocv:id},
                    success:function(data){
                        var seg;
                        if(data.st == 'no'){
                            var s = '<font color="red"> No se encontro informacion del documento:  </font>';
                            var mensaje = id;
                        }else if(data.st == 'ok'){
                            var ventana = "'width=1800,height=1200'";
                            var s = 'Se encontro la informacion: ';
                            var mes = data.fechaCaja.substring(5,7);;
                            var anio = data.fechaCaja.substring(0,4);
                            var dia = data.fechaCaja.substring(8,10);
                            var seg ='<a href="index.php?action=seguimientoCajasDiaDetalle&anio='+ anio + '&mes='+ mes +'&dia='+ dia+'"  class="btn btn-info" target="popup" onclick="window.open(this.href, this.target,'+ ventana +' ); return false;" > Ver Seguimiento de Documentos </a>';
                            var mensaje = '<br/>Caja: ' + data.caja + '<br/> fecha del consecutivo: ' + data.fechaCaja + seg +'<br/> Status logistica: ' + data.logistica + '<br/> Status de la caja: ' + data.status;
                        }
                        var midiv = document.getElementById('resultado');
                         midiv.innerHTML = "<br/><p><font size='5pxs' color='blue'>&nbsp;&nbsp; " + s + " </font> <font size='5pxs' color='red'>"+ mensaje + "</font></p>";
                        //("status"=>'ok',"resultado"=>'ok', "idstatus"=>$status, "idprov"=>'('.$proveedor.')'.$nomprov,"ordenado"=>$ordenado,"rec_faltante"=>$faltante,  "idpalterno"=>'('.$cvealt.')'.$nomalt,"Ordenes"=>$data);
                    }
                });
            }
        });


</script>
    