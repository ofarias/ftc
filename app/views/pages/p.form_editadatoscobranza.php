<br/>
<div class="row">
    <div class="container">
    <div class="form-horizontal col-lg-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <h3>Edición de datos cobranza.</h3>
            </div>
            <br />
            <div class="panel panel-body">
                <form action="index.php" method="post" id="form1">
                <?php foreach($exec as $dat): ?>
                    <div class="form-group">
                        <label for="cliente" class="col-lg-2 control-label">Cliente: </label>
                            <div class="col-lg-10">
                                <input type="hidden" class="form-control" name="cliente" value="<?php echo $dat->IDCLIENTE;?>" />
                                <input type="text" class="form-control" name="something" placeholder="<?php echo $dat->IDCLIENTE.' -- '.$dat->NOMBRE?>" readonly="true"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="carteracobranza" class="col-lg-2 control-label">Cartera Revisión: </label>
                            <div class="col-lg-8">
                                <select name="carteracobranza" class="form-control">
                                    <option value="CCA" <?php echo ($dat->CARTERA_COBRANZA == "CCA")?"selected":"";?> >CCA</option>
                                    <option value="CCB" <?php echo ($dat->CARTERA_COBRANZA == "CCB")?"selected":"";?>>CCB</option>
                                    <option value="CCC" <?php echo ($dat->CARTERA_COBRANZA == "CCC")?"selected":"";?>>CCC</option>
                                    <option value="CCD" <?php echo ($dat->CARTERA_COBRANZA == "CCD")?"selected":"";?>>CCD</option>
                                </select>
                            </div>
                    </div>

                    <div class="form-group">
                        <label for="carterarevision" class="col-lg-2 control-label">Cartera Cobranza: </label>
                            <div class="col-lg-8">
                                <select name="carterarevision" class="form-control">
                                    <option value="CR1" <?php echo ($dat->CARTERA_REVISION == "CR1")?"selected":"";?>>CR1</option>
                                    <option value="CR2" <?php echo ($dat->CARTERA_REVISION == "CR2")?"selected":"";?>>CR2</option>
                                    <option value="CR3" <?php echo ($dat->CARTERA_REVISION == "CR3")?"selected":"";?>>CR3</option>
                                    <option value="CR4" <?php echo ($dat->CARTERA_REVISION == "CR4")?"selected":"";?>>CR4</option>
                                </select>
                            </div>
                    </div>
               
                    <div class="form-group col-lg-12 text-center">
                    <label class="col-lg-2 control-label">Días Revisión: </label>
                        <div class="checkbox-inline">
                            <label for="rev1" class="checkbox-inline"><input type="checkbox" name="rev1" value="L" <?php $lun=strpos($dat->DIAS_REVISION,"L"); echo($lun === false) ? "":"checked";?> >L</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev2" class="checkbox-inline"><input type="checkbox" name="rev2" value="MA" <?php $lun=strpos($dat->DIAS_REVISION,"MA"); echo($lun === false) ? "":"checked";?> >MA</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev3" class="checkbox-inline"><input type="checkbox" name="rev3" value="MI" <?php $lun=strpos($dat->DIAS_REVISION,"MI"); echo($lun === false) ? "":"checked";?> >MI</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev4" class="checkbox-inline"><input type="checkbox" name="rev4" value="J" <?php $lun=strpos($dat->DIAS_REVISION,"J"); echo($lun === false) ? "":"checked";?> >J</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev5" class="checkbox-inline"><input type="checkbox" name="rev5" value="V" <?php $lun=strpos($dat->DIAS_REVISION,"V"); echo($lun === false) ? "":"checked";?> >V</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev6" class="checkbox-inline"><input type="checkbox" name="rev6" value="S" <?php $lun=strpos($dat->DIAS_REVISION,"S"); echo($lun === false) ? "":"checked";?> >S</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="rev7" class="checkbox-inline"><input type="checkbox" name="rev7" value="D" <?php $lun=strpos($dat->DIAS_REVISION,"D"); echo($lun === false) ? "":"checked";?> >D</label>
                        </div>
                    </div>
                   
                    <div class="form-group col-lg-12 text-center">
                    <label class="col-lg-2 control-label">Día(s) de Deposito: </label>
                        <div class="checkbox-inline">
                            <label for="pag1" class="checkbox-inline"><input type="checkbox" name="pag1" value="L" <?php $lun=strpos($dat->DIAS_PAGO,"L"); echo($lun === false) ? "":"checked";?> >L</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag2" class="checkbox-inline"><input type="checkbox" name="pag2" value="MA" <?php $lun=strpos($dat->DIAS_PAGO,"MA"); echo($lun === false) ? "":"checked";?> >MA</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag3" class="checkbox-inline"><input type="checkbox" name="pag3" value="MI" <?php $lun=strpos($dat->DIAS_PAGO,"MI"); echo($lun === false) ? "":"checked";?> >MI</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag4" class="checkbox-inline"><input type="checkbox" name="pag4" value="J" <?php $lun=strpos($dat->DIAS_PAGO,"J"); echo($lun === false) ? "":"checked";?> >J</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag5" class="checkbox-inline"><input type="checkbox" name="pag5" value="V" <?php $lun=strpos($dat->DIAS_PAGO,"V"); echo($lun === false) ? "":"checked";?> >V</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag6" class="checkbox-inline"><input type="checkbox" name="pag6" value="S" <?php $lun=strpos($dat->DIAS_PAGO,"S"); echo($lun === false) ? "":"checked";?> >S</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="pag7" class="checkbox-inline"><input type="checkbox" name="pag7" value="D" <?php $lun=strpos($dat->DIAS_PAGO,"D"); echo($lun === false) ? "":"checked";?> >D</label>
                        </div>
                    </div>
                    

                    <div class="form-group col-lg-12 text-center">
                    <label class="col-lg-2 control-label">Día(s) de Cobranza: </label>
                        <div class="checkbox-inline">
                            <label for="cob1" class="checkbox-inline">
                            <input type="checkbox" name="cob[]" value="L" <?php $lun=strpos($dat->DIAS_PAGO,"L"); echo($lun === false) ? "":"checked";?> >L</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="cob2" class="checkbox-inline">

                            <input type="checkbox" name="cob[]" value="MA" <?php $lun=strpos($dat->DIAS_PAGO,"MA"); echo($lun === false) ? "":"checked";?> >MA</label>
                        
                        </div>
                        <div class="checkbox-inline">
                            <label for="cob3" class="checkbox-inline">

                            <input type="checkbox" name="cob[]" value="MI" <?php $lun=strpos($dat->DIAS_PAGO,"MI"); echo($lun === false) ? "":"checked";?> >MI</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="cob4" class="checkbox-inline">

                            <input type="checkbox" name="cob[]" value="J" <?php $lun=strpos($dat->DIAS_PAGO,"J"); echo($lun === false) ? "":"checked";?> >J</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="cob5" class="checkbox-inline">
                            <input type="checkbox" name="cob[]" value="V" <?php $lun=strpos($dat->DIAS_PAGO,"V"); echo($lun === false) ? "":"checked";?> >V</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="cob6" class="checkbox-inline">
                            <input type="checkbox" name="cob[]" value="S" <?php $lun=strpos($dat->DIAS_PAGO,"S"); echo($lun === false) ? "":"checked";?> >S</label>
                        </div>
                        <div class="checkbox-inline">
                            <label for="cob7" class="checkbox-inline">
                            <input type="checkbox" name="cob[]" value="D" <?php $lun=strpos($dat->DIAS_PAGO,"D"); echo($lun === false) ? "":"checked";?> >D</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dospasos" class="col-lg-2 control-label">Revisión dos pasos: </label>
                            <div class="col-lg-8">
                                <select name="dospasos" class="form-control">
                                    <option value="S" <?php echo ($dat->REV_DOSPASOS == "S")?"selected":"";?> >Si</option>
                                    <option value="N" <?php echo ($dat->REV_DOSPASOS == "N")?"selected":"";?> >No</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="plazo" class="col-lg-2 control-label">Plazo: </label>
                            <div class="col-lg-8">
                                <select name="plazo" class="form-control">
                                    <option value = "8" <?php echo ($dat->PLAZO == 8)?"selected":"";?>> 8 Días</option>
                                    <option value="30" <?php echo ($dat->PLAZO == 30)?"selected":"";?>>30 Días</option>
                                    <option value="45" <?php echo ($dat->PLAZO == 45)?"selected":"";?>>45 Días</option>
                                    <option value="60" <?php echo ($dat->PLAZO == 60)?"selected":"";?>>60 Días</option>
                                    <option value="90" <?php echo ($dat->PLAZO == 90)?"selected":"";?>>90 Días</option>
                                    <option value="120" <?php echo ($dat->PLAZO == 120)?"selected":"";?>>120 Días</option>
                                    <option value="150" <?php echo ($dat->PLAZO == 150)?"selected":"";?>>150 Días</option>
                                </select>
                            </div>
                    </div>
                    
                    <div class="form-group col-lg-12 text-center">
                    <label for="addenda" class="col-lg-2 control-label">Addenda: </label>
                        <div class="checkbox-inline">
                            <input type="checkbox" name="addenda" value="S" id="addenda" <?php echo ($dat->ADDENDA == "S")?"checked":"";?>>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="portal" class="col-lg-2 control-label">Portal Addenda: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="portal" id="portal" value="<?php echo $dat->ADD_PORTAL;?>" placeholder="URL del portal" required = "required" maxlength="150" readonly="true"/><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="add_usuario" class="col-lg-2 control-label">Usuario: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="add_usuario" id="usuario" value="<?php echo $dat->ADD_USUARIO;?>" placeholder="Usuario del portal" required = "required" maxlength="30" readonly="true"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contrasena" class="col-lg-2 control-label">Contraseña: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="contrasena" id="contrasena" value="<?php echo $dat->ADD_CONTRASENA;?>" placeholder="Contraseña" required = "required" maxlength="15" readonly="true"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="observaciones" class="col-lg-2 control-label">Observaciones: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="observaciones" id="observaciones" value="<?php echo $dat->ADD_OBS;?>" placeholder="Observaciones addenda" required = "required" maxlength="150" readonly="true"/><br>
                            </div>
                    </div>
                   
                    <div class="form-group">
                        <label for="lineacred" class="col-lg-2 control-label">Linea de credito: </label>
                            <div class="col-lg-8">
                                <input type="number" step="any" lang="en-150" class="form-control" name="lincred" id="lincred" value="<?php echo $dat->LINEA_CRED;?>" required = "required" min="0"/><br>
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
                                <input type="text" class="form-control" name="portalcob" value="<?php echo $dat->PORTAL_COB;?>" placeholder="Link portal cobranza" maxlength="255"/><br>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="envio" class="col-lg-2 control-label">Envió: </label>
                            <div class="col-lg-8">
                                <select name="envio" class="form-control">
                                    <option value="local" <?php echo ($dat->ENVIO == "local")?"selected":"";?>>Foraneo</option>
                                    <option value="foraneo" <?php echo ($dat->ENVIO == "foraneo")?"selected":"";?>>Local</option>
                                </select>
                            </div>
                    </div>
                  
                    <div class="form-group">
                        <label for="cp" class="col-lg-2 control-label">Código Postal: </label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" name="cp" value="<?php echo $dat->CP;?>" placeholder="Código Postal" required = "required" min="1"/><br>
                            </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="maps" class="col-lg-2 control-label">Maps: </label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="maps" value="<?php echo $dat->MAPS;?>" placeholder="Link de ubicación en google maps" maxlength="255"/><br>
                            </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="tipo" class="col-lg-2 control-label">Pertenece a: </label>
                            <div class="col-lg-8">
                                <select name="tipo" class="form-control">
                                    <option value="<?php echo $dat->CLAVE_M?>"><?php echo $dat->NOMBRE_MAESTRO?></option>
                                    <?php foreach($datosMaestro as $data): ?>
                                    <option value="<?php echo $data->CLAVE?>"><?php echo $data->NOMBRE?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                    </div>
       <?php endforeach; ?>
        </form>
            </div>

                <!-- Submit Button  -->
                <div class="panel-footer">
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="salvaCambiosDatoCobranza" type="submit" class="btn btn-warning" form="form1"  onclick="setTimeout(cerrar(),3000)">Guardar <i class="fa fa-floppy-o"></i></button>
                            <a class="btn btn-warning" href="index.php?action=documentos_cliente">Cancelar <i class="fa fa-times"></i></a>
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

    function cerrar(){
        //window.close();
    }

</script>