<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Datos de la Addenda Liverpool / Suburbia</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="formdoc">
                    <div class="form-group">
                        <label for="nombre" class="col-lg-2 control-label">Orden de Compra: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="oc" placeholder="Orden de Compra" required = "required" maxlength="20"/><br>
                            </div>
                    </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Nota de Entrega: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="entrega" placeholder="Contra Recibo" required = "required" maxlength="150"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Informacion Adicional: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="infoAdicional" placeholder="AdditionalInformation" required = "required" maxlength="150"/><br>
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Departamento o Persona: </label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" name="depopersona" placeholder="Departamento o Persona" required = "required" maxlength="150"/><br>
                                </div>
                        </div>
                </div>
            <div>
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <input type="hidden" name="docf" value="<?php echo $docf?>">
                            <button name="addendaLiverpool" type="submit" value="enviar" class="btn btn-warning" form="formdoc">Guardar <i class="fa fa-floppy-o"></i></button>
                            <a class="btn btn-warning" href="index.php?action=imprimeXML">Cancelar <i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
    </div>
    </div>
</div>