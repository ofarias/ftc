<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Alta datos cobranza.</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="form1">
                    
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="cliente" value="<?php echo $cli;?>" readonly="true"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="carteracobranza" class="col-lg-2 control-label">Cartera Cobranza: </label>
                            <div class="col-lg-8">
                                <select name="carteracobranza" class="form-control">
                                    <option value="CCA">CCA</option>
                                    <option value="CCB">CCB</option>
                                    <option value="CCC">CCC</option>
                                    <option value="CCD">CCD</option>
                                </select>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="carterarevision" class="col-lg-2 control-label">Cartera Revisión: </label>
                            <div class="col-lg-8">
                                <select name="carterarevision" class="form-control">
                                    <option value="CR1">CR1</option>
                                    <option value="CR2">CR2</option>
                                    <option value="CR3">CR3</option>
                                    <option value="CR4">CR4</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group col-lg-12 text-center">
                    <label class="col-lg-2 control-label">Días Revisión: </label>
                        <div class="checkbox-inline">
                            <label for="rev1" class="checkbox-inline"><input type="checkbox" name="rev1" value="L">L</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev2" class="checkbox-inline"><input type="checkbox" name="rev2" value="MA">MA</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev3" class="checkbox-inline"><input type="checkbox" name="rev3" value="MI">MI</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev4" class="checkbox-inline"><input type="checkbox" name="rev4" value="J">J</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev5" class="checkbox-inline"><input type="checkbox" name="rev5" value="V">V</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev6" class="checkbox-inline"><input type="checkbox" name="rev6" value="S">S</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev7" class="checkbox-inline"><input type="checkbox" name="rev7" value="D">D</label>
                        </div>
                    </div>
                   
                    <div class="form-group col-lg-12 text-center">
                    <label class="col-lg-2 control-label">Días de pago: </label>
                        <div class="checkbox-inline">
                            <label for="pag1" class="checkbox-inline"><input type="checkbox" name="pag1" value="L">L</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag2" class="checkbox-inline"><input type="checkbox" name="pag2" value="MA">MA</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag3" class="checkbox-inline"><input type="checkbox" name="pag3" value="MI">MI</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag4" class="checkbox-inline"><input type="checkbox" name="pag4" value="J">J</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag5" class="checkbox-inline"><input type="checkbox" name="pag5" value="V">V</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag6" class="checkbox-inline"><input type="checkbox" name="pag6" value="S">S</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag7" class="checkbox-inline"><input type="checkbox" name="pag7" value="D">D</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="dospasos" class="col-lg-2 control-label">Revisión dos pasos: </label>
                            <div class="col-lg-8">
                                <select name="dospasos" class="form-control">
                                    <option value="S">Si</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="plazo" class="col-lg-2 control-label">Plazo: </label>
                            <div class="col-lg-8">
                                <select name="plazo" class="form-control">
                                    <option value = "8"> 8 Días</option>
                                    <option value="30">30 Días</option>
                                    <option value="45">45 Días</option>
                                    <option value="60">60 Días</option>
                                    <option value="90">90 Días</option>
                                    <option value="120">120 Días</option>
                                    <option value="150">150 Días</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group col-lg-12 text-center">
                    <label for="addenda" class="col-lg-2 control-label">Addenda: </label>
                        <div class="checkbox-inline">
                            <input type="checkbox" name="addenda" value="S" id="addenda">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="portal" class="col-lg-2 control-label">Portal Addenda: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="portal" id="portal" placeholder="URL del portal" required = "required" maxlength="150" readonly="true"/><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Usuario: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="add_usuario" id="usuario" placeholder="Usuario del portal" required = "required" maxlength="30" readonly="true"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contrasena" class="col-lg-2 control-label">Contraseña: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="contrasena" id="contrasena" placeholder="Contraseña" required = "required" maxlength="15" readonly="true"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="observaciones" class="col-lg-2 control-label">Observaciones: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Observaciones addenda" required = "required" maxlength="150" readonly="true"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="lineacred" class="col-lg-2 control-label">Linea de credito: </label>
                            <div class="col-lg-8">
                                <input type="number" step="any" class="form-control" name="lincred" id="lincred" required = "required" min="0"/><br>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="bancoDeposito" class="col-lg-2 control-label" > Banco Deposito Pegaso</label>
                        <div class = "col-lg-8">
                                <select name="bancoDeposito">
                                    <option value ="<?php echo $dat->BANCO_DEPOSITO?>"> <?php echo ($dat->BANCO_DEPOSITO <>'')? "$dat->BANCO_DEPOSITO":"Seleccione un Banco"?></option>
                                    <?php foreach ($banco as $key): ?>
                                        <option value="<?php echo $key->BANCO?>" > <?php echo $key->BANCO?></option>
                                    <?php endforeach ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="metodoPago" class="col-lg-2 control-label" > Forma de Pago</label>
                        <div class = "col-lg-8">
                                <select name="metodoPago">
                                        <option value="<?php echo $dat->METODO_PAGO?>"> <?php echo $dat->METODO_PAGO <>''? "$dat->METODO_PAGO":"Forma de Pago"?> </option>
                                         <option value="Efectivo"> Efectivo </option>
                                         <option value="cheque"> Cheque </option>
                                          <option value="transferencia"> Transferencia Electronica </option>
                                           <option value="otro"> Otro </option>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bancoOrigen" class="col-lg-2 control-label" > Banco Con que Paga el Cliente</label>
                        <div class = "col-lg-8">
                                <select name="bancoOrigen">
                                        <option value="<?php echo $dat->BANCO_ORIGEN?>"> <?php echo $dat->BANCO_ORIGEN <> ''? "$dat->BANCO_ORIGEN":"Seleccione el Banco Con que Paga el Cliente"?> </option>
                                         <option value="Banamex"> Banamex </option>
                                         <option value="Bancomer"> Bancomer </option>
                                          <option value="Azteca"> Banco Azteca </option>
                                           <option value="Banorte"> Banorte / Ixe </option>
                                        <option value="Inbursa"> Inbursa  </option>
                                        <option value="Bancopel"> Bancopel </option>
                                        <option value="Scotiabank"> Scotiabank </option>
                                        <option value="Santander"> Santander </option>
                                        <option value="Multiva"> Multiva </option>
                                        <option value="Otro"> Desconocido </option>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for = "referEdo" class="col-lg-2 control-label"> Referencia en estado de cuenta</label>
                        <div class="col-lg-8">
                            <input type="text" name="referEdo" placeholder="Referencia en Estado de cuenta" value="<?php echo $dat->REFER_EDO?>"" maxlength="35">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="portalcob" class="col-lg-2 control-label">Portal Cobranza: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="portalcob" placeholder="Link portal cobranza" maxlength="255"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="envio" class="col-lg-2 control-label">Envió: </label>
                            <div class="col-lg-8">
                                <select name="envio" class="form-control">
                                    <option value="local">Foraneo</option>
                                    <option value="foraneo">Local</option>
                                </select>
                            </div>
                    </div>
                  
                    <div class="form-group">
                        <label for="cp" class="col-lg-2 control-label">Código Postal: </label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" name="cp" placeholder="Código Postal" required = "required" min="1"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="maps" class="col-lg-2 control-label">Maps: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="maps" placeholder="Link de ubicación en google maps" maxlength="255"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="tipo" class="col-lg-2 control-label">Pertenece a: </label>
                            <div class="col-lg-8">
                                <select name="tipo" class="form-control">
                                    <?php foreach($datosMaestro as $data):
                                    ?>
                                    <option value="<?php echo $data->CLAVE?>"><?php echo $data->NOMBRE?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
            
        </form>
            </div>

                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="salvarDatoCobranza" type="submit" class="btn btn-warning" form="form1">Guardar <i class="fa fa-floppy-o"></i></button>
                            <!-- <a class="btn btn-warning" href="index.php?action=">Cancelar <i class="fa fa-times"></i></a> -->
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>
</div>

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