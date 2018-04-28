<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <?php foreach ($cuentas as $CreaU): ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i><?php echo $CreaU->BANCO?> / <?php echo $CreaU->NUM_CUENTA?></h4>
                        </div>
                        <div class="panel-body">
                            <p><?php echo $CreaU->NUM_CUENTA;?> / <?php echo $CreaU->BANCO;?></p>
                            <center><a href="index.php?action=verDepositos2&banco=<?php echo $CreaU->NUM_CUENTA;?>" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/64/flow.png"></a></center>
                        </div>
                    </div>
                </div>    
                <?php endforeach ?>
                </div>
        </div>
    </div>