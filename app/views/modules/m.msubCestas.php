<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                </h3>
                <?php foreach ($proveedor as $key): ?>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><i class="fa fa-list-alt"></i><?php echo $key->NOMBRE?> </h4>
                        </div>
                        <div class="panel-body">
                            <p><?php echo '('.$key->CLAVE.') '.$key->NOMBRE;?> </p>
                            <p>Productos Pendientes: <?php echo $key->PRODUCTOS;?></p>
                            <?php if( $user == 'Gerencia de Compras' or $gerencia == 'G'){?>
                            <?php echo '<p><font color="blue">Responsable:'.$key->RESPONSABLE.'</font></p>'; ?>
                             <?php } ?>
                            <center><a href="index.php?action=verCanasta&idprov=<?php echo $key->CLAVE;?>" class="btn btn-default"><img src="app/views/images/Shopping-basket-refresh-icon_small.png"></a></center>
                        </div>
                    </div>
                </div>    
                <?php endforeach ?>
                </div>
        </div>
    </div>