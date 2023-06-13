<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <?php foreach ($rutas as $unidad): ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i><?php echo $unidad->UNIDAD?> / <?php echo 'DOCUMENTOS: <font color="red">'.$unidad->DOCUMENTOS.'</font>'?></h4>
                        </div>
                        <div class="panel-body">
                            <p><?php echo $unidad->OPERADOR;?> / <?php echo $unidad->PLACAS;?></p>
                            <center><p><a href="index.php?action=recibirLogistica&ruta=<?php echo $unidad->UNIDAD?>" class="btn btn-info"></a></p></center>
                            <!--<p>Operador: <?php echo $CreaU->OPERADOR;?></p>
                            <p>Coordinador: <?php echo $CreaU->COORDINADOR;?></p>
                            <p>Documentos: <font color="red"><b><?php echo $CreaU->DOCUMENTOS?></b></font></p>
                            <center><a href="index.php?action=RutaUnidad&idr=<?php echo $CreaU->IDU;?>&tipo=<?php echo $tipo?>" class="btn btn-default"><img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/64/truck-icon.png"></a></center>-->
                        </div>
                    </div>
                </div>    
                <?php endforeach ?>
                </div>
        </div>
    </div>