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
                        <h4><i class="fa fa-list-alt"></i> C L I E N T E S </h4>
                    </div>
                    <div class="panel-body">
                        <p>Clientes y Maestros</p>
                        <center><a href="index.php?action=menuCM" class="btn btn-default" > <img src="app/views/images/cliente.png"></a></center>
                    </div>
                </div>
            </div>
           
    </div>
</div>
    