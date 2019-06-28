<div class="container-emp">
        <!-- Marketing Icons Section -->
        <div class="row marg-emp">
            <div class="col-gl-12">
                <h3 class="page-header">
                    <!--<img src="app/views/images/logob.jpg">-->
                </h3>
            </div>
             <div class="card">
                <img src="https://materiell.com/wp-content/uploads/2015/03/doug_full1.png" alt="" />
                <h1>Bienvenido</h1>
                <p><?php echo $u?></p>
            </div>
            <!--<div>
                <label class="titulo-emp"> Bienvenido  <br><?php echo $u?></label>
            </div>-->
            <br/>
            <?php foreach($usuario as $key):?>
            <div class="col-md-2 emp-tam">
                <div class="panel panel-default cuerpo-caja">
                    <div class="panel-heading-emp">
                        <h4 class="titulo-empresa"><?php echo $key['nombre']?></h4>
                    </div>
                    <div class="panel-body-emp">
                        
                        <center class="caja-logo"><a href="index.php?action=loginC&empresa=<?php echo $key['ide'].':'.$key['nombre']?>" class="btn btn-default boton-empre">
                            <img class="logos-empresas" src="app/views/images/Logos/<?php echo $key['logo']?>" width="100%" heigth="100%"></a></center>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

    