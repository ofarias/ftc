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
                    <?php foreach($exec as $data):

                        if($data->TIPO_DOC == 'InfNP'){
                            $TD = 'Informativo (Sin Papel)';
                        }elseif($data->TIPO_DOC == 'DImp'){
                            $TD = 'Docuemnto Impreso';
                        }elseif($data->TIPO_DOC == 'EviPDF'){
                            $TD = 'Archivo Evidencia (PDF o Foto)';
                        }elseif($data->TIPO_DOC == 'Fiscal'){
                            $TD = 'Archivo Fiscal PDF y XML';
                        }

                        if($data->TIPO_REQ == 'ent'){
                            $TR  = 'Para la entrega al Cliente';
                        }elseif($data->TIPO_REQ == 'rec'){
                            $TR = 'Solicitar al Cliente (para Ingreso a Pegaso)';
                        }

                     ?>
                   <div class="form-group text-right">
                            <div class="col-lg-4">
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

                       <div class="form-group">
                            <label for="descripcion" class="col-lg-2 control-label">Tipo Documento: </label>
                                <div class="col-lg-8">
                                    <select class="form-control" name="tipoDoc" required>
                                        <option value="<?php echo (!empty($data->TIPO_DOC))? '$data->TIPO_DOC':''?>"><?php echo (!empty($data->TIPO_DOC))?  $TD:'Seleccionar un tipo  de Requisito'?>  </option>
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
                                        <option value="<?php echo (!empty($data->TIPO_REQ))?  $data->TIPO_REQ:''?>"> <?php echo (!empty($data->TIPO_REQ))? $TR:'Seleccione Cuando se muestra el requisito'?> </option>
                                        <option value="ent"> Para la Entrega al Cliente </option>
                                        <option value="rec"> Solicitar al Cliente (para Ingreso a Pegaso) </option>
                                    </select>
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
                            <button name="guardaCambiosDocumentoC" type="submit" value="enviar" class="btn btn-success" form="formdoc">Guardar <i class="fa fa-floppy-o"></i></button>
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