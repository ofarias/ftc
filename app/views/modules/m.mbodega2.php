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
                       <h4><i class="fa fa-list-alt"></i> Ingresar Productos a Bodega </h4>
                   </div>
                   <div class="panel-body">
                       <p>Alta de Productos a Bodega</p>
                       <center><a href="index.php?action=IngresoBodega" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                   </div>
               </div>
           </div>

             <div class="col-md-4">
               <div class="panel panel-default">
                   <div class="panel-heading"> 
                       <h4><i class="fa fa-list-alt"></i> Ver Ingreso de Bodega </h4>
                   </div>
                   <div class="panel-body">
                       <p>Ver Productos Ingresados</p>
                       <center><a href="index.php?action=verIngresoBodega" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                   </div>
               </div>
           </div>

            <?php if(count($Solicitudes)>0){?>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Ver Solicitudes de Bodega Automaticos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Solicitudes a Bodega. <font color="red"><?php echo count($Solicitudes)?></font></p>
                        <center><a href="index.php?action=verSolBodega" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>             
            <?php }?>

            <?php if(count($vales)>0){?>
             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Ver Vales </h4>
                    </div>
                    <div class="panel-body">
                        <p>Vales de Bodega. <font color="red"><?php echo count($vales)?></font></p>
                        <center><a href="index.php?action=verValesBodega" class="btn btn-default"><img src="app/views/images/order.png"></a></center>
                    </div>
                </div>
            </div>             
            <?php }?>

             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Recibir Mercancia </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=recibirMercancia" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>

             <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Ver e Imprimir Recepciones </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verRecepDev" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Aduana Bodega </h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=verRecepSinProcesar" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/mcdo-design/smooth-leopard/64/Route-Folder-Blue-icon.png"></a></center>
                    </div>
                </div>
            </div>

           <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Inventario Fisico</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>
                        <center><a href="index.php?action=verInventarioBodega" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
                </div> 

                 <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Orden Interna</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>
                        <center><a href="index.php?action=nuevaOrdenInterna" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
                </div> 
            <?php if(count($oci)>0){?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Ver Ordenes de Compra Interna</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>
                        <center><a href="index.php?action=verOCI" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
                </div> 
            <?php }?>


              <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i>Recepcion de Orden de <br/> Compra Interna</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>
                        <center><a href="index.php?action=recepcionOCBdg" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/martz90/hex/72/car-icon.png"></a></center>
                    </div>
                </div>
                </div> 
                
			<!--
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

        </div>
    </div>
    