<br/>
<div class="row">
    <div class="container"
         >
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Asignar requisito nuevo</h3>
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
                        <label for="copias" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-8">           
                                <input type="text" class="form-control" name="cliente" value="<?php echo $_SESSION['ClaveCliente'];?>" required = "required" readonly/><br>
                            </div>
                    </div>                   
                    <div class="form-group">
                        <label for="documento" class="col-lg-2 control-label">Requisito: </label>
                            <div class="col-lg-8">
                                <select type="text" class="form-control" name="documento" required = "required">
                                <?php foreach($exec as $data):?>    
                                    <option value="<?php echo $data->ID;?>" ><?php echo $data->NOMBRE;?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="copias" class="col-lg-2 control-label">Copias: </label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" name="copias" value="1" placeholder="Copias del requisito" required = "required" min="1"/><br>
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