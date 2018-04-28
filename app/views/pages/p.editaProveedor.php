<br /><br />

<div class="row">
<div class="container">
<div class="form-horizontal">
<div class="panel panel-default">
    <div class="panel panel-heading">

                        <?php foreach ($proveedor as $data): ?>
                            
                        <form action="index.php" method="post" name="formulario">
                            <input type="hidden" name="idprov" value="<?php echo $data->CLAVE?>">
                            <input type="hidden" name="ids" value="<?php echo $ids;?>"/>
                                        
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Nombre del Proveedor</label>
                                <div class="col-lg-10">
                                    <label><?php echo $data->CLAVE.' - '.$data->NOMBRE?></label>
                                </div>
                            </div>            

                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Direccion: </label>
                                <div class="col-lg-10">
                                    <label><?php echo $data->CALLE.', '.$data->NUMEXT.', '.$data->COLONIA?></label>
                                </div>
                            </div>
                            

                             <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Urgencia </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="urgencia" value="Si" <?php echo ($data->URGENCIA == 'Si')? "checked='checked'":"";?> > Urgencia 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Tipo </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="envio" value="Si" <?php echo ($data->ENVIO == 'Si')? "checked='checked'":"";?> > Entrega  <br/> 
                                    <input type="checkbox" name="recoleccion" value="Si" <?php echo ($data->RECOLECCION == 'Si')? "checked='checked'":"";?> > Recoleccion
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label">Credito : </label>
                                <div class="col-lg-10">
                                        <input type="checkbox" name="credito" value="Si" <?php echo ($data->TP_CREDITO == 'Si')? "checked='checked'":"";?> onClick="cr1()"> Credito 
                                        <input type="number" min = "0" name="plazo" class="text text-right text-muted" placeholder="plazo" value="<?php echo $data->DIASCRED;?>"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Forma de Pago </label>
                                <div class="col-lg-10">
                                    <input type="checkbox" name="efectivo" value="Si" <?php echo ($data->TP_EFECTIVO == 'Si')? "checked='checked'":"";?> > Efectivo  <br/> 

                                    <input type="checkbox" name="cheque" value="Si" <?php echo ($data->TP_CHEQUE == 'Si')? "checked='checked'":"";?> onClick="tpch()" > Cheque >  Nombre del Beneficiario 

                                    <input type="text" name="beneficiario" class="form-control"  placeholder="Capture el Nombre del Beneficiario" value=<?php echo (empty($data->BENEFICIARIO))? '':"$data->BENEFICIARIO" ?> /> <br/> 

                                    <input type="checkbox" name="transferencia" value="Si" <?php echo ($data->TP_TRANSFERENCIA == 'Si')? "checked='checked'":"";?> onClick="foco1()" > Transferencia. --> 
                                    Banco: <input type="text" name="banco"  class="text text-right text-muted" placeholder="Banco" 
                                        value=<?php echo (empty($data->NOM_BANCO))? '':"$data->NOM_BANCO"; ?> />  
                                    Cuenta <input type="text" name="cuenta"  class="text text-right text-muted" placeholder="Cuenta" 
                                    value=<?php echo (empty($data->CUENTA))? '':"$data->CUENTA"?>> <br/>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Correo Electronico <br/> (Predeterminado) </label>
                                <div class="col-lg-10">
                                    <input type="email" name="email1" value="<?php echo $data->EMAILPRED?>" size='60' required='required' class="text text-left text-muted" ><br/>
                                    <label> A este correo se enviaran Ordenes de compra y pagos de forma automatica.</label> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Correo Electronico 2 <br/> Opcional </label>
                                <div class="col-lg-10">
                                    <input type="email" name="email2" value="<?php echo $data->EMAIL2?>" size='60' class="text text-left text-muted" ><br/>
                                    <label></label> 
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Correo Electronico 3 <br/> Opcional </label>
                                <div class="col-lg-10">
                                
                                    <input type="email" name="email3" value="<?php echo $data->EMAIL3?>" size='60' class="text text-left text-muted" ><br/>
                                    <label></label> 
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Proveedor Certificado? </label>
                                <div class="col-lg-10">
                                    <br/>
                                    <input type="checkbox" name="certificado" value="Si" <?php echo ($data->CERTIFICADO == 'Si')? "checked='checked'":"";?> > Certificado <br/>
                                    <label><?php echo empty($data->USR_CERT)? '':"Usuario que certifica $data->USR_CERT";?> <?php echo empty($data->FECHA_ULT_CERT)? "el $data->FECHA_CERT":"el $data->FECHA_ULT_CERT"?> </label> 
                                </div>
                            </div>

                             <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"> Seleccionar Responsable de Compra </label>
                                <div class="col-lg-10">
                                    <br/>
                                    <select class="form-control" name="responsable" requiered="requiered">
                                        <option value="<?php echo (empty($data->RESP_COMPRA))? '':"$data->RESP_COMPRA"?>"> 
                                        <?php echo (empty($data->RESP_COMPRA))? '--Seleccione un Responsable':"$data->RESP_COMPRA"?></option>
                                        <?php foreach($responsables as $key):?>
                                            <option value="<?php echo $key->NOMBRE?>"><?php echo $key->NOMBRE?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <label for="categoria" class="col-lg-2 control-label"></label>
                                <div class="col-lg-10">
                                    <button value="enviar" type="submit" 
                                    <?php echo empty($data->ID)? 'class="btn btn-success"':'class="btn btn-warning"' ?> 
                                    name="editarProveedor"> <?php echo empty($data->ID)? 'Guardar':'Cambiar';?></button>    
                                </div>
                            </div>
                            
                            <br/>
                            <hr size="30" />
                           <hr style="color: red;" />
                            </form>
                            <?php endforeach ?>
                      </div>
                </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>
<script type="text/javascript">

function foco1(){
    var chek = document.formulario.transferencia;
        if (chek.checked == true) {
            alert('Si selecciona transferencia es necesario capturar El banco y la Cuenta del Proveedor.');
            //document.formulario.banco.disabled = false;
            document.formulario.banco.required = true;
            //document.formulario.cuenta.disabled = false;
            document.formulario.cuenta.required = true;
            //document.formulario.banco.placeholder = 'Capture la Cuenta';
            document.formulario.banco.focus();
        }else{
            alert('No se guardara la informacion del proveedor.');
            //document.formulario.banco.value="";
            //document.formulario.cuenta.value="";
            //document.formulario.banco.disabled = true;
            document.formulario.banco.required = false;
            //document.formulario.cuenta.disabled = true;
            document.formulario.cuenta.required = false;
        }
        
}

function tpch(){
    var chek2 = document.formulario.cheque;
       if(chek2.checked == true){
            alert('Debe de colocar el nombre del Beneficiario por favor.');
            //document.formulario.beneficiario.disabled = false;
            document.formulario.beneficiario.required = true;
            document.formulario.beneficiario.focus();
        }else{
            alert('Se eliminara la informacion de l proveedor');
            //document.formulario.beneficiario.disabled = true;
            document.formulario.beneficiario.required = false;
            //document.formulario.beneficiario.value ="";
        }
    }

function cr1(){
    var chek3 = document.formulario.credito;
           
       if(chek3.checked == true){
            alert('Debe de colocar el plazo por favor.');
            //document.formulario.beneficiario.disabled = false;
            document.formulario.plazo.required = true;
            document.formulario.plazo.focus();
        }else{
            alert('Se quito el manejo de credito...');
            //document.formulario.beneficiario.disabled = true;
            document.formulario.plazo.required = false;
            //document.formulario.beneficiario.value ="";
        }
    }


</script>