<br/>
<div class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel panel-heading">
            <h3>Crear nueva cuenta de gastos.</h3>
        </div>
        <br />
        <div class="panel panel-body">
            <form action="index.php" method="post" id="formulario1">
                <div class="form-group">
                    <label for="concepto" class="col-lg-2 control-label">Concepto: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="concepto" placeholder="Concepto de la cuenta" required = "required"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="descripcion" class="col-lg-2 control-label">Descripción: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="descripcion" placeholder="Descripción de la cuenta" required = "required"/><br>
                        </div>
                </div>
                <div class="form-group">
                    <label for="iva" class="col-lg-2 control-label">¿Causa IVA?: </label>
                        <div class="col-lg-10">
                            <select name="iva" required="required" class="form-control"><br/>
                                <option value="SI">Si</option>
                                <option value="NO">No</option>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="centrocostos" class="col-lg-2 control-label">Centro de costos: </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="centrocostos" required = "required"><br/>
                                <option value="ventas">Ventas</option>
                                <option value="logistica">Logistica</option>
                                <option value="compras">Compras</option>
                                <option value="costos">Costos</option>
                                <option value="tesoreria">Tesorería</option>
                                <option value="cxc">CXC</option>
                                <option value="recibo">Recibo</option>
                                <option value="empaque">Empaque</option>
                                <option value="bodega">Bodega</option>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                    <label for="cuentacontable" class="col-lg-2 control-label">Cuenta Contable: </label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="cuentacontable" placeholder="###-###-###" required = "required"/><br>
                        </div>
                </div>

                <div class="form-group">
                    <label for="gasto" class="col-lg-2 control-label">Clasificacion Gasto: </label>
                        <div class="col-lg-10">
                            <select class="form-control" name="gasto" required = "required"><br/>
                                <?php foreach ($tipog as $key):?>
                                <option value="<?php echo $key->CLASIFICACION;?>"><?php echo $key->DESCRIPCION;?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                </div>
                <div class="form-group">
                <label for="presupuesto" class="col-lg-2 control-label">Presupuesto: </label>
                        <div class="col-lg-10">
                            <input type="number" step="any" min="0.0" class="form-control" name="presupuesto" placeholder="0.00" required = "required"/><br>
                        </div>
                </div>
                <div class="text-center">
                    <h4 class="h3">Retenciones </h4>
                </div>
                <div class="form-group">
                 <div class="text-center">   
                    <div class="col-lg-4">
                        <label for="retieneiva" class="inline control-label"> IVA </label>
                        <input type="checkbox" class="checkbox-inline" name="retieneiva" value="16"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="retieneisr" class="inline control-label"> ISR </label>
                        <input type="checkbox" class="checkbox-inline" name="retieneisr" value="10"/>
                    </div>
                    <div class="col-lg-4">
                        <label for="retieneflete" class="inline control-label">Flete </label>
                        <input type="checkbox" class="checkbox-inline" name="retieneflete" value="4"/>
                    </div>
                </div>
                </div>
                <br/>
            </form>
        <!--    </div> -->
        </div>
        <div class="panel-footer">
                    <!-- Submit Button  -->
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button name="guardanuevacuenta" form="formulario1" type="submit" value="enviar" class="btn btn-lg btn-primary">Guardar <i class="fa fa-floppy-o"></i></button>
                        </div>
                    </div>
        </div>
    </div>
</div>

