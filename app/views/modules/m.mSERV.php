<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
        	<div class="col-lg-12">
        		<!--<img class="img-rounded" src="app/views/images/logomed.png" />-->
        	</div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Registro de Tickets</h4>
                        </div>
                    <div class="panel-body">
                        <p><b>Tickets de Servicio</b></p>
                        <center><a href="index.serv.php?action=tickets" class="btn btn-default"> <img src="app/views/images/AdminUsuarios/AdminUsr.png" width="58" height="60"></a></center>
                    </div>
                </div>
                </div>
                <?php if($_SESSION['user']->LETRA_NUEVA != 'S'){?>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Registro de inventario</h4>
                        </div>
                    <div class="panel-body">
                        <p><b>Inventario de Equipos</b></p>
                        <center><a href="index.serv.php?action=invServ" class="btn btn-default"> <img src="app/views/images/AdminUsuarios/AdminUsr.png" width="58" height="60"></a></center>
                    </div>
                </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>Registro de Usuarios</h4>
                        </div>
                    <div class="panel-body">
                        <p><b>Usuarios</b></p>
                        <center><a href="index.serv.php?action=usuarios" class="btn btn-default"> <img src="app/views/images/AdminUsuarios/AdminUsr.png" width="58" height="60"></a></center>
                    </div>
                </div>
                </div>
                <?php } ?>

                <?php if($_SESSION['user']->USER_LOGIN == 'ofarias'){?>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>Reportes</h4>
                            </div>
                            <div class="panel-body">
                                <p><b>Reportes</b></p>
                                <center><a href="index.serv.php?action=tickets" class="btn btn-default"> <img src="app/views/images/AdminUsuarios/AdminUsr.png" width   ="58" height="60"></a></center>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    