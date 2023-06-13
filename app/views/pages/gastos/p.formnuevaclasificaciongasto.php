<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Crear Tipo de Documentos.</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="form-clasif">
                    <div class="form-group">
                        <label for="clasificacion" class="col-lg-2 control-label">Clasificacón: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="clasificacion" placeholder="Nombre corto para clasificación" required = "required" maxlength="10"/>
                                <label>Aparecera este valor en la lista de los documentos.</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-lg-2 control-label">Descripción: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="descripcion" placeholder="Descripción de la clasificación" required = "required" maxlength="30"/>
                                <label>Valor informativo que aparecera en los reportes</label>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-lg-2 control-label">Tipo de documento: </label>
                            <div class="col-lg-8">
                                <select name="tipo" required>
                                    <option value="">Seleccione el Tipo de Documento:</option>
                                    <option value="V">Ingreso / Ventas</option>
                                    <option value="G">Egreso / Compras </option>
                                </select>
                                <label>Se visualizara en la pantalla de los documentos XML de tipo Ingreso o Egreso.</label>
                            </div>
                    </div>
                   </form>
                </div>
            <div>
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
