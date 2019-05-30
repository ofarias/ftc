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
                        <h4><i class="fa fa-list-alt"></i> S U M I N I S T R O S</h4>
                    </div>
                    <div class="panel-body">
                        <p>Suministros</p>
                        <center><a href="index.php?action=menuS" class="btn btn-default" > <img src="app/views/images/Suministros/carrito_compras_3.png"></a></center>
                    </div>
                </div>
            </div>
             
    </div>
</div>
    