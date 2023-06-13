<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <?php foreach ($banco as $cbanco): ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i><?php echo $cbanco->ID?> / <?php echo $cbanco->NUM_CUENTA?></h4>
                        </div>
                        <div class="panel-body">
                            <p><?php echo $cbanco->ID;?> / <?php echo $cbanco->BANCO;?></p>
                            <p>Cuenta Bancaria: <?php echo $cbanco->NUM_CUENTA;?></p>
                            <p>Cuenta Contable: <?php echo $CreaU->CTA_CONTAB;?></p>
                            <center><a href="index.php?action=RutaUnidad&idr=<?php echo $cbanco->ID;?>" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/64/truck-icon.png"></a></center>
                        </div>
                    </div>
                </div>    
                <?php endforeach ?>
                </div>
        </div>
    </div>