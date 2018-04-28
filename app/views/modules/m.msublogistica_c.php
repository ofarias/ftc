<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <?php foreach ($unidad as $CreaU): ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i><?php echo $CreaU->MARCA?> / <?php echo $CreaU->MODELO?></h4>
                        </div>
                        <div class="panel-body">
                            <p><?php echo $CreaU->NUMERO;?> / <?php echo $CreaU->PLACAS;?></p>
                            <p>Operador: <?php echo $CreaU->OPERADOR;?></p>
                            <p>Coordinador: <?php echo $CreaU->COORDINADOR;?></p>
                            <center><a href="index.php?action=CierraRuta&idr=<?php echo $CreaU->IDU;?>" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/64/truck-icon.png"></a></center>
                        </div>
                    </div>
                </div>    
                <?php endforeach ?>
                </div>
        </div>
    </div>