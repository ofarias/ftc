<br/>
<?php foreach ($datos as $key):
?>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Datos de Envio.</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="form1">
                    <input type="hidden" name="clave" value="<?php echo $key->CLAVE?>">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="cliente" value="<?php echo '('.$key->CLAVE.') '.$key->NOMBRE;?>" readonly="true"/><br>
                            </div>
                    </div>     
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Calle: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="calle" id="usuario" placeholder="Calle de Envio" required = "required" maxlength="30" value="<?php echo (empty($key->CALLE_ENVIO))? '':$key->CALLE_ENVIO?>" /><br>
                            </div>
                    </div>

                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Numero Exterior: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="ext" id="usuario" placeholder="Numero Exterior" required = "required" maxlength="30" value="<?php echo (empty($key->NUMEXT_ENVIO))? '':$key->NUMEXT_ENVIO?>"  /><br>
                            </div>
                    </div>
                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Numero Interior </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="int" id="usuario" placeholder="Numero Interior" required = "required" maxlength="30" value="<?php echo (empty($key->NUMINT_ENVIO))? '':$key->NUMINT_ENVIO?>"  /><br>
                            </div>
                    </div>
                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Colonia: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="col" id="usuario" placeholder="Colonia" required = "required" maxlength="30" value="<?php echo (empty($key->COLONIA_ENVIO))? '':$key->COLONIA_ENVIO?>"  /><br>
                            </div>
                    </div>
                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Delegacion o Municipio: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="del" id="usuario" placeholder="Delegacion o Municipio" required = "required" maxlength="30" value="<?php echo (empty($key->MUNICIPIO_ENVIO))? '':$key->MUNICIPIO_ENVIO?>"  /><br>
                            </div>
                    </div>
                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Ciudad: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="ciudad" id="usuario" placeholder="Ciudad" required = "required" maxlength="30" value="<?php echo (empty($key->LOCALIDAD_ENVIO))? '':$key->LOCALIDAD_ENVIO?>"  /><br>
                            </div>
                    </div>

                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Estado: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="edo" id="usuario" placeholder="Estado" required = "required" maxlength="30" value="<?php echo (empty($key->ESTADO_ENVIO))? '':$key->ESTADO_ENVIO?>"  /><br>
                            </div>
                    </div>

                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Pais: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="pais" id="usuario" placeholder="Pais" required = "required" maxlength="30" value="<?php echo (empty($key->PAIS_ENVIO))? '':$key->PAIS_ENVIO?>"  /><br>
                            </div>
                    </div>

                                        <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">CP: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="cp" id="usuario" placeholder="CP de Envio" required = "required" maxlength="30" value="<?php echo (empty($key->CODIGO_ENVIO))? '':$key->CODIGO_ENVIO?>"  /><br>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="observaciones" class="col-lg-2 control-label">Observaciones: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="obs" id="observaciones" placeholder="Observaciones de entrega" required = "required" maxlength="150"   value="<?php echo (empty($key->CAMPLIB7))? '':$key->CAMPLIB7?>"/><br>
                            </div>
                    </div>  
        </form>
            </div>
                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="salvarDatosEnvio" type="submit" class="btn btn-warning" form="form1">Guardar <i class="fa fa-floppy-o"></i></button>
                            <!-- <a class="btn btn-warning" href="index.php?action=">Cancelar <i class="fa fa-times"></i></a> -->
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>
<?php endforeach?>
<script>
    
    document.getElementById("addenda").onclick = function(){
        var port = document.getElementById("portal");
        var usr = document.getElementById("usuario");
        var pss = document.getElementById("contrasena");
        var obs = document.getElementById("observaciones");
        if(this.checked){
            port.readOnly = false;
            usr.readOnly = false;
            pss.readOnly = false;
            obs.readOnly = false;
        }else{
            port.readOnly = true;
            usr.readOnly = true;
            pss.readOnly = true;
            obs.readOnly = true;
        }
    }
</script>