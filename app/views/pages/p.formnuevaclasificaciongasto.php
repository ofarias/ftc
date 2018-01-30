<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Crear clasificación de gastos.</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="form-clasif">
                   <!-- <div class="form-group text-right">
                            <div class="col-lg-12">
                                <label for="activo" class="inline control-label">Activo: </label>
                                <input type="checkbox" class="checkbox-inline" name="activo" value="S"/><br>
                            </div>
                    </div> 
                    <br/> -->
                    <div class="form-group">
                        <label for="clasificacion" class="col-lg-2 control-label">Clasificacón: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="clasificacion" placeholder="Nombre corto para clasificación" required = "required" maxlength="10"/><br>
                            </div>
                    </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Descripción: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="descripcion" placeholder="Descripción de la clasificación" required = "required" maxlength="30"/><br>
                                </div>
                        </div>
                   </form>
                </div>
            <div>
                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="nuevaclasifgasto" type="submit" value="enviar" class="btn btn-warning" form="form-clasif">Guardar <i class="fa fa-floppy-o"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    </div>
    </div>
</div>
