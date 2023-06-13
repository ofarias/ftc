
<div class="container">
       <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
            </div>
            <?php foreach($dias AS $m):?>
            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><center> <?php echo $m['dia'].' de '.$m['nombre'].' del '.$m['anio']?></center> </h4>
                    </div>
                    <div class="panel-body">
                        <p>Total Cajas = <?php echo $m['cajas']?><br></p>
                        <p>Cajas en Asignacion = <?php echo $m['asignacion']?><br></p>
                        <p>Cajas en Secuencia = <?php echo $m['secuencia']?><br></p>
                        <p>Cajas en Administracion = <?php echo $m['administracion']?><br></p>
                        <font color="blue"><i><p>Cajas en Bodega  = <?php echo $m['bodega']?><br></p></i></font>
                        <p>Cajas Finalizadas  = <?php echo $m['procesada']?><br></p>
                        <font color="red"><p>Cajas Pendientes =<b> <?php echo $m['cajas']-$m['procesada']?></b><br></p></font>
                        <center><a href="index.php?action=seguimientoCajasDiaDetalle&mes=<?php echo $m['mes'];?>&anio=<?php echo $m['anio']?>&dia=<?php echo $m['dia']?>" class="btn btn-default" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;">Ver Detalle</a></center>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
</div>