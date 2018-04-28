<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
           

           <?php foreach($ocmes[0] as $key):?> 
            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> OC del Dia <?php echo $key->FECHA?></h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <?php   
                                foreach ($ocmes[1] as $key1):
                                $color = '';
                                $color2= '';
                         ?>
                            <?php 
                            if($key1->FECHA == $key->FECHA){
                                if($key1->STATUS == 'CANCELADA_TOT'){
                                    $status = 'Cancelada Total';
                                    $linki = "<a href='index.php?action=verOC&fecha=$key1->FECHA&tipo=5' target='popup' onclick='window.open(this.href, this.target); return false;' >";
                                    $linkf = "</a>";
                                }elseif($key1->STATUS == 'CANCELADA_PAR'){
                                    $status = 'Cancelada Parcial';
                                    $linki = "<a href='index.php?action=verOC&fecha=$key1->FECHA&tipo=6' target='popup' onclick='window.open(this.href, this.target); return false;'>";
                                    $linkf = "</a>";
                                }elseif($key1->STATUS == 'LOGISTICA' or $key1->STATUS =='PAGADA'){
                                    $status = 'Ordenes en Ruta:';
                                    $color = "<font color=red>";
                                    $color2 = "</font>";
                                    $linki = "<a href='index.php?action=verOC&fecha=$key1->FECHA&tipo=3' target='popup' onclick='window.open(this.href, this.target); return false;'>";
                                    $linkf = "</a>";
                                }elseif($key1->STATUS == 'RECEPCION' or $key1->STATUS == 'RECEPCIONADA'){
                                    $status = 'Recolectadas';
                                    $linki = "<a href='index.php?action=verOC&fecha=$key1->FECHA&tipo=4' target='popup' onclick='window.open(this.href, this.target); return false;'>";
                                    $linkf = "</a>";
                                }elseif($key1->STATUS == 'ORDEN'){
                                    $status = 'Pendientes de Pago:';
                                    $color = "<font color=red>";
                                    $color2 = "</font>";
                                    $linki = "<a href='index.php?action=verOC&fecha=$key1->FECHA&tipo=2' target='popup' onclick='window.open(this.href, this.target); return false;'>";
                                    $linkf = "</a>";
                                }elseif($key1->STATUS == 'TESORERIA'){
                                    $status = 'Reenrutadas';
                                    $linki = "<a href='index.php?action=verOC&fecha=$key1->FECHA&tipo=7' target='popup' onclick='window.open(this.href, this.target); return false;'>";
                                    $linkf = "</a>";
                                }else{
                                    $status = 'Otro';
                                } 
                            ?>    
                            <p> <?php echo $linki.$color.$status.': '.$key1->OC.$color2.$linkf?> <p>
                            <?php }?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        <?php endforeach;?>

        </div>
</div>
    