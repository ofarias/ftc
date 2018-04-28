<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>

            <?php if($user == 'gcompras' and count($solicitudes)>0){?>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Solicitud de Cambio de Costo</h4>
                    </div>
                    <div class="panel-body">
                        <p><?php echo '('.$solicitudes.') Pendienetes' ?></p>
                        <center><a href="index.php?action=verSolCostos" class="btn btn-default"><img src="app/views/images/File-warning-icon.png"></a></center>
                    </div>
                </div>
            </div>

            <?php }?>

            <?php if($aux != 'Si'){?>
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
                        <h4><i class="fa fa-list-alt"></i>Ver Solicitud Cambio Proveedor</h4>
                    </div>
                    <div class="panel-body">
                        <p>Solicitudes</p>
                        <center><a href="index.php?action=verSolProveedor" class="btn btn-default" > <img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Productos Liberados desde Tesoreria</h4>
                    </div>
                    <div class="panel-body">
                        <p>Productos Liberados</p>
                        <center><a href="index.php?action=verProductosLiberados" class="btn btn-default" > <img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>


             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Administracion de Categorias</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Categorias</p>
                        <center><a href="index.php?action=verCategorias" class="btn btn-default" > <img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Administracion de Marcas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Marcas</p>
                        <center><a href="index.v.php?action=verMarcas" class="btn btn-default" > <img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ver Marcas x Categoria</h4>
                    </div>
                    <div class="panel-body">
                        <p>Administrar Marcas x Categoria</p>
                        <center><a href="index.php?action=verCatergoriasXMarcas" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>

       
               <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Cestas Agrupadas </h4>
                    </div>
                    <div class="panel-body">
                        <p>Por Cestas</p>
                        <center><a href="index.php?action=verCestas" class="btn btn-default"><img src="app/views/images/Shopping-basket-full-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!--
                <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Cestas </h4>
                    </div>
                    <div class="panel-body">
                        <p>Por Cestas</p>
                        <center><a href="index.php?action=verOrdCompCesta" class="btn btn-default"><img src="app/views/images/Shopping-basket-icon.png"></a></center>
                    </div>
                </div>
            </div>

              <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Ver e Imprimir Preorden de Compra. </h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver / Imprimir PreOC </p>
                        <center><a href="index.php?action=verPreOC" class="btn btn-default"><img src="app/views/images/Shopping-basket-full-icon.png"></a></center>
                    </div>
                </div>
            </div>

          

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Crear Ordenes de Compra</h4>
                    </div>
                    <div class="panel-body">
                        <p>TODAS LAS CATEGORIAS.</p>
                        <center><a href="index.php?action=ordcomp" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Ver Ordenes de Compra</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ordenes de Compra.</p>
                        <center><a href="index.php?action=verOrdenesCompra" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Catalogo de Inventarios</h4>
                    </div>
                    <div class="panel-body">
                        <p>Inventario Almacen 9.</p>
                        <center><a href="index.php?action=ccompvent" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>

        -->
                      
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Catalogo de Productos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Alta y Edicion de productos</p>
                        <center><a href="index.php?action=catalogoProductosFTC" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ver Solicitudes</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Poductos Solicitados</p>
                        <center><a href="index.php?action=verSolProdVentas" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Lista de Pedidos Pendientes</h4>
                    </div>
                    <div class="panel-body">
                        <p>PEDIDOS PENDIENTES.</p>
                        <center><a href="index.php?action=lista_pedidos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div></a></center>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Lista de Todos los Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>TODOS LOS PEDIDOS.</p>
                        <center><a href="index.php?action=lista_t_pedidos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div></a></center>
                    </div>
                </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos</p>
                        <center><a href="index.php?action=pantalla1&cat=1" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
           <!-- <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Estado de Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>
                        <center><a href="index.php?action=pedimento" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
                </div> 			
			<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Lista de Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>TODOS LOS PEDIDOS.</p>
                        <center><a href="index.php?action=lista_pedidos" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div> 
			<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i>  Ordenes por Categorias:</h4>
                    </div>
                    <div class="panel-body">
                        <p>JARCERIA Y SEGURIDAD INDUSTRIAL / ACEROS Y PERFILES.</p>
                        <center><a href="index.php?action=ordcompCat&cat=2" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>	

			<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i>  Ordenes por Categorias:</h4>
                    </div>
                    <div class="panel-body">
                        <p>PLOMERIA / FERRETERIA / H. MANUAL.</p>
                        <center><a href="index.php?action=ordcompCat&cat=3" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>

			<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i>  Ordenes por Categorias:</h4>
                    </div>
                    <div class="panel-body">
                        <p>ADHESIVOS / CERRAJERIA Y HERRAJES / MEDICION.</p>
                        <center><a href="index.php?action=ordcompCat&cat=4" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>	
			
			<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i>  Ordenes por Categorias:</h4>
                    </div>
                    <div class="panel-body">
                        <p>CONSTRUCCION Y PINTURAS / FIJACION Y SOPORTE.</p>
                        <center><a href="index.php?action=ordcompCat&cat=5" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>

			<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Ordenes por Categorias:</h4>
                    </div>
                    <div class="panel-body">
                        <p>HERRAMIENTA ELECTRICA / ACCESORIOS Y CONSTRUCCION DE HERRAMIENTA / ELECTRICO.</p>
                        <center><a href="index.php?action=ordcompCat&cat=6" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>	
			-->
			<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Orden - URGENCIAS</h4>
                    </div>
                    <div class="panel-body">
                        <p>U R G E N C I A S .</p>
                        <center><a href="index.php?action=ordcompCat&cat=7" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
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
                        <h4><i class="fa fa-list-alt"></i> Detalle de Orden de Compra</h4>
                    </div>
                    <div class="panel-body">
                        <p>Detalle de la O.C.</p>
                        <center><a href="index.php?action=detalleOC" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
            </div>
                <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> REVISION DE OC</h4>
                    </div>
                    <div class="panel-body">
                        <p>ORDENES DE COMPRA</p>
                        <center><a href="index.php?action=ordenes" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Captura de productos</h4>
                    </div>
                    <div class="panel-body">
                        <p> Captura de productos</p>
                        <center><a href="index.php?action=capturaproductos" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> No suministrables</h4>
                    </div>
                    <div class="panel-body">
                        <p>Pedidos no suministrablers</p>
                        <center><a href="index.php?action=VerNoSuministrableCompras" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Catalogo de productos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Catalogo de productos Almacen 10</p>
                        <center><a href="index.php?action=Cat10&alm=10" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
               <div class="panel panel-default">
                   <div class="panel-heading"> 
                       <h4><i class="fa fa-list-alt"></i> Productos POR RFC</h4>
                   </div>
                   <div class="panel-body">
                       <p>Muestra la lista de Productos vendidos a un RFC en Especifico</p>
                       <center><a href="index.php?action=ProdRFC" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                   </div>
               </div>
           </div>

         

            <!--
			 <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos</p>
                        <center><a href="index.php?action=pantalla1&cat=1" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'A'</p>
                        <center><a href="index.php?action=pantalla1&cat=2" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'B'</p>
                        <center><a href="index.php?action=pantalla1&cat=3" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'C'</p>
                        <center><a href="index.php?action=pantalla1&cat=4" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'D'</p>
                        <center><a href="index.php?action=pantalla1&cat=5" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'E Y S'</p>
                        <center><a href="index.php?action=pantalla1&cat=6" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'F'</p>
                        <center><a href="index.php?action=pantalla1&cat=7" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'G'</p>
                        <center><a href="index.php?action=pantalla1&cat=8" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'H'</p>
                        <center><a href="index.php?action=pantalla1&cat=9" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'I'</p>
                        <center><a href="index.php?action=pantalla1&cat=10" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div> 
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'J'</p>
                        <center><a href="index.php?action=pantalla1&cat=11" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'K'</p>
                        <center><a href="index.php?action=pantalla1&cat=12" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'L'</p>
                        <center><a href="index.php?action=pantalla1&cat=13" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                    </div>
                    </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'M'</p>
                        <center><a href="index.php?action=pantalla1&cat=14" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
        </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'N'</p>
                        <center><a href="index.php?action=pantalla1&cat=15" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>

              </div>
        </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'O'</p>
                        <center><a href="index.php?action=pantalla1&cat=16" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
            </div>
                    </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'Q'</p>
                        <center><a href="index.php?action=pantalla1&cat=17" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>

                                    </div>
                    </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Seguimiento a Pedidos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pedidos letra 'R'</p>
                        <center><a href="index.php?action=pantalla1&cat=18" class="btn btn-default"><img src="app/views/images/pedido2.png"></a></center>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Pagos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Seguimiento a Pagos</p>
                        <center><a href="index.php?action=pagos" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/designbolts/seo/64/Pay-Per-Click-icon.png"></a></center>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Asignacion Ruta</h4>
                    </div>
                    <div class="panel-body">
                        <p>Asignacion de Rutas</p>
                        <center><a href="index.php?action=aruta" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>   -->

            <?php if ($usuario == 'DANIEL GARCIA CANALES'){ ?>
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
    