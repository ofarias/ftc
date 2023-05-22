<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    <!--<img class="img-ico" src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <div>
                <label> Bienvenido: <?php echo $usuario?></label>
            </div>
            <br/>
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    <!--<img class="img-ico" src="app/views/images/logob.jpg">-->
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
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4> Ordenes del dia Anterior</h4>
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
                        
                     
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4> Ordenes del dia </h4>
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
                        
                     
                    </div>
                </div>
            </div>
             <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Ordenes compra x Mes</h4>
                    </div>
                    <div class="panel-body">
                        <p></p>
                        <center><a href="index.php?action=verOCmes" class="btn btn-default"><img class="img-ico" src="app/views/images/LogisticaRecoleccion/ControlOC.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
              <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Alta de Unidades</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=buscaOC2" class="btn btn-default"><img class="img-ico" src="app/views/images/LogisticaRecoleccion/EstatusOrden.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
             
            <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Alta de Unidades</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=funidades" class="btn btn-default"><img class="img-ico" src="app/views/images/LogisticaRecoleccion/Unidades.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Asignacion Unidad</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=aruta" class="btn btn-default"><img class="img-ico" src="app/views/images/LogisticaRecoleccion/AsignaUnidad.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
    
            <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Documentos en Preruta</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=submenusec" class="btn btn-default"><img class="img-ico" src="app/views/images/Clientes/CatalogodeClientes.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Administracion Reenrutadas</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=adminruta&tipo=admon" class="btn btn-default"><img class="img-ico" src="app/views/images/LogisticaRecoleccion/AdminRuta.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Finalizar Rutas</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=adminruta&tipo=total" class="btn btn-default"><img class="img-ico" src="app/views/images/LogisticaRecoleccion/FinalizarRuta.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>

           
            <div class="col-md-2 cu-panel-clie">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Seguimiento de operadores</h4>
                    </div>
                    <div class="panel-body">
                        <center><a href="index.php?action=RegistroOperadores&formro=1" class="btn btn-default"><img class="img-ico" src="app/views/images/LogisticaRecoleccion/SeguimientoOperadores.png" width="50" height="70"></a></center>
                    </div>
                </div>
            </div>
        

        </div>
    </div>
    