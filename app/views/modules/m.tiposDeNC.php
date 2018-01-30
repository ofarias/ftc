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
                        <h4><i class="fa fa-list-alt"></i> Refacturacion</h4>
                    </div>
                    <div class="panel-body">
                        <p>Refacturar</p>
                        <center><a href="index.php?action=buscaFacturaNC&opcion=1" class="btn btn-default"><img src="app/views/images/invoice.png"></a></center>
                    </div>
                </div>
            </div>    

            <?php if(count($solicitudes >= 1 )){?>
                    <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Solicitudes Pendientes</h4>
                    </div>
                    <div class="panel-body">
                        <p>Ver Solicitudes &nbsp;<font color = "red"><?php echo count($solicitudes)?> </font>pendientes</p>
                        <center><a href="index.php?action=verSolicitudesNC" class="btn btn-default"><img src="app/views/images/invoice.png"></a></center>
                    </div>
                </div>
            </div>
            <?php } ?>    
        </div>
    </div>
    