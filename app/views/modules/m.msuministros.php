<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <?php 
                $totalOC = empty($info['oc'])? 0:$info['oc'];
                $pago = empty($info['pago'])? 0:$info['pago'];
                $ruta = empty($info['ruta'])? 0:$info['ruta'];
                $rec = empty($info['recolectadas'])? 0:$info['recolectadas'];
                $ctotal = empty($info['cTotal'])? 0:$info['cTotal'];
                $cpar = empty($info['cPar'])? 0:$info['cPar'];
                $ocreen =empty($info['reen'])? 0:$info['reen'];
                $htotalOC = empty($infohoy['oc'])? 0:$infohoy['oc'];
                $hpago = empty($infohoy['pago'])? 0:$infohoy['pago'];
                $hruta = empty($infohoy['ruta'])? 0:$infohoy['ruta'];
                $hrec = empty($infohoy['recolectadas'])? 0:$infohoy['recolectadas'];
                $hctotal = empty($infohoy['cTotal'])? 0:$infohoy['cTotal'];
                $hcpar = empty($infohoy['cPar'])? 0:$infohoy['cPar'];
                $hocreen =empty($infohoy['reen'])? 0:$infohoy['reen'];

//$info=array("oc"=>$oc, "pago"=>$ocsp,"ruta"=>$ocruta, "recolectadas"=>$ocrec, "cTotal"=>$occant, "cPar"=>$occanp, "reen"=>$ocreen);
                
            ?>
           <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Control de Ordenes de Compra</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ordenes de compra x Mes</p>
                        <center><a href="index.php?action=verOCmes" class="btn btn-default"><img src="app/views/images/OrdenCompra.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ordenes del dia Anterior</h4>
                    </div>
                    <div class="panel-body">
                        <?php $hoy=date("d.m.Y"); $ayer=strtotime('-1 day',strtotime($hoy)); $ayer = date('d.m.Y', $ayer);?>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=1" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><font color="blue"><b><?php echo $totalOC?></b></font> Ordenes de compra del 
                        <font color="red"><b> <?php echo $ayer;?></font>
                        </a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=2" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Pendientes de Pago: <font color="red"><?php echo $pago?></font></a></p>

                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=3" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Ordenes en Ruta: <font color="red"><?php echo $ruta?></font></a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=4" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Recolectadas:   <font color="red"><?php echo $rec?></font> </a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=5" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Canceladas Total:    <font color="red"><?php echo $ctotal?></font></a> </p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=6" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Canceladas Parcial:     <font color="red"><?php echo $cpar?></font></a> </p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=7" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Reenrutadas: <font color = "red"><?php echo $ocreen?></font></a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $ayer?>&tipo=8" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Completas al 100% : <font color="red"></font></a></p>
                     
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Ordenes del dia </h4>
                    </div>
                   <div class="panel-body">
                        <?php $hoy=date("d.m.Y"); $ayer=strtotime('-1 day',strtotime($hoy)); $ayer = date('d.m.Y', $ayer);?>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=1" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"><font color="blue"><b><?php echo $htotalOC?></b></font> Ordenes de compra del 
                        <font color="red"><b> <?php echo $ayer;?></font>
                        </a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=2" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Pendientes de Pago: <font color="red"><?php echo $hpago?></font></a></p>

                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=3" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Ordenes en Ruta: <font color="red"><?php echo $hruta?></font></a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=4" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Recolectadas:   <font color="red"><?php echo $hrec?></font> </a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=5" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Canceladas Total:    <font color="red"><?php echo $hctotal?></font></a> </p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=6" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Canceladas Parcial:     <font color="red"><?php echo $hcpar?></font></a> </p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=7" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;"> Reenrutadas: <font color = "red"><?php echo $hocreen?></font></a></p>
                        <p><a href="index.php?action=verOC&fecha=<?php echo $hoy?>&tipo=8" target="pop-up" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Completas al 100% : <font color="red"></font></a></p>
                     
                    </div>
                </div>
            </div>
              <div class="col-md-3">
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
            <?php if(count($fallidas)>0){?>
           <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Ordenes Fallidas </h4>
                    </div>
                    <div class="panel-body">
                        <p>Ordenes Fallidas: <?php echo count($fallidas)?></p>
                        <center><a href="index.php?action=ocfallidas" class="btn btn-default"><img src="app/views/images/Shopping-basket-full-icon.png"></a></center>
                    </div>
                </div>
            </div>
               <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Recuperar Pagos a Proveedores </h4>
                    </div>
                    <div class="panel-body">
                        <p>Recuperar Pagos </p>
                        <center><a href="index.php?action=verOrdenesFallidas" class="btn btn-default"><img src="app/views/images/Shopping-basket-full-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <?php }else{?>
             <div class="col-md-3">
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

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Preordenes de Compra. </h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver / Imprimir PreOC </p>
                        <center><a href="index.php?action=verPreOC" class="btn btn-default"><img src="app/views/images/Shopping-basket-full-icon.png"></a></center>
                    </div>
                </div>
            </div>        
          <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading"> 
                        <h4><i class="fa fa-list-alt"></i> Recuperar Pagos a Proveedores </h4>
                    </div>
                    <div class="panel-body">
                        <p>Recuperar Pagos </p>
                        <center><a href="index.php?action=verPreOC" class="btn btn-default"><img src="app/views/images/Shopping-basket-full-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <!--<div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Catalogo de Inventarios</h4>
                    </div>
                    <div class="panel-body">
                        <p>Inventario Almacen 9.</p>
                        <center><a href="index.php?action=ccompvent" class="btn btn-default"><img src="app/views/images/folder.png"></a></center>
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
            </div>-->

            <div class="col-md-3">
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
            <?php }?>
            <?php if(count($Solicitudes)>0){?>
             <div class="col-md-3">
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

        </div>
    </div>
    