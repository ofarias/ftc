<br/>
<div class="row">
    <div class="container-fluid">
        <div class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3>Captura de gasto.</h3>
                </div>
                <br />
                <div class="panel panel-body">
                    <form action="index.php" method="post" id="formgasto">
                        <div class="form-group">
                            <label for="concepto" class="col-lg-2 control-label">Concepto: </label>
                            <div class="col-lg-10">
                                <select class="form-control" id="concepto" name="concepto" required = "required" ><br/>
                                    <option>--Selecciona un concepto--</option>
                                    <?php foreach ($exec as $gasto): ?>
                                        <option value="<?php echo $gasto->ID; ?>"><?php echo $gasto->CONCEPTO; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="proveedor" class="col-lg-2 control-label">Proveedor: </label>
                            <div class="col-lg-10">
                                <select class="form-control" name="proveedor" required = "required"><br/>
                                    <option>--Selecciona un proveedor--</option>
                                    <?php foreach ($prov as $data): ?>
                                        <option value="<?php echo !empty($data->CLAVE)? $data->CLAVE:'xml_'.$data->IDCLIENTE; ?>">(&nbsp; <?php echo !empty($data->CLAVE)? $data->CLAVE:'xml'?>&nbsp;)&nbsp;<?php echo $data->NOMBRE; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="clasificacion" class="col-lg-2 control-label">Clasificación: </label>
                            <div class="col-lg-10">
                                <select class="form-control" name="clasificacion" required = "required"><br/>
                                    <?php foreach ($clasificacion as $cla): ?>
                                        <option value="<?php echo $cla->ID; ?>"><?php echo $cla->CLASIFICACION; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="referencia" class="col-lg-2 control-label">Referencia: </label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="referencia" placeholder="Referencia del proveedor" maxlength="30" required = "required"/><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="presupuestoestablecido" class="col-lg-2 control-label">Presupuesto: </label>
                            <div class="col-lg-10">
                                <input type="text" name="presupuesto" id="presupuestoestablecido" class="form-control" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tipopago" class="col-lg-2 control-label">Tipo de pago: </label>
                            <div class="col-lg-10">
                                <select class="form-control" name="tipopago" required = "required"><br/>
                                    <option value="credito">Crédito</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="monto" class="col-lg-2 control-label">Monto: </label>
                            <div class="col-lg-10">
                                <input type="number" id="presupuestoCapturado" step="any" class="form-control" name="monto" placeholder="Monto del pago" min="0" required = "required"/><br>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="movpar" class="col-lg-2 control-label">¿Movimiento parcial? </label>
                            <div class="col-lg-10">
                                <select name="movpar" required="required" class="form-control" id="movimiento_parcial"><br/>
                                    <option value="S">Si</option>
                                    <option value="N" selected>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="numpar" class="col-lg-2 control-label">Parcialidades: </label>
                            <div class="col-lg-10">
                                <input type="number" class="form-control" name="numpar" id="numpar" placeholder="¿Cuantas parcialidades?" min="0" value="0" readonly /><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fechadoc" class="col-lg-2 control-label">Fecha documento: </label>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" name="fechadoc" placeholder="<?php echo date('d-m-Y'); ?>" required="required"/><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fechaven" class="col-lg-2 control-label">Fecha vencimiento: </label>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" name="fechaven" placeholder="<?php echo date('d-m-Y'); ?>" required="required"/><br>
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
                            <button name="guardanuevogasto" form="formgasto" type="submit" class="btn btn-warning">Generar <i class="fa fa-file"></i></button>
                            <a href="index.php?action=inicio" class="btn btn-warning">Cancelar <i class="fa fa-times"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modified by GDELEON 3/Ago/2016-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    var gastos = {
        <?php 
        foreach ($exec as $gasto): 
            echo "\"".$gasto->ID."\": ".$gasto->PRESUPUESTO.",";
        endforeach; 
        ?>        
    };
        
    $('#concepto').on('change', function() {
        var concept = this.value;        
        console.log( "valor: " + gastos[concept]);
        var result = number_format(gastos[concept],2,'.',',');
        console.log(result);
        $('#presupuestoestablecido').val(result);        
    });

    $('#movimiento_parcial').on('change', function() {
        var concept = this.value;        
        console.log( "valor: " + concept);        
        if(concept=='S'){
            $("#numpar").prop("readonly", false);
            $("#numpar").val("1");
        } else {
            $("#numpar").val("0");
            $("#numpar").prop("readonly", true);
        }        
    });

    $("#presupuestoCapturado").focusout(function() {
        var presupuestoCapturado = $('#presupuestoCapturado').val();
        var presupuestoestablecido = $('#presupuestoestablecido').val();
        console.log(presupuestoestablecido.replace(',',''));
        //alert(presupuestoCapturado);
        if (presupuestoCapturado > presupuestoestablecido) {
            //res = "Presupuesto Capturado Excede el permitido, requiere Autorización.";
            alert("Para Pagar más de lo presupuestado, se requiere autorización ");
            $('#autorizacion').focus();
        }

    });

    function number_format(number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
</script>