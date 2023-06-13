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
                   <!-- <div class="form-group text-right">
                            <div class="col-lg-12">
                                <label for="activo" class="inline control-label">Activo: </label>
                                <input type="checkbox" class="checkbox-inline" name="activo" value="S"/><br>
                            </div>
                    </div> 
                    <br/> -->
                    <div class="form-group">
                        <label for="nombre" class="col-lg-2 control-label">Nombre: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre del documento" required = "required" maxlength="20"/><br>
                            </div>
                    </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Descripción: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="descripcion" placeholder="Descripción del documento" required = "required" maxlength="150"/><br>
                                </div>
                        </div>
                   
                </div>
            <div>

                       <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Tipo Documento: </label>
                                <div class="col-lg-8">
                                    <select class="form-control" name="tipoDoc" required>
                                        <option value=""> Seleccionar un tipo  de Requisito </option>
                                        <option value="InfNP"> Informativo (Sin Papel) </option>
                                        <option value="DImp"> Documento Impreso </option>
                                        <option value="EviPDF" > Archivo Evidencia (PDF o Foto) </option>
                                        <option value="Fiscal"> Archivo Fiscal PDF y XML </option>
                                    </select>
                                    
                                </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Tipo Requisito: </label>
                                <div class="col-lg-8">
                                    <select class="form-control" required  name="tipoReq">
                                        <option value=""> Seleccione Cuando se muestra el requisito </option>
                                        <option value="ent"> Para la Entrega al Cliente </option>
                                        <option value="rec"> Solicitar al Cliente (Necesario para Cobranza) </option>
                                    </select>
                                </div>
                        </div>
                        </form>
                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="guardaNuevoDocumentoC" type="submit" value="enviar" class="btn btn-warning" form="formdoc">Guardar <i class="fa fa-floppy-o"></i></button>
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