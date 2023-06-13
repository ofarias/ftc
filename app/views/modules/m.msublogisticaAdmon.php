<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <?php foreach ($unidad as $CreaU): ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i><?php echo $CreaU->MARCA?> / <?php echo $CreaU->MODELO?>&nbsp;&nbsp;Documentos:&nbsp;&nbsp;<font color="red"><?php echo $CreaU->DOCUMENTOS ?></font></h4>
                        </div>
                        <div class="panel-body">
                            <p><?php echo $CreaU->NUMERO;?> / <?php echo $CreaU->PLACAS;?></p>
                            <p>Operador: &nbsp;&nbsp;<font color="blue"><?php echo $CreaU->OPERADOR;?></font></p>
                            <p>Coordinador:&nbsp;&nbsp; <?php echo $CreaU->COORDINADOR;?></p>
                            <center><a href="index.php?action=SecUnidadRec&ids=<?php echo $CreaU->IDU;?>&tipo=<?php echo $tipo?>" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/64/truck-icon.png"></a></center>
                        </div>
                    </div>
                </div>    
                <?php endforeach ?>
                </div>
        </div>
    </div>