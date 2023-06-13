<br/>
<div class="row">
    <div class="container-fluid">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3>Captura de Compras para el Estado de cuenta.</h3>
                </div>
                <br />
                <div class="panel panel-body">
                    <form action="index.php" method="post" id="formgasto">
                        <div class="form-group">
                            <label for="concepto" class="col-lg-2 control-label">Factura: </label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="fact" placeholder="Factura Proveedor" maxlength="20" required="required" value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="proveedor" class="col-lg-2 control-label">Proveedor: </label>
                            <div class="col-lg-10">
                                <select class="form-control" name="proveedor" required = "required"><br/>
                                    <option>--Selecciona un proveedor--</option>
                                    <?php foreach ($prov as $data): ?>
                                        <option value="<?php echo isset($data->CLAVE)? $data->CLAVE:'xml_'.$data->IDCLIENTE; ?>"><?php echo $data->NOMBRE; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="clasificacion" class="col-lg-2 control-label">Importe: </label>
                            <div class="col-lg-10">
                               <input type="number" step="any" name="monto" class="form-control" placeholder="Monto de la Factura con IVA" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="referencia" class="col-lg-2 control-label">Referencia: </label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="referencia" placeholder="Referencia del proveedor" maxlength="30" required = "required"/><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipopago" class="col-lg-2 control-label">Tipo de pago: </label>
                            <div class="col-lg-10">
                                <select class="form-control" name="tipopago" required = "required"><br/>
                                    <option value="tr">Transferencia</option>
                                    <option value="efe">Efectivo</option>
                                    <option value="che">Cheque</option>
                                   
                                </select>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="tipopago" class="col-lg-2 control-label">Tipo de pago: </label>
                            <div class="col-lg-10">
                                <select class="form-control" name="banco" required = "required"><br/>
                                    <option value = "ScotiaBank - 044180001025870734">ScotiaBank - 044180001025870734</option>
                                    <?php foreach ($banco as $key):?>
                                    <option value="<?php echo $key->BANCO?>"><?php echo $key->BANCO?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>                 
                        <div class="form-group">
                            <label for="fechadoc" class="col-lg-2 control-label">Fecha documento: </label>
                            <div class="col-lg-10">
                                <input type="date"  class="form-control fecha" name="fechadoc" placeholder="<?php echo date('d-m-Y'); ?>"/><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fechaven" class="col-lg-2 control-label" >Fecha Estado de cuenta: </label>
                            <div class="col-lg-10">
                                <input type="date"  class="form-control fecha" name="fechaEdoCta" placeholder="<?php echo date('d-m-Y');?>" required="required" title="Solo se permite cargos a Estado de cuenta Abierto"/><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fechaven" class="col-lg-2 control-label">Tipo: </label>
                            <div class="col-lg-10">
                                <input type="radio" name="tipo" value="compra" checked="checked"/>Compra<br/>
                                <input type="radio" name="tipo" value="gasto">Gasto<br/>
                                <input type="radio" name="tipo" value="Anticipo">Anticipo<br/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fechaven" class="col-lg-2 control-label">Nombre del Gasto: </label>
                            <div class="col-lg-10">
                                <select name ="idg" >
                                    <option value = '0'>---No Aplica---</option>
                                    <?php foreach ($gastos as $data):
                                    ?>
                                    <option value ="<?php echo $data->IDG;?>"><?php echo $data->NOMBRE?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="usuariogastos" value="<?php echo $_SESSION['user']->USER_LOGIN; ?>"/>
                        <br/>
                    </form>
                    <!--    </div> -->
                </div>
                <div class="panel-footer">
                    <!-- Submit Button  -->
                    <div class="form-group">
                        <div class="col-lg-11 col-lg-offset-1 text-right">
                            <button name="guardaCompra" form="formgasto" type="submit" class="btn btn-warning"> Generar <i class="fa fa-file"></i></button>
                            <a href="index.php?action=inicio" class="btn btn-warning">Cancelar <i class="fa fa-times"></i></a>
                        </div>
                        <input type="hidden" name="mensaje" value="<?php echo $mensaje?>" id="mensaje">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script>

  $(document).ready(function() {
    $(".fecha").datepicker({dateFormat: 'dd.mm.yy'});
        var mensaje = document.getElementById('mensaje').value;
        if(mensaje != ''){
            alert(mensaje);    
        }
  });

  </script>