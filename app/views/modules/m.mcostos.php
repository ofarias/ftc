<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>
            <div>
                <p><label> Bienvenido: <?php echo $usuario?></label></p>
                <p><label><?php echo $_SESSION['empresa']['nombre'].'<br/>'.$_SESSION['rfc']?></label></p>
            </div>
            <br/>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i>Prveedores y Productos</h4>
                    </div>
                    <div class="panel-body">
                        <p>Proveedores y Productos</p>
                        <center><a href="index.php?action=menuPP" class="btn btn-default" > <img src="app/views/images/proveedor.png"></a></center>
                    </div>
                </div>
            </div>
    </div>
</div>
    