<div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <?php foreach($exec AS $cc):?>
            <div class="col-xs-12 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i> <?php echo "Cartera Cobranza ".  substr($cc->CARTERA_COBRANZA,2);?></h4>
                    </div>
                    <div class="panel-body">
                        <p><br></p>
                        <center><a href="index.php?action=catCobranza&cc=<?php echo $cc->CARTERA_COBRANZA;?>" class="btn btn-default"><img src="app/views/images/wallet-icon2.png"></a></center>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
</div>