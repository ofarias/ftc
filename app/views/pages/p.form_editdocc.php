<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Nuevo requisito</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="formdoc">
                    <?php foreach($exec as $data): ?>
                   <div class="form-group text-right">
                            <div class="col-lg-12">
                                <label for="activo" class="inline control-label">Activo: </label>
                                <input type="checkbox" class="checkbox-inline" name="activo" value="S" <?php echo ($data->ACTIVO == 'S') ? "checked":"";?> /><br>
                            </div>
                    </div> 
                    <br/>
                    <div class="form-group">
                        <label for="nombre" class="col-lg-2 control-label">Nombre: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="nombre" value="<?php echo $data->NOMBRE;?>" placeholder="Nombre del documento" required = "required" maxlength="20"/><br>
                            </div>
                    </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Descripción: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="descripcion" value="<?php echo $data->DESCRIPCION;?>" placeholder="Descripción del documento" required = "required" maxlength="150"/><br>
                                </div>
                        </div>
                    <input type="hidden" name="id" value="<?php echo $data->ID?>"/>
                   <?php endforeach;?>
                   </form>
                </div>
            <div>
                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="guardaCambiosDocumentoC" type="submit" value="enviar" class="btn btn-warning" form="formdoc">Guardar <i class="fa fa-floppy-o"></i></button>
                            <a class="btn btn-warning" href="index.php?action=catalogo_documentos">Cancelar <i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    </div>
    </div>
</div>