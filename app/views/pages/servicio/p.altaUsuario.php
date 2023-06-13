<br/>
<style type="text/css">
.comentario
    {
        font-family: Comic Sans MS;
        font-style: oblique; 
        color: grey;
    }
</style>
<?php if($clie !=''){
    foreach ($cl as $x){
        if($x->CLAVE_TRIM == $clie){
            $nombreC = $x->NOMBRE;
        }
    }
    }
?>
<div class="row">
    <div class="container"
         >
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Alta de Usuarios</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.serv.php" method="post" id="formdoc">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-8">
                                <select name="cliente" required>
                                    <?php if($clie !=''){?>
                                        <option value="<?php echo $clie?>"><?php echo $nombreC?> </option>
                                    <?php }else{?>
                                        <option value="">Seleccione un cliente</option>
                                    <?php } ?>
                                    <?php foreach ($cl as $cli): ?>
                                        <option value="<?php echo $cli->CLAVE_TRIM?>"><?php echo $cli->NOMBRE?></option>
                                    <?php endforeach ?>
                                </select>
                                <br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Nombre: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="nombre" placeholder="" value="" required>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Segundo: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="segundo" placeholder="" value="" >
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Paterno: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="paterno" placeholder="" value="" >
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Materno: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="materno" placeholder="" value="" >
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Correo: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="correo" placeholder="" value="" >
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Telefono: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="telefono" placeholder="" value="" >
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Extension: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="extension" placeholder="" value="" >
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Cargo: </label>
                            <div class="col-lg-8">
                                <input type="text" size="50" maxlength="50" name="cargo" placeholder="" value="" >
                            </div>
                    </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button title="Al Guardar se queda predeterminado el nombre del cliente" name="nuevoUsuario" type="submit" value="enviar" class="btn btn-success" form="formdoc"> Guardar <i class="fa fa-floppy-o"></i>
                            </button>
                            <a class="btn btn-info" href="index.serv.php?action=altaUsuario">Limpiar Formulario</a>
                            <a class="btn btn-danger" onclick="window.close()">Cancelar<i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
