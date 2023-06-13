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
                        <h4><i class="fa fa-list-alt"></i> C O N T A B I L I D A D </h4>
                    </div>
                    <div class="panel-body">
                        <p><b>Contabilidad</b></p>
                        <center><a href="index.php?action=menuCO" class="btn btn-default" > <img src="app/views/images/Contabilidad/contabilidad_1.png"></a></center>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> XML </h4>
                    </div>
                    <div class="panel-body">
                        <p>Bodega</p>
                        <center><a href="index.php?action=menuXML" class="btn btn-default" > <img src="app/views/images/Xml/xml_2.jpg"></a></center>
                    </div>
                </div>
            </div>
    </div>
</div>
    