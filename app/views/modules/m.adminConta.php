<div class="container container-emp">
        <div class="row marg-emp">
            <div class="col-gl-12">
                <h3 class="page-header cabeza-pagina">
                </h3>
            </div>
             <div class="card">
                <img src="https://materiell.com/wp-content/uploads/2015/03/doug_full1.png" alt="" />
                <p><strong>Bienvenido</strong></p>
                <p><?php echo $u?></p>
            </div>
            <br/>
            <?php foreach($usuario as $key):?>
            <div class="col-md-2 emp-tam">
                <div class="panel panel-default cuerpo-caja">
                    <div class="panel-heading-emp">
                        <h4 class="titulo-empresa"><?php echo $key['nombre']?></h4>
                    </div>
                    <div class="panel-body-emp">
                        <center class="caja-logo">
                            <a href="index.php?action=loginC&empresa=<?php echo $key['ide'].':'.$key['nombre']?>" class="btn btn-default boton-empre">
                            <img class="logos-empresas" src="app/views/images/Logos/<?php echo $key['logo']?>" width="100%" heigth="100%">
                            <!--<img class="logos-empresas" src="logo.php?ide=<?php echo $key['ide']?>" width="100%" heigth="100%">-->
                            <!--<img class="logos-empresas" src="<?php echo base64_encode_image()?>" width="100%" heigth="100%">-->

                        </a>
                        </center>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

<?php
    function base64_encode_image ($filename=string,$filetype=string) {
        if ($filename){
            $imgbinary = fread(fopen($filename, "r"), filesize($filename));
            return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
        }
    }
?>