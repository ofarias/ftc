<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <?php if($cajasAbiertas > 0 ){?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Ver Cajas Abiertas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Cajas Abiertas.</p>
                        <center><a href="index.php?action=verCtrlCajasAbiertas"  class="btn btn-default" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <?php }?>

            <?php if($paquetesSinFact > 0 ){?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Pendientes Facturacion</h4>
                    </div>
                    <div class="panel-body">
                        <p>Pendientes por Facturar</p>
                        <center><a href="index.php?action=verFaltantesFacturar" class="btn btn-default" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" ><img src="app/views/images/boxes-brown-icon.png"></a></center>
                    </div>
                </div>
            </div>
            <?php }?>
           
        </div>
    </div>
    