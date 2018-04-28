<?php if($tipo == 2){?>
<style>
<?php foreach ($cajas as $data): 

 if ( ($data['original'] - $data['recepcion']) > 0 and $data['dias'] < 5){
    echo ".panel-body".$data['cotizacion']."{ background-color: #ffcccc;}";
 }elseif (($data['original'] - $data['recepcion']) < 0) {
    echo ".panel-body".$data['cotizacion']."{ background-color: #e60000;}";
 }elseif (($data['original'] - $data['recepcion']) > 0 and $data['dias'] >= 5) {
    echo ".panel-body".$data['cotizacion']."{ background-color: #ff4d4d;}";
 }elseif (($data['original'] - $data['recepcion']) <> 0 and $data['dias'] >= 5) {
     echo ".panel-body".$data['cotizacion']."{ background-color: #990000;}";
 }
?>
<?php endforeach?>
</style>
<?php }?>
<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
           <?php if($tipo == 1){?>
            <?php foreach ($cajas as $key): ?>
                  <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Pedidos del Mes de <?php echo $key['mes'].' Del Año: '.$key['anio']?>  </h4>
                    </div>
                    <div class="panel-body">
                        <p> Pedidos Totales: <?php echo $key['cajas']?> </p>
                        <p> <a href="index.v.php?action=cajas&tipo=2&mes=<?php echo $key['mes']?>&anio=<?php echo $key['anio']?>" class="btn btn-default">Pendientes X Finalizar: <?php echo $key['pendientes']?></a></p>
                        <p align="center"><font color="red"> Monto Total Pedidos: <?php echo '$ '.number_format($key['subtotal'],2)?></font></p>
                        <p align="center"> <font color ="blue" size = "14px"><?php echo number_format(((($key['cajas']-$key['pendientes']) * 100)/$key['cajas']),2).' %' ?></font></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php }elseif($tipo==2){?>
                   <?php foreach ($cajas as $key): 
                    if($key['original']-$key['recepcion'] == 0){
                        $imagen = 'ok.jpg';
                    }elseif($key['dias']>= 5){
                        $imagen = 'mal.jpg';
                    }else{
                        $imagen = 'proceso.png';
                    }
                   ?>
                  <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> Caja  <?php echo $key['cotizacion'].' Dias: ( '.$key['dias'].' ) '?></h4>
                    </div>
                    <div class="panel-body<?php echo $key['cotizacion']?>">
                        <p><font size="4pxs"><b><?php echo $key['cliente']?></b></font></p>
                        <p><font size="3pxs"><b>Liberacion:<?php echo $key['fechalib']?></b></font></p>
                        <p> Prod. del Pedido: <?php echo $key['original'].' en '.$key['partidas'].' partidas.'?> </p>
                        <p> Productos Recibidos: <?php echo $key['recepcion']?> </p>
                        <p> Productos Empacados: <?php echo $key['empacado']?></p>
                        <p><font color="blue"><a href="index.v.php?action=detalleFaltante&docf=<?php echo $key['cotizacion']?>" target="popup" onclick="window.open(this.href, this.target, 'width=1200,height=820'); return false;" > Productos Faltantes: <?php echo $key['original']-$key['recepcion']?></a></p>
                        <p><a href="/PedidosVentas/<?php echo substr($key['archivo'],30, 176)?>" download="/PedidosVentas/<?php echo substr($key['archivo'],30, 176)?>"><?php echo substr($key['archivo'],30, 176)?></a></font>
                        </p>
                        <center><img src="app/views/images/<?php echo $imagen?>"></center>
                        
                        </div>
                    </div>
                </div>
                <?php endforeach; ?> 
            <?php } ?>
        </div>

    </div>
    