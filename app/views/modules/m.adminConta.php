
           <div class="container">
        <!-- Marketing Icons Section -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
            <div>
                <label> Bienvenido: <?php echo $u?></label>
            </div>
            <br/>
            <?php foreach($usuario as $key):?>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><i class="fa fa-list-alt"></i><?php echo $key['nombre']?></h4>
                    </div>
                    <div class="panel-body">
                        
                        <center><a href="index.php?action=loginC&empresa=<?php echo $key['ide'].':'.$key['nombre']?>" class="btn btn-default">
                            <img src="app/views/images/Logos/<?php echo $key['logo']?>"></a></center>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
    