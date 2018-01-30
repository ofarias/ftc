<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Alta de Maestro</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="form1">
                    <input name = "idm" type="hidden" value ="<?php echo $key->ID ?>">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Nombre Maestro: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="nombre" pattern=".{3,50}"   required title="3 characters minimum" /><br>
                            </div>
                    </div>                
                </form>

            </div>

                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="altaMaestro" type="submit" class="btn btn-warning" form="form1">Crear <i class="fa fa-floppy-o"></i></button><br/>
                            <!-- <a class="btn btn-warning" href="index.php?action=">Cancelar <i class="fa fa-times"></i></a> -->
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>

