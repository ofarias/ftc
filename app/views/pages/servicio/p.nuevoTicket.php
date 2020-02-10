<br/>
<div class="row">
    <div class="container"
         >
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Crear Nuevo Ticket</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="formdoc">
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-8">
                                <select name="cliente" required>
                                    <?php foreach ($cl as $cli): ?>
                                        <option value="<?php echo $cli->CLAVE_TRIM?>"><?php echo $cli->NOMBRE?></option>
                                    <?php endforeach ?>
                                </select>
                                <br>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="usuario" class="col-lg-2 control-label">Usuario que Reporta: </label>
                            <div class="col-lg-8">
                                <select class="form-control" name="usuario" required = "required">
                                    <option value="">Seleccion el Usuario que Reporta</option>
                                <?php foreach($us as $usu):?>    
                                    <option value="<?php echo $usu->ID;?>" ><?php echo $usu->NOMBRE.' '.$usu->SEGUNDO.' '.$usu->PATERNO.' '.$usu->MATERNO.' '.$usu->CLIENTE;?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="copias" class="col-lg-2 control-label">Equipo: </label>
                            <div class="col-lg-8">
                                <select name="equipo" required>
                                    <option value="">Equipo</option>
                                    <?php foreach ($eq as $equi): ?>
                                        <option value="<?php echo $equi->ID?>"><?php echo $equi->NOMBRE?></option>    
                                    <?php endforeach ?>
                                </select>    
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="requerido" class="col-lg-2 control-label">Requerido: </label>
                            <div class="col-lg-8">
                                <select type="text" class="form-control" name="requerido" required = "required">
                                    <option value="S">Si</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                    </div>
                   </form>
                </div>
            <div>
                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <?php unset($_SESSION['ClaveCliente']) ?>
                            <button name="asignaDocumentoC" type="submit" value="enviar" class="btn btn-warning" form="formdoc">Guardar <i class="fa fa-floppy-o"></i></button>
                            <a class="btn btn-warning" href="index.php?action=documentos_cliente">Cancelar <i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    </div>
    </div>
</div>